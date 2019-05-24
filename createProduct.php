<?include("SessionCheck.php");
require_once('IConstants.inc');
require_once ($ConstantsArray ['dbServerUrl'] . "Managers/ProductMgr.php");
require_once ($ConstantsArray ['dbServerUrl'] . "Managers/ProductCategoryMgr.php");
require_once ($ConstantsArray ['dbServerUrl'] . "Managers/ProductBrandMgr.php");
require_once ($ConstantsArray ['dbServerUrl'] . "Managers/ProductFlavourMgr.php");
require_once ($ConstantsArray ['dbServerUrl'] . "Utils/DropdownUtil.php");


$product = new Product();
$isEnableChecked = "checked";
$productMgr = ProductMgr::getInstance();
if(isset($_POST["seq"])){
 	$seq = $_POST["seq"];
 	$isCopy = $_POST["isCopy"];
 	$product = $productMgr->findBySeq($seq);
 	if(empty($product->getIsEnabled())){
 		$isEnableChecked = "";
 	}
 	if(!empty($isCopy)){
 		$product->setSeq(0);
 	}
}
$productCategoryMgr = ProductCategoryMgr::getInstance();
$productBrandMgr = ProductBrandMgr::getInstance();
$productFlavourMgr = ProductFlavourMgr::getInstance();

$productCategories = $productCategoryMgr->findAllArrEnabled();
$productFlavours = $productFlavourMgr->findAllArrEnabled();
$productBrands = $productBrandMgr->findAllArrEnabled();

$imagePath = StringConstants::IMAGE_PATH ."/dummy.jpg";
if(!empty($product->getImageFormat())){
	$imagePath =$ConstantsArray ['productImageURL'].$product->getSeq() . ".". $product->getImageFormat();
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Product</title>
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
									<h4 class="p-h-sm font-normal"> Create Product</h4>
							</nav>
	                        
	                    </div>
	                </div>
	                <div class="ibox-content mainDiv">
	                	<form id="productForm" method="post" enctype="multipart/form-data" action="Actions/ProductAction.php" class="m-t-lg">
                        		<input type="hidden" id ="call" name="call"  value="saveProduct"/>
                        		<input type="hidden" id ="seq" name="seq"  value="<?php echo $product->getSeq()?>"/>
                        		<div class="form-group row">
                       				<label class="col-lg-1 col-form-label">Title</label>
                                    <div class="col-lg-7">
                                    	<input type="text" value="<?php echo $product->getTitle()?>"  id="title" name="title" required placeholder="product name" class="form-control">
                                    </div>
                                    
                                    <label class="col-lg-1 col-form-label">Barcode</label>
                                    <div class="col-lg-3">
                                    	<input type="text" value="<?php echo $product->getBarcode()?>"  id="barcode" name="barcode" placeholder="product barcode" class="form-control">
                                    </div>
                               </div>
                               <div class="form-group row">
                                    <label class="col-lg-1 col-form-label">Description</label>
                                    <div class="col-lg-11">
                                    	<input type="text" value="<?php echo $product->getDescription()?>"  id="description" name="description"  placeholder="product description" class="form-control">
                                    </div>
                               </div>
                               <div class="form-group row">
                                    <label class="col-lg-1 col-form-label">Quantity</label>
                                    <div class="col-lg-3">
                                    	<input type="text" value="<?php echo $product->getQuantity()?>"  id="quantity" name="quantity" required placeholder="product quantity" class="form-control">
                                    </div>
                                    <div class="col-lg-2">
                                    	<?php 
                                    		$select = DropDownUtils::getMeasuringUnitTypeDD("measuringunit", null, $product->getMeasuringUnit());
                                    		echo $select;
                                    	?>
                                    </div>
                                    
                                    <label class="col-lg-1 col-form-label">Price</label>
                                    <div class="col-lg-5">
                                    	<input type="text" value="<?php echo $product->getPrice()?>"  id="price" name="price" required placeholder="product price" class="form-control">
                                    </div>
                               </div>
                              
                               <div class="form-group row">
                                    <label class="col-lg-1 col-form-label">Category</label>
                                    <div class="col-lg-5">
                                    	<select class="form-control categorySelect" name="categoryseq">
	                                    		<?php 
	                                    			foreach($productCategories as $key => $value){
		                                    			$selected = "";
		                                    			if($product->getCategorySeq() == $value[0]){
		                                    				$selected = "selected";
		                                    			}
		                                    			echo "<option ".$selected." value='".$value[0]."'>".$value[1]."</option>";
		                                    		}
		                                    	?>
	                                    </select>
                                    </div>
                                    
                                    <label class="col-lg-1 col-form-label">Brand</label>
                                    <div class="col-lg-5">
                                    	<select class="form-control brandSelect" name="brandseq">
	                                    		<?php 
	                                    			foreach($productBrands as $key => $value){
		                                    			$selected = "";
		                                    			if($product->getBrandSeq() == $value[0]){
		                                    				$selected = "selected";
		                                    			}
		                                    			echo "<option ".$selected." value='".$value[0]."'>".$value[1]."</option>";
		                                    		}
		                                    	?>
	                                    </select>
                                    </div>
                               </div>
                               <div class="form-group row">
                                    <label class="col-lg-1 col-form-label">Flavour</label>
                                    <div class="col-lg-5">
                                    	<select class="form-control flavourSelect" name="flavourseq">
	                                    		<?php 
	                                    			foreach($productFlavours as $key => $value){
		                                    			$selected = "";
		                                    			if($product->getFlavourSeq() == $value[0]){
		                                    				$selected = "selected";
		                                    			}
		                                    			echo "<option ".$selected." value='".$value[0]."'>".$value[1]."</option>";
		                                    		}
		                                    	?>
	                                    </select>
                                    </div>
                                    
                                    <!--  label class="col-lg-1 col-form-label">Stock</label>
                                    <div class="col-lg-5">
                                    	<input type="number" value=""  id="stock" name="stock" required placeholder="stock" class="form-control">
                                    </div-->
                                    <label class="col-lg-1 col-form-label">Enabled</label>
                                    <div class="col-lg-4">
	                                    <input class="i-checks" type="checkbox" <?php echo $isEnableChecked?>  id="isenabled" name="isenabled">
	                                 </div>
                               </div>
                             	<div class="form-group row" style="display:none">
									<label class="col-sm-1 control-label">Image</label>
									<div class="col-sm-5">
										<input type="file" id="productImage" name="productImage"
											class="form-control hidden" /> <label for="productImage"><a><img
												alt="image" id="badgeImg" class="img" width="92px;"
												src="<?echo $imagePath. "?".time() ?>"></a></label> <label
											class="jqx-validator-error-label" id="imageError"></label>
									</div>
							   	</div>
                               <div class="form-group row">
                               		<label class="col-lg-1 col-form-label"></label>
                               		<div class="col-lg-6">
	                               		<button class="btn btn-primary" type="button" onclick="javascript:submitproductForm('save')" 
	                               				id="rzp-button">
	                               			Save
		                               	</button>
		                               	<?php if(empty($product->getSeq())){?>
			                               	<button class="btn btn-primary" type="button" onclick="javascript:submitproductForm('saveandnew')" 
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
	    $("#productImage").change(function(){
	    	readIMG(this);
	    });
    });
    function submitproductForm(action){
    	if($("#productForm")[0].checkValidity()) {
        	 $('#productForm').ajaxSubmit(function( data ){
	    		 var obj = $.parseJSON(data);
	    		 if(obj.success == 1){
		    		 if(action == "save"){
	        		 	location.href = "showProducts.php";
		    		 }else{
		    			 showResponseToastr(data,null,"productForm","mainDiv");
		    			 clearForm($("#productForm"));
		    		 }
	    		 }else{
	        		 alert("Error" + obj.message);
	    		 }	 
	    	 });
    	}else{
    		$("#productForm")[0].reportValidity();
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
    	      this.selectedIndex = 0;
    	  });
    	};
    function cancel(){
    	location.href = "showProducts.php";
    }
    function readIMG(input){
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#badgeImg').attr('src', e.target.result);
                $("#imageError").text("");
                $("#badgeImg").removeClass("hilight");
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
 </script>	