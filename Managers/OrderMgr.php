<?php
require_once($ConstantsArray['dbServerUrl'] ."DataStores/BeanDataStore.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/Order.php");
require_once($ConstantsArray['dbServerUrl'] ."Managers/OrderProductDetailMgr.php");
class OrderMgr{
	private static $orderMgr;
	private static $dataStore;
	private static $sessionUtil;

	public static function getInstance(){
		if (!self::$orderMgr){
			self::$orderMgr = new OrderMgr();
			self::$dataStore = new BeanDataStore(Order::$className, Order::$tableName);
		}
		return self::$orderMgr;
	}
	
	public function saveOrder($order,$productDetail){
		$id = self::$dataStore->save($order);
		if($id > 0){
			$orderProductDetailMgr = OrderProductDetailMgr::getInstance();
			$orderProductDetailMgr->saveOrderProductDetail($id, $productDetail);
		}
		return $id;
	}
	
	public function getAllOrdersForGrid(){
		$sessionUtil = SessionUtil::getInstance();
		$isRepersentative = $sessionUtil->isRepresentative();
		$query = "SELECT orders.*,customers.title FROM orders inner join customers on orders.customerseq = customers.seq";
		if($isRepersentative){
			$userSeq = $sessionUtil->getUserLoggedInSeq();
			$query .= " inner join usercompanies on customers.seq = usercompanies.customerseq where usercompanies.userseq = $userSeq";
		}
		$orders = self::$dataStore->executeQuery($query,true);
		$mainArr = array();
		foreach ($orders as $order){
			$order["orders.createdon"] = $order["createdon"];
			$totalAmount = $order["totalamount"];
			$totalAmount = number_format($totalAmount,2,'.','');
			$order["totalamount"] =  "Rs. " .$totalAmount;
			array_push($mainArr, $order);
		}
		$jsonArr["Rows"] =  $mainArr;
		$jsonArr["TotalRows"] = $this->getCount();
		return $jsonArr;
	}
	
	public function getCount(){
		$sessionUtil = SessionUtil::getInstance();
		$isRepersentative = $sessionUtil->isRepresentative();
		$query = "SELECT count(*) FROM orders inner join customers on orders.customerseq = customers.seq";
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
			$orderProductDetailMgr->deleteInListByOrderSeq($ids);
		}
		return $flag;
	}
	
	
}