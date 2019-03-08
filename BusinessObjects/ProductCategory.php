<?php
class ProductCategory{
	
	private $seq,$title,$description,$userseq,$createdon,$lastmodifiedon,$isenabled;
	public static $className = "ProductCategory";
	public static $tableName = "productcategories";
	
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
	public function setUserSeq($val){
		$this->userseq= $val;
	}
	public function getUserSeq(){
		return $this->userseq;
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