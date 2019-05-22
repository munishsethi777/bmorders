<?php
require_once($ConstantsArray['dbServerUrl'] ."DataStores/BeanDataStore.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/PurchaseReturn.php");
require_once($ConstantsArray['dbServerUrl'] ."StringConstants.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/DateUtil.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/ExportUtil.php");

class PurchaseReturnMgr{
	private static $purchaseReturnMgr;
	private static $dataStore;
	private static $sessionUtil;

	public static function getInstance(){
		if (!self::$purchaseReturnMgr){
			self::$purchaseReturnMgr = new PurchaseReturnMgr();
			self::$dataStore = new BeanDataStore(PurchaseReturn::$className, PurchaseReturn::$tableName);
		}
		return self::$purchaseReturnMgr;
	}
	
	public function savePurchaseReturnsFromRequest(){
		$purchaseSeq = $_REQUEST["purchaseseq"];
		$this->deleteByPurchaseSeq($purchaseSeq);
		$purchaseDetailSeqArr = $_REQUEST["purchasedetailseq"];
		$quantityArr = $_REQUEST["quantity"];
		$commentArr = $_REQUEST["comments"];
		$isReturnArr = $_REQUEST["isreturn"];
		foreach ($isReturnArr as $key=>$isReturn){
			if(empty($isReturn)){
				continue;
			}
			$quantity = $quantityArr[$key];
			if(empty($quantity)){
				continue;
			}
			$comment = $commentArr[$key];
			$purchaseReturn = new PurchaseReturn();
			$purchaseReturn->setComments($comment);
			$purchaseReturn->setCreatedOn(new DateTime());
			$purchaseReturn->setPurchaseDetailSeq($purchaseDetailSeqArr[$key]);
			$purchaseReturn->setPurchaseSeq($purchaseSeq);
			$purchaseReturn->setQuantity($quantity);
			self::$dataStore->save($purchaseReturn);
		}
	}
	
	public function getReturnDetailByPurchaseSeq($purchaseSeq){
		$query = "select * from purchasereturns where purchaseseq = $purchaseSeq";
		$purchaseReturns = self::$dataStore->executeQuery($query);
		$purchaseReturns = $this->_group_by($purchaseReturns, "purchasedetailseq");
		return $purchaseReturns;
	}
	
	private function deleteByPurchaseSeq($purchaseSeq){
		$attr["purchaseseq"] = $purchaseSeq;
		self::$dataStore->deleteByAttribute($attr);
	}
	
	function _group_by($array, $key) {
		$return = array();
		foreach($array as $val) {
			$return[$val[$key]][] = $val;
		}
		return $return;
	}
	
	
}