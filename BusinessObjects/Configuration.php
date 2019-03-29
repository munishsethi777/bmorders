<?php
class Configuration{
	private $configkey,$configvalue;
	public static $PAYMENT_NOTIFICATION_EMAIL = "paymentNotificationEmail";
	public static $PAYMENT_NOTIFICATION_MOBILE = "paymentNotificationMobile";
	public static $ORDER_NOTIFICATION_EMAIL = "orderNotificationEmail";
	public static $ORDER_NOTIFICATION_MOBILE = "orderNotificationMobile";
	public static $EXPECTED_PAYMENT_NOTIFICATION_EMAIL = "expectedPaymentNotificationEmail";
	public static $EXPECTED_PAYMENT_NOTIFICATION_MOBILE = "expectedPaymentNotificationMobile";
	public static $SMTP_USERNAME = "smtpusername";
	public static $SMTP_PASSWORD = "smtppassword";
	public static $SMTP_HOST = "smtphost";
	
	
	public static $tableName = "configurations";
	public static $className = "configuration";

	
	public function setSeq($seq_){
		$this->seq = $seq_;
	}
	public function getSeq(){
		return $this->seq;
	}
	
	public function setConfigKey($configKey){
		$this->configkey = $configKey;
	}
	public function getConfigKey(){
		return $this->configkey;
	}

	public function setConfigValue($configValue){
		$this->configvalue = $configValue;
	}
	public function getConfigValue(){
		return $this->configvalue;
	}
}