<?php
require_once($ConstantsArray['dbServerUrl'] ."Enums/BasicEnum.php");
class PaymentMode extends BasicEnum{
	const cash = "Cash";
	const check = "Cheque";
}