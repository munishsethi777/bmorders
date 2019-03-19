<?php
require_once($ConstantsArray['dbServerUrl'] ."Enums/BasicEnum.php");
class NotificationType extends BasicEnum{
	const sms = "sms";
	const email = "email";
}