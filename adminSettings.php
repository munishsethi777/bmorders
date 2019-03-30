<?include("SessionCheck.php");
require_once('IConstants.inc');
require_once($ConstantsArray['dbServerUrl'] ."Managers/ConfigurationMgr.php");
$configurationMgr = ConfigurationMgr::getInstance();
$paymentNotificationEmail = $configurationMgr->getConfiguration(Configuration::$PAYMENT_NOTIFICATION_EMAIL);
$paymentNotificationMobile = $configurationMgr->getConfiguration(Configuration::$PAYMENT_NOTIFICATION_MOBILE);
$orderNotificationEmail = $configurationMgr->getConfiguration(Configuration::$ORDER_NOTIFICATION_EMAIL);
$orderNotificationMobile = $configurationMgr->getConfiguration(Configuration::$ORDER_NOTIFICATION_MOBILE);
$expectedPaymentNotificationEmail = $configurationMgr->getConfiguration(Configuration::$EXPECTED_PAYMENT_NOTIFICATION_EMAIL);
$expectedPaymentNotificationMobile = $configurationMgr->getConfiguration(Configuration::$EXPECTED_PAYMENT_NOTIFICATION_MOBILE);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings</title>
    <?include "ScriptsInclude.php"?>
</head>
<body>
    <div id="wrapper">
    <?php include("menuInclude.php")?>  
        <div id="page-wrapper" class="gray-bg">
	        <div class="row border-bottom">
	        </div>
        	<div class="row">
        		 <div class="col-lg-12">
	                <div class="ibox mainDiv">
	                    <div class="ibox-title">
	                    	 <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
								<a class="navbar-minimalize minimalize-styl-2 btn btn-primary "
									href="#"><i class="fa fa-bars"></i> </a>
							</nav>
	                        <h5>Settings</h5>
	                    </div>
	                    <div class="ibox-content">
	                     		<h5>Order Notifications</h5>
	                        	<form id="orderNotificationForm" action="Actions/UserAction.php" class="m-t-lg">
	                        		<input type="hidden" id ="call" name="call" value="saveOrderNotificationSettings"/>
		                        		<div id="cakeSettingDiv">
			                        		<div class="form-group row">
			                       				<label class="col-lg-1 col-form-label">Email</label>
			                                  	<div class="col-lg-8">
			                                  		<input type="text" required placeholder="Email" value="<?php echo $orderNotificationEmail?>" name="orderNotificationEmail" class="form-control">
			                            		</div>
			                            	</div>
			                            	<div class="form-group row">
			                       				<label class="col-lg-1 col-form-label">Mobile</label>
			                                  	<div class="col-lg-8">
			                                  		 <input type="text" required placeholder="Mobile" value="<?php echo $orderNotificationMobile?>" name="orderNotificationMobile" class="form-control">
			                            		</div>
			                            	</div>		
			                           </div>
		                            	<div>
		                                     <button class="btn btn-primary ladda-button" data-style="expand-right" id="saveOrderNotificationSettings" type="button">
		                                        <span class="ladda-label">Save</span>
		                                    </button>
	                               		</div>  
	                       		 </form>
	                     </div>
	                     <div class="ibox-content">
	                     		<h5>Expected Payment Notifications</h5>
	                        	<form id="expectedPaymentSettingForm" action="Actions/UserAction.php" class="m-t-lg">
	                        		<input type="hidden" id ="call" name="call"   value="saveExpectedPaymentNotificationSettings"/>
		                        		<div id="cakeSettingDiv">
			                        		<div class="form-group row">
			                       				<label class="col-lg-1 col-form-label">Email</label>
			                                  	<div class="col-lg-8">
			                                  		<input type="text" required placeholder="Email" value="<?php echo $expectedPaymentNotificationEmail?>" name="expectedPaymentNotificationEmail" class="form-control">
			                            		</div>
			                            	</div>
			                            	<div class="form-group row">
			                       				<label class="col-lg-1 col-form-label">Mobile</label>
			                                  	<div class="col-lg-8">
			                                  		 <input type="text" required placeholder="Mobile" value="<?php echo $expectedPaymentNotificationMobile?>" name="expectedPaymentNotificationMobile" class="form-control">
			                            		</div>
			                            	</div>		
			                           </div>
		                            	<div>
		                                     <button class="btn btn-primary ladda-button" data-style="expand-right" id="saveExpectedPaymentSettingBtn" type="button">
		                                        <span class="ladda-label">Save</span>
		                                    </button>
	                               		</div>  
	                       		 </form>
	                     </div>
	                     <div class="ibox-content">
	                     		<h5>Payment Notifications</h5>
	                        	<form id="paymentSettingForm" action="Actions/UserAction.php" class="m-t-lg">
	                        		<input type="hidden" id ="call" name="call"   value="savePaymentNotificationSettings"/>
		                        		<div id="cakeSettingDiv">
			                        		<div class="form-group row">
			                       				<label class="col-lg-1 col-form-label">Email</label>
			                                  	<div class="col-lg-8">
			                                  		<input type="text" required placeholder="Email" value="<?php echo $paymentNotificationEmail?>" name="paymentNotificationEmail" class="form-control">
			                            		</div>
			                            	</div>
			                            	<div class="form-group row">
			                       				<label class="col-lg-1 col-form-label">Mobile</label>
			                                  	<div class="col-lg-8">
			                                  		 <input type="text" required placeholder="Mobile" value="<?php echo $paymentNotificationMobile?>" name="paymentNotificationMobile" class="form-control">
			                            		</div>
			                            	</div>		
			                           </div>
		                            	<div>
		                                     <button class="btn btn-primary ladda-button" data-style="expand-right" id="savePaymentSettingBtn" type="button">
		                                        <span class="ladda-label">Save</span>
		                                    </button>
	                               		</div>  
	                       		 </form>
	                     </div>
	                     
	                     
	                 </div>
	              </div>
        	</div>
       </div>
     </div>
 </body>
 </html>
<script type="text/javascript">
$(document).ready(function(){ 
	$("#saveOrderNotificationSettings").click(function(e){
    	if($("#orderNotificationForm")[0].checkValidity()) {
        	saveSettings("orderNotificationForm");
    	}else{
    		$("#orderNotificationForm")[0].reportValidity(); 
    	}
    })
     $("#saveExpectedPaymentSettingBtn").click(function(e){
    	if($("#expectedPaymentSettingForm")[0].checkValidity()) {
        	saveSettings("expectedPaymentSettingForm");
    	}else{
    		$("#expectedPaymentSettingForm")[0].reportValidity(); 
    	}
    })
    $("#savePaymentSettingBtn").click(function(e){
    	if($("#paymentSettingForm")[0].checkValidity()) {
        	saveSettings("paymentSettingForm");
    	}else{
    		$("#paymentSettingForm")[0].reportValidity(); 
    	}
    })
    
   
});
function saveSettings(formId){
    $('#'+formId).ajaxSubmit(function( data ){
        showResponseToastr(data,null,null,"mainDiv");
    })
} 
</script>


