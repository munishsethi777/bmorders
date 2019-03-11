<?php
require_once('../IConstants.inc');
require_once($ConstantsArray['dbServerUrl'] ."Managers/UserMgr.php");
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
		$customers = $_REQUEST["customers"];
		if(empty($customers)){
			throw new Exception("Please Select at least one customer");
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
if($call == "getUserTypes"){
	$userTypes = UserType::getAll();
	$userTypes = array_values($userTypes);
	echo json_encode($userTypes);
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


$response["success"] = $success;
$response["message"] = $message;
echo json_encode($response);
return;