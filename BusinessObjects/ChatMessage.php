<?php
class ChatMessage{
	
	private $seq,$fromuser,$touser,$message,$orderid,$isgroupchat,$createdon,$readon;

	public static $className = "ChatMessage";
	public static $tableName = "chatmessages";
	
	public function setSeq($val){
		$this->seq = $val;
	}
	public function getSeq(){
		return $this->seq;
	}
	
	public function setFromUser($val){
		$this->fromuser = $val;
	}
	public function getFromUser(){
		return $this->fromuser;
	}
	
	public function setToUser($val){
		$this->touser = $val;
	}
	public function getToUser(){
		return $this->touser;
	}
	
	public function setMessage($val){
		$this->message = $val;
	}
	public function getMessage(){
		return $this->message;
	}
	
	public function setOrderId($val){
		$this->orderid = $val;
	}
	public function getOrderId(){
		return $this->orderid;
	}
	
	public function setIsGroupChat($val){
		$this->isgroupchat = $val;
	}
	public function getIsGroupChat(){
		return $this->isgroupchat;
	}
	
	public function setCreatedOn($val){
		$this->createdon = $val;
	}
	public function getCreatedOn(){
		return $this->createdon;
	}
	
	public function setReadOn($val){
		$this->readon = $val;
	}
	public function getReadOn(){
		return $this->readon;
	}
}