<?php
require_once('../IConstants.inc');
require_once($ConstantsArray['dbServerUrl'] ."Managers/PurchaseReturnMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/SessionUtil.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/DateUtil.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/PurchaseReturn.php");
$sessionUtil = SessionUtil::getInstance();
$sessionUtil->actionSessionCheck();
$success = 1;
$message = "";
$call = "";
$response = new ArrayObject();
$purchaseReturnMgr = PurchaseReturnMgr::getInstance();
if(isset($_GET["call"])){
	$call = $_GET["call"];
}else{
	$call = $_POST["call"];
}
if($call == "savePurchaseReturn"){
	try{
		$purchaseReturnMgr->savePurchaseReturnsFromRequest();
		$message = "Return saved successfully!";
	}catch(Exception $e){
		$success = 0;
		$message  = $e->getMessage();
	}
}
$response["success"] = $success;
$response["message"] = $message;
echo json_encode($response);
return;