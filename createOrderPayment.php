<?php
include("SessionCheck.php");
require_once('IConstants.inc');
require_once ($ConstantsArray ['dbServerUrl'] . "Managers/OrderPaymentDetailMgr.php");
require_once ($ConstantsArray ['dbServerUrl'] . "Utils/DropDownUtil.php");
require_once($ConstantsArray['dbServerUrl'] ."Enums/PaymentMode.php");
$orderPaymentDetail = new OrderPaymentDetail();
$orderPaymentDetailMgr = OrderPaymentDetailMgr::getInstance();
$orderSeq = 0;
if(isset($_POST["orderSeq"])){
	$orderSeq = $_POST["orderSeq"];	
}
$paymentModesJson = $orderPaymentDetailMgr->getPaymentModesJson();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Payment</title>
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
								<h4 class="p-h-sm font-normal"> Order Payment Detail</h4>
						</nav>
	                    </div>
	                </div>
	            </div>
	            <div class="ibox-content mainDiv">
		        	<form id="cashBookForm" method="post" enctype="multipart/form-data" action="Actions/OrderPaymentDetailAction.php" class="m-t-lg">
		                <input type="hidden" id ="call" name="call"  value="savePaymentDetail"/>
		                <input type="hidden" id ="seq" name="seq[]"  value="<?php echo $orderPaymentDetail->getSeq()?>"/>
		                <input type="hidden" id ="orderSeq" name="orderSeq"  value="<?php echo $orderSeq?>"/>
		               	<div class="form-group row">
		               		   <div class="col-lg-2">
			                    	<?php 
		                             	$select = DropDownUtils::getPaymentModeDD("paymentmode[]", null, "");
		                                echo $select;
	                             	?>
		                       </div>
			                   <div class="col-lg-2">
					           		<input type="text" value="" id="amount" name="amount[]" required placeholder="Amount"  class="form-control">
						        </div>
						        <div class="col-lg-2">
					            	<input type="text" value=""  id="detail" name="detail[]" required placeholder="detail"  class="form-control">
						        </div>
						          <div class="col-lg-2">
					            	<input type="text" value=""  id="expectedon" name="expectedon[]" placeholder="Expected date"  class="form-control dateControl">
						        </div>
						        <div class="col-lg-2 i-checks">
					            	<input type="checkbox" value="1"  id="isconfirmed" name="isconfirmed[]" class="form-control">
					            	<label> Confirmed</label>
						        </div>
						        <div class="col-lg-1 i-checks">
					            	<input type="checkbox" value="1"  id="ispaid" name="ispaid[]" class="form-control">
					            	<label> Paid</label>
					             </div>
					    </div>
					    
				        <div id="paymentModeDivRow">
				        			
				        </div>
				        <div class="form-group row">
			           		<div class="col-lg-2"> 
	                         	<a onClick="addRow()" title="Add More Product" href="#"><i class="fa fa-plus"> Add More</i></a> 
	                        </div> 	
			            </div>
		                <div class="form-group row">
                              <label class="col-lg-1 col-form-label"></label>
                              <div class="col-lg-6">
		                          	<button class="btn btn-primary" type="button" onclick="javascript:submitOrderPayment('save')" 
	                               				id="rzp-button">
	                               			Save
		                           	</button>
		                           	<?php if(empty($orderSeq)){?>
			                           <button class="btn btn-primary" type="button" onclick="javascript:submitOrderPayment('saveandnew')" 
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
</body>
</html>
<script type="text/javascript">
	$(document).ready(function(){
		initIcheck();
   		initDateControl();
   		getOrderPaymentDetail();
	});

function submitOrderPayment(action){
	if($("#cashBookForm")[0].checkValidity()) {
		var this_master =  $('#cashBookForm');

	    this_master.find('input[type="checkbox"]').each( function () {
	        var checkbox_this = $(this);


	        if( checkbox_this.is(":checked") == true ) {
	            checkbox_this.attr('value','1');
	        } else {
	            checkbox_this.prop('checked',true);
	            //DONT' ITS JUST CHECK THE CHECKBOX TO SUBMIT FORM DATA    
	            checkbox_this.attr('value','0');
	        }
	    })
    	 $('#cashBookForm').ajaxSubmit(function( data ){
    		 var obj = $.parseJSON(data);
    		 showResponseToastr(data,null,"cashBookForm","mainDiv");
    		 if(obj.success == 1 && action == "save"){
 		    	location.href = "showOrders.php";
 		     }   
    	 });
	}else{
		$("#cashBookForm")[0].reportValidity();
	}
}
function cancel(){
	location.href = "showOrders.php";
}
function removeRow(btn){
	$(btn).closest("#paymentModeDiv").remove();
}
function addRow(value){
	var paymentMode = "";
	var amount = "";	
	var detail = "";
	var confirmed = "";
	var paid = "";
	var expectedDate = "";
	var seq = "";
	if(value != null){
		paymentMode = value.paymentmode;
 		amount = value.amount;	
		detail = value.details;
		confirmed = value.isconfirmed;
		seq = value.seq;
		paid = value.ispaid;
		if(confirmed == "1"){
			confirmed = "checked";
	 	}
	 	if(paid == "1"){
	 		paid = "checked";
	 	}
	 	if(value.expectedon != null){
			expectedDate = value.expectedon;
	 	}
	}
	var paymentModeDD = getPaymentMode(paymentMode);
	var html = '<div id="paymentModeDiv" class="form-group row">';
	   	html += '<div class="col-lg-2">';
	   	html += paymentModeDD;
  		html += '</div>';
  		html += '<div class="col-lg-2">';
  		html += '<input type="text" value="'+amount+'" id="amount" name="amount[]" required placeholder="Amount"  class="form-control">';
   		html += '</div>';
   		html += '<div class="col-lg-2">';
   		html += '<input type="text" value="'+detail+'"  id="detail" name="detail[]" required placeholder="detail"  class="form-control">';
   		html += '</div>';
     	html += '<div class="col-lg-2">';
   		html += '<input type="text" value="'+expectedDate+'"    id="expectedon" name="expectedon[]" placeholder="Expected date"  class="form-control dateControl">';
   		html += '</div>';
   		html += '<div class="col-lg-2 i-checks">';
   		html += '<input type="checkbox" '+confirmed+'  id="isconfirmed" name="isconfirmed[]" class="form-control">';
   		html += '<label>&nbspConfirmed</label>';
   		html += '</div>';
   		html += '<div class="col-lg-1 i-checks">';
   		html += '<input type="checkbox" '+paid+' id="ispaid" name="ispaid[]" class="form-control">';
   		html += '<label>&nbspPaid</label>';
    	html += '</div>';
    	html += '<label class="col-lg-1 col-form-label">'; 
		html += '<a onClick="removeRow(this)" href="#"><i class="fa fa-times"></i></a>';
		html += '</label>';
        html += '<input type="hidden" id ="seq" name="seq[]"  value="'+seq+'"/></div>';
   		$("#paymentModeDivRow").append(html);	
   		initIcheck();
   		initDateControl();
}

function getOrderPaymentDetail(){
 	$.getJSON("Actions/OrderPaymentDetailAction.php?call=getDetailByOrderSeq&orderSeq="+<?php echo $orderSeq?>,function( response ){
 	 	$.each( response, function( key, value ) {
 	 	 	 if(key == 0){
 	 	 	 	var confirmed = value.isconfirmed;
 	 			var paid = value.ispaid;
 	 			var expectedDate = value.expectedon;
 	 			$("#paymentmode").val(value.paymentmode);
 	 			$("#amount").val(value.amount);
 	 	 		$("#detail").val(value.details);
 	 	 		$("#expectedon").val(value.expectedon);
 	 	 		$("#seq").val(value.seq);
 	 	 		if(confirmed == "1"){
 	 	 			$('#isconfirmed').iCheck('check')
 	 	 		}
 	 	 		if(paid == "1"){
 	 	 			$('#ispaid').iCheck('check')
 	 	 		}
 	 	 	 }else{
 			 	addRow(value);
 	 	 	 }
 		});
    }) 
}
function initIcheck(){
	$('.i-checks').iCheck({
		checkboxClass: 'icheckbox_square-green',
	   	radioClass: 'iradio_square-green',
	}); 
}
function initDateControl(){
	$('.dateControl').datetimepicker({
        timepicker:false,
        format:'d-m-Y',
        minDate:new Date()
   });
}
function getPaymentMode(selectedValue){
	var paymentModes = '<?php echo $paymentModesJson?>';
	var paymentModeJson = $.parseJSON(paymentModes);
	var select = '<select required="" class="form-control m-b" name="paymentmode[]" id="paymentmode">';
		select += '<option value="">Payment Mode</option>';
	var options = "";
	$.each( paymentModeJson, function( key, value ) {
		var selected ="";
		if(key == selectedValue){
			selected = "selected";
		}
		options += '<option '+selected+' value="'+key+'">'+value+'</option>';
	});
	select += options + '</select>'
	return select;
}
</script>
