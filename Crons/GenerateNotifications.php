<?php
require_once('../IConstants.inc');
require_once($ConstantsArray['dbServerUrl'] ."Utils/NotificationUtil.php");
NotificationUtil::generateExpectedPaymentNotification();
