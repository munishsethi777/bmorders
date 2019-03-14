<?include("SessionCheck.php");
require_once('IConstants.inc');
require_once ($ConstantsArray ['dbServerUrl'] . "Managers/UserMgr.php");
require_once ($ConstantsArray ['dbServerUrl'] . "Managers/UserCompanyMgr.php");
require_once ($ConstantsArray ['dbServerUrl'] . "Managers/CustomerMgr.php");
require_once ($ConstantsArray ['dbServerUrl'] . "Utils/DropDownUtil.php");

$user = new User();
$userMgr = UserMgr::getInstance();

//$user->setPassword("gaheer#7");
//$user->setEmailId("baljeetgaheer@gmail.com");
//$user->setFullName("Baljeet Singh");
//$user->setMobile("9999999999");
$customerMgr = CustomerMgr::getInstance();
$customers = $customerMgr->findAll();
$isEnableChecked = "checked";
$selectedCustomers = array();
if(isset($_POST["seq"])){
	$seq = $_POST["seq"];
	$user = $userMgr->findBySeq($seq);
	if(empty($user->getIsEnabled())){
		$isEnableChecked = "";
	}
	$userCompanyMgr = UserCompanyMgr::getInstance();
	$selectedCustomers = $userCompanyMgr->findCustomerIdsByUser($seq);
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User</title>
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
								<h4 class="p-h-sm font-normal"> Create User</h4>
						</nav>
	                    </div>
	                </div>
	            </div>
	            <div class="ibox-content mainDiv">
		        	<form id="userForm" method="post" enctype="multipart/form-data" action="Actions/UserAction.php" class="m-t-lg">
		                <input type="hidden" id ="call" name="call"  value="saveUser"/>
		                <input type="hidden" id ="seq" name="seq"  value="<?php echo $user->getSeq()?>"/>
		                <div class="form-group row">
		                	<label class="col-lg-1 col-form-label">Email Id</label>
		                    <div class="col-lg-7">
		                    	<input type="text" value="<?php echo $user->getEmailId()?>" value=""  id="emailid" name="emailid" required placeholder="Email Id" class="form-control">
		                    </div>
		                </div>
		                <div class="form-group row">
		                	<label class="col-lg-1 col-form-label">Password</label>
		                    <div class="col-lg-7">
		                    	<input type="text" value="<?php echo $user->getPassword()?>"  id="password" name="password" required placeholder="Password" class="form-control">
		                    </div>
		                </div>
		                <div class="form-group row">
		                	<label class="col-lg-1 col-form-label">FullName</label>
		                    <div class="col-lg-7">
		                    	<input type="text" value="<?php echo $user->getFullName()?>"  id="fullname" name="fullname" required placeholder="Name" class="form-control">
		                    </div>
		                </div>
		                
		                <div class="form-group row">
		                	<label class="col-lg-1 col-form-label">Mobile</label>
		                    <div class="col-lg-3">
		                    	<input type="text" value="<?php echo $user->getMobile()?>"  id="mobile" name="mobile" required placeholder="Mobile" class="form-control">
		                    </div>
		                	<label class="col-lg-1 col-form-label">Type</label>
		                	<div class="col-lg-3">
		                    	<?php 
	                             	$select = DropDownUtils::getUserTypeDD("usertype", null, $user->getUserType());
	                                echo $select;
                             	?>
		                    </div>
		                	
		                </div>
		                 <div class="form-group row">
		                	<label class="col-lg-1 col-form-label">Customers</label>
		                	<div class="col-lg-7">
		                    	<select class="form-control chosen-select" multiple  required id="customers" name="customers[]">
									<?php foreach ($customers as $customer){
										$seq = $customer->getSeq();
										$selected = "";
										if(in_array($seq, $selectedCustomers)){
											$selected = "selected";
										}
										?>
										<option <?php echo $selected?>  value="<?php echo $customer->getSeq()?>"><?php echo $customer->getTitle()?></option>
										
									<?php }?>
								</select> <label class="jqx-validator-error-label" id="lpError"></label>
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
		                          	<button class="btn btn-primary" type="button" onclick="javascript:submitUserForm('save')" 
	                               				id="rzp-button">
	                               			Save
		                           	</button>
		                           <button class="btn btn-primary" type="button" onclick="javascript:submitUserForm('saveandnew')" 
	                               				id="rzp-button">
	                               			Save & New
		                           	</button>
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
</body>
</html>
<script type="text/javascript">
$(document).ready(function(){
    $('.i-checks').iCheck({
		checkboxClass: 'icheckbox_square-green',
	   	radioClass: 'iradio_square-green',
	});
    $(".chosen-select").chosen({width:"100%"});
});
function submitUserForm(action){
	if($("#userForm")[0].checkValidity()) {
    	 $('#userForm').ajaxSubmit(function( data ){
    		 var obj = $.parseJSON(data);
    		 showResponseToastr(data,null,"userForm","mainDiv");
    		 resetChosen("chosen-select");
 	         if(obj.success == 1 && action == "save"){
 		    	location.href = "showUsers.php";
 		     }   
    	 });
	}else{
		$("#userForm")[0].reportValidity();
	}
}
function cancel(){
	location.href = "showUsers.php";
}
</script>