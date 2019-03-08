<?php
require_once($ConstantsArray['dbServerUrl'] ."Enums/BasicEnum.php");
class UserType extends BasicEnum{
	const superadmin = "SuperAdmin";
	const admin = "Admin";
	const representative = "Representative";	
}