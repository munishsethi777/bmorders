<?php
require_once('../IConstants.inc');
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/Supplier.php");
require_once($ConstantsArray['dbServerUrl'] ."Managers/SupplierMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/SessionUtil.php");

$call = "";
if(isset($_GET["call"])){
	$call = $_GET["call"];
}else{
	$call = $_POST["call"];
}
$sessionUtil = SessionUtil::getInstance();
$sessionUtil->actionSessionCheck();

$userSeq = $sessionUtil->getUserLoggedInSeq();
$supplierMgr = SupplierMgr::getInstance();
$success = 1;
$message = "";
if($call == "saveSupplier"){
	try{
		$isEnabled = 0;
		if (isset ($_POST ['isenabled'] )) {
			$isEnabled = 1;
		}
		$isRegistered = 0;
		if (isset ($_POST ['isregistered'] )) {
			$isRegistered = 1;
		}
		$supplier = new Supplier();
		$supplier = $supplier->createFromRequest($_REQUEST);
		$supplier->setUserSeq($userSeq);
		$supplier->setCreatedOn(new DateTime());
		$supplier->setLastModifiedOn(new DateTime());
		$supplier->setIsEnabled($isEnabled);
		$supplier->setIsRegistered($isRegistered);
		$supplierMgr->saveSupplier($supplier);
		$message = "Supplier Saved Successfully!";
	}catch (Exception $e){
		$success = 0;
		$message  = $e->getMessage();
	}
	$response = new ArrayObject();
	$response["success"]  = $success;
	$response["message"]  = $message;
	echo json_encode($response);
	return;
}
if($call == "getAllSuppliers"){
	$suppliers = $supplierMgr->getAllSuppliersForGrid();
	echo json_encode($suppliers);
}
if($call == "deleteSuppliers"){
	    $ids = $_GET["ids"];
	    try{
	    	$supplierMgr->deleteBySeqs($ids);
	    	$message = "Supplier(s) Deleted successfully";
	    }catch(Exception $e){
	        $success = 0;
	        $message = $e->getMessage();
	        //$message = ErrorUtil::checkReferenceError(LearningPlan::$className,$e);
	    }
	    $response = new ArrayObject();
	    $response["message"] = $message;
	    $response["success"] =  $success;
	    echo json_encode($response);
}
if($call == "searchSupplier"){
	$searchString = $_GET["q"];
	$suppliers  = $supplierMgr->searchSuppliers($searchString);
	$response['results'] = array();
	foreach($suppliers as $supplier){
		$text = $supplier['title'];
		$json = array();
		$json['text'] = $text;
		$json['id'] = $supplier['seq'];
		array_push($response['results'],$json);
	}
	echo json_encode($response);
}
if($call == "getSupplierBySeq"){
	$supplierSeq = $_GET["supplierSeq"];
	$suppliers  = $supplierMgr->findArrBySeq($supplierSeq);
	echo json_encode($suppliers);
}
if($call == "getSupplierTitlesForFilter"){
	$suppliersTitles = $supplierMgr->getAllSuppliersTitles();
	$response["suppliers"] = $suppliersTitles;
	echo json_encode($response);
}
if($call == "exportSuppliers"){
	try{
		$queryString = $_GET["queryString"];
		$supplierMgr->exportCustomers($queryString);
		return;
	}catch(Exception $e){
		$success = 0;
		$message = $e->getMessage();
	}
}