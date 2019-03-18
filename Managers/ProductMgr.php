<?php
require_once($ConstantsArray['dbServerUrl'] ."DataStores/BeanDataStore.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/Product.php");
require_once($ConstantsArray['dbServerUrl'] ."StringConstants.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/DateUtil.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/ExportUtil.php");
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
	
	public function findArrBySeq($seq){
		$product = self::$dataStore->findArrayBySeq($seq);
		return $product;
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
			$arr["p.title"] = $product["title"];
			$arr["pb.title"] = $product["brand"];
			$arr["pc.title"] = $product["category"];
			$arr["pf.title"] = $product["flavour"];
			$arr["p.lastmodifiedon"] = $product["lastmodifiedon"];
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
	
	public function searchProducts($searchString){
		$sql = "select products.*,productflavours.title as flavour , productbrands.title as brand from products inner join productflavours on products.flavourseq = productflavours.seq inner join productbrands on products.brandseq = productbrands.seq";
		if($searchString != null){
			$sql .= " where (products.title like '%$searchString%' or productflavours.title like '%$searchString%' or productbrands.title like '%$searchString%') order by products.title asc";
		}
		$products =  self::$dataStore->executeQuery($sql);
		return $products;
	}
	
	public function exportProducts($queryString){
		$output = array();
		parse_str($queryString, $output);
		$_GET = array_merge($_GET,$output);
		$products = $this->findAllWithAttributeTitles(true);
		ExportUtil::exportProducts($products);
	}
	
	public function updateStock($stock,$seq){
		$attr["stock"] = $stock;
		$colVal["seq"] = $seq;
		return self::$dataStore->updateByAttributesWithBindParams($attr,$colVal);
	}
	
	public function updateStockForOnDeleteOrder($productQtyArr){
		foreach ($productQtyArr as $product=>$qtyArr){
			$qty = $qtyArr[0]["quantity"];
			$query = "update products set stock = stock + $qty WHERE seq = $product";
			self::$dataStore->executeQuery($query);
		}
	}

}