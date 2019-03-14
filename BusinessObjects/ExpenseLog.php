<?php
class ExpenseLog{
	private $seq,$userseq,$title,$description,$amount,$createon;
	public static $className = "ExpenseLog";
	public static $tableName = "expenselogs";

	public function setSeq($seq_){
		$this->seq = $seq_;
	}
	public function getSeq(){
		return  $this->seq;
	}
	
	public function setUserSeq($userSeq_){
		$this->userseq = $userSeq_;
	}
	public function getUserSeq(){
		return $this->userseq;
	}
	
	public function setTitle($title_){
		$this->title = $title_;
	}
	public function getTitle(){
		return $this->title;
	}
	
	public function setDescription($description_){
		$this->description = $description_;
	}
	public function getDescription(){
		return $this->description;
	}
	
	public function setAmount($amount_){
		$this->amount = $amount_;
	}
	public function getAmount(){
		return $this->amount;
	}
	
	public function setCreatedOn($createdOn_){
		$this->createdon = $createdOn_;
	}
	public function getCreatedOn(){
		return $this->createdon;
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