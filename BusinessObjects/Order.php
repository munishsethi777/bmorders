<?php
class Order{
	private $seq,$comments,$customerseq,$discountpercent,$totalamount,$ispaymentcompletelypaid,$createdon;
	public static $className = "Order";
	public static $tableName = "orders";
	public function setSeq($seq_){
		$this->seq = $seq_;
	}
	public function getSeq(){
		return  $this->seq;
	}
	
	public function setComments($comments_){
		$this->comments = $comments_;
	}
	public function getComments(){
		return $this->comments;
	}
	
	public function setCustomerSeq($customerSeq_){
		$this->customerseq = $customerSeq_;
	}
	public function getCustomerSeq(){
		return $this->customerseq;
	}
	
	public function setDiscountPercent($discountPer_){
		$this->discountpercent = $discountPer_;
	}
	public function  getDiscountPercent(){
		return $this->discountpercent;
	}
	
	public function setTotalAmount($totalAmount_){
		$this->totalamount = $totalAmount_;
	}
	public function getTotalAmount(){
		return $this->totalamount;
	}
	
	public function setIsPaymentCompletelyPaid($isPaid_){
		$this->ispaymentcompletelypaid = $isPaid_;
	}
	public function getIsPaymentCompletelyPaid(){
		return $this->ispaymentcompletelypaid;
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