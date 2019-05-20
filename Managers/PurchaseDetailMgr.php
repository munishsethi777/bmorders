<?php
require_once($ConstantsArray['dbServerUrl'] ."DataStores/BeanDataStore.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/PurchaseDetail.php");
require_once($ConstantsArray['dbServerUrl'] ."StringConstants.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/DateUtil.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/ExportUtil.php");

class PurchaseDetailMgr{
	private static $purchaseDetailMgr;
	private static $dataStore;
	private static $sessionUtil;

	public static function getInstance(){
		if (!self::$purchaseDetailMgr){
			self::$purchaseDetailMgr = new PurchaseDetailMgr();
			self::$dataStore = new BeanDataStore(PurchaseDetail::$className, PurchaseDetail::$tableName);
		}
		return self::$purchaseDetailMgr;
	}

	public function findBySeq($seq){
		$purchase = self::$dataStore->findBySeq($seq);
		return $purchase;
	}

	public function deleteByPurchaseSeq($orderSeq){
		$colVal["purchaseseq"] = $orderSeq;
		return self::$dataStore->deleteByAttribute($colVal);
	}
	
	public function savePurchaseDetail($purchaseSeq,$purchaseDetail){
		$this->deleteByPurchaseSeq($purchaseSeq);
		$products = $purchaseDetail["products"];
		$priceArr = $purchaseDetail["netrate"];
		$quantityArr = $purchaseDetail["quantity"];
		$discountArr = $purchaseDetail["discount"];
		$expiryDateArr = $purchaseDetail["expirydate"];
		$lotNoArr = $purchaseDetail["lotnumber"];
		foreach ($products as $key=>$product){
			$price = $priceArr[$key];
			$qty = $quantityArr[$key];
			$discount = $discountArr[$key];
			$expDate = $expiryDateArr[$key];
			$lotNumber = $lotNoArr[$key];
			if(!empty($price) && !empty($qty)){
				$purchaseDetailObj = new PurchaseDetail();
				$purchaseDetailObj->setDiscount($discount);
				$expiryDate = DateUtil::StringToDateByGivenFormat("d-m-Y", $expDate);
				$expiryDate->setTime(0,0);
				$purchaseDetailObj->setExpiryDate($expiryDate);
				$purchaseDetailObj->setLotNumber($lotNumber);
				$purchaseDetailObj->setNetRate($price);
				$purchaseDetailObj->setPurchaseSeq($purchaseSeq);
				$purchaseDetailObj->setQuantity($qty);
				$purchaseDetailObj->setProductSeq($product);
				$id = self::$dataStore->save($purchaseDetailObj);
			}
		}
		return $id;
	}
	
	public function deleteByPurchaseSeqs($purchaseSeq){
		$query = "delete from purchasedetails where purchaseseq in ($purchaseSeq)";
		self::$dataStore->executeQuery($query);
	}
	
	public function findByPurchaseSeq($purchaseSeq){
		$query = "SELECT purchasedetails.*,products.title, products.measuringunit, productflavours.title as flavour,productbrands.title as brand FROM purchasedetails
		inner join products on purchasedetails.productseq = products.seq
		inner join productflavours on products.flavourseq = productflavours.seq
		inner join productbrands on products.brandseq = productbrands.seq
		where purchaseseq = $purchaseSeq";
		$purchaseDetails = self::$dataStore->executeQuery($query,false,true);
		$mainArr = array();
		foreach ($purchaseDetails as $purchaseDetail){
			$measureUnits = MeasuringUnitType::getValue($purchaseDetail["measuringunit"]);
			$quantity = $purchaseDetail["quantity"];
			$weight = $quantity . " " . $measureUnits . " - " . $purchaseDetail["flavour"] . " (".$purchaseDetail["brand"].")";
			$purchaseDetail['title'] = $purchaseDetail['title'] . " " . $weight ;
			$expDate = $purchaseDetail["expirydate"];
			$expDate = DateUtil::StringToDateByGivenFormat("Y-m-d h:i:s", $expDate);
			$expDate = $expDate->format("d-m-Y");
			$purchaseDetail["expirydate"] = $expDate;
			array_push($mainArr, $purchaseDetail);
		}
		return $mainArr;
	}
	
	public function findByProductSeq($productSeq){
		$query = "select purchasedetails.*,sum(orderproductdetails.quantity) as soldqty from purchasedetails 
left join orderproductdetails on purchasedetails.lotnumber = orderproductdetails.lotnumber where purchasedetails.productseq = $productSeq 
group by lotnumber order by expirydate";
		$purchaseDetail = self::$dataStore->executeQuery($query);
		return $purchaseDetail;
	}

}