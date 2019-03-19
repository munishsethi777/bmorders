<?php
class Customer{
	
	private $seq,$title,$description,$contactperson,$email,$mobile,$phone,$address1,$address2,$city,$state,$zip,$discount,$gst,$userseq,$createdon,
	$lastmodifiedon,$isenabled;
	public static $className = "Customer";
	public static $tableName = "customers";
	
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
	public function setContactPerson($val){
		$this->contactperson = $val;
	}
	public function getContactPerson(){
		return $this->contactperson;
	}
	public function setEmail($val){
		$this->email = $val;
	}
	public function getEmail(){
		return $this->email;
	}
	public function setMobile($val){
		$this->mobile= $val;
	}
	public function getMobile(){
		return $this->mobile;
	}
	public function setPhone($val){
		$this->phone= $val;
	}
	public function getPhone(){
		return $this->phone;
	}
	public function setAddress1($val){
		$this->address1= $val;
	}
	public function getAddress1(){
		return $this->address1;
	}
	public function setAddress2($val){
		$this->address2= $val;
	}
	public function getAddress2(){
		return $this->address2;
	}
	public function setCity($val){
		$this->city= $val;
	}
	public function getCity(){
		return $this->city;
	}
	public function setState($val){
		$this->state= $val;
	}
	public function getState(){
		return $this->state;
	}
	public function setZip($val){
		$this->zip= $val;
	}
	public function getZip(){
		return $this->zip;
	}
	public function setDiscount($val){
		$this->discount= $val;
	}
	public function getDiscount(){
		return $this->discount;
	}
	public function setGST($val){
		$this->gst= $val;
	}
	public function getGST(){
		return $this->gst;
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