<?php
require_once($ConstantsArray['dbServerUrl'] ."DataStores/BeanDataStore.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/UserCompany.php");

class UserCompanyMgr{
	private static $userCompanyMgr;
	private static $dataStore;
	private static $sessionUtil;

	public static function getInstance(){
		if (!self::$userCompanyMgr){
			self::$userCompanyMgr = new UserCompanyMgr();
			self::$dataStore = new BeanDataStore(UserCompany::$className, UserCompany::$tableName);
		}
		return self::$userCompanyMgr;
	}
	
	public function saveFromUser($userSeq,$customers){
		$this->deleteByUser($userSeq);
		foreach ($customers as $customer){
			$userCompany = new UserCompany();
			$userCompany->setCustomerSeq($customer);
			$userCompany->setUserSeq($userSeq);
			$this->saveUserCompany($userCompany);
		}
	}
	
	public function findCustomerIdsByUser($userSeq){
		$colVal["userseq"] = $userSeq;
		$userCompanies = self::$dataStore->executeConditionQuery($colVal);
		$companies = array_map(create_function('$o', 'return $o->getCustomerSeq();'), $userCompanies);
		return $companies;
	}
	
	public function saveUserCompany($userCompany){
		$id = self::$dataStore->save($userCompany);
		return $id;
	}
	
	public function deleteByUser($userSeq){
		$colVal["userseq"] = $userSeq;
		$flag = self::$dataStore->deleteByAttribute($colVal);
		return $flag;
	}
}