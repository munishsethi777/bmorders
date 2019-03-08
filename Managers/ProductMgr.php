<?php
require_once($ConstantsArray['dbServerUrl'] ."DataStores/BeanDataStore.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/Product.php");
require_once($ConstantsArray['dbServerUrl'] ."StringConstants.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/DateUtil.php");
require_once($ConstantsArray['dbServerUrl'] ."Enums/MeasuringUnitType.php");


class ProductMgr{
	private static $productMgr;
	private static $dataStore;
	private static $sessionUtil;
	
	public static function getInstance(){
		if (!self::$productMgr){
			self::$productMgr = new ProductMgr();
			self::$dataStore = new BeanDataStore(Product::$className, Product::$tableName);
		}
		return self::$productMgr;
	}
	
	public function findBySeq($seq){
		$products = self::$dataStore->findBySeq($seq);
		return $products;
	}
	
	public function findAll($isApplyFilter = false){
		$products = self::$dataStore->findAll($isApplyFilter);
		return $products;
	}
	
	public function saveProduct($product){
		$id = self::$dataStore->save($product);
		return $id;
	}
	
	public function getAllProductsForGrid(){
		$products = $this->findAllWithAttributeTitles(true);
		$mainArr = array();
		foreach ($products as $product){
			$arr = $product;
			$arr["measuringunit"] = MeasuringUnitType::getValue($product["measuringunit"]);
			array_push($mainArr, $arr);
 		}
 		$jsonArr["Rows"] =  $mainArr;
 		$jsonArr["TotalRows"] = $this->getCount();
 		return $jsonArr;
	}

	public function getCount(){
		$query = "SELECT count(*) from products p
		left join productflavours pf on pf.seq = p.flavourseq left join productcategories pc on pc.seq = p.categoryseq 
		left join productbrands pb on pb.seq = p.brandseq";
		$count = self::$dataStore->executeCountQueryWithSql($query,true);
		return $count;
	}
	
	public function deleteBySeqs($ids) {
		$flag = self::$dataStore->deleteInList ( $ids );
		return $flag;
	}
	public function findAllWithAttributeTitles($isApplyFilter){
		$query = "SELECT p.*,pf.title flavour, pb.title brand, pc.title category from products p
		left join productflavours pf on pf.seq = p.flavourseq left join productcategories pc on pc.seq = p.categoryseq 
		left join productbrands pb on pb.seq = p.brandseq";
		$products = self::$dataStore->executeQuery($query,$isApplyFilter);
		return $products;
	}
	function _group_by($array, $key) {
		$return = array();
		foreach($array as $val) {
			$return[$val[$key]][] = $val;
		}
		return $return;
	}

}