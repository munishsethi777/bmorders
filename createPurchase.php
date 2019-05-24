<?include("SessionCheck.php");
require_once('IConstants.inc');
require_once ($ConstantsArray ['dbServerUrl'] . "Managers/PurchaseMgr.php");
require_once ($ConstantsArray ['dbServerUrl'] . "Managers/SupplierMgr.php");
require_once ($ConstantsArray ['dbServerUrl'] . "Utils/DateUtil.php");
require_once ($ConstantsArray ['dbServerUrl'] . "Enums/UserType.php");
$sessionUtil = SessionUtil::getInstance();
$roleType = $sessionUtil->getUserLoggedInUserType();
$isDisabled = "";
$isEnableChecked = "";
if($roleType == UserType::getName(UserType::representative)){
	$isDisabled = "disabled";
}
$purchase = new Purchase();
$supplierMgr = SupplierMgr::getInstance();
$suppliers = $supplierMgr->findAll();
$selectedSupplier = 0;
$seq = 0;
$invoiceDate = "";
if(isset($_POST["seq"])){
 	$seq = $_POST["seq"];
 	$purchaseMgr = PurchaseMgr::getInstance();
 	$purchase = $purchaseMgr->findBySeq($seq);
 	$selectedSupplier = $purchase->getSupplierSeq();
 	$invoiceDate = $purchase->getInvoiceDate();
 	$invoiceDate = DateUtil::StringToDateByGivenFormat("Y-m-d h:i:s", $invoiceDate);
 	$invoiceDate = $invoiceDate->format("d-m-Y");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Purchase</title>
    <?include "ScriptsInclude.php"?>
    <style>
    .productRow .form-group{
    	margin-bottom:5px !important;
    }
   
    hr{
    	margin:10px 0px 10px 0px !important;
    }
    </style>
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
	                	<form id="customerForm" method="post" enctype="multipart/form-data" action="Actions/PurchaseAction.php" class="m-t-lg">
                        		<input type="hidden" id ="call" name="call"  value="savePurchase"/>
                        		<input type="hidden" id ="seq" name="seq"  value="<?php echo $purchase->getSeq()?>"/>
                        		<div class="form-group row">
                       				<label class="col-lg-1 col-form-label">Supplier</label>
				                	<div class="col-lg-5">
				                    	<select class="form-control select2"  required id="supplierseq" name="supplierseq">
				                    		<option value=''>Select Supplier</option>
				                    		<?php foreach ($suppliers as $supplier){
												$supSeq = $supplier->getSeq();
												$selected = "";
												if($supSeq == $selectedSupplier){
													$selected = "selected";
												}
												?>
												<option <?php echo $selected?>  value="<?php echo $supplier->getSeq()?>"><?php echo $supplier->getTitle()?></option>
											<?php }?>
										</select> <label class="jqx-validator-error-label" id="lpError"></label>
				                    </div>
                                    <label class="col-lg-1 col-form-label">Invoice#</label>
                                    <div class="col-lg-5">
                                    	<input type="text" value="<?php echo $purchase->getInvoiceNumber()?>"  id="invoicenumber" name="invoicenumber" required placeholder="#Invoice" class="form-control">
                                    </div>
                               </div>
                               <div class="form-group row">
                       				<label class="col-lg-1 col-form-label">Inv Date</label>
                                    <div class="col-lg-5">
                                    	<input type="text" value="<?php echo $invoiceDate?>" id="invoicedate" name="invoicedate"  placeholder="Select Date" class="form-control dateControl">
                                    </div>
                                    
                                    <label class="col-lg-1 col-form-label">Net Amt</label>
                                    <div class="col-lg-5">
                                    	<input type="text" value="<?php echo $purchase->getNetAmount()?>" readonly id="netamount" name="netamount"  placeholder="Net Amount" class="form-control">
                                    </div>
                               </div>
                                <div class="form-group row">
		                			<label class="col-lg-1 col-form-label">Comments</label>
				                	<div class="col-lg-10">
				                		<textarea class="form-control" id="comments" name="comments"  rows="3" cols="80"><?php echo $purchase->getComments()?></textarea>
				                    </div>
				                </div>
                               <div class="form-group row">
			                		<label class="col-lg-1 col-form-label"><i class="fa fa-chevron-circle-right"></i></label>
		                			<div class="col-lg-6" id="productDiv">
				                    	<select class="form-control produtSelect2"  required name="products[]">
				                    	</select> <label class="jqx-validator-error-label" id="lpError"></label>
				                    </div>
				                    <div class="col-lg-2">
				                  	 	<input type="text" value=""  id="netrate" onkeyup="calculateAmount()" name="netrate[]" required placeholder="Rs."  class="form-control">
					                </div>
				                     <div class="col-lg-2">
				                  	 	<input type="text" value=""  id="quantity" onkeyup="calculateAmount()" name="quantity[]" required placeholder="Qty."  class="form-control">
					                </div>
					               
					          </div>
			                 <div class="form-group row">
			                 	<label class="col-lg-1 col-form-label"></label>
			                 	 <div class="col-lg-2">
				               	 		<input type="text" value=""  id="lotnumber" name="lotnumber[]" required placeholder="Lot No."  class="form-control">
					           		 </div>
			                 	 <div class="col-lg-2">
				              	 	<input type="text" value=""  id="discount" onkeyup="calculateAmount()" name="discount[]"  placeholder="Discount"  class="form-control">
					             </div>
					                 <div class="col-lg-2">
				                  	 	<input type="text" value="" id="expirydate" name="expirydate[]" required placeholder="Expiry Date"  class="form-control dateControl">
					                </div>
					               <div class="col-lg-1"> 
                                    	<a onClick="addRow(true)" title="Add More Product" href="#"><i class="fa fa-plus"> more</i></a> 
                              		</div>
                             </div>	  
			                 <div id="productDiv1" >
			                	 	
			                 </div>
			                 
                               <div class="form-group row">
                               	<hr>
                               		<label class="col-lg-1 col-form-label"></label>
                               		<div class="col-lg-6">
	                               		<button class="btn btn-primary" type="button" onclick="javascript:submitCustomerForm('save')" 
	                               				id="rzp-button">
	                               			Save
		                               	</button>
		                               	<?php if(empty($purchase->getSeq())){?>
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
	    loadSuppliers();
	    addDefaultRows();
	    initDateControl()
    });
    function submitCustomerForm(action){
    	if($("#customerForm")[0].checkValidity()) {
        	 $('#customerForm').ajaxSubmit(function( data ){
	    		 var obj = $.parseJSON(data);
	    		 if(obj.success == 1){
		    		 if(action == "save"){
	        		 	location.href = "showPurchases.php";
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
    	  $(".produtSelect2").select2("val", "");
    	  $(".select2").select2("val", "");	 	 
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
    	location.href = "showPurchases.php";
    }
    function addRow(isLoadProducts,value){
    	var quantity = "";
    	var selectedProduct = "";
    	var price = "";
    	var lotno ="";
    	var discount = ""
    	var expDate = ""
        var requred = "";
    	if(value != null){
    		 productSeq = value.productseq	
    		 productTitle = value.title
    		 selectedProduct = "<option selected value='"+productSeq+"'>"+productTitle+"</option>"
    		 price = value.netrate;
    		 quantity = value.quantity;
    		 lotno = value.lotnumber;
    		 discount = value.discount;
    		 expDate = value.expirydate;
    		 requred  = "required";
    	}
     	var html = '<div class="productRow" id="productRow"> <div class="form-group row">';
     		html += '<hr><label class="col-lg-1 col-form-label"><i class="fa fa-chevron-circle-right"></i></label>';
        	html += '<div class="col-lg-6" id="productDiv">';
    		html += '<select class="form-control produtSelect2" name="products[]">';
    		html += selectedProduct;
    		html += '</select> <label class="jqx-validator-error-label" id="lpError"></label>';
    		html += '</div>';
    		html += '<div class="col-lg-2">';
    	 	html += '<input type="text" value="'+price+'" ' + requred +  ' onkeyup="calculateAmount()"  id="netrate" name="netrate[]" placeholder="Rs."  class="form-control">';
    		html += '</div>'
    		html += '<div class="col-lg-2">';
    	 	html += '<input type="text" value="'+quantity+'" ' + requred +  ' onkeyup="calculateAmount()"  id="quantity" name="quantity[]" placeholder="Qty."  class="form-control">';
    		html += '</div>';
    		html += '</div>';
    		html += '<div class="form-group row">';
    		html += '<label class="col-lg-1 col-form-label"></label>';
    		html += '<div class="col-lg-2">';
       	 	html += '<input type="text" value="'+lotno+'" ' + requred +  '   id="lotnumber" name="lotnumber[]"  placeholder="Lot No."  class="form-control">';
      		html += '</div>'; 
            html += '<div class="col-lg-2">'
            html += '<input type="text" value="'+discount+'"  id="quantity" onkeyup="calculateAmount()" name="discount[]" placeholder="Discount"  class="form-control">';
	        html += '</div>';
	        html += '<div class="col-lg-2">'
            html += '<input type="text" value="'+expDate+'" ' + requred +  ' id="expirydate" name="expirydate[]"  placeholder="Expiry Date"  class="form-control dateControl">';
	        html += '</div>';
	        html += '<label class="col-lg-1 col-form-label">'; 
    		html += '<a onClick="removeRow(this)" href="#"><i class="fa fa-times"></i></a>';
    		html += '</label>';
    		html += '</div>';
    		html += '</div>';
    		html += '</div>';
     	$("#productDiv1").append(html);
     	if(isLoadProducts){
     		loadProducts();
     	}
     	initDateControl();
    }
    function removeRow(btn){
    	$(btn).closest("#productRow").remove();
    }
    function initDateControl(){
    	$('.dateControl').datetimepicker({
            timepicker:false,
            format:'d-m-Y',
       });
    }
    function loadProducts(){
 	   $(".produtSelect2").select2({
 	        ajax: {
 	        url: "Actions/ProductAction.php?call=searchProduct",
 	        dataType: 'json',
 	        delay: 250,
 	        data: function (params) {
 	          return {
 	            q: params.term, // search term
 	            page: params.page
 	          };
 	        },
 	        processResults: function (data, page) {
 	          return data;
 	        },
 	        cache: true
 	      },
 	      placeholder: "Select Product",
 	      allowClear: true,
 	      minimumInputLength: 1,
 	      value:8
 	    });
 	   $('.produtSelect2').on('select2:select', function (e) {
 		  selectProduct(this)
 	   });
 	   $(".produtSelect2").on("select2:unselect", function (e) {
 		  unSelectProduct(this);
 	   });
 	}
    function addDefaultRows(){
    	var seq = <?php echo $seq?>;
    	if(seq > 0){
    		getPurchaseDetail(seq);
    	}else{
    		for(var i=0;i<4;i++){
    			addRow(false,null);
    		}	
    		loadProducts();
    	}
    }
    function loadSuppliers(){		
        $(".select2").select2({
            ajax: {
            url: "Actions/SupplierAction.php?call=searchSupplier",
            dataType: 'json',
            delay: 250,
            data: function (params) {
              return {
                q: params.term, // search term
                page: params.page
              };
            },
            processResults: function (data, page) {
              return data;
            },
            cache: true
          },
          minimumInputLength: 1
        });
       
    }
    function getPurchaseDetail(seq){
     	$.getJSON("Actions/PurchaseDetailAction.php?call=getDetailByPurchaseSeq&purchaseSeq="+seq,function( response ){
     		productSeq = 0;
     	 	$.each( response, function( key, value ) {
     	 	 	 if(key == 0){
     	 	 		productSeq = value.productseq	
     	 			productTitle = value.title
     	 			var selectedProduct = "<option selected value='"+productSeq+"'>"+productTitle+"</option>";
     	 			$(".produtSelect2").append(selectedProduct)
     	 			$("#netrate").val(value.netrate);
     	 	 		$("#quantity").val(value.quantity);
     	 	 		$("#lotnumber").val(value.lotnumber);
     	 	 		$("#discount").val(value.discount);
     	 	 		$("#expirydate").val(value.expirydate);
     	 	 	 }else{
     			 	addRow(false,value);
     	 	 	 }
     		});		
     	 	loadProducts();
        }) 
    }
    function unSelectProduct(productDD){
	   	$(productDD).closest("div.productRow").find("input[name='netrate[]']").val("");
	   	$(productDD).closest("div.productRow").find("input[name='quantity[]']").val("");
	   	$(productDD).closest("div.productRow").find("input[name='netrate[]']").removeAttr('required')
	    $(productDD).closest("div.productRow").find("input[name='quantity[]']").removeAttr('required')
    	$(productDD).closest("div.productRow").find("input[name='lotnumber[]']").removeAttr('required')
    	$(productDD).closest("div.productRow").find("input[name='expirydate[]']").removeAttr('required')
	   	 calculateAmount();
    }
    
    function selectProduct(productDD){
    	$(productDD).closest("div.productRow").find("input[name='netrate[]']").attr("required", true);
    	$(productDD).closest("div.productRow").find("input[name='quantity[]']").attr("required", true);
    	$(productDD).closest("div.productRow").find("input[name='lotnumber[]']").attr("required", true);
    	$(productDD).closest("div.productRow").find("input[name='expirydate[]']").attr("required", true);
    }
    
    function calculateAmount(){
    	var priceArr = $("input[name='netrate[]']").map(function(){return $(this).val();}).get();
    	var quantityArr = $("input[name='quantity[]']").map(function(){return $(this).val();}).get();
    	var discountArr = $("input[name='discount[]']").map(function(){return $(this).val();}).get();
    	var totalAmount = 0;
    	var grossAmount = 0;
    	$("select.produtSelect2").each(function(i, sel){
    		var price = priceArr[i];
    		var quantity = quantityArr[i];
    		var discount = discountArr[i];
    		if(price != null && price != "" && quantity != null && quantity != ""){
    			price = parseInt(price);
    			quantity = parseInt(quantity);
    			amount = price * quantity;
    			if(discount != null && discount != "" && discount  > 0){
    				discount = parseInt(discount);	
    				discountAmount = (discount / 100) * amount
    				amount = amount - discountAmount;
    			}
    			totalAmount += amount;
    		}
    	});
    	totalAmount = Math.round(totalAmount);
    	$("#netamount").val(totalAmount);
    }

    function isValidateQty(){
    	var quantityArr = $("input[name='quantity[]']").map(function(){return $(this).val();}).get();
    	var stockArr = $("input[name='stock[]']").map(function(){return $(this).val();}).get();
    	check = true;
    	$.each( quantityArr, function(key , value ) {
    		var quantity = value;
    		var stock = stockArr[key];
    		if( quantity != null && quantity != ""){
    			quantity = parseInt(quantity);
    			stock = parseInt(stock);
    			if(quantity > stock){
    				check = false;
    				return false;
    			}	
    		}
    	});
    	return check;
    }
 </script>	