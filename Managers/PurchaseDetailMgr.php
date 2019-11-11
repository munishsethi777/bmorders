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
				if(!empty($expDate)){
					$expiryDate = DateUtil::StringToDateByGivenFormat("d-m-Y", $expDate);
					$expiryDate->setTime(0,0);
					$purchaseDetailObj->setExpiryDate($expiryDate);
				}
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
		$query = "SELECT products.quantity as productquantity,orderproductdetails.quantity as soldqty,purchasedetails.*,products.title, products.measuringunit, productflavours.title as flavour,productbrands.title as brand FROM purchasedetails
		inner join products on purchasedetails.productseq = products.seq
		inner join productflavours on products.flavourseq = productflavours.seq
		inner join productbrands on products.brandseq = productbrands.seq
        left join orderproductdetails on purchasedetails.productseq = orderproductdetails.productseq and purchasedetails.lotnumber = orderproductdetails.lotnumber
		where purchaseseq = $purchaseSeq group by purchasedetails.productseq , lotnumber order by purchasedetails.seq";
		$purchaseDetails = self::$dataStore->executeQuery($query,false,true);
		$mainArr = array();
		foreach ($purchaseDetails as $purchaseDetail){
			$measureUnits = MeasuringUnitType::getValue($purchaseDetail["measuringunit"]);
			$quantity = $purchaseDetail["quantity"];
			$productQuantity = $purchaseDetail["productquantity"];
			$weight = $productQuantity . " " . $measureUnits . " - " . $purchaseDetail["flavour"] . " (".$purchaseDetail["brand"].")";
			$purchaseDetail['title'] = $purchaseDetail['title'] . " " . $weight ;
			$expDate = "";
			if(!empty($purchaseDetail["expirydate"])){
				$expDate = $purchaseDetail["expirydate"];
				$expDate = DateUtil::StringToDateByGivenFormat("Y-m-d h:i:s", $expDate);
				$expDate = $expDate->format("d-m-Y");
			}
			$purchaseDetail["expirydate"] = $expDate;
			array_push($mainArr, $purchaseDetail);
		}
		return $mainArr;
	}
	
	public function findByProductSeq($productSeq){
		$query = "select sum(purchasereturns.quantity) as returnqty, purchasedetails.*,sum(orderproductdetails.quantity) as soldqty from purchasedetails 
left join orderproductdetails on purchasedetails.lotnumber = orderproductdetails.lotnumber 
left join purchasereturns on purchasedetails.seq = purchasereturns.purchasedetailseq
where purchasedetails.productseq = $productSeq group by lotnumber order by expirydate";
		$purchaseDetail = self::$dataStore->executeQuery($query);
		return $purchaseDetail;
	}
	
	public function getPurchaseDetailByPurchaseSeqForNestedGrid($purchaseSeq){
		$query = "select purchasereturns.quantity as returnqty ,products.title, sum(purchasedetails.quantity)as totalquantity ,purchasedetails.* from 
 purchasedetails inner join products on purchasedetails.productseq = products.seq 
 left join purchasereturns on purchasedetails.seq = purchasereturns.purchasedetailseq where purchasedetails.purchaseseq =  $purchaseSeq group by productseq ,lotnumber";
		$purchaseDetails = self::$dataStore->executeQuery($query,true);
		$mainArr = array();
		foreach ($purchaseDetails as $purchaseDetail){
			$returnQty = $purchaseDetail["returnqty"];
			$quantity = $purchaseDetail["totalquantity"];
			if(!empty($returnQty)){
				$quantity = $quantity - $returnQty;
			}
			$purchaseDetail["totalquantity"] = $quantity;
			array_push($mainArr, $purchaseDetail);
		}
		
		return $mainArr;
	}

}