<?php
require_once($ConstantsArray['dbServerUrl'] ."DataStores/BeanDataStore.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/ChatThread.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/SessionUtil.php");
class ChatThreadMgr{
	private static $chatThreadMgr;
	private static $dataStore;
	private static $sessionUtil;

	public static function getInstance(){
		if (!self::$chatThreadMgr){
			self::$chatThreadMgr = new ChatThreadMgr();
			self::$dataStore = new BeanDataStore(ChatThread::$className, ChatThread::$tableName);
		}
		return self::$chatThreadMgr;
	}

	public function saveChatThread($chatThread){
		$id = self::$dataStore->save($chatThread);
		return $id;
	}
}
?>	