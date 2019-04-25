<?php
require_once('../IConstants.inc');
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/ProductBrand.php");
require_once($ConstantsArray['dbServerUrl'] ."Managers/ProductBrandMgr.php");
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
$productBrandMgr = ProductBrandMgr::getInstance();
$success = 1;
$message = "";
if($call == "saveProductBrand"){
	try{
		$isEnabled = 0;
		if (isset ($_POST ['isenabled'] )) {
			$isEnabled = 1;
		}
		$productBrand = new ProductBrand();
		$productBrand = $productBrand->createFromRequest($_REQUEST);
		$productBrand->setUserSeq($userSeq);
		$productBrand->setCreatedOn(new DateTime());
		$productBrand->setLastModifiedOn(new DateTime());
		$productBrand->setIsEnabled($isEnabled);
		$productBrandMgr->save($productBrand);
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
if($call == "getAllProductBrands"){
	$productBrands = $productBrandMgr->getAllForGrid();
	echo json_encode($productBrands);
}
if($call == "deleteProductBrands"){
	    $ids = $_GET["ids"];
	    try{
	    	$productBrandMgr->deleteBySeqs($ids);
	    	$message = "Product Brand(s) Deleted successfully";
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
