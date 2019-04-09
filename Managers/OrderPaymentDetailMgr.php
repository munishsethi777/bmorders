<?php
require_once($ConstantsArray['dbServerUrl'] ."DataStores/BeanDataStore.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/OrderPaymentDetail.php");
require_once($ConstantsArray['dbServerUrl'] ."Managers/NotificationMgr.php");
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
		$existingPayments = $this->findSeqsByOrderSeq($orderSeq);
		$existingSeqs = array_keys($existingPayments);
		$seqsForDelete = array_diff($existingSeqs, $seqs);
		$paymentModes = $_REQUEST["paymentmode"];
		$amounts = $_REQUEST["amount"];
		$details = $_REQUEST["detail"];
		$expectedDates = $_REQUEST["expectedon"];
		$isConfirmed = $_REQUEST["isconfirmed"];
		$isPaid = $_REQUEST["ispaid"];
		$allPaidPayments = array();
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
				$expectedDate->setTime(0,0);
				$orderPaymnetDetail->setExpectedOn($expectedDate);
			}
			$orderPaymnetDetail->setIsConfirmed($isConfirmed[$key]);
			$orderPaymnetDetail->setIsPaid($isPaid[$key]);
			$orderPaymnetDetail->setOrderSeq($orderSeq);
			$orderPaymnetDetail->setCreatedOn(new DateTime());
			$paymentSeq = self::$dataStore->save($orderPaymnetDetail);
			if(!empty($isPaid[$key])){
				$allPaidPayments[$paymentSeq] = $orderPaymnetDetail;
			}
		}
		if(!empty($seqsForDelete)){
			$seqsForDelete = implode(",", $seqsForDelete);
			$this->deleteInList($seqsForDelete);
		}
		$notificationMgr = NotificationMgr::getInstance();
		$notificationMgr->saveCreatePaymentNotificationForEmail($allPaidPayments, $existingPayments);
		
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
		$orderPaymentDetails = self::$dataStore->executeConditionQuery($colVal);
		$orderPaymentDetails = $this->groupBySeq($orderPaymentDetails, "seq");
		return $orderPaymentDetails;
	}
	
	public function findPaidPaymentsByOrderSeq($orderSeq){
		$colVal["orderSeq"] = $orderSeq;
		$colVal["ispaid"] = 1;
		$orderPaymentDetails = self::$dataStore->executeConditionQuery($colVal);
		$orderPaymentDetails = $this->groupBySeq($orderPaymentDetails, "seq");
		return $orderPaymentDetails;
	}
	
	function groupBySeq($array, $key) {
		$return = array();
		foreach($array as $val) {
			$return[$val->getSeq()] = $val;
		}
		return $return;
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
	public function getAllPayments(){
		$query = 'select orderpaymentdetails.*,orders.seq as ordernumber,orders.createdon as orderdate,customers.title as customer from orderpaymentdetails
inner join orders on orders.seq = orderpaymentdetails.orderseq inner join customers on customers.seq = orders.customerseq';
		$payments = self::$dataStore->executeQuery($query,true);
		return $payments;
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
	
	public function getExpectedPayments(){
		$expectedOn = new DateTime();
		$expectedOn->setTime(0, 0);
		$expectedOnToday = new DateTime();
		$expectedOnToday->modify("+2 days");
		$expectedOnToday->setTime(0, 0);
		$expectedOnStr = $expectedOn->format("Y-m-d H:i:s");
		$expectedOnTodayStr = $expectedOnToday->format("Y-m-d H:i:s");
		$query = "select * from orderpaymentdetails where isnotificationgenerated is  NULL and ispaid = 0 and (expectedon = '$expectedOnStr' or expectedon = '$expectedOnTodayStr') ";
		$expectedPayments = self::$dataStore->executeObjectQuery($query);
		return $expectedPayments;
	}
	
	public function getRecentExpectedPayments(){
		$query = "select orderpaymentdetails.*,customers.title from orderpaymentdetails 
inner join orders on orderpaymentdetails.orderseq = orders.seq inner join customers on orders.customerseq = customers.seq
where ispaid = 0 and expectedon is not NULL order by expectedon desc limit 0,9";
		$expectedPayments = self::$dataStore->executeQuery($query);
		$mainArr = array();
		foreach ($expectedPayments as $payment){
			$expectedOn = $payment["expectedon"];
			$expectedOn = DateUtil::StringToDateByGivenFormat("Y-m-d H:i:s", $expectedOn);
			$expectedOn = $expectedOn->format("M d, Y");
			$payment["expectedon"] = $expectedOn;
			$amount = $payment["amount"];
			$amount = number_format($amount,2,'.','');
			$payment["amount"] = $amount;
			array_push($mainArr, $payment);
		}
		return $mainArr;
	}
	
	public function updateIsNotificationFlag($flag,$seq){
		$colval["isnotificationgenerated"] = $flag;
		$condition["seq"] = $seq;
		self::$dataStore->updateByAttributesWithBindParams($colval,$condition);
	}
	
	public function exportPayments($queryString){
		$output = array();
		parse_str($queryString, $output);
		$_GET = array_merge($_GET,$output);
		$payments =$this->getAllPayments();
		ExportUtil::exportPayments($payments);
	}
	
	function getPaymentsForDashBoard($days,$userSeq){
		$toDate = new DateTime();
		$fromDate = new DateTime();
		$fromDate->setTime(0, 0);
		$fromDate->modify("-".$days . "days");
		$fromDateStr = $fromDate->format("Y-m-d H:i:s");
		$toDateStr = $toDate->format("Y-m-d H:i:s");
		$query = "select sum(orderpaymentdetails.amount) as amount, CAST(orderpaymentdetails.createdon AS DATE) as createddate from orderpaymentdetails inner join orders on orders.seq = orderpaymentdetails.orderseq where ispaid = 1 and orderpaymentdetails.createdon >= '$fromDateStr' and orderpaymentdetails.createdon <= '$toDateStr' GROUP BY createddate";
		if(!empty($userSeq)){
			$query .= " and orders.userseq = $userSeq";
		}
		$payments =self::$dataStore->executeQuery($query,false,true);
		$paymentArr = array();
		if(!empty($payments)){
			$paymentArr = $this->groupByDate($payments,"createddate");
		}
		return $paymentArr;
	}
	
	function groupByDate($array, $key) {
		$return = array();
		foreach($array as $val) {
			$return[$val[$key]][] = $val;
		}
		return $return;
	}
	
}