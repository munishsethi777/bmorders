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
	
	public function isChatExistsForOrder($orderId){
		$colVal = array();
		$colVal["orderid"] = $orderId;
		$count = self::$dataStore->executeCountQuery($colVal);
		return $count > 0;
	}
}