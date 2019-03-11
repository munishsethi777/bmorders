<?php
class User{
	
	private $seq, $emailid, $password, $fullname, $mobile, $usertype, $createdon, $lastmodifiedon, $isenabled;
	public static $className = "User";
	public static $tableName = "users";
	
	public function setSeq($seq_){
		$this->seq = $seq_;
	}
	public function getSeq(){
		return $this->seq;
	}
	
	public function setEmailId($val){
		$this->emailid = $val;
	}
	public function getEmailId(){
		return $this->emailid;
	}
	
	public function setPassword($password_){
		$this->password = $password_;
	}
	public function getPassword(){
		return $this->password;
	}
	
	public function setFullName($val){
		$this->fullname = $val;
	}
	public function getFullName(){
		return $this->fullname;
	}
	
	public function setMobile($val){
		$this->mobile= $val;
	}
	public function getMobile(){
		return $this->mobile;
	}

	public function setUserType($val){
		$this->usertype= $val;
	}
	public function getUserType(){
		return $this->usertype;
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