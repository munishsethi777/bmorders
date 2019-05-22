<?php
require_once($ConstantsArray['dbServerUrl'] ."DataStores/BeanDataStore.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/Product.php");
require_once($ConstantsArray['dbServerUrl'] ."StringConstants.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/DateUtil.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/ExportUtil.php");
require_once($ConstantsArray['dbServerUrl'] ."Enums/MeasuringUnitType.php");
require_once($ConstantsArray['dbServerUrl'] ."Managers/PurchaseDetailMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."Managers/OrderProductDetailMgr.php");


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
	
	public function findProductAndLotsByProductSeq($productSeq){
		$product = $this->findArrBySeq($productSeq);
		$purchaseDetailMgr = PurchaseDetailMgr::getInstance();
		$purchaseDetails = $purchaseDetailMgr->findByProductSeq($productSeq);
		$lots = array();
		$lotNumbers = array();
		foreach ($purchaseDetails as $purchaseDetail){
			$lotNumber = $purchaseDetail["lotnumber"];
			$qty = $purchaseDetail["quantity"];
			$soldQty = $purchaseDetail["soldqty"];
			$availableQty = $qty;
			if(!empty($soldQty)){
				$availableQty = $qty - $soldQty; 
			}
			$expiryDate = $purchaseDetail["expirydate"];
			$expiryDate = DateUtil::StringToDateByGivenFormat("Y-m-d h:i:s", $expiryDate);
			$expiryDate = $expiryDate->format("d/m/Y");
			//$title = $lotNumber . " - " . $expiryDate . " - " . $availableQty . "pcs.";
			$lotDetail["quantity"] = $availableQty;
			$lotDetail["expiryDate"] = $expiryDate;
			$lots[$lotNumber] = $lotDetail;
		}
		$product["lots"]  = $lots;
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
		$orderProductDetailMgr = OrderProductDetailMgr::getInstance();
		$mainArr = array();
		$qtySolds = $orderProductDetailMgr->getTotalSoldQtyForAll();
		foreach ($products as $product){
			$arr = $product;
			$totalQty = $product["totalquantity"];
			$soldQty = 0;
			if(array_key_exists($product["seq"], $qtySolds)){
				$soldQty = $qtySolds[$product["seq"]][0]["soldqty"];
			}
			$stock = $totalQty - $soldQty;
			$arr["measuringunit"] = MeasuringUnitType::getValue($product["measuringunit"]);
			$arr["p.title"] = $product["title"];
			$arr["pb.title"] = $product["brand"];
			$arr["pc.title"] = $product["category"];
			$arr["pf.title"] = $product["flavour"];
			$arr["totalquantity"] = $stock;
			$arr["p.lastmodifiedon"] = $product["lastmodifiedon"];
			array_push($mainArr, $arr);
 		}
 		$jsonArr["Rows"] =  $mainArr;
 		$jsonArr["TotalRows"] = $this->getCount();
 		return $jsonArr;
	}
	
	
	public function getProductDetailByProductSeqForNestedGrid($productSeq){
		$query = "select sum(purchasedetails.quantity)as totalquantity ,purchasedetails.* from purchasedetails inner join products on purchasedetails.productseq = products.seq where productseq = $productSeq group by lotnumber";
		$productDetails = self::$dataStore->executeQuery($query,true);
		$orderProductDetailMgr= OrderProductDetailMgr::getInstance();
		$arr = array();
		foreach ($productDetails as $productDetail){
			$productSeq = $productDetail["productseq"];
			$lotNumber = $productDetail["lotnumber"];
			$totalQty = $productDetail["totalquantity"];
			$qtySold =  $orderProductDetailMgr->getTotalSoldQtyByProductSeqAndLotNumber($productSeq, $lotNumber);
			$qtyAvailable = $totalQty - $qtySold;
			$productDetail["quantity"] = $qtyAvailable;
			array_push($arr, $productDetail);
		}
		return $arr;
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
	public function findAllWithAttributeTitles($isApplyFilter,$isExport=false){
		$query = "SELECT p.* ,purchasedetails.expirydate,purchasedetails.netrate,purchasedetails.quantity stock,purchasedetails.lotnumber, sum(purchasedetails.quantity)as totalquantity, pf.title flavour, pb.title brand, pc.title category from products p
		left join productflavours pf on pf.seq = p.flavourseq 
        left join productcategories pc on pc.seq = p.categoryseq 
		left join productbrands pb on pb.seq = p.brandseq
        left join purchasedetails on p.seq = purchasedetails.productseq
        group by p.seq";
		if($isExport){
			$query .= " ,lotnumber";
		}
		$products = self::$dataStore->executeQuery($query,$isApplyFilter);
		if($isExport){
			$products = $this->_group_by($products, "seq");
		}
		return $products;
	}
	
// 	public function findAllWithAttributeTitles($isApplyFilter){
// 		$query = "SELECT p.*,pf.title flavour, pb.title brand, pc.title category from products p
// 		left join productflavours pf on pf.seq = p.flavourseq left join productcategories pc on pc.seq = p.categoryseq
// 		left join productbrands pb on pb.seq = p.brandseq";
// 		$products = self::$dataStore->executeQuery($query,$isApplyFilter);
// 		return $products;
// 	}
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
			$sql .= " where (products.barcode like '%$searchString%' or products.title like '%$searchString%' or productflavours.title like '%$searchString%' or productbrands.title like '%$searchString%') order by products.title asc";
		}
		$products =  self::$dataStore->executeQuery($sql);
		return $products;
	}
	
	public function exportProducts($queryString){
		$output = array();
		parse_str($queryString, $output);
		$_GET = array_merge($_GET,$output);
		$products = $this->findAllWithAttributeTitles(true,true);
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