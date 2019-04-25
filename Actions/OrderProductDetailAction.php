<?php
require_once('../IConstants.inc');
require_once($ConstantsArray['dbServerUrl'] ."Managers/OrderProductDetailMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/SessionUtil.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/OrderProductDetail.php");

$sessionUtil = SessionUtil::getInstance();
$sessionUtil->actionSessionCheck();
$success = 1;
$message = "";
$call = "";
$response = new ArrayObject();
$oderDetailMgr =OrderProductDetailMgr::getInstance();
if(isset($_GET["call"])){
	$call = $_GET["call"];
}else{
	$call = $_POST["call"];
}
if($call == "getDetailByProductSeq"){
	$orderSeq = $_GET["orderSeq"];
	$products = $oderDetailMgr->findByOrderSeq($orderSeq);
	echo json_encode($products);
}
