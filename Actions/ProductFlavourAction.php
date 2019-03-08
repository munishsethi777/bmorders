<?php
require_once('../IConstants.inc');
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/ProductFlavour.php");
require_once($ConstantsArray['dbServerUrl'] ."Managers/ProductFlavourMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/SessionUtil.php");

$call = "";
if(isset($_GET["call"])){
	$call = $_GET["call"];
}else{
	$call = $_POST["call"];
}
$sessionUtil = SessionUtil::getInstance();
$userSeq = $sessionUtil->getUserLoggedInSeq();
$productFlavourMgr = ProductFlavourMgr::getInstance();
$success = 1;
$message = "";
if($call == "saveProductFlavour"){
	try{
		$isEnabled = 0;
		if (isset ($_POST ['isenabled'] )) {
			$isEnabled = 1;
		}
		$productFlavour = new ProductFlavour();
		$productCategory = $productFlavour->createFromRequest($_REQUEST);
		$productFlavour->setUserSeq($userSeq);
		$productFlavour->setCreatedOn(new DateTime());
		$productFlavour->setLastModifiedOn(new DateTime());
		$productFlavour->setIsEnabled($isEnabled);
		$productFlavourMgr->save($productFlavour);
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
if($call == "getAllProductFlavours"){
	$objs = $productFlavourMgr->getAllForGrid();
	echo json_encode($objs);
}
if($call == "deleteProductFlavours"){
	    $ids = $_GET["ids"];
	    try{
	    	$productFlavourMgr->deleteBySeqs($ids);
	    	$message = "Product Flavour(s) Deleted successfully";
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
