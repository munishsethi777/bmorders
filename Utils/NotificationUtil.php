<?php
$docroot1 = $_SERVER["DOCUMENT_ROOT"] ."/bmorders/";
require_once($docroot1."IConstants.inc");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/Notification.php");
require_once($ConstantsArray['dbServerUrl'] ."Managers/ConfigurationMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."Enums/NotificationType.php");
require_once ($ConstantsArray ['dbServerUrl'] . "log4php/Logger.php");
Logger::configure ( $ConstantsArray ['dbServerUrl'] . "log4php/log4php.xml" );
require_once($ConstantsArray['dbServerUrl'] ."Utils/MailUtil.php");

class NotificationUtil{
	
	public static function sendNotifications(){
		$logger = Logger::getLogger ( "logger" );
		$notificationMgr = NotificationMgr::getInstance();
		$pendingNotifications = $notificationMgr->getPendingNotifications();
		foreach ($pendingNotifications as $notification){
			try{
				$emails = $notification->getDestination();
				MailUtil::sendEmailFromNotification($notification);
				$logger->info("Notification Sent Successfully to - " . $emails);
			}catch (Exception $e){
				$logger->error($e->getMessage(),$e);
			}	
		}
	}
}
