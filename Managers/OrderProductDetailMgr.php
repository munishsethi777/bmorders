<?php
require_once($ConstantsArray['dbServerUrl'] ."DataStores/BeanDataStore.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/OrderProductDetail.php");

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
		$query = "SELECT orderproductdetails.*,products.title FROM orderproductdetails inner join products on orderproductdetails.productseq = products.seq  where orderseq = $orderSeq";
		$orderProductDetail = self::$dataStore->executeQuery($query,false,true);
		return $orderProductDetail;
	}
}