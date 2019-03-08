<?include("SessionCheck.php");
require_once('IConstants.inc');
require_once ($ConstantsArray ['dbServerUrl'] . "Managers/ProductFlavourMgr.php");

$productFlavour = new ProductFlavour();
$isEnableChecked = "checked";
if(isset($_POST["seq"])){
 	$seq = $_POST["seq"];
 	$productFlavourMgr = ProductFlavourMgr::getInstance();
 	$productFlavour = $productFlavourMgr->findBySeq($seq);
 	if(empty($productFlavour->getIsEnabled())){
 		$isEnableChecked = "";
 	}
}



?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Product Flavour</title>
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
									<h4 class="p-h-sm font-normal"> Create Product Flavour</h4>
							</nav>
	                        
	                    </div>
	                </div>
	                <div class="ibox-content">
	                	<form id="productFlavourForm" method="post" enctype="multipart/form-data" action="Actions/ProductFlavourAction.php" class="m-t-lg">
                        		<input type="hidden" id ="call" name="call"  value="saveProductFlavour"/>
                        		<input type="hidden" id ="seq" name="seq"  value="<?php echo $productFlavour->getSeq()?>"/>
                        		<div class="form-group row">
                       				<label class="col-lg-1 col-form-label">Title</label>
                                    <div class="col-lg-11">
                                    	<input type="text" value="<?php echo $productFlavour->getTitle()?>"  id="title" name="title" required placeholder="title" class="form-control">
                                    </div>
                               </div>
                               
                               
                               <div class="form-group row">
                       				<label class="col-lg-1 col-form-label">Description</label>
                                    <div class="col-lg-11">
                                    	<input type="text" value="<?php echo $productFlavour->getDescription()?>" id="description" name="description"  placeholder="description" class="form-control">
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
	                               		<button class="btn btn-primary" type="button" onclick="javascript:submitproductFlavourForm('save')" 
	                               				id="rzp-button">
	                               			Save
		                               	</button>
		                               	<button class="btn btn-primary" type="button" onclick="javascript:submitproductFlavourForm('saveandnew')" 
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
    function submitproductFlavourForm(action){
    	if($("#productFlavourForm")[0].checkValidity()) {
        	 $('#productFlavourForm').ajaxSubmit(function( data ){
	    		 var obj = $.parseJSON(data);
	    		 if(obj.success == 1){
		    		 if(action == "save"){
	        		 	location.href = "showProductFlavours.php";
		    		 }else{
		    			 clearForm($("#productFlavourForm"));
		    			 toastr.success("Object Saved Successfully.");
		    		 }
	    		 }else{
	        		 alert("Error" + obj.message);
	    		 }	 
	    	 });
    	}else{
    		$("#productFlavourForm")[0].reportValidity();
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
    	location.href = "showProductFlavours.php";
    }
 </script>	