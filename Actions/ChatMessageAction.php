<?php
require_once('../IConstants.inc');
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/ChatMessage.php");
require_once($ConstantsArray['dbServerUrl'] ."Managers/ChatMessageMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/SessionUtil.php");
$call = "";
if(isset($_GET["call"])){
	$call = $_GET["call"];
}else{
	$call = $_POST["call"];
}

$success = 1;
$message = "";
$sessionUtil = SessionUtil::getInstance();
$userSeq = $sessionUtil->getUserLoggedInSeq();
$chatMessageMgr = ChatMessageMgr::getInstance();

if($call == "sendMessageChat"){
	try{
		$chatMessage = new ChatMessage();
		$chatMessage->createFromRequest($_REQUEST);
		$chatMessage->setCreatedOn(new DateTime());
		$chatMessage->setReadOn(null);
		$id = $chatMessageMgr->saveChatMessage($chatMessage);
		$success = 1;
	}catch(Exception $e){
		$success = 0;
		$message  = $e->getMessage();
	}
	$response = new ArrayObject();
	$response["success"]  = $success;
	$response["message"]  = $message;
	$response["lastMessageSeq"] = $id;
	echo json_encode($response);
}

if($call == "isChatExists"){
	try{
		$orderId = $_GET["orderid"];
		$isExists = $chatMessageMgr->isChatExistsForOrder($orderId);
		$response["isExists"] = $isExists;
		$json = json_encode($response);
		echo $json;
	}catch(Exception $e){
		$success = 0;
	}
}
if($call == "getUnReadCount"){
	try{
		$count = $chatMessageMgr->getUnReadChatCount($userSeq);
		$response["unreadCount"] = $count;
		$json = json_encode($response);
		echo $json;
	}catch(Exception $e){
		$success = 0;
	}
}
if($call == "markAsRead"){
	try{
		$orderId = $_GET["orderid"];
		$chatMessageMgr->markAsReadOrderMessages($orderId,$userSeq);
	}catch(Exception $e){
		$success = 0;
	}
}
if($call == "getAllChats"){
	$chats = $chatMessageMgr->getAllChatsForGrid();
	echo json_encode($chats);
	return;
}
if($call == "getMessagesChat"){
	$response = new ArrayObject();
	try{
		$toUserSeq = $_GET['toUserSeq'];
		$orderSeq = $_GET['orderid'];
		$chatLoadedTillSeq = $_GET['chatLoadedTillSeq'];
		$messages = $chatMessageMgr->getChatConversation($toUserSeq,$orderSeq,$chatLoadedTillSeq);
		$response["messages"] = $messages;
		$success = 1;
	}catch(Exception $e){
		$success = 0;
		$message  = $e->getMessage();
	}
	
	$response["success"]  = $success;
	$response["message"]  = $message;
	echo json_encode($response);
	
}
if($call == "getGroupMessagesChat"){
	$response = new ArrayObject();
	try{
		$chatLoadedTillSeq = $_GET['chatLoadedTillSeq'];
		$messages = $chatMessageMgr->getGroupChatConversation($chatLoadedTillSeq);
		$response["messages"] = $messages;
		$success = 1;
	}catch(Exception $e){
		$success = 0;
		$message  = $e->getMessage();
	}

	$response["success"]  = $success;
	$response["message"]  = $message;
	echo json_encode($response);
}
if($call == "deleteMessageChat"){
	try{
		$chatMessageMgr->deleteChatConversation($_POST['userseq'],$_POST['usertype']);
		$message = "Message Deleted successfully";
	}catch(Exception $e){
		$success = 0;
		$message = $e->getMessage();
	}
	$response = new ArrayObject();
	$response["message"] = $message;
	$response["success"] =  $success;
	echo json_encode($response);
}
if($call == "getReceivedMessagesJSON"){	
	$messagesArr = $chatMessageMgr->getMessagesArr(true);
	echo json_encode($messagesArr);
}
if($call == "getAdminReceivedMessagesJSON"){
	$messagesArr = $chatMessageMgr->getMessagesArrByAdmin(true);
	echo json_encode($messagesArr);
}
if($call == "getAdminSentMessagesJSON"){
	$messagesArr = $chatMessageMgr->getMessagesArrByAdmin(false);
	echo json_encode($messagesArr);
}
if($call == "getSentMessagesJSON"){
	$messagesArr = $chatMessageMgr->getMessagesArr(false);
	echo json_encode($messagesArr);
}
if($call == "deleteMessage"){
	$ids = $_GET["ids"];
	if(empty($ids)){
		$ids = $_POST["ids"];
	}
	try{		
		$chatMessageMgr->deleteBySeqs($ids);
		$message = "Message Deleted successfully";
	}catch(Exception $e){
		$success = 0;
	}
	$response = new ArrayObject();
	$response["message"] = $message;
	$response["success"] =  $success;
	echo json_encode($response);
}
if($call == "getMessageActionForReply"){
	$id = $_GET["replyToSeq"];
	$isSent = false;
	if(isset($_GET["issent"])){
		$isSent = $_GET["issent"];
	}
	try{
		if($isSent){
			$message = $chatMessageMgr->getSentMessageBySeq($id);
		}else{
			$message = $chatMessageMgr->getMessageBySeq($id);
		}
	}catch(Exception $e){
		$success = 0;
	}
	$response = new ArrayObject();
	$response["message"] = $message;
	$response["success"] =  $success;
	echo json_encode($response);
}

if($call == "getUserMessagesForDashboard"){
	try{
		$userSeq = $sessionUtil->getUserLoggedInSeq();
		$message = $chatMessageMgr->getMessagesByToUserSeq($userSeq,true);
		$json = json_encode($message);
		echo $json;
	}catch(Exception $e){
		$success = 0;
	}	
}
if($call == "getAdminMessagesForDashboard"){
	try{
		$adminSeq = $sessionUtil->getAdminLoggedInSeq();
		$companySeq = $sessionUtil->getAdminLoggedInCompanySeq();
		$message = $chatMessageMgr->getMessagesByToAdminSeq($adminSeq,$companySeq);
		$json = json_encode($message);
		echo $json;
	}catch(Exception $e){
		$success = 0;
	}
}

if($call == "markReadAndUnRead"){
	try{
		$seq = $_GET["seq"];
		$isRead = $_GET["isRead"];	
		$chatMessageMgr->markRead($isRead,$seq);
	}catch(Exception $e){
		$success = 0;
	}
}

function sendMessage($userSeqs){
	$chatMessageMgr = UserMessageMgr::getInstance();
	$sessionUtil = SessionUtil::getInstance();
	$adminSeq = $sessionUtil->getUserLoggedInAdminSeq();
	$message = $_POST['message'];
	$sendTo = $_POST['sendTo'];
	$sendFrom = $_POST['sendFrom'];
	foreach ($userSeqs as $toUserSeq){
		$chatMessage = new UserMessage();
		if($sendTo == "user"){
			$userMgr = UserMgr::getInstance();
			$chatMessage->setToUserSeq($toUserSeq);
			$userName = "user - " . $userMgr->getUserNameBySeq($toUserSeq);
		}else{
			$adminMgr = AdminMgr::getInstance();
			$chatMessage->setToAdminSeq($adminSeq);
			$userName = "admin - " . $adminMgr->getAdminUserNameBySeq($adminSeq);
		}
		$chatMessage->setDated(new DateTime());
		$chatMessage->setFromUserSeq(null);
		$chatMessage->setFromAdminSeq(null);
		$companySeq = 0;
		if($sendFrom == "user"){
			$chatMessage->setFromUserSeq($sessionUtil->getUserLoggedInSeq());
			$companySeq = $sessionUtil->getUserLoggedInCompanySeq();
		}else{
			$chatMessage->setFromAdminSeq($sessionUtil->getAdminLoggedInSeq());
			$companySeq = $sessionUtil->getAdminLoggedInCompanySeq();
		}
		$chatMessage->setIsRead(0);
		$chatMessage->setMessageText($message);
		//$chatMessage->setReplyToSeq(0);
		//$chatMessage->setReplyToAdminSeq(0);
		$chatMessage->setCompanySeq($companySeq);
		$chatMessageMgr->save($chatMessage);
		if($sendFrom == "user"){
			UserLogMgr::addLog(LogType::sent_message,"Sent message to " . $userName);
		}
	}
}
