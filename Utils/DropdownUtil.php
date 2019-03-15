<?php
require_once ($ConstantsArray ['dbServerUrl'] . "Enums/MeasuringUnitType.php");
require_once ($ConstantsArray ['dbServerUrl'] . "Enums/UserType.php");
require_once ($ConstantsArray ['dbServerUrl'] . "Enums/PaymentMode.php");
class DropDownUtils {
	
   public static function getDropDown($values, $selectName, $onChangeMethod, $selectedValue,$isAll = false,$firstOption = "Select Any") {
   		$id = $selectName;
   		if(strpos($selectName, "[]") !== false){
   			$id = str_replace("[]", "", $id);
   		}
		$str = "<select required class='form-control m-b' name='" . $selectName . "' id='" . $id . "' onchange='" . $onChangeMethod . "'>";
		if($isAll){
			$str .= "<option value=''>".$firstOption."</option>";
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
	
	public static function getPaymentModeDD($selectName, $onChangeMethod, $selectedValue,$isAll = false) {
		$paymentMode = PaymentMode::getAll();
		return self::getDropDown ($paymentMode, $selectName, $onChangeMethod, $selectedValue,true,"Payment Mode");
	}

}