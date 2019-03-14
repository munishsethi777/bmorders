<?php
require_once('../IConstants.inc');
require_once($ConstantsArray['dbServerUrl'] ."Managers/ExpenseLogMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/SessionUtil.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/ExpenseLog.php");
$success = 1;
$message = "";
$call = "";
$response = new ArrayObject();
$expenseLogMgr = ExpenseLogMgr::getInstance();
if(isset($_GET["call"])){
	$call = $_GET["call"];
}else{
	$call = $_POST["call"];

}
if($call == "saveExpenseLog"){
	$expenseLog = new ExpenseLog();
	$userSeq = SessionUtil::getInstance()->getUserLoggedInSeq();
	try{
		$expenseLog->createFromRequest($_REQUEST);
		$expenseLog->setUserSeq($userSeq);
		$expenseLog->setCreatedOn(new DateTime());
		$expenseLogMgr->saveExpenseLog($expenseLog);
		$message = "Cash book saved successfully!";
	}catch(Exception $e){
		$success = 0;
		$message  = $e->getMessage();
	}
}
if($call == "getAllExpenseLogs"){
	$expenses = $expenseLogMgr->getAllForGrid();
	echo json_encode($expenses);
	return;
}
if($call == "deleteExpenseLogs"){
	$ids = $_GET["ids"];
	try{
		$expenseLogMgr->deleteInList($ids);
		$message = "Record(s) Deleted successfully";
	}catch(Exception $e){
		$success = 0;
		$message = $e->getMessage();
	}
}
if($call == "exportExpenseLogs"){
	try{
		$queryString = $_GET["queryString"];
		$expenseLogMgr->exportExpensesLogs($queryString);
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
