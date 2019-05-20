<?php
class OrderProductDetail{
	private $seq,$orderseq,$price,$productseq,$quantity,$lotnumber;
	public static $className = "OrderProductDetail";
	public static $tableName = "orderproductdetails";
	
	public function setSeq($seq_){
		$this->seq = $seq_;
	}
	public function getSeq(){
		return  $this->seq;
	}
	
	public function setOrderSeq($orderSeq_){
		$this->orderseq = $orderSeq_;
	}
	public function getOrderSeq(){
		return $this->orderseq;
	}
	
	public function setPrice($price_){
		$this->price = $price_;
	}
	public function getPrice(){
		return $this->price;
	}
	
	public function setProductSeq($productSeq_){
		$this->productseq = $productSeq_;
	}
	public function getProductSeq(){
		return  $this->productseq;
	}
	
	public function setQuantity($qty_){
		$this->quantity = $qty_;
	}
	public function getQuantity(){
		return $this->quantity;
	}
	
	public function getLotNumber(){
		return $this->lotnumber;
	}
	public function setLotNumber($lotNumber_){
		$this->lotnumber = $lotNumber_;
	}
}