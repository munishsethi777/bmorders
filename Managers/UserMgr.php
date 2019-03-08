<?php
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/User.php");
require_once($ConstantsArray['dbServerUrl'] ."DataStores/BeanDataStore.php");
class UserMgr{
	private static $userMgr;
	private static $userDataStore;
	
	public static function getInstance()
	{
		if (!self::$userMgr)
		{
			self::$userMgr = new UserMgr();
			self::$userDataStore = new BeanDataStore(User::$className,User::$tableName);
		}
		return self::$userMgr;
	}
	
	public function logInUser($username, $password){
		$conditionVal["emailid"] = $username;
		$admin = self::$userDataStore->executeConditionQuery($conditionVal);
		if(!empty($admin)){
			return $admin[0];
		}
		return null;
	}
	
	public function getAllUsers(){
		$admins = self::$userDataStore->findAll();
		return $admins;
	}
	
	public function isPasswordExist($password){
		//$sessionUtil = SessionUtil::getInstance();
		//$adminSeq = $sessionUtil->getAdminLoggedInSeq();
		$params["password"] = $password;
		//$params["seq"] = $adminSeq;
		$count = self::$userDataStore->executeCountQuery($params);
		return $count > 0;
	}
	
	public function ChangePassword($password){
		//$sessionUtil = SessionUtil::getInstance();
		//$adminSeq = $sessionUtil->getAdminLoggedInSeq();
		//$attr["password"] = $password;
		//$condition["seq"] = $adminSeq;
		$sql = "update admins set password = '$password'";
		self::$userDataStore->executeQuery($sql);
	}
	
	public function toArray($user){
		$adminArr = array();
		$adminArr["seq"] = $user->getSeq();
		$adminArr["username"] = $user->getEmailid();
		$adminArr["name"] = $user->getFullName();
		return $adminArr;
	}
}