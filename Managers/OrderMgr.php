<?php
require_once($ConstantsArray['dbServerUrl'] ."DataStores/BeanDataStore.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/Order.php");
require_once($ConstantsArray['dbServerUrl'] ."Managers/OrderProductDetailMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."Managers/OrderPaymentDetailMgr.php");
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
			$query .= " inner join usercompanies on customers.seq = usercompanies.customerseq where usercompanies.userseq = $userSeq";
		}
		$query .= " GROUP by orders.seq";
		
		$orders = self::$dataStore->executeQuery($query,true);
		$mainArr = array();
		foreach ($orders as $order){
			$order["orders.createdon"] = $order["createdon"];
			$totalAmount = $order["totalamount"];
			$totalAmount = number_format($totalAmount,2,'.','');
			$pendingAmount = $totalAmount - $order["paidamount"];
			$order["totalamount"] =  "<span class='text-success pull-right'>" .$totalAmount. "</span>";
			$order["pendingamount"] = "<span class='text-danger pull-right'>" .number_format($pendingAmount,2,'.','') ."</span>";
			$order["customers.title"] = $order["customer"];
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
			$query .= " inner join usercompanies on customers.seq = usercompanies.customerseq where usercompanies.userseq = $userSeq";
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
	
	
}