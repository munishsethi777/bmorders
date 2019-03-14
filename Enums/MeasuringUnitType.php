<?php
require_once($ConstantsArray['dbServerUrl'] ."Enums/BasicEnum.php");
class MeasuringUnitType extends BasicEnum{
	const grams = "gms";
	const kilograms = "kg";
	const pounds = "lbs";
	const pieces = "pcs";
	const millilitres = "ml";
}