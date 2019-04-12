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
		$isRep = $sessionUtil->isRepresentative();
		if($isRep){
			$userSeq = $chattingUserSeq;
		}
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
	
	
	public function getAllUnreadChatForUser($userSeq){
		$query = "select users.fullname, chatmessages.* from chatmessages inner join users on chatmessages.fromuser = users.seq where readon is NULL and fromuser != $userSeq and touser = $userSeq";
		$orderChats = self::$dataStore->executeQuery($query,false,true);
		$mainArr = array();
		foreach ($orderChats as $orderChat){
			$createDate = $orderChat["createdon"];
			$createDateObj = DateUtil::StringToDateByGivenFormat("Y-m-d H:i:s", $createDate);
			$date = DateUtil::getTimeDiffTillNow($createDateObj);
			$orderChat["createdon"] = $date;
			array_push($mainArr, $orderChat);
		}
		return $mainArr;
	}
	
	public function getUnReadChatCount($fromUserSeq){
		$query = "select count(*) from chatmessages where readon is NULL and fromuser != $fromUserSeq and orderid > 0";
		$count = self::$dataStore->executeCountQueryWithSql($query);
		return $count;
	}
	
	public function getUnReadGroupChatCount($fromUserSeq){
		$query = "select count(*) from chatmessages where readon is NULL and fromuser != $fromUserSeq and orderid = 0";
		$count = self::$dataStore->executeCountQueryWithSql($query);
		return $count;
	}
	
	
	
	public function markAsReadOrderMessages($orderId,$fromUser){
		$date = new DateTime();
		$dataStr = $date->format("Y-m-d- H:i:s");
		$query = "update chatmessages set readon = '$dataStr' where orderid = $orderId and fromuser != $fromUser";
		self::$dataStore->executeQuery($query);
	}
	
	public function getAllChatsForGrid(){
		$sessionUtil = SessionUtil::getInstance();
		$userSeq = $sessionUtil->getUserLoggedInSeq();
		$query = "select MAX(chatmessages.createdon) as lastmessagedate , users.fullname ,customers.title as customer ,orders.seq as orderid, chatmessages.* from chatmessages 
inner join orders on chatmessages.orderid = orders.seq inner join customers on orders.customerseq = customers.seq INNER join users on orders.userseq = users.seq GROUP by chatmessages.orderid";
		$orderChats = self::$dataStore->executeQuery($query,true);
		$mainArr = array();
		$chatMgr = ChatMessageMgr::getInstance();
		$sessionUtil = SessionUtil::getInstance();
		$loggedInUser = $sessionUtil->getUserLoggedInSeq();
		foreach ($orderChats as $orderChat){
			$orderChat["chatmessages.createdon"] = $orderChat["lastmessagedate"];
			$orderChat["customers.title"] = $orderChat["customer"];
			$readon = $orderChat["readon"];
			$fromUser = $orderChat["fromuser"];
			$hasChat = 0;
			if(empty($readon) && $fromUser != $userSeq){
				$hasChat = 1;
			}
			$orderChat["haschat"] = $this->hadUnReadChatForOrder($orderChat["orderid"], $userSeq);
			array_push($mainArr, $orderChat);
		}
 		$jsonArr["Rows"] =  $mainArr;
		$jsonArr["TotalRows"] = $this->getCount();
		return $jsonArr;
	}
	
	public function getCount(){
		$query = "select count(*) from (select count(*) from chatmessages 
inner join orders on chatmessages.orderid = orders.seq inner join customers on orders.customerseq = customers.seq INNER join users on orders.userseq = users.seq GROUP by chatmessages.orderid) table1";
		$count = self::$dataStore->executeCountQueryWithSql($query,true);
		return $count;
	}
}