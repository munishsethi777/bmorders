<?php
require_once('../IConstants.inc');
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/Product.php");
require_once($ConstantsArray['dbServerUrl'] ."Managers/ProductMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/FileUtil.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/SessionUtil.php");

$call = "";
if(isset($_GET["call"])){
	$call = $_GET["call"];
}else{
	$call = $_POST["call"];
}
$productMgr = ProductMgr::getInstance();
$sessionUtil = SessionUtil::getInstance();
$userSeq = $sessionUtil->getUserLoggedInSeq();

$success = 1;
$message = "";
if($call == "saveProduct"){
	try{
		$product = new Product();
		$isEnabled = 0;
		if (isset ($_POST ['isenabled'] )) {
			$isEnabled = 1;
		}
		if(isset($_FILES["productImage"])){
			$file = $_FILES["productImage"];
			$filename = $file["name"];
			if(!empty($filename)){
				$imageType = pathinfo($filename, PATHINFO_EXTENSION);
				$product->setImageFormat($imageType);
			}
		}
		
		$product = $product->createFromRequest($_REQUEST);
		$product->setUserSeq($userSeq);
		$product->setCreatedOn(new DateTime());
		$product->setLastModifiedOn(new DateTime());
		$product->setIsEnabled($isEnabled);
		$id= $productMgr->saveProduct($product);
		if(isset($_FILES["productImage"])){
			$file = $_FILES["productImage"];
			$filename = $file["name"];
			if(!empty($filename)){
				$uploaddir = $ConstantsArray['productImagesFolderPath'];//StringConstants::IMAGE_PATH_PRODUCTS;
				$name = $id . ".".$imageType;
				FileUtil::uploadImageFiles($file,$uploaddir,$name);
			}
		}
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
if($call == "getAllProducts"){
	$products = $productMgr->getAllProductsForGrid();
	echo json_encode($products);
}
if($call == "deleteProducts"){
	    $ids = $_GET["ids"];
	    try{
	    	$customerMgr->deleteBySeqs($ids);
	    	$message = "Product(s) Deleted successfully";
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

