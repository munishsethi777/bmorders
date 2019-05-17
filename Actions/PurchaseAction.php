<?php
require_once('../IConstants.inc');
require_once($ConstantsArray['dbServerUrl'] ."Managers/PurchaseMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/SessionUtil.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/DateUtil.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/Purchase.php");
$sessionUtil = SessionUtil::getInstance();
$sessionUtil->actionSessionCheck();
$success = 1;
$message = "";
$call = "";
$response = new ArrayObject();
$purchaseMgr = PurchaseMgr::getInstance();
if(isset($_GET["call"])){
	$call = $_GET["call"];
}else{
	$call = $_POST["call"];

}
if($call == "savePurchase"){
	$purchase = new Purchase();
	try{
		$purchase->createFromRequest($_REQUEST);
		$purchase->setCreatedOn(new DateTime());
		$purchase->setDiscount(0);
		$purchase->setLastModifiedOn(new DateTime());
		$userSeq = $sessionUtil->getUserLoggedInSeq();
		$productDetail = $_REQUEST["products"];
		$invoiceDate = $_REQUEST["invoicedate"];
		$invoiceDate = DateUtil::StringToDateByGivenFormat("d-m-Y", $invoiceDate);
		$invoiceDate->setTime(0,0);
		$purchase->setInvoiceDate($invoiceDate);
		if(empty($productDetail)){
			throw new Exception("Please Select at least one product");
		}
		$purchase->setUserSeq($userSeq);
		$purchaseMgr->savePurchase($purchase, $_REQUEST);
		$message = "Order saved successfully!";
	}catch(Exception $e){
		$success = 0;
		$message  = $e->getMessage();
	}
}
if($call == "getAllPurchases"){
	$purchases = $purchaseMgr->getAllPurchasesForGrid();
	echo json_encode($purchases);
	return;
}
if($call == "deletePurchase"){
	$ids = $_GET["ids"];
	try{
		$purchaseMgr->deleteBySeqs($ids);
		$message = "Purchase(s) Deleted successfully";
	}catch(Exception $e){
		$success = 0;
		$message = $e->getMessage();
	}
}
$response["success"] = $success;
$response["message"] = $message;
echo json_encode($response);
return;