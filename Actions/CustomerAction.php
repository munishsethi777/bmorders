<?php
require_once('../IConstants.inc');
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/Customer.php");
require_once($ConstantsArray['dbServerUrl'] ."Managers/CustomerMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/SessionUtil.php");

$call = "";
if(isset($_GET["call"])){
	$call = $_GET["call"];
}else{
	$call = $_POST["call"];
}
$sessionUtil = SessionUtil::getInstance();
$userSeq = $sessionUtil->getUserLoggedInSeq();
$customerMgr = CustomerMgr::getInstance();
$success = 1;
$message = "";
if($call == "saveCustomer"){
	try{
		$isEnabled = 0;
		if (isset ($_POST ['isenabled'] )) {
			$isEnabled = 1;
		}
		$customer = new Customer();
		$customer = $customer->createFromRequest($_REQUEST);
		$customer->setUserSeq($userSeq);
		$customer->setCreatedOn(new DateTime());
		$customer->setLastModifiedOn(new DateTime());
		$customer->setIsEnabled($isEnabled);
		$customerMgr->saveCustomer($customer);
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
if($call == "getAllCustomers"){
	$customers = $customerMgr->getAllCustomersForGrid();
	echo json_encode($customers);
}
if($call == "deleteCustomers"){
	    $ids = $_GET["ids"];
	    try{
	    	$customerMgr->deleteBySeqs($ids);
	    	$message = "Customer(s) Deleted successfully";
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
if($call == "searchCustomer"){
	$searchString = $_GET["q"];
	$customers  = $customerMgr->searchCustomers($searchString);
	$response['results'] = array();
	foreach($customers as $customer){
		$text = $customer['title'];
		$json = array();
		$json['text'] = $text;
		$json['id'] = $customer['seq'];
		array_push($response['results'],$json);
	}
	echo json_encode($response);
}

if($call == "getCustomerTitlesForFilter"){
	$customersTitles = $customerMgr->getAllCustomerTitles();
	$response["customers"] = $customersTitles;
	echo json_encode($response);
}
if($call == "exportCustomers"){
	try{
		$queryString = $_GET["queryString"];
		$customerMgr->exportCustomers($queryString);
		return;
	}catch(Exception $e){
		$success = 0;
		$message = $e->getMessage();
	}
}