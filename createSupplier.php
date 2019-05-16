<?include("SessionCheck.php");
require_once('IConstants.inc');
require_once ($ConstantsArray ['dbServerUrl'] . "Managers/SupplierMgr.php");
require_once ($ConstantsArray ['dbServerUrl'] . "Enums/UserType.php");
$sessionUtil = SessionUtil::getInstance();
$roleType = $sessionUtil->getUserLoggedInUserType();
$isDisabled = "";
$isEnableChecked = "";
if($roleType == UserType::getName(UserType::representative)){
	$isDisabled = "disabled";
}
$supplier = new Supplier();

if(isset($_POST["seq"])){
 	$seq = $_POST["seq"];
 	$supplierMgr = SupplierMgr::getInstance();
 	$supplier = $supplierMgr->findBySeq($seq);
 	if(!empty($supplier->getIsEnabled())){
 		$isEnableChecked = "checked";
 	}
 	if(!empty($supplier->getIsRegistered())){
 		$isRegistered = "checked";
 	}
}



?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Supplier</title>
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
									<h4 class="p-h-sm font-normal"> Create Supplier</h4>
							</nav>
	                        
	                    </div>
	                </div>
	                <div class="ibox-content mainDiv">
	                	<form id="supplierForm" method="post" enctype="multipart/form-data" action="Actions/SupplierAction.php" class="m-t-lg">
                        		<input type="hidden" id ="call" name="call"  value="saveSupplier"/>
                        		<input type="hidden" id ="seq" name="seq"  value="<?php echo $supplier->getSeq()?>"/>
                        		<div class="form-group row">
                       				<label class="col-lg-1 col-form-label">Title</label>
                                    <div class="col-lg-5">
                                    	<input type="text" value="<?php echo $supplier->getTitle()?>"  id="title" name="title" required placeholder="company" class="form-control">
                                    </div>
                                    <label class="col-lg-1 col-form-label">Contact</label>
                                    <div class="col-lg-5">
                                    	<input type="text" value="<?php echo $supplier->getContactPerson()?>"  id="contactperson" name="contactperson" required placeholder="contact person" class="form-control">
                                    </div>
                               </div>
                               
                               
                               <div class="form-group row">
                       				<label class="col-lg-1 col-form-label">Description</label>
                                    <div class="col-lg-5">
                                    	<input type="text" value="<?php echo $supplier->getDescription()?>" id="description" name="description"  placeholder="description" class="form-control">
                                    </div>
                                    
                                    <label class="col-lg-1 col-form-label">GST</label>
                                    <div class="col-lg-5">
                                    	<input type="text" value="<?php echo $supplier->getGST()?>" id="gst" name="gst"  placeholder="gst" class="form-control">
                                    </div>
                               </div>
                              
                               <div class="form-group row">
                       				<label class="col-lg-1 col-form-label">Email Id</label>
                                    <div class="col-lg-5">
                                    	<input type="email" value="<?php echo $supplier->getEmail()?>"  id="email" name="email" placeholder="email id" class="form-control">
                                    </div>
                                    <label class="col-lg-1 col-form-label">Mobile</label>
                                    <div class="col-lg-5">
                                    	<input type="text" value="<?php echo $supplier->getMobile()?>"  id="mobile" name="mobile" required placeholder="mobile" class="form-control">
                                    </div>
                               </div>
                               
                               <div class="form-group row">
                       				<label class="col-lg-1 col-form-label">Phone</label>
                                    <div class="col-lg-11">
                                    	<input type="text" value="<?php echo $supplier->getPhone()?>"  id="phone" name="phone"  placeholder="phone" class="form-control">
                                    </div>
                               </div>
                               
                               <div class="form-group row">
                       				<label class="col-lg-1 col-form-label">Address1</label>
                                    <div class="col-lg-11">
                                    	<input type="text" value="<?php echo $supplier->getAddress1()?>"  id="address1" name="address1" required placeholder="address1" class="form-control">
                                    </div>
                               </div>
                               
                               <div class="form-group row">
                       				<label class="col-lg-1 col-form-label">Address2</label>
                                    <div class="col-lg-11">
                                    	<input type="text" value="<?php echo $supplier->getAddress2()?>"  id="address2" name="address2"  placeholder="address2" class="form-control">
                                    </div>
                               </div>
                               
                               <div class="form-group row">
                       				<label class="col-lg-1 col-form-label">City</label>
                                    <div class="col-lg-5">
                                    	<input type="text" value="<?php echo $supplier->getCity()?>"  id="city" name="city" required placeholder="city" class="form-control">
                                    </div>
                                    
                                    <label class="col-lg-1 col-form-label">State</label>
                                    <div class="col-lg-5">
                                    	<input type="text" value="<?php echo $supplier->getState()?>"  id="state" name="state" required placeholder="state" class="form-control">
                                    </div>
                               </div>
                               <div class="form-group row">
                       				<label class="col-lg-1 col-form-label">Zip</label>
                                    <div class="col-lg-5">
                                    	<input type="number" value="<?php echo $supplier->getZip()?>"  id="zip" name="zip" placeholder="zipcode" class="form-control">
                                    </div>
                                    
                                    <label class="col-lg-1 col-form-label">Discount</label>
                                    <div class="col-lg-5">
                                    	<input type="text" value="<?php echo $supplier->getDiscount()?>"  id="discount" name="discount" placeholder="discount offered" class="form-control">
                                    </div>
                               </div>
                                <div class="form-group row">
                       				<label class="col-lg-1 col-form-label">Enabled</label>
                                    <div class="col-lg-5">
	                                    <input class="i-checks" type="checkbox" <?php echo $isDisabled?> <?php echo $isEnableChecked?>  id="isenabled" name="isenabled">
	                                 </div>
	                                 
	                                 <label class="col-lg-1 col-form-label">Registered</label>
                                    <div class="col-lg-4">
	                                    <input class="i-checks" type="checkbox" <?php echo $isRegistered?>  id="isregistered" name="isregistered">
	                                 </div>
                               </div>
                               
                               
                               <div class="form-group row">
                               		<label class="col-lg-1 col-form-label"></label>
                               		<div class="col-lg-6">
	                               		<button class="btn btn-primary" type="button" onclick="javascript:submitSupplierForm('save')" 
	                               				id="rzp-button">
	                               			Save
		                               	</button>
		                               	<?php if(empty($supplier->getSeq())){?>
			                               	<button class="btn btn-primary" type="button" onclick="javascript:submitSupplierForm('saveandnew')" 
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
    function submitSupplierForm(action){
    	if($("#supplierForm")[0].checkValidity()) {
        	 $('#supplierForm').ajaxSubmit(function( data ){
	    		 var obj = $.parseJSON(data);
	    		 if(obj.success == 1){
		    		 if(action == "save"){
	        		 	location.href = "showSuppliers.php";
		    		 }else{
		    			 showResponseToastr(data,null,"supplierForm","mainDiv");
		    			 clearForm($("#supplierForm"));
		    		 }
	    		 }else{
	        		 alert("Error" + obj.message);
	    		 }	 
	    	 });
    	}else{
    		$("#supplierForm")[0].reportValidity();
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
    	location.href = "showSuppliers.php";
    }
 </script>	