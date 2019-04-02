<?php
require_once('../IConstants.inc');
require_once($ConstantsArray['dbServerUrl'] ."Managers/CashbookMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/SessionUtil.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/Cashbook.php");
require_once($ConstantsArray['dbServerUrl'] ."Enums/ExpenseType.php");
require_once($ConstantsArray['dbServerUrl'] ."Enums/TransactionType.php");
require_once($ConstantsArray['dbServerUrl'] ."Managers/UserMgr.php");
$success = 1;
$message = "";
$call = "";
$response = new ArrayObject();
$cashbookMgr = CashbookMgr::getInstance();
if(isset($_GET["call"])){
	$call = $_GET["call"];
}else{
	$call = $_POST["call"];

}
if($call == "saveCashbook"){
	$cashbook = new Cashbook();
	$userSeq = SessionUtil::getInstance()->getUserLoggedInSeq();
	try{
		$cashbook->createFromRequest($_REQUEST);
		$cashbook->setUserSeq($userSeq);
		$cashbook->setCreatedOn(new DateTime());
		if($cashbook->getTransactionType() == "receipt"){
			$cashbook->setCategory(null);
		}
		$cashbookMgr->saveCashbook($cashbook);
		$message = "Cash book saved successfully!";
	}catch(Exception $e){
		$success = 0;
		$message  = $e->getMessage();
	}
}
if($call == "getAllCashbook"){
	$cashbook = $cashbookMgr->getAllForGrid();
	echo json_encode($cashbook);
	return;
}
if($call == "deleteCashbook"){
	$ids = $_GET["ids"];
	try{
		$cashbookMgr->deleteInList($ids);
		$message = "Record(s) Deleted successfully";
	}catch(Exception $e){
		$success = 0;
		$message = $e->getMessage();
	}
}
if($call == "exportCashbook"){
	try{
		$queryString = $_GET["queryString"];
		$cashbookMgr->exportCashbooks($queryString);
		return;
	}catch(Exception $e){
		$success = 0;
		$message = $e->getMessage();
	}
}
if($call == "getMenusForFilter"){
	try{
		$userMgr = UserMgr::getInstance();
		$categories = ExpenseType::getAll();
		$categories = array_values($categories);
		$response["categories"] = $categories;
		$transactionTypes = TransactionType::getAll();
		$transactionTypes = array_values($transactionTypes);
		$response["transactiontypes"] = $transactionTypes;
		$response["users"] = $userMgr->getAllUserNames();
		echo json_encode($response);
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
