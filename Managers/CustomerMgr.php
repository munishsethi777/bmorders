<?php
require_once($ConstantsArray['dbServerUrl'] ."DataStores/BeanDataStore.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/Customer.php");
require_once($ConstantsArray['dbServerUrl'] ."StringConstants.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/DateUtil.php");

class CustomerMgr{
	private static $customerMgr;
	private static $dataStore;
	private static $sessionUtil;
	
	public static function getInstance(){
		if (!self::$customerMgr){
			self::$customerMgr = new CustomerMgr();
			self::$dataStore = new BeanDataStore(Customer::$className, Customer::$tableName);
		}
		return self::$customerMgr;
	}
	
	public function findBySeq($seq){
		$customers = self::$dataStore->findBySeq($seq);
		return $customers;
	}
	
	public function findAll($isApplyFilter = false){
		$customers = self::$dataStore->findAll($isApplyFilter);
		return $customers;
	}
	
	public function saveCustomer($customer){
		$id = self::$dataStore->save($customer);
		return $id;
	}
	
	public function getAllCustomersForGrid(){
		$customers = $this->findAll(true);
		$mainArr = array();
		foreach ($customers as $customer){
			$arr["seq"] = $customer->getSeq();
			$arr["title"] = $customer->getTitle();
			$arr["contactperson"] = $customer->getContactPerson();
			$arr["mobile"] = $customer->getMobile();
			$arr["city"] = $customer->getCity();
			$arr["isenabled"] = !empty($customer->getIsEnabled());
			$arr["lastmodifiedon"] = $customer->getLastModifiedOn();
			array_push($mainArr, $arr);
 		}
 		$jsonArr["Rows"] =  $mainArr;
 		$jsonArr["TotalRows"] = $this->getCount();
 		return $jsonArr;
	}

	public function getCount(){
		$query = "select count(*) from customers";
		$count = self::$dataStore->executeCountQueryWithSql($query,true);
		return $count;
	}
	
	public function deleteBySeqs($ids) {
		$flag = self::$dataStore->deleteInList ( $ids );
		return $flag;
	}
	function _group_by($array, $key) {
		$return = array();
		foreach($array as $val) {
			$return[$val[$key]][] = $val;
		}
		return $return;
	}

}