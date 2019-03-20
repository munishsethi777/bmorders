<?php
require_once($ConstantsArray['dbServerUrl'] ."DataStores/BeanDataStore.php");
require_once($ConstantsArray['dbServerUrl'] ."BusinessObjects/Notification.php");
require_once($ConstantsArray['dbServerUrl'] ."Managers/ConfigurationMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."Managers/NotificationMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."Managers/CustomerMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."Managers/OrderPaymentDetailMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."Managers/OrderProductDetailMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."Managers/UserMgr.php");
require_once($ConstantsArray['dbServerUrl'] ."Enums/NotificationType.php");
require_once($ConstantsArray['dbServerUrl'] ."Enums/NotificationStatus.php");
require_once($ConstantsArray['dbServerUrl'] ."Utils/DateUtil.php");
class NotificationMgr{
	private static $notificationMgr;
	private static $dataStore;
	private static $sessionUtil;
	public static function getInstance()
	{
		if (!self::$notificationMgr)
		{
			self::$notificationMgr = new NotificationMgr();
			self::$dataStore = new BeanDataStore(Notification::$className, Notification::$tableName);
		}
		return self::$notificationMgr;
	}
	
	public function saveNotification($notificationObj){
		$id = self::$dataStore->save($notificationObj);
		return $id;
	}
	
	public function getPendingNotifications(){
		$colval["issent"] = 0;
		$pendingNotifications = self::$dataStore->executeConditionQuery($colval);
		return $pendingNotifications;
	}
	
	public function saveCreateOrderNotificationForEmail($order){
		$notification = new Notification();
		$totalAmount = $order->getTotalAmount();
		$pendingAmount = $order->getTotalAmount();
		$amountStr = number_format($totalAmount,2,'.','');
		$customerMgr = CustomerMgr::getInstance();
		$userMgr = UserMgr::getInstance();
		$user = $userMgr->findBySeq($order->getUserSeq());
		$userInfo = $user->getFullName() . " - " . $user->getMobile(); 
		$customer = $customerMgr->findBySeq($order->getCustomerSeq());
		$customerName = $customer->getTitle() . ", " . $customer->getCity();
		$customerAddress = $customer->getAddress1() . ", " . $customer->getAddress2() . ", " . $customer->getCity() . "-" . $customer->getZip() . ", " . $customer->getState();
		$orderPaymentDetailMgr = OrderPaymentDetailMgr::getInstance();
		$payments = $orderPaymentDetailMgr->findByOrderSeq($order->getSeq());
		$paymentHtml = "";
		$productDetailHtml = $this->getProductDetailInfo($order->getSeq());
		$netAmount = $totalAmount;
		$discountPercent = $order->getDiscountPercent();
		$discount = 0;
		if(!empty($discountPercent)){
			$discount = ($discountPercent / 100) * $totalAmount;
			$netAmount = $netAmount - $discount;
		}
		$discount = number_format($discount,2,'.','');
		$totalAmount = number_format($totalAmount,2,'.','');
		$netAmount = number_format($netAmount,2,'.','');
		$body = file_get_contents("../orderEmailTemplate.php"); 
		$phAnValues = array();
		$orderDate = $order->getCreatedOn();
		$orderDateStr = $orderDate->format("M d, Y, h:i:s a");
		$phAnValues["ORDER_DATE"] = $orderDateStr;
		$phAnValues["ORDER_ID"] = $order->getSeq();
		$phAnValues["CUSTOMER_NAME"] = $customerName;
		$phAnValues["CUSTOMER_ADDRESS"] = $customerAddress;
		$phAnValues["CUSTOMER_MOBILE"] = $customer->getMobile();
		$phAnValues["CUSTOMER_EMAIL"] = $customer->getEmail();
		$phAnValues["ORDER_COMMENTS"] = $order->getComments();
		$phAnValues["ORDER_AMOUNT"] = $amountStr;
		$phAnValues["PROCESSED_BY_INFO"] = $userInfo;
		$phAnValues["PRODUCT_HTML"] = $productDetailHtml;
		$phAnValues["GROSS_TOTAL"] = $totalAmount;
		$phAnValues["DISCOUNT_AMOUNT"] = $discount;
		$phAnValues["NET_AMOUNT"] = $netAmount;
		$body = $this->replacePlaceHolders($phAnValues, $body);
		$subject = "Order Confirmation";
		$configurationMgr = ConfigurationMgr::getInstance();
		$destination = $configurationMgr->getConfiguration(Configuration::$EMAIL);
		$notification->setBody($body);
		$notification->setCreatedOn(new DateTime());
		$notification->setDestination($destination);
		$notification->setIsViewed(1);
		$notification->setIsSent(0);
		$notification->setTitle($subject);
		$notification->setNotificationType(NotificationType::email);
		$notification->setCreatedOn(new DateTime());
		$notificationMgr = NotificationMgr::getInstance();
		$notificationMgr->saveNotification($notification);
	}
	
	private function replacePlaceHolders($placeHolders,$body){
		foreach ($placeHolders as $key=>$value){
			$placeHolder = "{".$key."}";
			$body = str_replace($placeHolder, $value, $body);
		}
		return $body;
	}
	
	private function getProductDetailInfo($orderSeq){
		$orderProductMgr = OrderProductDetailMgr::getInstance();
		$productDetails = $orderProductMgr->findByOrderSeq($orderSeq);
		$productDetailHtml = "";
		if(!empty($productDetails)){
			foreach ($productDetails as $productDetail){
				$price = number_format($productDetail["price"],2,'.','');
				$qty = $productDetail["quantity"];
				$amount = $productDetail["price"] * $qty;
				
				$amountStr = number_format($amount,2,'.','');
				$productDetailHtml .= "<tr>";
				$productDetailHtml .= '<td width="75%" style="text-align:left;vertical-align:top">'.$productDetail["title"].'</td>';
				$productDetailHtml .= '<td width="10%" style="text-align:right;vertical-align:top">'.$price.'</td>';
				$productDetailHtml .= '<td width="5%" style="text-align:right;vertical-align:top">'.$qty.'</td>';
				$productDetailHtml .= '<td width="15%" style="text-align:right;vertical-align:top">'.$amountStr.'</td>';
				$productDetailHtml .= '</tr>';
			}
			
		}
		return $productDetailHtml;
	}
}