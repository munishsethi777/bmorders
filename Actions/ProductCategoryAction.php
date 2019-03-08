<?php
require_once('../IConstants.inc');
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/ProductCategory.php");
require_once($ConstantsArray['dbServerUrl'] ."Managers/ProductCategoryMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/SessionUtil.php");

$call = "";
if(isset($_GET["call"])){
	$call = $_GET["call"];
}else{
	$call = $_POST["call"];
}
$sessionUtil = SessionUtil::getInstance();
$userSeq = $sessionUtil->getUserLoggedInSeq();
$productCategoryMgr = ProductCategoryMgr::getInstance();
$success = 1;
$message = "";
if($call == "saveProductCategory"){
	try{
		$isEnabled = 0;
		if (isset ($_POST ['isenabled'] )) {
			$isEnabled = 1;
		}
		$productCategory = new ProductCategory();
		$productCategory = $productCategory->createFromRequest($_REQUEST);
		$productCategory->setUserSeq($userSeq);
		$productCategory->setCreatedOn(new DateTime());
		$productCategory->setLastModifiedOn(new DateTime());
		$productCategory->setIsEnabled($isEnabled);
		$productCategoryMgr->save($productCategory);
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
if($call == "getAllProductCategories"){
	$objs = $productCategoryMgr->getAllForGrid();
	echo json_encode($objs);
}
if($call == "deleteProductCategories"){
	    $ids = $_GET["ids"];
	    try{
	    	$productCategoryMgr->deleteBySeqs($ids);
	    	$message = "Product Category(s) Deleted successfully";
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
