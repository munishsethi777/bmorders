<?include("SessionCheck.php");
require_once('IConstants.inc');
require_once ($ConstantsArray ['dbServerUrl'] . "Managers/CustomerMgr.php");
require_once ($ConstantsArray ['dbServerUrl'] . "Managers/OrderMgr.php");
$customerMgr = CustomerMgr::getInstance();
$order = new Order();
$customers = $customerMgr->findAll();
$selectedCustomerSeq = 0;
$seq = 0;
if(isset($_POST["seq"])){
	$seq = $_POST["seq"];
	$orderMgr = OrderMgr::getInstance();
	$order = $orderMgr->findBySeq($seq);
	$selectedCustomerSeq = $order->getCustomerSeq();
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
									<h4 class="p-h-sm font-normal"> Create Order</h4>
							</nav>
	                        
	                    </div>
	                </div>
	                <div class="ibox-content mainDiv">
	                	<form id="createOrderForm" method="post" enctype="multipart/form-data" action="Actions/OrderAction.php" class="m-t-lg">
                        		<input type="hidden" id ="call" name="call"  value="saveOrder"/>
                        		<input type="hidden" id ="seq" name="seq"  value="<?php echo $order->getSeq()?>"/>
                        		<input type="hidden" id ="totalamount" name="totalamount"/>
                        		<div class="form-group row">
				                	<label class="col-lg-1 col-form-label">Customer</label>
				                	<div class="col-lg-10">
				                    	<select class="form-control select2"  required id="customers" name="customerseq">
				                    		<option value=''>Select Customer</option>
				                    		<?php foreach ($customers as $customer){
												$cseq = $customer->getSeq();
												$selected = "";
												if($cseq == $selectedCustomerSeq){
													$selected = "selected";
												}
												?>
												<option <?php echo $selected?>  value="<?php echo $customer->getSeq()?>"><?php echo $customer->getTitle()?></option>
											<?php }?>
										</select> <label class="jqx-validator-error-label" id="lpError"></label>
				                    </div>
			                	</div>
			                	<div class="form-group row">
		                			<label class="col-lg-1 col-form-label">Comments</label>
				                	<div class="col-lg-10">
				                		<textarea class="form-control" id="comments" name="comments"  rows="3" cols="80"><?php echo $order->getComments()?></textarea>
				                    </div>
				                 </div>
			                	<div class="form-group row">
			                		<input type="hidden" id ="stock" name="stock[]"/>
		                			<label class="col-lg-1 col-form-label">Products</label>
				                	<div class="col-lg-6" id="productDiv">
				                    	<select class="form-control produtSelect2"  required name="products[]">
				                    	</select> <label class="jqx-validator-error-label" id="lpError"></label>
				                    </div>
				                    <div class="col-lg-1 col-form-label">
				                  	 	<span id="stockSpan">0</span><small> Available</small>
					                </div>
				                    <div class="col-lg-1">
				                  	 	<input type="text" value="" onchange="calculateAmount()"  id="price" name="price[]" required placeholder="Rs."  class="form-control">
					                </div>
					                <div class="col-lg-1">
				                  	 	<input type="text" value=""  id="quantity" onchange="calculateAmount()" name="quantity[]" required placeholder="qty"  class="form-control">
					                </div>
					               <div class="col-lg-1"> 
                                    	<a onClick="addRow(true)" title="Add More Product" href="#"><i class="fa fa-plus"> more</i></a> 
                              		</div>
			                	</div>
			                	 <div id="productDiv1" >
			                		 	
			                	 </div>
			                	 
				                 
				                  <div class="form-group row">
	                                    <label class="col-lg-1 col-form-label">Discount</label>
	                                    <div class="col-lg-4">
	                                    	<input type="text" value="<?php echo $order->getDiscountPercent()?>" onchange="calculateAmount()"  id="discount" name="discountpercent"  placeholder="Discount Percent" class="form-control">
	                                    </div>
	                              </div>
				                 <div class="form-group row">
	                                    <label class="col-lg-1 col-form-label">Amount</label>
	                                    <div class="col-lg-4">
	                                    	<span id="finalAmount">Rs. <?php echo $order->getTotalAmount()?></span>
	                                    </div>
	                              </div>
				                  <div class="form-group row">
                               		<label class="col-lg-2 col-form-label"></label>
                               		<div class="col-lg-6">
	                               		<button class="btn btn-primary" type="button" onclick="javascript:submitcreateOrderForm('save')" 
	                               				id="rzp-button">
	                               			Save
		                               	</button>
		                               	<?php if(empty($seq)){?>
		                               	<button class="btn btn-primary" type="button" onclick="javascript:submitcreateOrderForm('saveandnew')" 
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
<script type="text/javascript">
$(document).ready(function(){
    $('.i-checks').iCheck({
		checkboxClass: 'icheckbox_square-green',
	   	radioClass: 'iradio_square-green',
	});
    loadCustomers();
    addDefaultRows();
    
});
function addDefaultRows(){
	var seq = <?php echo $seq?>;
	if(seq > 0){
		getOrderDetail(seq);
	}else{
		for(var i=0;i<4;i++){
			addRow(false,null);
		}	
		loadProducts();
	}
	
}
function loadCustomers(){		
    $(".select2").select2({
        ajax: {
        url: "Actions/CustomerAction.php?call=searchCustomer",
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
function loadProducts(selectedSeq){
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
	      minimumInputLength: 1
	    });
	   $('.produtSelect2').on('select2:select', function (e) {
	  		 selectProduct(this);
	  });
}
function addRow(isLoadProducts,value){
	var quantity = "";
	var selectedProduct = "";
	var price = "";
	var stock = 0;
	if(value != null){
		 productSeq = value.productseq	
		 productTitle = value.title
		 selectedProduct = "<option selected value='"+productSeq+"'>"+productTitle+"</option>"
		 price = value.price;
		 quantity = value.quantity;
		 stock = parseInt(value.stock) + parseInt(value.quantity);
	}
 	var html = '<div id="productRow" class="form-group row">';
 		html += '<label class="col-lg-1 col-form-label"></label>';
    	html += '<div class="col-lg-6" id="productDiv">';
		html += '<select class="form-control produtSelect2" name="products[]">';
		html += selectedProduct;
		html += '</select> <label class="jqx-validator-error-label" id="lpError"></label>';
		html += '</div>';
		html += '<div class="col-lg-1 col-form-label">';
      	html += '<span id="stockSpan">'+stock+'</span><small> Available</small>';
        html += '</div>';
 		html += '<div class="col-lg-1">';
	 	html += '<input type="text" value="'+price+'" onchange="calculateAmount()"  id="price" name="price[]" placeholder="Price"  class="form-control">';
		html += '</div>'
		html += '<div class="col-lg-1">';
	 	html += '<input type="text" value="'+quantity+'" onchange="calculateAmount()"  id="quantity" name="quantity[]" placeholder="Quantity"  class="form-control">';
		html += '</div>'; 
		html += '<label class="col-lg-1 col-form-label">'; 
		html += '<a onClick="removeRow(this)" href="#"><i class="fa fa-times"></i></a>';
		html += '</label>';
		html += '<input type="hidden" value="'+stock+'" id ="stock" name="stock[]"/></div>';
 	$("#productDiv1").append(html);
 	if(isLoadProducts){
 		loadProducts();
 	}
}
function removeRow(btn){
	$(btn).closest("#productRow").remove();
}
function submitcreateOrderForm(action){
	if($("#createOrderForm")[0].checkValidity()) {
    	 $('#createOrderForm').ajaxSubmit(function( data ){
    		 var obj = $.parseJSON(data);
    		 showResponseToastr(data,null,"createOrderForm","mainDiv");
    		 $(".produtSelect2").select2("val", "");
    		 if(obj.success == 1 && action == "save"){
 		    	location.href = "showOrders.php";
 		     }  	 
    	 });
	}else{
		$("#createOrderForm")[0].reportValidity();
	}
} 
function cancel(){
	location.href = "showOrders.php";
}
function selectProduct(productDD){
	 var productSeq = productDD.value;
	 $.getJSON("Actions/ProductAction.php?call=getProductBySeq&seq="+productSeq,function( response ){
		 var price = response.price;
		 var stock = response.stock;
		 $(productDD).closest("div.form-group").find("input[name='price[]']").val(price);
		 $(productDD).closest("div.form-group").find("#stockSpan").text(stock);
		 $(productDD).closest("div.form-group").find("input[name='stock[]']").val(stock);
     }) 
}

function calculateAmount(){
	var priceArr = $("input[name='price[]']").map(function(){return $(this).val();}).get();
	var quantityArr = $("input[name='quantity[]']").map(function(){return $(this).val();}).get();
	var totalAmount = 0;
	$("select.produtSelect2").each(function(i, sel){
		var price = priceArr[i];
		var quantity = quantityArr[i];
		if(price != null && price != "" && quantity != null && quantity != ""){
			price = parseInt(price);
			quantity = parseInt(quantity);
			totalAmount += price * quantity;
		}
	});
	if(totalAmount > 0){
		var discount = $("#discount").val();
		if(discount != null && discount != "" && discount > 0){
			discount = parseInt(discount);
			discountAmount = (discount / 100) * totalAmount
			totalAmount = totalAmount - discountAmount;
		}	
	}
	$("#totalamount").val(totalAmount);
	$("#finalAmount").html("Rs. " + totalAmount);
}

function getOrderDetail(seq){
 	$.getJSON("Actions/OrderProductDetailAction.php?call=getDetailByProductSeq&orderSeq="+seq,function( response ){
 	 	$.each( response, function( key, value ) {
 	 	 	 if(key == 0){
 	 	 		productSeq = value.productseq	
 	 			productTitle = value.title
 	 			var selectedProduct = "<option selected value='"+productSeq+"'>"+productTitle+"</option>";
 	 			$(".produtSelect2").append(selectedProduct)
 	 	 	 	$("#price").val(value.price);
 	 	 		$("#quantity").val(value.quantity);
 	 	 		var stock = parseInt(value.stock) + parseInt(value.quantity);
 	 	 		$("#stockSpan").text(stock);
 	 	 		$("#stock").val(stock);
 	 	 	 }else{
 			 	addRow(false,value);
 	 	 	 }
 		});		
 	 	loadProducts();
 	 	calculateAmount();
    }) 
}
</script>





