<?include("SessionCheck.php");
require_once('IConstants.inc');
require_once ($ConstantsArray ['dbServerUrl'] . "Managers/CustomerMgr.php");
require_once ($ConstantsArray ['dbServerUrl'] . "Enums/UserType.php");
$sessionUtil = SessionUtil::getInstance();
$roleType = $sessionUtil->getUserLoggedInUserType();
$isDisabled = "";
$isEnableChecked = "";
if($roleType == UserType::getName(UserType::representative)){
	$isDisabled = "disabled";
}
$customer = new Customer();

if(isset($_POST["seq"])){
 	$seq = $_POST["seq"];
 	$customerMgr = CustomerMgr::getInstance();
 	$customer = $customerMgr->findBySeq($seq);
 	if(!empty($customer->getIsEnabled())){
 		$isEnableChecked = "checked";
 	}
 	if(!empty($customer->getIsRegistered())){
 		$isRegistered = "checked";
 	}
}



?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Purchase</title>
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
	                <div class="ibox">
	                    <div class="ibox-title">
	                    	 <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
								<a class="navbar-minimalize minimalize-styl-2 btn btn-primary "
									href="#"><i class="fa fa-bars"></i> </a>
									<h4 class="p-h-sm font-normal"> Create Purchase</h4>
							</nav>
	                        
	                    </div>
	                </div>
	                <div class="ibox-content mainDiv">
	                	<form id="customerForm" method="post" enctype="multipart/form-data" action="Actions/CustomerAction.php" class="m-t-lg">
                        		<input type="hidden" id ="call" name="call"  value="saveCustomer"/>
                        		<input type="hidden" id ="seq" name="seq"  value="<?php echo $customer->getSeq()?>"/>
                        		<div class="form-group row">
                       				<label class="col-lg-1 col-form-label">Supplier</label>
                                    <div class="col-lg-5">
                                    	<input type="text" value="<?php echo $customer->getTitle()?>"  id="title" name="title" required placeholder="company" class="form-control">
                                    </div>
                                    <label class="col-lg-1 col-form-label">Invoice#</label>
                                    <div class="col-lg-5">
                                    	<input type="text" value="<?php echo $customer->getContactPerson()?>"  id="contactperson" name="contactperson" required placeholder="contact person" class="form-control">
                                    </div>
                               </div>
                               
                               
                               <div class="form-group row">
                       				<label class="col-lg-1 col-form-label">Inv Date</label>
                                    <div class="col-lg-5">
                                    	<input type="text" value="<?php echo $customer->getDescription()?>" id="description" name="description"  placeholder="description" class="form-control">
                                    </div>
                                    
                                    <label class="col-lg-1 col-form-label">Net Amt</label>
                                    <div class="col-lg-5">
                                    	<input type="text" value="<?php echo $customer->getGST()?>" id="gst" name="gst"  placeholder="gst" class="form-control">
                                    </div>
                               </div>
                              
                               
                               
                               
                               
                               
                               <div class="form-group row">
                               		<label class="col-lg-1 col-form-label"></label>
                               		<div class="col-lg-6">
	                               		<button class="btn btn-primary" type="button" onclick="javascript:submitCustomerForm('save')" 
	                               				id="rzp-button">
	                               			Save
		                               	</button>
		                               	<?php if(empty($customer->getSeq())){?>
			                               	<button class="btn btn-primary" type="button" onclick="javascript:submitCustomerForm('saveandnew')" 
		                               				id="rzp-button">
		                               			Save & New
			                               	</button>
		                               	<?php }?>
		                               	<button class="btn btn-default" type="button" onclick="javascript:cancel()" 
	                               				id="rzp-button">
	                               			Cancel
		                               	</button>
	                              	</div>
	                           </div>
	                     </form>
	                </div>
	             </div>
        	</div>
       </div>	
    </div>
</body>
</html>
<script type="text/javascript">
	$(document).ready(function(){
	    $('.i-checks').iCheck({
			checkboxClass: 'icheckbox_square-green',
		   	radioClass: 'iradio_square-green',
		});
    });
    function submitCustomerForm(action){
    	if($("#customerForm")[0].checkValidity()) {
        	 $('#customerForm').ajaxSubmit(function( data ){
	    		 var obj = $.parseJSON(data);
	    		 if(obj.success == 1){
		    		 if(action == "save"){
	        		 	location.href = "showCustomers.php";
		    		 }else{
		    			 showResponseToastr(data,null,"customerForm","mainDiv");
		    			 clearForm($("#customerForm"));
		    		 }
	    		 }else{
	        		 alert("Error" + obj.message);
	    		 }	 
	    	 });
    	}else{
    		$("#customerForm")[0].reportValidity();
    	}
    } 
    function clearForm(form) {
    	  $(':input', form).each(function() {
    	    var type = this.type;
    	    var tag = this.tagName.toLowerCase(); // normalize case
    	    if (type == 'text' || type == 'password' || tag == 'textarea' || type == 'email' || type == 'number')
    	      this.value = "";
    	    else if (type == 'checkbox' || type == 'radio')
    	      this.checked = false; 
    	    else if (tag == 'select')
    	      this.selectedIndex = -1;
    	  });
    	};
    function cancel(){
    	location.href = "showCustomers.php";
    }
 </script>	