<?php
require_once ($ConstantsArray ['dbServerUrl'] . "Enums/MeasuringUnitType.php");
require_once ($ConstantsArray ['dbServerUrl'] . "Enums/UserType.php");
class DropDownUtils {
	
   public static function getDropDown($values, $selectName, $onChangeMethod, $selectedValue,$isAll = false) {
		$str = "<select required class='form-control m-b' name='" . $selectName . "' id='" . $selectName . "' onchange='" . $onChangeMethod . "'>";
		if($isAll){
			$str .= "<option value=''>Select Any</option>";
		}
		foreach ( $values as $key => $value ) {
			if( strpos( $key, "group_" ) !== false ) {
				$str .= "<optgroup label='$value'>";
			}else{
				$select = $selectedValue == $key ? 'selected' : null;
				$str .= "<option value='" . $key . "' " . $select . ">" . $value . "</option>";
			}
		}
		$str .= "</select>";
		return $str;
	}
	
	public static function getMeasuringUnitTypeDD($selectName, $onChangeMethod, $selectedValue,$isAll = false) {
		$types = MeasuringUnitType::getAll();
		return self::getDropDown ($types, $selectName, $onChangeMethod, $selectedValue,true);
	}
	
	public static function getUserTypeDD($selectName, $onChangeMethod, $selectedValue,$isAll = false) {
		$types = UserType::getAll();
		return self::getDropDown ($types, $selectName, $onChangeMethod, $selectedValue,true);
	}

}