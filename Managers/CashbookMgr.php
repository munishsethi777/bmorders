<?php
require_once($ConstantsArray['dbServerUrl'] ."DataStores/BeanDataStore.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/Cashbook.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/ExportUtil.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/SessionUtil.php");
require_once($ConstantsArray['dbServerUrl'] ."Enums/ExpenseType.php");
require_once($ConstantsArray['dbServerUrl'] ."Enums/TransactionType.php");
class CashbookMgr{
	private static $cashbookMgr;
	private static $dataStore;
	private static $sessionUtil;

	public static function getInstance(){
		if (!self::$cashbookMgr){
			self::$cashbookMgr = new CashbookMgr();
			self::$dataStore = new BeanDataStore(Cashbook::$className, Cashbook::$tableName);
		}
		return self::$cashbookMgr;
	}

	public function saveCashbook($cashbook){
		$id = self::$dataStore->save($cashbook);
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
		$expenses = $this->getCashbooks();
		$mainArr = array();
		foreach ($expenses as  $expense){
			$amount = $expense["amount"];
			$amount = number_format($amount,2,'.','');
			$expense["amount"] =  "Rs. " .$amount;
			$expense["category"] = ExpenseType::getValue($expense["category"]);
			$expense["cashbook.createdon"] = $expense["createdon"];
			$expense["transactiontype"] = TransactionType::getValue($expense["transactiontype"]);
			array_push($mainArr, $expense);
		}
		$jsonArr["Rows"] =  $mainArr;
		$jsonArr["TotalRows"] = $this->getAllCount();
		return $jsonArr;
	}

	public function getAllCount(){
		$query = "select count(*) from cashbook inner join users on cashbook.userseq = users.seq";
		$sessionUtil = SessionUtil::getInstance();
		$isRep = $sessionUtil->isRepresentative();
		if($isRep){
			$userSeq = $sessionUtil->getUserLoggedInSeq();
			$query .= " where cashbook.userseq = $userSeq";
		}
		$count = self::$dataStore->executeCountQueryWithSql($query,true);
		return $count;
	}
	
	private function getCashbooks(){
		$query = "select cashbook.*,users.fullname from cashbook inner join users on cashbook.userseq = users.seq";
		$sessionUtil = SessionUtil::getInstance();
		$isRep = $sessionUtil->isRepresentative();
		if($isRep){
			$userSeq = $sessionUtil->getUserLoggedInSeq();
			$query .= " where cashbook.userseq = $userSeq";
		}
		$cashbooks = self::$dataStore->executeQuery($query,true);
		return $cashbooks;
	}

	public function exportCashbooks($queryString){
		$output = array();
		parse_str($queryString, $output);
		$_GET = array_merge($_GET,$output);
		$cashBooks =$this->getCashbooks();
		ExportUtil::exportCashbook($cashBooks);
	}
}