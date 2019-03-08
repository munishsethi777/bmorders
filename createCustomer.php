<?include("SessionCheck.php");
require_once('IConstants.inc');
require_once ($ConstantsArray ['dbServerUrl'] . "Managers/CustomerMgr.php");

$customer = new Customer();
$isEnableChecked = "checked";
if(isset($_POST["seq"])){
 	$seq = $_POST["seq"];
 	$customerMgr = CustomerMgr::getInstance();
 	$customer = $customerMgr->findBySeq($seq);
 	if(empty($customer->getIsEnabled())){
 		$isEnableChecked = "";
 	}
}



?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Customer</title>
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
									<h4 class="p-h-sm font-normal"> Create Customer</h4>
							</nav>
	                        
	                    </div>
	                </div>
	                <div class="ibox-content">
	                	<form id="customerForm" method="post" enctype="multipart/form-data" action="Actions/CustomerAction.php" class="m-t-lg">
                        		<input type="hidden" id ="call" name="call"  value="saveCustomer"/>
                        		<input type="hidden" id ="seq" name="seq"  value="<?php echo $customer->getSeq()?>"/>
                        		<div class="form-group row">
                       				<label class="col-lg-1 col-form-label">Title</label>
                                    <div class="col-lg-5">
                                    	<input type="text" value="<?php echo $customer->getTitle()?>"  id="title" name="title" required placeholder="company" class="form-control">
                                    </div>
                                    <label class="col-lg-1 col-form-label">Contact</label>
                                    <div class="col-lg-5">
                                    	<input type="text" value="<?php echo $customer->getContactPerson()?>"  id="contactperson" name="contactperson" required placeholder="contact person" class="form-control">
                                    </div>
                               </div>
                               
                               
                               <div class="form-group row">
                       				<label class="col-lg-1 col-form-label">Description</label>
                                    <div class="col-lg-11">
                                    	<input type="text" value="<?php echo $customer->getDescription()?>" id="description" name="description"  placeholder="description" class="form-control">
                                    </div>
                               </div>
                              
                               <div class="form-group row">
                       				<label class="col-lg-1 col-form-label">Email Id</label>
                                    <div class="col-lg-5">
                                    	<input type="email" value="<?php echo $customer->getEmail()?>"  id="email" name="email" required placeholder="email id" class="form-control">
                                    </div>
                                    <label class="col-lg-1 col-form-label">Mobile</label>
                                    <div class="col-lg-5">
                                    	<input type="text" value="<?php echo $customer->getMobile()?>"  id="mobile" name="mobile" required placeholder="mobile" class="form-control">
                                    </div>
                               </div>
                               
                               <div class="form-group row">
                       				<label class="col-lg-1 col-form-label">Phone</label>
                                    <div class="col-lg-11">
                                    	<input type="text" value="<?php echo $customer->getPhone()?>"  id="phone" name="phone" required placeholder="phone" class="form-control">
                                    </div>
                               </div>
                               
                               <div class="form-group row">
                       				<label class="col-lg-1 col-form-label">Address1</label>
                                    <div class="col-lg-11">
                                    	<input type="text" value="<?php echo $customer->getAddress1()?>"  id="address1" name="address1" required placeholder="address1" class="form-control">
                                    </div>
                               </div>
                               
                               <div class="form-group row">
                       				<label class="col-lg-1 col-form-label">Address2</label>
                                    <div class="col-lg-11">
                                    	<input type="text" value="<?php echo $customer->getAddress2()?>"  id="address2" name="address2" required placeholder="address2" class="form-control">
                                    </div>
                               </div>
                               
                               <div class="form-group row">
                       				<label class="col-lg-1 col-form-label">City</label>
                                    <div class="col-lg-5">
                                    	<input type="text" value="<?php echo $customer->getCity()?>"  id="city" name="city" required placeholder="city" class="form-control">
                                    </div>
                                    
                                    <label class="col-lg-1 col-form-label">State</label>
                                    <div class="col-lg-5">
                                    	<input type="text" value="<?php echo $customer->getState()?>"  id="state" name="state" required placeholder="state" class="form-control">
                                    </div>
                               </div>
                               <div class="form-group row">
                       				<label class="col-lg-1 col-form-label">Zip</label>
                                    <div class="col-lg-5">
                                    	<input type="number" value="<?php echo $customer->getZip()?>"  id="zip" name="zip" required placeholder="zipcode" class="form-control">
                                    </div>
                                    
                                    <label class="col-lg-1 col-form-label">Discount</label>
                                    <div class="col-lg-5">
                                    	<input type="text" value="<?php echo $customer->getDiscount()?>"  id="discount" name="discount" required placeholder="discount offered" class="form-control">
                                    </div>
                               </div>
                                <div class="form-group row">
                       				<label class="col-lg-1 col-form-label">Enabled</label>
                                    <div class="col-lg-4">
	                                    <input class="i-checks" type="checkbox" <?php echo $isEnableChecked?>  id="isenabled" name="isenabled">
	                                 </div>
                               </div>
                               
                               
                               <div class="form-group row">
                               		<label class="col-lg-1 col-form-label"></label>
                               		<div class="col-lg-6">
	                               		<button class="btn btn-primary" type="button" onclick="javascript:submitCustomerForm('save')" 
	                               				id="rzp-button">
	                               			Save
		                               	</button>
		                               	<button class="btn btn-primary" type="button" onclick="javascript:submitCustomerForm('saveandnew')" 
	                               				id="rzp-button">
	                               			Save & New
		                               	</button>
		                               	<button class="btn btn-primary" type="button" onclick="javascript:cancel()" 
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