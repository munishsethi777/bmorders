<?php
require_once($ConstantsArray['dbServerUrl'] ."Enums/BasicEnum.php");
class MeasuringUnitType extends BasicEnum{
	
	const kilograms = "kilograms";
	const pounds = "pounds";
	const pieces = "pieces";
	const millilitres = "ml";
}