<?php
class PurchaseDetail{
	private $seq, $purchaseseq, $productseq, $lotnumber, $expirydate, $netrate, $discount, $quantity;
	public static $className = "PurchaseDetail";
	public static $tableName = "purchasedetails";

	public function setSeq($val){
		$this->seq = $val;
	}
	public function getSeq(){
		return  $this->seq;
	}
	public function setPurchaseSeq($val){
		$this->purchaseseq = $val;
	}
	public function getPurchaseSeq(){
		return  $this->purchaseseq;
	}
	public function setProductSeq($val){
		$this->productseq = $val;
	}
	public function getProductSeq(){
		return  $this->productseq;
	}
	public function setLotNumber($val){
		$this->lotnumber= $val;
	}
	public function getLotNumber(){
		return  $this->lotnumber;
	}
	public function setExpiryDate($val){
		$this->expirydate= $val;
	}
	public function getExpiryDate(){
		return  $this->expirydate;
	}
	public function setNetRate($val){
		$this->netrate= $val;
	}
	public function getNetRate(){
		return  $this->netrate;
	}
	public function setDiscount($val){
		$this->discount = $val;
	}
	public function getDiscount(){
		return  $this->discount;
	}
	public function setQuantity($val){
		$this->quantity = $val;
	}
	public function getQuantity(){
		return  $this->quantity;
	}

}