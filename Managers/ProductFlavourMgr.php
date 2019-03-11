<?php
require_once($ConstantsArray['dbServerUrl'] ."DataStores/BeanDataStore.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/ProductFlavour.php");
require_once($ConstantsArray['dbServerUrl'] ."StringConstants.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/DateUtil.php");

class ProductFlavourMgr{
	private static $productFlavourMgr;
	private static $dataStore;
	private static $sessionUtil;
	
	public static function getInstance(){
		if (!self::$productFlavourMgr){
			self::$productFlavourMgr = new ProductFlavourMgr();
			self::$dataStore = new BeanDataStore(ProductFlavour::$className, ProductFlavour::$tableName);
		}
		return self::$productFlavourMgr;
	}
	
	public function findBySeq($seq){
		$obj = self::$dataStore->findBySeq($seq);
		return $obj;
	}
	
	public function findAll($isApplyFilter = false){
		$objs = self::$dataStore->findAll($isApplyFilter);
		return $objs;
	}
	
	public function save($obj){
		$id = self::$dataStore->save($obj);
		return $id;
	}
	
	public function getAllForGrid(){
		$objs = $this->findAll(true);
		$mainArr = array();
		foreach ($objs as $obj){
			$arr["seq"] = $obj->getSeq();
			$arr["title"] = $obj->getTitle();
			$arr["description"] = $obj->getDescription();
			$arr["isenabled"] = !empty($obj->getIsEnabled());
			$arr["lastmodifiedon"] = $obj->getLastModifiedOn();
			array_push($mainArr, $arr);
 		}
 		$jsonArr["Rows"] =  $mainArr;
 		$jsonArr["TotalRows"] = $this->getCount();
 		return $jsonArr;
	}

	public function getCount(){
		$query = "select count(*) from productflavours";
		$count = self::$dataStore->executeCountQueryWithSql($query,true);
		return $count;
	}
	
	public function deleteBySeqs($ids) {
		$flag = self::$dataStore->deleteInList ( $ids );
		return $flag;
	}
	public function findAllArrEnabled(){
		$query = "select * from productflavours where isenabled = 1 order by title ASC";
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
	
	public function getAllFlavoursTitles(){
		$query = "select title from productflavours";
		$objs = self::$dataStore->executeQuery($query,false,true);
		$flavours = array_map(create_function('$o', 'return $o["title"];'), $objs);
		return $flavours;
	}

}