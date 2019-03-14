<?php
class UserCompany{
	
	private $seq,$userseq,$customerseq;
	public static $className = "UserCompany";
	public static $tableName = "usercompanies";
	
	public function setSeq($seq_){
		$this->seq = $seq_;
	}
	public function getSeq(){
		return $this->seq;
	}
	
	public function setUserSeq($userSeq_){
		$this->userseq = $userSeq_;
	}
	public function getUserSeq(){
		return $this->userseq;
	}
	
	public function setCustomerSeq($customerSeq_){
		$this->customerseq = $customerSeq_;
	}
	public function getCustomerSeq(){
		return $this->customerseq;
	}
	
}