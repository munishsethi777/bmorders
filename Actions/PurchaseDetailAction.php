<?php
require_once('../IConstants.inc');
require_once($ConstantsArray['dbServerUrl'] ."Managers/PurchaseDetailMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/SessionUtil.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/PurchaseDetail.php");

$sessionUtil = SessionUtil::getInstance();
$sessionUtil->actionSessionCheck();
$success = 1;
$message = "";
$call = "";
$response = new ArrayObject();
$purchaseDetailMgr = PurchaseDetailMgr::getInstance();
if(isset($_GET["call"])){
	$call = $_GET["call"];
}else{
	$call = $_POST["call"];
}
if($call == "getDetailByPurchaseSeq"){
	$purchaseSeq = $_GET["purchaseSeq"];
	$purchaseDetails = $purchaseDetailMgr->findByPurchaseSeq($purchaseSeq);
	echo json_encode($purchaseDetails);
}

if($call == "getPurchaseDetailByPurchaseSeq"){
	$purchaseSeq = $_GET["purchaseSeq"];
	$products = $purchaseDetailMgr->getPurchaseDetailByPurchaseSeqForNestedGrid($purchaseSeq);
	echo json_encode($products);
}
