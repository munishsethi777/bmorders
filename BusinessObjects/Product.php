<?php
class Product{
	
	private $seq,$title,$description,$stock,$measuringunit,$price,$quantity,$categoryseq,$flavourseq,$brandseq,$userseq,$imageformat,$barcode,$createdon,$lastmodifiedon,$isenabled;
	public static $className = "Product";
	public static $tableName = "products";
	
	public function setSeq($seq_){
		$this->seq = $seq_;
	}
	public function getSeq(){
		return $this->seq;
	}
	public function setTitle($val){
		$this->title = $val;
	}
	public function getTitle(){
		return $this->title;
	}
	public function setDescription($val){
		$this->description = $val;
	}
	public function getDescription(){
		return $this->description;
	}
	public function setStock($val){
		$this->stock = $val;
	}
	public function getStock(){
		return $this->stock;
	}
	public function setPrice($val){
		$this->price = $val;
	}
	public function getPrice(){
		return $this->price;
	}
	public function setQuantity($val){
		$this->quantity = $val;
	}
	public function getQuantity(){
		return $this->quantity;
	}
	public function setCategorySeq($val){
		$this->categoryseq = $val;
	}
	public function getCategorySeq(){
		return $this->categoryseq;
	}
	public function setFlavourSeq($val){
		$this->flavourseq = $val;
	}
	public function getFlavourSeq(){
		return $this->flavourseq;
	}
	public function setBrandSeq($val){
		$this->brandseq = $val;
	}
	public function getBrandSeq(){
		return $this->brandseq;
	}
	public function setUserSeq($val){
		$this->userseq= $val;
	}
	public function getUserSeq(){
		return $this->userseq;
	}
	public function setImageFormat($val){
		$this->imageformat= $val;
	}
	public function getImageFormat(){
		return $this->imageformat;
	}
	public function setCreatedOn($createdOn_){
		$this->createdon = $createdOn_;
	}
	public function getCreatedOn(){
		return $this->createdon;
	}
	public function setLastModifiedOn($lastModifiedOn){
		$this->lastmodifiedon = $lastModifiedOn;
	}
	public function getLastModifiedOn(){
		return $this->lastmodifiedon;
	}
	public function setIsEnabled($isEnabled){
		$this->isenabled = $isEnabled;
	}
	public function getIsEnabled(){
		return $this->isenabled;
	}
	public function setMeasuringUnit($val){
		$this->measuringunit = $val;
	}
	public function getMeasuringUnit(){
		return $this->measuringunit;
	}
	
	public function setBarcode($val){
		$this->barcode = $val;
	}
	public function getBarcode(){
		return $this->barcode;
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