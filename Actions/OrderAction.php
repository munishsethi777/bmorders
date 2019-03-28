<?php
require_once('../IConstants.inc');
require_once($ConstantsArray['dbServerUrl'] ."Managers/OrderMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/SessionUtil.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/Order.php");
$success = 1;
$message = "";
$call = "";
$response = new ArrayObject();
$oderMgr = OrderMgr::getInstance();
$sessionUtil = SessionUtil::getInstance();
if(isset($_GET["call"])){
	$call = $_GET["call"];
}else{
	$call = $_POST["call"];

}
if($call == "saveOrder"){
	$order = new Order();
	try{
		$order->createFromRequest($_REQUEST);
		$order->setCreatedOn(new DateTime());
		$order->setIsPaymentCompletelyPaid(0);
		$userSeq = $sessionUtil->getUserLoggedInSeq();
		$productDetail = $_REQUEST["products"];
		if(empty($productDetail)){
			throw new Exception("Please Select at least one product");
		}
		$order->setUserSeq($userSeq);
		$oderMgr->saveOrder($order, $_REQUEST);
		$message = "Order saved successfully!";
	}catch(Exception $e){
		$success = 0;
		$message  = $e->getMessage();
	}
}
if($call == "getAllOrders"){
	$orders = $oderMgr->getAllOrdersForGrid();
	echo json_encode($orders);
	return;
}
if($call == "deleteOrders"){
	$ids = $_GET["ids"];
	try{
		$oderMgr->deleteBySeqs($ids);
		$message = "Order(s) Deleted successfully";
	}catch(Exception $e){
		$success = 0;
		$message = $e->getMessage();
		//$message = ErrorUtil::checkReferenceError(LearningPlan::$className,$e);
	}
}
if($call == "exportOrders"){
	try{
		$queryString = $_GET["queryString"];
		$oderMgr->exportOrders($queryString);
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

