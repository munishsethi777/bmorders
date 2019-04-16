<?php
class ChatThread{
	private $seq,$orderseq,$fromuser,$touser,$createdon;
	
	public static $className = "ChatThread";
	public static $tableName = "chatthreads";
	
	public function setSeq($seq_){
		$this->seq = $seq_;
	}
	public function getSeq(){
		return $this->seq;
	}
	
	public function setFromUser($fromUser_){
		$this->fromuser = $fromUser_;
	}
	public function getFromUser(){
		return $this->fromuser;
	}
	
	public function setToUser($touser_){
		$this->touser = $touser_;
	}
	public function getToUser(){
		return $this->touser;
	}
	
	public function setCreatedOn($createdon_){
		$this->createdon  = $createdon_;
	}
	public function getCreatedOn(){
		return $this->createdon;
	}
	
	public function setOrderSeq($orderSeq_){
		$this->orderseq = $orderSeq_;
	}
	public function getOrderSeq(){
		return $this->orderseq;
	}
	
}