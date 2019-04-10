<?php
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/User.php");
require_once($ConstantsArray['dbServerUrl'] ."Managers/UserCompanyMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."DataStores/BeanDataStore.php");
require_once ($ConstantsArray ['dbServerUrl'] . "log4php/Logger.php");
Logger::configure ( $ConstantsArray ['dbServerUrl'] . "log4php/log4php.xml" );
require_once($ConstantsArray['dbServerUrl'] ."Enums/UserType.php");


class UserMgr{
	private static $userMgr;
	private static $userDataStore;
	private static $logger;
	
	public static function getInstance()
	{
		if (!self::$userMgr)
		{
			self::$userMgr = new UserMgr();
			self::$userDataStore = new BeanDataStore(User::$className,User::$tableName);
			self::$logger = Logger::getLogger("logger");
		}
		return self::$userMgr;
	}
	
	public function saveUser($user,$customers){
		$id = self::$userDataStore->save($user);
		if(!empty($id)){
			$userCompanyMgr = UserCompanyMgr::getInstance();
			$userCompanyMgr->saveFromUser($id, $customers);
			self::$logger->info("User ".$user->getEmailId()." saved for customers ". implode(",", $customers));
		}
	}
	
	public function getAllUsersForGrid(){
		$users = self::$userDataStore->findAllArr(true);
		$mainArr = array();
		foreach ($users as  $user){
			$userType = UserType::getValue($user["usertype"]);
			$user["usertype"] = $userType;
			array_push($mainArr, $user);
		}
		$jsonArr["Rows"] =  $mainArr;
		$jsonArr["TotalRows"] = $this->getAllCount();
		return $jsonArr;
	}
	
	public function findAllArr(){
		$users = self::$userDataStore->findAllArr();
		return $users;
	}
	
	public function getAllCount(){
		$query = "select count(*) from users";
		$count = self::$userDataStore->executeCountQueryWithSql($query,true);
		return $count;
	}
	
	public function getAllAdmins(){
		$rep = UserType::representative;
		$query = "select * from users where usertype != '$rep'";
		$admins = self::$userDataStore->executeQuery($query,false,true);
		return $admins;
	}
	
	public function logInUser($username, $password){
		$conditionVal["emailid"] = $username;
		$admin = self::$userDataStore->executeConditionQuery($conditionVal);
		if(!empty($admin)){
			self::$logger->info("User ".$username." logged in successfully");
			return $admin[0];
		}
		return null;
	}
	
	public function getAllUsers(){
		$admins = self::$userDataStore->findAll();
		return $admins;
	}
	
	public function getAllUserNames(){
		$sessionUtil = SessionUtil::getInstance();
		$isRep = $sessionUtil->isRepresentative();
		$names = array();
		if($isRep){
			$userName = $sessionUtil->getUserLoggedInName();
			$names = array(0=>$userName);
		}else{
			$admins = $this->getAllUsers();
			$names = array_map(create_function('$o', 'return $o->getFullName();'), $admins);
		}
		return $names;
	}
	
	
	public function toArray($user){
		$adminArr = array();
		$adminArr["seq"] = $user->getSeq();
		$adminArr["username"] = $user->getEmailid();
		$adminArr["name"] = $user->getFullName();
		$adminArr["fullname"] = $user->getFullName();
		return $adminArr;
	}
	
	
	public function findBySeq($seq){
		$user = self::$userDataStore->findBySeq($seq);
		return $user;
	}
	
	public function deleteBySeqs($ids) {
		$flag = self::$userDataStore->deleteInList ( $ids );
		return $flag;
	}
}