<?include("SessionCheck.php");
require_once('IConstants.inc');
require_once ($ConstantsArray ['dbServerUrl'] . "Managers/ProductBrandMgr.php");

$productBrand = new ProductBrand();
$isEnableChecked = "checked";
if(isset($_POST["seq"])){
 	$seq = $_POST["seq"];
 	$productBrandMgr = ProductBrandMgr::getInstance();
 	$productBrand = $productBrandMgr->findBySeq($seq);
 	if(empty($productBrand->getIsEnabled())){
 		$isEnableChecked = "";
 	}
}



?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Product Brand</title>
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
									<h4 class="p-h-sm font-normal"> Create Product Brand</h4>
							</nav>
	                        
	                    </div>
	                </div>
	                <div class="ibox-content">
	                	<form id="productBrandForm" method="post" enctype="multipart/form-data" action="Actions/ProductBrandAction.php" class="m-t-lg">
                        		<input type="hidden" id ="call" name="call"  value="saveProductBrand"/>
                        		<input type="hidden" id ="seq" name="seq"  value="<?php echo $productBrand->getSeq()?>"/>
                        		<div class="form-group row">
                       				<label class="col-lg-1 col-form-label">Title</label>
                                    <div class="col-lg-11">
                                    	<input type="text" value="<?php echo $productBrand->getTitle()?>"  id="title" name="title" required placeholder="title" class="form-control">
                                    </div>
                               </div>
                               
                               
                               <div class="form-group row">
                       				<label class="col-lg-1 col-form-label">Description</label>
                                    <div class="col-lg-11">
                                    	<input type="text" value="<?php echo $productBrand->getDescription()?>" id="description" name="description"  placeholder="description" class="form-control">
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
	                               		<button class="btn btn-primary" type="button" onclick="javascript:submitproductBrandForm('save')" 
	                               				id="rzp-button">
	                               			Save
		                               	</button>
		                               	<?php if(empty($productBrand->getSeq())){?>
			                               	<button class="btn btn-primary" type="button" onclick="javascript:submitproductBrandForm('saveandnew')" 
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
    function submitproductBrandForm(action){
    	if($("#productBrandForm")[0].checkValidity()) {
        	 $('#productBrandForm').ajaxSubmit(function( data ){
	    		 var obj = $.parseJSON(data);
	    		 if(obj.success == 1){
		    		 if(action == "save"){
	        		 	location.href = "showProductBrands.php";
		    		 }else{
		    			 clearForm($("#productBrandForm"));
		    			 toastr.success("Object Saved Successfully.");
		    		 }
	    		 }else{
	        		 alert("Error" + obj.message);
	    		 }	 
	    	 });
    	}else{
    		$("#productBrandForm")[0].reportValidity();
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
    	location.href = "showProductBrands.php";
    }
 </script>	