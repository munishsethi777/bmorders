<?php
require_once($ConstantsArray['dbServerUrl'] ."Utils/PermissionUtil.php");
require_once($ConstantsArray['dbServerUrl'] ."Enums/UserType.php");
class SessionUtil{

    private static $USER_SEQ = "userSeq";
    private static $USER_USERNAME = "userUserName";
    private static $USER_LOGGED_IN = "userLoggedIn";
  
    
	private static $sessionUtil;	
	public static function getInstance(){
		if(!self::$sessionUtil){
			session_start();
		   	self::$sessionUtil = new SessionUtil();
			return self::$sessionUtil;
		}
		return self::$sessionUtil;
	}

    public function createSession(User $user){
        $arr = new ArrayObject();
        $arr[0] = $user->getSeq();
        $arr[1] = $user->getFullName();
        $arr[2] = $user->getEmailId();
        $arr[3] = $user->getUserType();
        $_SESSION[self::$USER_LOGGED_IN] = $arr;
    }


    public function refreshSession(){
    	$adminSeq = self::getAdminLoggedInSeq();
    	if(!empty($adminSeq)){
    		$ADS = AdminDataStore::getInstance();
    		$admin = $ADS->findBySeq($adminSeq);
    		self::createAdminSession($admin);
    		return true;
    	}
    	return false;
    }

    public function getUserLoggedInName(){
      if( $_SESSION[self::$USER_LOGGED_IN] != null){
                $arr = $_SESSION[self::$USER_LOGGED_IN];
                return $arr[1];
        }
    }
    
    public function getUserLoggedInUserName(){
    	if($_SESSION[self::$USER_LOGGED_IN] != null){
    			$arr = $_SESSION[self::$USER_LOGGED_IN];
    			return $arr[2];
    	}
    }
    public function getUserLoggedInUserType(){
    	if($_SESSION[self::$USER_LOGGED_IN] != null){
    		$arr = $_SESSION[self::$USER_LOGGED_IN];
    		return $arr[3];
    	}
    }
    
    public function getUserLoggedInSeq(){
        if($_SESSION[self::$USER_LOGGED_IN] != null){
    			$arr = $_SESSION[self::$USER_LOGGED_IN];
    			return $arr[0];
	    }
    }


	public function isSessionUser(){
		if(	$_SESSION[self::$USER_LOGGED_IN] != null){
			return true;
		}
		return false;
	}
	
	public function isRepresentative(){
		if(	$_SESSION[self::$USER_LOGGED_IN] != null){
			$arr = $_SESSION[self::$USER_LOGGED_IN];
    		$userType =  $arr[3];
    		if($userType == UserType::getName(UserType::representative)){
    			return true;
    		}
		}
		return false;
	}
	
	public function isSuperAdmin(){
		if(	$_SESSION[self::$USER_LOGGED_IN] != null){
			$arr = $_SESSION[self::$USER_LOGGED_IN];
			$userType =  $arr[3];
			if($userType == UserType::getName(UserType::superadmin)){
				return true;
			}
		}
		return false;
	}
	
	public function sessionCheck(){
		$bool = self::isSessionUser();
		if($bool == false){
			header("location:index.php");
			die;
		}
		$userType = $this->getUserLoggedInUserType();
		if($userType == UserType::getName(UserType::representative)){
			$page = basename ( $_SERVER ['PHP_SELF'] );
			if(!PermissionUtil::isAuthRep($page)){
				header("location: logout.php");
				die;
			}
		}
		return $bool;
	}
	
	public function destroySession(){
		$boolAdmin = self::isSessionUser();
		$_SESSION = array();
		session_destroy();
		if($boolAdmin == true){
			header("Location:index.php");
			die;
		}
	}
}
?>