<?php

class Purchase{
	private $seq, $supplierseq, $invoicenumber, $invoicedate, $netamount, $discount, $userseq, $createdon, $lastmodifiedon;
	public static $className = "Purchase";
	public static $tableName = "purchases";

	public function setSeq($seq_){
		$this->seq = $seq_;
	}
	public function getSeq(){
		return  $this->seq;
	}
	
	public function setSupplierSeq($val){
		$this->supplierseq = $val;
	}
	public function getSupplierSeq(){
		return  $this->supplierseq;
	}
	
	public function setInvoiceNumber($val){
		$this->invoicenumber = $val;
	}
	public function getInvoiceNumber(){
		return  $this->invoicenumber;
	}
	
	public function setInvoiceDate($val){
		$this->invoicedate = $val;
	}
	public function getInvoiceDate(){
		return  $this->invoicedate;
	}
	public function setNetAmount($val){
		$this->netamount = $val;
	}
	public function getNetAmount(){
		return  $this->netamount;
	}
	public function setDiscount($val){
		$this->discount = $val;
	}
	public function getDiscount(){
		return  $this->discount;
	}
	public function setUserSeq($val){
		$this->userseq = $val;
	}
	public function getUserSeq(){
		return  $this->userseq;
	}
	public function setCreatedOn($val){
		$this->createdon = $val;
	}
	public function getCreatedOn(){
		return  $this->createdon;
	}
	public function setLastModifiedOn($val){
		$this->lastmodifiedon = $val;
	}
	public function getLastModifiedOn(){
		return  $this->lastmodifiedon;
	}
	
	public function createFromRequest($request){
		if (is_array($request)){
			$this->from_array($request);
		}
		return $this;
	}
	
	public function from_array($array){
		foreach(get_object_vars($this) as $attrName => $attrValue){
			$flag = property_exists(self::$className, $attrName);
			$isExists = array_key_exists($attrName, $array);
			if($flag && $isExists){
				$this->{$attrName} = $array[$attrName];
			}
		}
	}
}