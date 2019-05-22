<?php
class PurchaseReturn{
	private $seq,$purchaseseq,$purchasedetailseq,$quantity,$createdon,$comments;
	public static $className = "PurchaseReturn";
	public static $tableName = "purchasereturns";
	
	public function setSeq($seq_){
		$this->seq = $seq_;
	}
	public function getSeq(){
		return $this->seq;
	}
	
	public function setPurchaseSeq($purchaseSeq_){
		$this->purchaseseq = $purchaseSeq_;
	}
	public function getPurchaseSeq(){
		return $this->purchaseseq;
	}
	
	public function setPurchaseDetailSeq($purchaseDetailSeq_){
		$this->purchasedetailseq = $purchaseDetailSeq_;
	}
	public function getPurchaseDetailSeq(){
		return $this->purchasedetailseq;
	}
	
	public function setQuantity($quantity_){
		$this->quantity = $quantity_;
	}
	public function getQuantity(){
		return $this->quantity;
	}
	
	public function setComments($comments_){
		$this->comments = $comments_;
	}
	public function getComments(){
		return $this->comments;
	}
	
	public function setCreatedOn($val){
		$this->createdon = $val;
	}
	public function getCreatedOn(){
		return  $this->createdon;
	}
	
}