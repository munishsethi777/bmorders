<?php
class OrderPaymentDetail{
	private $seq,$amount,$details,$isconfirmed,$ispaid,$orderseq,$paymentmode,$createdon,$expectedon,$isnotificationgenerated;
	public static $className = "OrderPaymentDetail";
	public static $tableName = "orderpaymentdetails";
	public function setSeq($seq_){
		$this->seq = $seq_;
	}
	public function getSeq(){
		return $this->seq;
	}
	
	public function setAmount($amount_){
		$this->amount = $amount_;
	}
	
	public function getAmount(){
		return $this->amount;
	}
	
	public function setDetails($details_){
		$this->details = $details_;
	}
	public function getDetails(){
		return $this->details;
	}
	
	public function setIsConfirmed($isConfirmed_){
		$this->isconfirmed = $isConfirmed_;
	}
	public function getIsConfirmed(){
		return $this->isconfirmed;
	}
	
	public function setIsPaid($paid_){
		$this->ispaid = $paid_;
	}
	public function getIsPaid(){
		return $this->ispaid;
	}
	
	public function setOrderSeq($orderSeq_){
		$this->orderseq = $orderSeq_;
	}
	public function getOrderSeq(){
		return $this->orderseq;
	}
	
	public function setPaymentMode($paymentMode_){
		$this->paymentmode = $paymentMode_;
	}
	public function getPaymentMode(){
		return $this->paymentmode;
	}
	
	public function setCreatedOn($createdOn_){
		$this->createdon = $createdOn_;
	}
	public function getCreatedOn(){
		return $this->createdon;
	}
	
	public function setExpectedOn($expectedOn_){
		$this->expectedon = $expectedOn_;	
	}
	public function getExpectedOn(){
		return $this->expectedon;
	}
	
	public function setIsNotificationGenerated($isGenereated_){
		$this->isnotificationgenerated  = $isGenereated_;
	}
	public function getIsNotificationGenerated(){
		return $this->isnotificationgenerated;
	}
}