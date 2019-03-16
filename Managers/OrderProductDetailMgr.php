<?php
require_once($ConstantsArray['dbServerUrl'] ."DataStores/BeanDataStore.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/OrderProductDetail.php");
require_once($ConstantsArray['dbServerUrl'] ."Enums/MeasuringUnitType.php");
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
		$this->deleteByOrderSeq($orderSeq);
		$products = $orderDetail["products"];
		$priceArr = $orderDetail["price"];
		$quantityArr = $orderDetail["quantity"];
		foreach ($products as $key=>$product){
			$price = $priceArr[$key];
			$qty = $quantityArr[$key];
			if(!empty($price) && !empty($qty)){
				$orderProductDetail = new OrderProductDetail();
				$orderProductDetail->setOrderSeq($orderSeq);
				$orderProductDetail->setPrice($price);
				$orderProductDetail->setProductSeq($product);
				$orderProductDetail->setQuantity($qty);
				$id = self::$dataStore->save($orderProductDetail);
			}
		}
		
		return $id;
	}
	
	public function deleteByOrderSeq($orderSeq){
		$colVal["orderseq"] = $orderSeq;
		self::$dataStore->deleteByAttribute($colVal);
	}
	
	public function deleteInListByOrderSeq($orderSeqs){
		$query = "delete from orderproductdetails where orderseq in ($orderSeqs)";
		self::$dataStore->executeQuery($query);
	}
	
	
	
	
	public function findByOrderSeq($orderSeq){
		$query = "SELECT orderproductdetails.*,products.seq as productseq ,products.title, products.measuringunit, productflavours.title as flavour,productbrands.title as brand FROM orderproductdetails 
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
}