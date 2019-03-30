<?php
require_once($ConstantsArray['dbServerUrl'] ."Enums/BasicEnum.php");
class TransactionType extends BasicEnum{
	const receipt = "Receipt";
	const payment = "Payment";
}