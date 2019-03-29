<?php
require_once($ConstantsArray['dbServerUrl'] ."Enums/BasicEnum.php");
class ExpenseType extends BasicEnum{
	const misc = "Misc";
	const transfer = "Transfer";
	const tradeexpense = "Trade Expense";
}