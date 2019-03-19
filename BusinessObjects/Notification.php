<?php
class Notification{
	private $seq, $notificationtype, $title, $body, $userseq, $destination, $isviewed, $createdon, $issent, $exception;
	public static $className = "Notification";
	public static $tableName = "notifications";
	
	public function setSeq($seq_){
		$this->seq = $seq_;
	}
	public function getSeq(){
		return  $this->seq;
	}
	
	public function setNotificationType($val){
		$this->notificationtype = $val;
	}
	public function getNotificationType(){
		return  $this->notificationtype;
	}
	
	public function setTitle($val){
		$this->title = $val;
	}
	public function getTitle(){
		return  $this->title;
	}
	
	public function setBody($val){
		$this->body = $val;
	}
	public function getBody(){
		return  $this->body;
	}
	
	public function setUserSeq($val){
		$this->userseq = $val;
	}
	public function getUserSeq(){
		return  $this->userseq;
	}
	
	public function setDestination($val){
		$this->destination = $val;
	}
	public function getDestination(){
		return  $this->destination;
	}
	public function setIsViewed($val){
		$this->isviewed = $val;
	}
	public function getIsViewed(){
		return  $this->isviewed;
	}
	public function setCreatedOn($val){
		$this->createdon = $val;
	}
	public function getCreatedOn(){
		return  $this->createdon;
	}
	public function setIsSent($val){
		$this->issent = $val;
	}
	public function getIsSent(){
		return  $this->issent;
	}
	public function setException($val){
		$this->exception = $val;
	}
	public function getException(){
		return  $this->exception;
	}
	
	
	
	
	
}