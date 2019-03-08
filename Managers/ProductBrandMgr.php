<?php
require_once($ConstantsArray['dbServerUrl'] ."DataStores/BeanDataStore.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/ProductBrand.php");
require_once($ConstantsArray['dbServerUrl'] ."StringConstants.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/DateUtil.php");

class ProductBrandMgr{
	private static $productBrandMgr;
	private static $dataStore;
	private static $sessionUtil;
	
	public static function getInstance(){
		if (!self::$productBrandMgr){
			self::$productBrandMgr = new ProductBrandMgr();
			self::$dataStore = new BeanDataStore(ProductBrand::$className, ProductBrand::$tableName);
		}
		return self::$productBrandMgr;
	}
	
	public function findBySeq($seq){
		$customers = self::$dataStore->findBySeq($seq);
		return $customers;
	}
	
	public function findAll($isApplyFilter = false){
		$customers = self::$dataStore->findAll($isApplyFilter);
		return $customers;
	}
	
	public function save($productBrand){
		$id = self::$dataStore->save($productBrand);
		return $id;
	}
	
	public function getAllForGrid(){
		$productBrands = $this->findAll(true);
		$mainArr = array();
		foreach ($productBrands as $productBrand){
			$arr["seq"] = $productBrand->getSeq();
			$arr["title"] = $productBrand->getTitle();
			$arr["description"] = $productBrand->getDescription();
			$arr["isenabled"] = !empty($productBrand->getIsEnabled());
			$arr["lastmodifiedon"] = $productBrand->getLastModifiedOn();
			array_push($mainArr, $arr);
 		}
 		$jsonArr["Rows"] =  $mainArr;
 		$jsonArr["TotalRows"] = $this->getCount();
 		return $jsonArr;
	}

	public function getCount(){
		$query = "select count(*) from productbrands";
		$count = self::$dataStore->executeCountQueryWithSql($query,true);
		return $count;
	}
	
	public function deleteBySeqs($ids) {
		$flag = self::$dataStore->deleteInList ( $ids );
		return $flag;
	}
	public function findAllArrEnabled(){
		$query = "select * from productbrands where isenabled = 1 order by title ASC";
		$objs = self::$dataStore->executeQuery($query);
		return $objs;
	}
	function _group_by($array, $key) {
		$return = array();
		foreach($array as $val) {
			$return[$val[$key]][] = $val;
		}
		return $return;
	}

}