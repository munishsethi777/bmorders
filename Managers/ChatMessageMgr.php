<?php
require_once($ConstantsArray['dbServerUrl'] ."DataStores/BeanDataStore.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/ChatMessage.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/SessionUtil.php");
class ChatMessageMgr{
	private static $ChatMessageMgr;
	private static $dataStore;
	private static $sessionUtil;

	public static function getInstance(){
		if (!self::$ChatMessageMgr){
			self::$ChatMessageMgr = new ChatMessageMgr();
			self::$dataStore = new BeanDataStore(ChatMessage::$className, ChatMessage::$tableName);
		}
		return self::$ChatMessageMgr;
	}
	
	public function saveChatMessage($chatMessage){
		$id = self::$dataStore->save($chatMessage);
		return $id;
	}
	
	public function getChatConversation($chattingUserSeq,$orderid,$afterSeq = 0){
		$sessionUtil = SessionUtil::getInstance();
		$userSeq = $sessionUtil->getUserLoggedInSeq();
		$sql = "SELECT chatmessages.*,users.fullname as fromusername FROM chatmessages inner join users on chatmessages.fromuser = users.seq where (chatmessages.fromuser = $userSeq or chatmessages.touser = $userSeq) and (chatmessages.seq > $afterSeq) and chatmessages.orderid = $orderid order by chatmessages.createdon ASC";
		$chatMessages = self::$dataStore->executeQuery($sql,false,true);
		return $chatMessages;
	}
	
	public function getGroupChatConversation($afterSeq = 0){
		$sessionUtil = SessionUtil::getInstance();
		$userSeq = $sessionUtil->getUserLoggedInSeq();
		$sql = "SELECT chatmessages.*,users.fullname as fromusername FROM chatmessages inner join users on chatmessages.fromuser = users.seq where chatmessages.touser = 0 and chatmessages.seq > $afterSeq and chatmessages.orderid = 0 order by chatmessages.createdon ASC";
		$chatMessages = self::$dataStore->executeQuery($sql,false,true);
		return $chatMessages;
	}
	
	public function isChatExistsForOrder($orderId){
		$colVal = array();
		$colVal["orderid"] = $orderId;
		$count = self::$dataStore->executeCountQuery($colVal);
		return $count > 0;
	}
	
	public function hadUnReadChatForOrder($orderId,$fromUserSeq){
		$query = "select count(*) from chatmessages where orderid = $orderId and readon is NULL and fromuser != $fromUserSeq";
		$count = self::$dataStore->executeCountQueryWithSql($query);
		return $count > 0;
	}
	
	public function markAsReadOrderMessages($orderId,$fromUser){
		$date = new DateTime();
		$dataStr = $date->format("Y-m-d- H:i:s");
		$query = "update chatmessages set readon = '$dataStr' where orderid = $orderId and fromuser != $fromUser";
		self::$dataStore->executeQuery($query);
	}
}