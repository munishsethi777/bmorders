<?php
require_once('../IConstants.inc');
require_once($ConstantsArray['dbServerUrl'] ."Managers/UserMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."Managers/ConfigurationMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/SessionUtil.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/User.php");
require_once($ConstantsArray['dbServerUrl'] ."Enums/UserType.php");
$success = 1;
$message = "";
$call = "";
$response = new ArrayObject();
$userMgr = UserMgr::getInstance();
if(isset($_GET["call"])){
	$call = $_GET["call"];
}else{
	$call = $_POST["call"];
	
}
if($call == "saveUser"){
	$user = new User();
	try{
		$user->createFromRequest($_POST);
		$isEnabled = 0;
		if(isset($_REQUEST["isenabled"]) && !empty($_REQUEST["isenabled"])){
			$isEnabled = 1;
		}
		$user->setIsEnabled($isEnabled);
		$user->setCreatedOn(new DateTime());
		$user->setLastModifiedOn(new DateTime());
		$customers = array();
		if(isset($_REQUEST["customers"]) && !empty($_REQUEST["customers"])){
			$customers = $_REQUEST["customers"];
		}
		$userMgr->saveUser($user, $customers);
		$message = "User saved successfully!";
	}catch(Exception $e){
		$success = 0;
		$message  = $e->getMessage();
	}
}
if($call == "getAllUsers"){
	$users = $userMgr->getAllUsersForGrid();
	echo json_encode($users);
	return;
}
if($call == "getAllAdmins"){
	$users = $userMgr->getAllAdmins();
	echo json_encode($users);
	return;
}
if($call == "getUserTypes"){
	$userTypes = UserType::getAll();
	$userTypes = array_values($userTypes);
	echo json_encode($userTypes);
	return;
}
if($call == "getAllUsersForDD"){
	$users = $userMgr->findAllArr();
	echo json_encode($users);
	return;
}
if($call == "loginUser"){
	$username = $_GET["username"];
	$password = $_GET["password"];
	$userMgr = UserMgr::getInstance();
	$user = $userMgr->logInUser($username,$password);
	if(!empty($user) && $user->getPassword() == $password){
		$sessionUtil = SessionUtil::getInstance();
		$sessionUtil->createSession($user);
		$response["admin"] = $userMgr->toArray($user);
		$message = "Login successfully";
	}else{
		$success = 0;
		$message = "Incorrect Username or Password";
	}
}

if($call == "deleteUsers"){
	$ids = $_GET["ids"];
	try{
		$userMgr->deleteBySeqs($ids);
		$message = "User(s) Deleted successfully";
	}catch(Exception $e){
		$success = 0;
		$message = $e->getMessage();
		//$message = ErrorUtil::checkReferenceError(LearningPlan::$className,$e);
	}
}

if($call == "changePassword"){
	$password = $_GET["newPassword"];
	$earlierPassword = $_GET["earlierPassword"];
	try{
		$adminMgr = AdminMgr::getInstance();
		$isPasswordExists = $adminMgr->isPasswordExist($earlierPassword);
		if($isPasswordExists){
			$adminMgr->ChangePassword($password);
			$message = "Password Updated Successfully";
		}else{
			$message = "Incorrect Current Password!";
			$success = 0;
		}

	}catch(Exception $e){
		$success = 0;
		$message  = $e->getMessage();
	}
}
if($call == "saveOrderNotificationSettings"){
	$orderNotificationEmail = $_GET["orderNotificationEmail"];
	$orderNotificationMobile = $_GET["orderNotificationMobile"];
	try{
		$configurationMgr = ConfigurationMgr::getInstance();
		$configurationMgr->saveConfiguration(Configuration::$ORDER_NOTIFICATION_EMAIL, $orderNotificationEmail);
		$configurationMgr->saveConfiguration(Configuration::$ORDER_NOTIFICATION_MOBILE, $orderNotificationMobile);
		$message = "Settings Saved Successfully";
	}catch(Exception $e){
		$success = 0;
		$message  = $e->getMessage();
	}
}

if($call == "savePaymentNotificationSettings"){
	$paymentNotificationEmail = $_GET["paymentNotificationEmail"];
	$paymentNotificationMobile = $_GET["paymentNotificationMobile"];
	try{
		$configurationMgr = ConfigurationMgr::getInstance();
		$configurationMgr->saveConfiguration(Configuration::$PAYMENT_NOTIFICATION_EMAIL, $paymentNotificationEmail);
		$configurationMgr->saveConfiguration(Configuration::$PAYMENT_NOTIFICATION_MOBILE, $paymentNotificationMobile);
		$message = "Settings Saved Successfully";
	}catch(Exception $e){
		$success = 0;
		$message  = $e->getMessage();
	}
}

if($call == "saveExpectedPaymentNotificationSettings"){
	$expectedPaymentNotificationEmail = $_GET["expectedPaymentNotificationEmail"];
	$expectedPaymentNotificationMobile = $_GET["expectedPaymentNotificationMobile"];
	try{
		$configurationMgr = ConfigurationMgr::getInstance();
		$configurationMgr->saveConfiguration(Configuration::$EXPECTED_PAYMENT_NOTIFICATION_EMAIL, $expectedPaymentNotificationEmail);
		$configurationMgr->saveConfiguration(Configuration::$EXPECTED_PAYMENT_NOTIFICATION_MOBILE, $expectedPaymentNotificationMobile);
		$message = "Settings Saved Successfully";
	}catch(Exception $e){
		$success = 0;
		$message  = $e->getMessage();
	}
}


$response["success"] = $success;
$response["message"] = $message;
echo json_encode($response);
return;