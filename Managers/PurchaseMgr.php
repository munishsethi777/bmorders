<?php
require_once($ConstantsArray['dbServerUrl'] ."DataStores/BeanDataStore.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/Purchase.php");
require_once($ConstantsArray['dbServerUrl'] ."Managers/PurchaseDetailMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."StringConstants.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/DateUtil.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/ExportUtil.php");
require_once ($ConstantsArray ['dbServerUrl'] . "log4php/Logger.php");
Logger::configure ( $ConstantsArray ['dbServerUrl'] . "log4php/log4php.xml" );

class PurchaseMgr{
	private static $purchaseMgr;
	private static $dataStore;
	private static $sessionUtil;
	private static $logger;
	public static function getInstance(){
		if (!self::$purchaseMgr){
			self::$purchaseMgr = new PurchaseMgr();
			self::$dataStore = new BeanDataStore(Purchase::$className, Purchase::$tableName);
			self::$logger = Logger::getLogger("logger");
		}
		return self::$purchaseMgr;
	}

	public function findBySeq($seq){
		$purchase = self::$dataStore->findBySeq($seq);
		return $purchase;
	}
	
	public function findArrBySeq($seq){
		$query = "select purchases.*,suppliers.title from purchases inner join suppliers on purchases.supplierseq = suppliers.seq where purchases.seq = $seq";
		$purchases = self::$dataStore->executeQuery($query);
		if(!empty($purchases)){
			return $purchases[0];
		}
		return null;
	}
	
	public function savePurchase($purchase,$purchaseDetail){
		$id = self::$dataStore->save($purchase);
		if($id > 0){
			$purchaseDetailMgr = PurchaseDetailMgr::getInstance();
			$purchaseDetailMgr->savePurchaseDetail($id, $purchaseDetail);
			self::$logger->info("Purchase saved with id ".$id);
		}
		return $id;
	}
	public function getAllPurchasesForGrid(){
		$query = "select purchases.*,suppliers.title from purchases inner join suppliers on purchases.supplierseq = suppliers.seq";
		$suppliers = self::$dataStore->executeQuery($query,true);
		$jsonArr["Rows"] =  $suppliers;
		$jsonArr["TotalRows"] = $this->getCount();
		return $jsonArr;
	}
	
	public function getCount(){
		$query = "select count(*) from purchases inner join suppliers on purchases.supplierseq = suppliers.seq";
		$count = self::$dataStore->executeCountQueryWithSql($query,true);
		return $count;
	}
	
	public function deleteBySeqs($ids) {
		$flag = self::$dataStore->deleteInList ( $ids );
		if($flag){
			$purchaseDetailMgr = PurchaseDetailMgr::getInstance();
			$purchaseDetailMgr->deleteByPurchaseSeqs($ids);
			self::$logger->info("Purchase deleted with id(s) ".$ids);
		}
		return $flag;
	}
	function _group_by($array, $key) {
		$return = array();
		foreach($array as $val) {
			$return[$val[$key]][] = $val;
		}
		return $return;
	}
	
	public function exportPurchases($queryString){
		$query = "select suppliers.title,products.title as producttitle,purchases.*,purchasedetails.lotnumber,purchasedetails.expirydate,purchasedetails.netrate,purchasedetails.discount as detaildiscount,purchasedetails.quantity from purchases 
inner join suppliers on purchases.supplierseq = suppliers.seq inner join purchasedetails on purchases.seq = purchasedetails.purchaseseq inner join products on products.seq = purchasedetails.productseq";
		$output = array();
		parse_str($queryString, $output);
		$_GET = array_merge($_GET,$output);
		$purchases = self::$dataStore->executeQuery($query);
		$purchases = $this->_group_by($purchases, "seq");
		ExportUtil::exportPurchases($purchases);
	}
}