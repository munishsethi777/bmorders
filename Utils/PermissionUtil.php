<?php
class PermissionUtil{
	private static $repersentativePermissions =  array(0=>'dashboard.php',
			1=>'showCustomers.php',
			2=>'createCustomer.php',
			3=>'showOrders.php',
			4=>'createOrder.php',
			5=>'createOrderPayment.php',
			6=>'showCashBook.php',
			7=>'createCashBook.php',8=>'orderChat.php',9=>'groupChat.php',10=>'showOrderChats.php'
	);
	public static function isAuthRep($pageUrl){
		if(in_array($pageUrl, self::$repersentativePermissions)){
			return true;
		}
		return false;
	}
}