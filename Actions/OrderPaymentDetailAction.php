<?php
require_once('../IConstants.inc');
require_once($ConstantsArray['dbServerUrl'] ."Managers/OrderPaymentDetailMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/SessionUtil.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/OrderPaymentDetail.php");

$success = 1;
$message = "";
$call = "";
$response = new ArrayObject();
$oderPaymentDetailMgr = OrderPaymentDetailMgr::getInstance();
if(isset($_GET["call"])){
	$call = $_GET["call"];
}else{
	$call = $_POST["call"];
}
if($call == "savePaymentDetail"){
	try{
		$orderSeq = $_REQUEST["orderSeq"];
		$oderPaymentDetailMgr->savePaymentDetailFromRequest($orderSeq);
		$message = "PaymentDetail saved successfully!";
	}catch(Exception $e){
		$success = 0;
		$message  = $e->getMessage();
	}
}
if($call == "getDetailByOrderSeq"){
	$orderSeq = $_GET["orderSeq"];
	$paymentDetail = $oderPaymentDetailMgr->findByOrderSeq($orderSeq);
	echo json_encode($paymentDetail);
	return;
}
if($call == "getOrderPaymentDetails"){
	$payments = $oderPaymentDetailMgr->getAllPaymentsForGrid();
	echo json_encode($payments);
	return;
}
if($call == "exportPayments"){
	try{
		$queryString = $_GET["queryString"];
		$oderPaymentDetailMgr->exportPayments($queryString);
		return;
	}catch(Exception $e){
		$success = 0;
		$message = $e->getMessage();
	}
}
$response["success"] = $success;
$response["message"] = $message;
echo json_encode($response);
return;