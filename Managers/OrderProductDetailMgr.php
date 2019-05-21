<?php
require_once($ConstantsArray['dbServerUrl'] ."DataStores/BeanDataStore.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/OrderProductDetail.php");
require_once($ConstantsArray['dbServerUrl'] ."Enums/MeasuringUnitType.php");
require_once($ConstantsArray['dbServerUrl'] ."Managers/ProductMgr.php");
class OrderProductDetailMgr{
	private static $OrderProductDetailMgr;
	private static $dataStore;
	private static $sessionUtil;

	public static function getInstance(){
		if (!self::$OrderProductDetailMgr){
			self::$OrderProductDetailMgr = new OrderProductDetailMgr();
			self::$dataStore = new BeanDataStore(OrderProductDetail::$className, OrderProductDetail::$tableName);
		}
		return self::$OrderProductDetailMgr;
	}

	public function saveOrderProductDetail($orderSeq,$orderDetail){
		$existingProductDetails = $this->getDetailByOrderSeq($orderSeq);
		$this->deleteByOrderSeq($orderSeq);
		$products = $orderDetail["products"];
		$priceArr = $orderDetail["price"];
		$quantityArr = $orderDetail["quantity"];
		$stocks = $orderDetail["stock"];
		$lotNumberArr = $orderDetail["lotnumber"];
		$productMgr = ProductMgr::getInstance();
		$productQtyArr = array();
		foreach ($products as $key=>$product){
			$price = $priceArr[$key];
			$qty = $quantityArr[$key];
			$stock = $stocks[$key];
			$lot = $lotNumberArr[$key];
			$existingQty = 0;
			if(!empty($price) && !empty($qty)){
				$orderProductDetail = new OrderProductDetail();
				$orderProductDetail->setOrderSeq($orderSeq);
				$orderProductDetail->setPrice($price);
				$orderProductDetail->setProductSeq($product);
				$orderProductDetail->setQuantity($qty);
				$orderProductDetail->setLotNumber($lot);
				$id = self::$dataStore->save($orderProductDetail);
				if($id > 0){
					if(isset($existingProductDetails[$product])){
// 						$existingQty = $existingProductDetails[$product][0]["quantity"];
// 						$stock =  $stock + $existingQty;
						unset($existingProductDetails[$product]);
					}
					$stock = $stock - $qty;
					$productMgr->updateStock($stock, $product);
				}
			}
		}
		if(!empty($existingProductDetails)){
			$productMgr->updateStockForOnDeleteOrder($existingProductDetails);
		}
		return $id;
	}
	
	public function deleteByOrderSeq($orderSeq){
		$colVal["orderseq"] = $orderSeq;
		return self::$dataStore->deleteByAttribute($colVal);
	}
	
	public function deleteInListByOrderSeq($orderSeqs){
		$query = "delete from orderproductdetails where orderseq in ($orderSeqs)";
		self::$dataStore->executeQuery($query);
	}
	
	public function deleteAndUpdateStock($orderSeqs){
		$orderSeqs = explode(",", $orderSeqs);
		foreach ($orderSeqs as $orderSeq){
			$detail = $this->getDetailByOrderSeq($orderSeq);
			$flag = $this->deleteByOrderSeq($orderSeq);
			if($flag){
				$productMgr = ProductMgr::getInstance();
				$productMgr->updateStockForOnDeleteOrder($detail);
			}
		}
	}
	
	
	public function getDetailByOrderSeq($orderSeq){
		$query = "select * from orderproductdetails where orderseq =  $orderSeq";
		$orderDetails = self::$dataStore->executeQuery($query,false,true);
		$orderDetails = $this->_group_by($orderDetails,"productseq");
		return $orderDetails;
	}
	
	function _group_by($array, $key) {
		$return = array();
		foreach($array as $val) {
			$return[$val[$key]][] = $val;
		}
		return $return;
	}
	
	public function findByOrderSeq($orderSeq){
		$query = "SELECT orderproductdetails.*,products.stock,products.seq as productseq ,products.title, products.measuringunit, productflavours.title as flavour,productbrands.title as brand FROM orderproductdetails 
inner join products on orderproductdetails.productseq = products.seq  
inner join productflavours on products.flavourseq = productflavours.seq 
inner join productbrands on products.brandseq = productbrands.seq
where orderseq = $orderSeq";
		$orderProductDetails = self::$dataStore->executeQuery($query,false,true);
		$mainArr = array();
		foreach ($orderProductDetails as $orderProductDetail){
			$measureUnits = MeasuringUnitType::getValue($orderProductDetail["measuringunit"]);
			$quantity = $orderProductDetail["quantity"];
			$weight = $quantity . " " . $measureUnits . " - " . $orderProductDetail["flavour"] . " (".$orderProductDetail["brand"].")";
			$orderProductDetail['title'] = $orderProductDetail['title'] . " " . $weight ;
			array_push($mainArr, $orderProductDetail);
		}
		return $mainArr;
	}
	
	public function getTotalSoldQtyByProductSeq($productSeq){
		$query = "select sum(quantity) from orderproductdetails where productseq = $productSeq";
		$totalSoldQty = self::$dataStore->executeCountQueryWithSql($query);
		return $totalSoldQty;
	}
	
	public function getTotalSoldQtyForAll(){
		$query = "select productseq,sum(quantity) as soldqty from orderproductdetails group by productseq";
		$totalSoldQty = self::$dataStore->executeQuery($query);
		$totalSoldQty = $this->_group_by($totalSoldQty, 'productseq');
		return $totalSoldQty;
	}
}