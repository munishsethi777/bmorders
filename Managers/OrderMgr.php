<?php
require_once($ConstantsArray['dbServerUrl'] ."DataStores/BeanDataStore.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/DateUtil.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/Order.php");
require_once($ConstantsArray['dbServerUrl'] ."Managers/OrderProductDetailMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."Managers/OrderPaymentDetailMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."Managers/NotificationMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."Managers/ChatMessageMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."Enums/NotificationType.php");
require_once ($ConstantsArray ['dbServerUrl'] . "log4php/Logger.php");
Logger::configure ( $ConstantsArray ['dbServerUrl'] . "log4php/log4php.xml" );
class OrderMgr{
	private static $orderMgr;
	private static $dataStore;
	private static $sessionUtil;
	private static $logger;
	public static function getInstance(){
		if (!self::$orderMgr){
			self::$orderMgr = new OrderMgr();
			self::$dataStore = new BeanDataStore(Order::$className, Order::$tableName);
			self::$logger = Logger::getLogger("logger");
		}
		return self::$orderMgr;
	}
	
	public function saveOrder($order,$productDetail){
		$id = self::$dataStore->save($order);
		if($id > 0){
			$orderProductDetailMgr = OrderProductDetailMgr::getInstance();
			$orderProductDetailMgr->saveOrderProductDetail($id, $productDetail);
			self::$logger->info("Order saved with id ".$id);
		}
		if(empty($order->getSeq())){
			$order->setSeq($id);
			$notificationMgr = NotificationMgr::getInstance();
			$notificationMgr->saveCreateOrderNotificationForEmail($order, NotificationType::email);
		}
		return $id;
	}
	
	public function getAllOrdersForGrid(){
		$sessionUtil = SessionUtil::getInstance();
		$isRepersentative = $sessionUtil->isRepresentative();
		$query = "SELECT sum(orderpaymentdetails.amount) paidamount, orders.*,customers.title as customer,users.fullname FROM orders inner JOIN users on orders.userseq = users.seq 
			inner join customers on orders.customerseq = customers.seq
			left join orderpaymentdetails on orders.seq  = orderpaymentdetails.orderseq and orderpaymentdetails.ispaid = 1";
		//$query = "SELECT orders.*,customers.title FROM orders inner join customers on orders.customerseq = customers.seq";
		if($isRepersentative){
			$userSeq = $sessionUtil->getUserLoggedInSeq();
			$query .= " inner join usercompanies on customers.seq = usercompanies.customerseq where usercompanies.userseq = $userSeq and orders.userseq = $userSeq";
		}
		$query .= " GROUP by orders.seq";
		
		$orders = self::$dataStore->executeQuery($query,true);
		$mainArr = array();
		$chatMgr = ChatMessageMgr::getInstance();
		$sessionUtil = SessionUtil::getInstance();
		$loggedInUser = $sessionUtil->getUserLoggedInSeq();
		foreach ($orders as $order){
			$order["orders.createdon"] = $order["createdon"];
			$totalAmount = $order["totalamount"];
			$totalAmount = number_format($totalAmount,2,'.','');
			$pendingAmount = $totalAmount - $order["paidamount"];
			$order["totalamount"] =  "<span class='text-success pull-right'>" .$totalAmount. "</span>";
			$order["pendingamount"] = "<span class='text-danger pull-right'>" .number_format($pendingAmount,2,'.','') ."</span>";
			$order["customers.title"] = $order["customer"];
			$order["orders.seq"] = $order["seq"];
			$order["haschat"] = $chatMgr->hadUnReadChatForOrder($order["seq"],$loggedInUser);
			array_push($mainArr, $order);
		}
		$jsonArr["Rows"] =  $mainArr;
		$jsonArr["TotalRows"] = $this->getCount();
		return $jsonArr;
	}
	
	
	
	public function getCount(){
		$sessionUtil = SessionUtil::getInstance();
		$isRepersentative = $sessionUtil->isRepresentative();
		$query = "SELECT count(*) FROM orders inner JOIN users on orders.userseq = users.seq  inner join customers on orders.customerseq = customers.seq";
		if($isRepersentative){
			$userSeq = $sessionUtil->getUserLoggedInSeq();
			$query .= " inner join usercompanies on customers.seq = usercompanies.customerseq where usercompanies.userseq = $userSeq and orders.userseq = $userSeq";
		}
		$count = self::$dataStore->executeCountQueryWithSql($query,true);
		return $count;
	}
	
	public function findBySeq($seq){
		$order = self::$dataStore->findBySeq($seq);
		return $order;
	}
	
	public function findOrderArr($seq){
		$query = "SELECT orders.*,customers.title as customername FROM orders inner join customers on orders.customerseq = customers.seq where orders.seq = $seq";
		$orderArr = self::$dataStore->executeQuery($query);
		if(!empty($orderArr)){
			$order =  $orderArr[0];
			$createdon = $order["createdon"];
			$createdon = DateUtil::StringToDateByGivenFormat("Y-m-d H:i:s", $createdon);
			$createdon = $createdon->format("d-m-Y H:i A");
			$order["createdon"] = $createdon;
			return $order;
		}
		return null;
	}
	
	public function deleteBySeqs($ids) {
		$flag = self::$dataStore->deleteInList ( $ids );
		if($flag){
			$orderProductDetailMgr = OrderProductDetailMgr::getInstance();
			$orderProductDetailMgr->deleteAndUpdateStock($ids);
			$orderPaymentDtailMgr = OrderPaymentDetailMgr::getInstance();
			$orderPaymentDtailMgr->deleteByOrderSeqs($ids);
			self::$logger->info("Order deleted with id(s) ".$ids);
		}
		return $flag;
	}
	
	public function exportOrders($queryString){
		$output = array();
		parse_str($queryString, $output);
		$_GET = array_merge($_GET,$output);
		$query = "select customers.title as customer,products.title as product ,orders.*,orderproductdetails.lotnumber,orderproductdetails.productseq,orderproductdetails.price,orderproductdetails.quantity from orders 
inner join orderproductdetails on orders.seq = orderproductdetails.orderseq
inner join products on orderproductdetails.productseq = products.seq
inner join customers on orders.customerseq = customers.seq
inner join users on orders.userseq = users.seq";
		$sessionUtil = SessionUtil::getInstance();
		$isRepersentative = $sessionUtil->isRepresentative();
		if($isRepersentative){
			$userSeq = $sessionUtil->getUserLoggedInSeq();
			$query .= " inner join usercompanies on customers.seq = usercompanies.customerseq where usercompanies.userseq = $userSeq and orders.userseq = $userSeq";
		}
		$orders =self::$dataStore->executeQuery($query,true);
		$orders = $this->group_by($orders, "seq");
		ExportUtil::exportOrders($orders);
		
	}
	
	
	function group_by($array, $key) {
		$return = array();
		foreach($array as $val) {
			$return[$val[$key]][] = $val;
		}
		return $return;
	}
	
	
	public function getOrdersByForDashBoard($days,$userSeq){
		$toDate = new DateTime();
		$fromDate = new DateTime();
		$fromDate->setTime(0, 0);
		$fromDate->modify("-".$days . "days");
		$toDateStr = $toDate->format("Y-m-d H:i:s");
		$fromDateStr = $fromDate->format("Y-m-d H:i:s");
		$query = "select sum(totalamount) as amount, CAST(createdon AS DATE) as createddate  from orders where createdon >= '$fromDateStr' 
		and createdon <= '$toDateStr'";
		if(!empty($userSeq)){
			$query .= " and userseq = $userSeq";
		}
		$query .= " GROUP BY createddate";
		$orders =self::$dataStore->executeQuery($query,false,true);
		$dateSlices = DateUtil::getDatesSlicesTillNowWithFormat($fromDateStr,"Y-m-d");
		$orderArr = $this->group_by($orders,"createddate");
		$paymentMgr = OrderPaymentDetailMgr::getInstance();
		$paymentArr = $paymentMgr->getPaymentsForDashBoard($days, $userSeq);
		$orderArr  = $this->getDataByDates($dateSlices, $orderArr,$paymentArr);
		return $orderArr;
	}
	
	private function getDataByDates($dateSlices,$orderArr,$paymentArr){
		$orderArrByDate = array();
		foreach ($dateSlices as $formatedDate){
			$order = null;
			$data = array();
			if(isset($orderArr[$formatedDate])){
				$order = array();
				$order = $orderArr[$formatedDate][0];
			}
			$data["order"] = $order;
			$payment = null;
			if(isset($paymentArr[$formatedDate])){
				$payment = $paymentArr[$formatedDate][0];
			}
			$data["payment"] = $payment;
			$key = DateUtil::StringToDateByGivenFormat("Y-m-d", $formatedDate);
			$key = $key->format("j F");
			$orderArrByDate[$key] = $data;
		}
		return $orderArrByDate;
	}
	
	
	public function getOrderAndDetailBySeq($orderSeq){
		$query = "select users.fullname as username ,customers.title as customer,products.title as product ,orders.*,orderproductdetails.productseq,orderproductdetails.price,orderproductdetails.quantity from orders 
inner join orderproductdetails on orders.seq = orderproductdetails.orderseq
inner join products on orderproductdetails.productseq = products.seq
inner join customers on orders.customerseq = customers.seq
inner join users on orders.userseq = users.seq WHERE orders.seq = $orderSeq";
	  $orderDetail= self::$dataStore->executeQuery($query,false,true);
	  if(!empty($orderDetail)){
	  	return $orderDetail[0];
	  }
	  return null;
	}
	
	
}