<?php
require_once($ConstantsArray['dbServerUrl'] ."DataStores/BeanDataStore.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/OrderPaymentDetail.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/DateUtil.php");
require_once($ConstantsArray['dbServerUrl'] ."Enums/PaymentMode.php");

class OrderPaymentDetailMgr{
	private static $OrderPaymentDetailMgr;
	private static $dataStore;
	private static $sessionUtil;

	public static function getInstance(){
		if (!self::$OrderPaymentDetailMgr){
			self::$OrderPaymentDetailMgr = new OrderPaymentDetailMgr();
			self::$dataStore = new BeanDataStore(OrderPaymentDetail::$className, OrderPaymentDetail::$tableName);
		}
		return self::$OrderPaymentDetailMgr;
	}
	
	public function savePaymentDetailFromRequest($orderSeq){
		$seqs = $_REQUEST["seq"];
		$existingSeqs = $this->findSeqsByOrderSeq($orderSeq);
		$seqsForDelete = array_diff($existingSeqs, $seqs);
		$paymentModes = $_REQUEST["paymentmode"];
		$amounts = $_REQUEST["amount"];
		$details = $_REQUEST["detail"];
		$expectedDates = $_REQUEST["expectedon"];
		$isConfirmed = $_REQUEST["isconfirmed"];
		$isPaid = $_REQUEST["ispaid"];
		foreach ($paymentModes as $key=>$paymentMode){
			$orderPaymnetDetail = new OrderPaymentDetail();
			if(!empty($seqs[$key])){
				$orderPaymnetDetail->setSeq($seqs[$key]);
			}
			$orderPaymnetDetail->setPaymentMode($paymentMode);
			$orderPaymnetDetail->setAmount($amounts[$key]);
			$orderPaymnetDetail->setDetails($details[$key]);
			$expectedDate = $expectedDates[$key];
			if(!empty($expectedDate)){
				$expectedDate = DateUtil::StringToDateByGivenFormat("d-m-Y", $expectedDate);
				$orderPaymnetDetail->setExpectedOn($expectedDate);
			}
			$orderPaymnetDetail->setIsConfirmed($isConfirmed[$key]);
			$orderPaymnetDetail->setIsPaid($isPaid[$key]);
			$orderPaymnetDetail->setOrderSeq($orderSeq);
			$orderPaymnetDetail->setCreatedOn(new DateTime());
			self::$dataStore->save($orderPaymnetDetail);
		}
		if(!empty($seqsForDelete)){
			$seqsForDelete = implode(",", $seqsForDelete);
			$this->deleteInList($seqsForDelete);
		}
	}
	
	public function deleteInList($seqs){
		self::$dataStore->deleteInList($seqs);
	}
	
	public function deleteByOrderSeqs($orderSeqs){
		$query = "delete from orderpaymentdetails where orderseq in ($orderSeqs)";
		self::$dataStore->executeQuery($query);
	}
	
	public function findByOrderSeq($orderSeq){
		$query = "SELECT * FROM orderpaymentdetails where orderseq = $orderSeq";
		$orderPaymentDetails = self::$dataStore->executeQuery($query,false,true);
		$mainArr = array();
		foreach ($orderPaymentDetails as $orderPaymentDetail){
			$expectedDate = $orderPaymentDetail["expectedon"];
			if(!empty($expectedDate)){
				$expectedDate = DateUtil::StringToDateByGivenFormat("Y-m-d H:i:s", $expectedDate);
				$expectedDate = $expectedDate->format("d-m-Y");
				$orderPaymentDetail["expectedon"] = $expectedDate;
			}
			array_push($mainArr, $orderPaymentDetail);
		}
		return $mainArr;
	}
	
	public function findSeqsByOrderSeq($orderSeq){
		$colVal["orderSeq"] = $orderSeq;
		$orderPaymentDetail = self::$dataStore->executeConditionQuery($colVal);
		$seqs = array_map(create_function('$o', 'return $o->getSeq();'), $orderPaymentDetail);
		return $seqs;
	}
	
	public function getPaymentModesJson(){
		$paymentModes = PaymentMode::getAll();
		return  json_encode($paymentModes);
	}
	
	public function getAllPaymentsForGrid(){
		$query = 'select orderpaymentdetails.*,orders.seq as ordernumber,orders.createdon as orderdate,customers.title as customer from orderpaymentdetails
inner join orders on orders.seq = orderpaymentdetails.orderseq inner join customers on customers.seq = orders.customerseq';
		$payments = self::$dataStore->executeQuery($query,true);
		$mainArr = array();
		foreach ($payments as  $payment){
			$payment["orders.seq"] = $payment["ordernumber"];
			$payment["orderseq"] = $payment["ordernumber"];
			$payment["orders.createdon"] = $payment["orderdate"];
			$payment["customers.title"] = $payment["customer"];
			$payment["orderpaymentdetails.createdon"] = $payment["createdon"];
			$amount = number_format($payment["amount"],2,'.','');
			//$payment["ispaid"] = !empty($payment["ispaid"]);
			$payment["amount"] = $amount;
			array_push($mainArr, $payment);
		}
		$jsonArr["Rows"] =  $mainArr;
		$jsonArr["TotalRows"] = $this->getAllCount();
		return $jsonArr;
	}
	
	public function getAllCount(){
		$query = 'select count(*) from orderpaymentdetails inner join orders on orders.seq = orderpaymentdetails.orderseq inner join customers on customers.seq = orders.customerseq';
		$count = self::$dataStore->executeCountQueryWithSql($query,true);
		return $count;
	}
	
	public function getOrderPayments($orderSeq, $isPaid){
		$query = "select sum(amount) from orderpaymentdetails where ispaid = $isPaid and orderseq = ". $orderSeq;
		$response = self::$dataStore->executeCountQueryWithSql($query);
		return $response;
	}
	
}