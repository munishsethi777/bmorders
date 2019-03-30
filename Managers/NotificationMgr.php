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
require_once($ConstantsArray['dbServerUrl'] ."Managers/OrderMgr.php");
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
		$destination = $configurationMgr->getConfiguration(Configuration::$ORDER_NOTIFICATION_EMAIL);
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
	
	public function saveCreatePaymentNotificationForEmail($payments,$existingPayments){
		$notification = new Notification();
		$paymentDate = new DateTime();
		$paymentDateStr = $paymentDate->format("M d, Y");
		$orderMgr = OrderMgr::getInstance();
		$paymentHtml = "";
		$earilerPaymentsHtml = '<p style="font-size: 12px; color: #000; margin-bottom: 0px;line-height:20px;">EARLIER RECEIPTS:<br>';
		$flag = false;
		$orderNo = 0;
		$amountPaid = 0;
		$isPaidPayment = false;
		foreach ($payments as $key=>$payment){
			$isPaid = $payment->getIsPaid();
			$paymentMode = PaymentMode::getValue($payment->getPaymentMode());
			$amount = $payment->getAmount();
			$amountStr = number_format($amount,2,'.','');
			$detail = $payment->getDetails();
			$createOn = $payment->getCreatedOn();
			$createOn = $createOn->format("d/m/Y");
			$amountPaid = $amountPaid + $amount;
			if(isset($existingPayments[$key])){
				$existingPayment = $existingPayments[$key];
				$existingPaymentIsPaid = $existingPayment->getIsPaid();
				if(!empty($existingPaymentIsPaid)){
					$earilerPaymentsHtml .= $createOn . ' ' . $paymentMode . ' Rs. '. $amountStr . '/- <br>';
					$flag = true;
					continue;
				}
			}
			$isPaidPayment = true;
			$paymentHtml .= '<p style="color:navy;font-size:14px;margin-bottom:6px;">';
			$paymentHtml .= $paymentMode . ': Rs. '.$amountStr.'/- <br><span style="color:grey;font-size:12px">'.$detail.'</span></p>';
			$orderNo = $payment->getOrderSeq();
			
		}
		if(!$isPaidPayment){
			return;
		}
		if($flag){
			$earilerPaymentsHtml .= "</p>";
		}else{
			$earilerPaymentsHtml = "";
		}
		$order = $orderMgr->findBySeq($orderNo);
		$totalAmount = $order->getGrossAmount();
		$userMgr = UserMgr::getInstance();
		$user = $userMgr->findBySeq($order->getUserSeq());
		$userInfo = $user->getFullName() . " - " . $user->getMobile();
		$customerMgr = CustomerMgr::getInstance();
		$customer = $customerMgr->findBySeq($order->getCustomerSeq());
		$customerName = $customer->getTitle() . ", " . $customer->getCity();
		$customerAddress = $customer->getAddress1() . ", " . $customer->getAddress2() . ", " . $customer->getCity() . "-" . $customer->getZip() . ", " . $customer->getState();
		$productDetailHtml = $this->getProductDetailInfo($orderNo);
		$netAmount = $totalAmount;
		$discountPercent = $order->getDiscountPercent();
		$discount = 0;
		if(!empty($discountPercent)){
			$discount = ($discountPercent / 100) * $totalAmount;
			$netAmount = $netAmount - $discount;
		}
		$pendingAmount = $netAmount - $amountPaid;
		$discount = number_format($discount,2,'.','');
		$totalAmount = number_format($totalAmount,2,'.','');
		$netAmount = number_format($netAmount,2,'.','');
		$pendingAmount = number_format($pendingAmount,2,'.','');
		$body = file_get_contents("../paymentEmailTemplate.php");
		$phAnValues = array();
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
		$phAnValues["PAYMENT_INFO"] = $paymentHtml;
		$phAnValues["EARLIER_PAYMENTS"] = $earilerPaymentsHtml;
		$phAnValues["PENDING_AMOUNT"] = $pendingAmount;
		$phAnValues["PAYMENT_DATE"] = $paymentDateStr;
		$body = $this->replacePlaceHolders($phAnValues, $body);
		$subject = "Payment Confirmation";
		$configurationMgr = ConfigurationMgr::getInstance();
		$destination = $configurationMgr->getConfiguration(Configuration::$PAYMENT_NOTIFICATION_EMAIL);
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
	
	
	
	public function saveExcpectedPaymentNotificationForEmail(){
		$paymentMgr = OrderPaymentDetailMgr::getInstance();
		$expectedPayments = $paymentMgr->getExpectedPayments();
		foreach ($expectedPayments as $expectedPayment){
			$paymentSeq = $expectedPayment->getSeq();
			$orderId = $expectedPayment->getOrderSeq();
			$payments = $paymentMgr->findPaidPaymentsByOrderSeq($orderId);
			$expectedAmount =  number_format($expectedPayment->getAmount(),2,'.','');;
			$notification = new Notification();
			$paymentDate = $expectedPayment->getExpectedOn();
			$paymentDate = DateUtil::StringToDateByGivenFormat("Y-m-d H:i:s", $paymentDate);
			$paymentDateStr = $paymentDate->format("M d, Y");
			$orderMgr = OrderMgr::getInstance();
			$earilerPaymentsHtml = '<p style="font-size: 12px; color: #000; margin-bottom: 0px;line-height:20px;">EARLIER RECEIPTS:<br>';
			$flag = false;
			$orderNo = 0;
			$amountPaid = 0;
			$isPaidPayment = false;
			foreach ($payments as $key=>$payment){
				$isPaid = $payment->getIsPaid();
				if(empty($isPaid)){
					continue;
				}
				$paymentMode = PaymentMode::getValue($payment->getPaymentMode());
				$amount = $payment->getAmount();
				$amountStr = number_format($amount,2,'.','');
				$detail = $payment->getDetails();
				$createOn = $payment->getCreatedOn();
				$createOn = DateUtil::StringToDateByGivenFormat("Y-m-d H:i:s", $createOn);
				$createOn = $createOn->format("d/m/Y");
				$amountPaid = $amountPaid + $amount;
				$earilerPaymentsHtml .= $createOn . ' ' . $paymentMode . ' Rs. '. $amountStr . '/- <br>';
				$orderNo = $payment->getOrderSeq();
				$flag = true;
			}
			if($flag){
				$earilerPaymentsHtml .= "</p>";
			}else{
				$earilerPaymentsHtml = "";
			}
			$order = $orderMgr->findBySeq($orderNo);
			$totalAmount = $order->getGrossAmount();
			$userMgr = UserMgr::getInstance();
			$user = $userMgr->findBySeq($order->getUserSeq());
			$userInfo = $user->getFullName() . " - " . $user->getMobile();
			$customerMgr = CustomerMgr::getInstance();
			$customer = $customerMgr->findBySeq($order->getCustomerSeq());
			$customerName = $customer->getTitle() . ", " . $customer->getCity();
			$customerAddress = $customer->getAddress1() . ", " . $customer->getAddress2() . ", " . $customer->getCity() . "-" . $customer->getZip() . ", " . $customer->getState();
			$productDetailHtml = $this->getProductDetailInfo($orderNo);
			$netAmount = $totalAmount;
			$discountPercent = $order->getDiscountPercent();
			$discount = 0;
			if(!empty($discountPercent)){
				$discount = ($discountPercent / 100) * $totalAmount;
				$netAmount = $netAmount - $discount;
			}
			$pendingAmount = $netAmount - $amountPaid;
			$discount = number_format($discount,2,'.','');
			$totalAmount = number_format($totalAmount,2,'.','');
			$netAmount = number_format($netAmount,2,'.','');
			$pendingAmount = number_format($pendingAmount,2,'.','');
			$body = file_get_contents("../expectedPaymentEmailTemplate.php");
			$phAnValues = array();
			$phAnValues["EXPECTED_AMOUNT"] = $expectedAmount;
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
			$phAnValues["EARLIER_PAYMENTS"] = $earilerPaymentsHtml;
			$phAnValues["PENDING_AMOUNT"] = $pendingAmount;
			$phAnValues["PAYMENT_DATE"] = $paymentDateStr;
			$body = $this->replacePlaceHolders($phAnValues, $body);
			$subject = "Expected Payment";
			$configurationMgr = ConfigurationMgr::getInstance();
			$destination = $configurationMgr->getConfiguration(Configuration::$EXPECTED_PAYMENT_NOTIFICATION_EMAIL);
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
			$paymentMgr->updateIsNotificationFlag(1, $paymentSeq);
		}
		
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