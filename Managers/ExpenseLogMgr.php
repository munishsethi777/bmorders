<?php
require_once($ConstantsArray['dbServerUrl'] ."DataStores/BeanDataStore.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/ExpenseLog.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/ExportUtil.php");

class ExpenseLogMgr{
	private static $ExpenseLogMgr;
	private static $dataStore;
	private static $sessionUtil;

	public static function getInstance(){
		if (!self::$ExpenseLogMgr){
			self::$ExpenseLogMgr = new ExpenseLogMgr();
			self::$dataStore = new BeanDataStore(ExpenseLog::$className, ExpenseLog::$tableName);
		}
		return self::$ExpenseLogMgr;
	}
	
	public function saveExpenseLog($expLog){
		$id = self::$dataStore->save($expLog);
		return $id;
	}
	
	public function findBySeq($seq){
		$expLog = self::$dataStore->findBySeq($seq);
		return $expLog;
	}
	
	public function deleteInList($ids){
		$flag = self::$dataStore->deleteInList($ids);
		return $flag;
	}
	
	public function getAllForGrid(){
		$expenses = self::$dataStore->findAllArr(true);
		$mainArr = array();
		foreach ($expenses as  $expense){
			$amount = $expense["amount"];
			$amount = number_format($amount,2,'.','');
			$expense["amount"] =  "Rs. " .$amount;
			array_push($mainArr, $expense);
		}
		$jsonArr["Rows"] =  $mainArr;
		$jsonArr["TotalRows"] = $this->getAllCount();
		return $jsonArr;
	}
	
	public function getAllCount(){
		$query = "select count(*) from expenselogs";
		$count = self::$dataStore->executeCountQueryWithSql($query,true); 
		return $count;
	}
	
	public function exportExpensesLogs($queryString){
		$output = array();
		parse_str($queryString, $output);
		$_GET = array_merge($_GET,$output);
		$expensesLogs =self::$dataStore->findAll(true);
		ExportUtil::exportExpenseLogs($expensesLogs);
	}
}