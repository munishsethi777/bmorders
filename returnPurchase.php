<?include("SessionCheck.php");
require_once('IConstants.inc');
require_once ($ConstantsArray ['dbServerUrl'] . "Managers/PurchaseMgr.php");
require_once ($ConstantsArray ['dbServerUrl'] . "Managers/PurchaseDetailMgr.php");
require_once ($ConstantsArray ['dbServerUrl'] . "Managers/PurchaseReturnMgr.php");
require_once ($ConstantsArray ['dbServerUrl'] . "Utils/DateUtil.php");
require_once ($ConstantsArray ['dbServerUrl'] . "Enums/UserType.php");
$sessionUtil = SessionUtil::getInstance();
$roleType = $sessionUtil->getUserLoggedInUserType();
$isDisabled = "disabled";
$isEnableChecked = "";
if($roleType == UserType::getName(UserType::representative)){
	$isDisabled = "disabled";
}
$purchase = array();
$purchaseDetails = array();
$seq = 0;
$invoiceDate = "";
$purchaseReturns = array();
if(isset($_POST["seq"])){
 	$seq = $_POST["seq"];
 	$purchaseMgr = PurchaseMgr::getInstance();
 	$purchase = $purchaseMgr->findArrBySeq($seq);
 	$purchaseDetailsMgr = PurchaseDetailMgr::getInstance();
 	$purchaseDetails = $purchaseDetailsMgr->findByPurchaseSeq($seq);
 	$invoiceDate = $purchase["invoicedate"];
 	$invoiceDate = DateUtil::StringToDateByGivenFormat("Y-m-d h:i:s", $invoiceDate);
 	$invoiceDate = $invoiceDate->format("d-m-Y");
 	$purchaseReturnMgr = PurchaseReturnMgr::getInstance();
 	$purchaseReturns = $purchaseReturnMgr->getReturnDetailByPurchaseSeq($seq);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Purchase</title>
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
									<h4 class="p-h-sm font-normal"> Return Purchase</h4>
							</nav>
	                    </div>
	                </div>
	                <div class="ibox-content mainDiv">
	                	<form id="returnPurchaseForm" method="post" enctype="multipart/form-data" action="Actions/PurchaseReturnAction.php" class="m-t-lg">
                        		<input type="hidden" id ="call" name="call"  value="savePurchaseReturn"/>
                        		<input type="hidden" id ="purchaseseq" name="purchaseseq"  value="<?php echo $purchase["seq"]?>"/>
                        		<div class="form-group row">
                       				<label class="col-lg-1 col-form-label">Supplier:</label>
				                	<div class="col-lg-5">
				                    	<label class="col-form-label" ><?php echo $purchase["title"]?></label>
				                    </div>
                                    <label class="col-lg-1 col-form-label">Invoice#</label>
                                    <div class="col-lg-5">
                                    	<label class="col-form-label" ><?php echo $purchase["invoicenumber"]?></label>
                                    </div>
                               </div>
                               <div class="form-group row">
                       				<label class="col-lg-1 col-form-label">Inv Date</label>
                                    <div class="col-lg-5">
                                      	<label class="col-form-label" ><?php echo $invoiceDate?></label>
                                    </div>
                                    
                                    <label class="col-lg-1 col-form-label">Net Amt</label>
                                    <div class="col-lg-5">
                                     	<label class="col-form-label" ><?php echo $purchase["netamount"]?></label>
                                    </div>
                               </div>
                                <div class="form-group row">
		                			<label class="col-lg-1 col-form-label">Comments</label>
				                	<div class="col-lg-10">
				                   		<label class="col-form-label" ><?php echo $purchase["comments"]?></label>
				                    </div>
				                </div>
				               <?php foreach ($purchaseDetails as $purchaseDetail){
				               		$quantity = "";
				               		$comments = "";
				               		$readonly = "readonly";
				               		$checked = "";
				               		$detailSeq = $purchaseDetail["seq"];
				               		if(isset($purchaseReturns[$detailSeq])){
				               			$purchaseReturn = $purchaseReturns[$detailSeq];
				               			$quantity = $purchaseReturn[0]["quantity"];
				               			$comments = $purchaseReturn[0]["comments"];
				               			$readonly = "";
				               			$checked = "checked";
				               		}
				               		
				               ?>
				               	<div class="returnDiv">	
				               		   <input type="hidden" id ="purchasedetailseq" name="purchasedetailseq[]"  value="<?php echo $purchaseDetail["seq"]?>"/>
		                               <div class="form-group row">
					                		<label class="col-lg-1 col-form-label"><i class="fa fa-chevron-circle-right"></i></label>
					                		<div class="col-lg-6">
					                			<input type="checkbox" value="1" <?php echo $checked?>  id="isreturn" name="isreturn[]" class="form-control i-checks">
						                    	<label class="col-form-label" ><?php echo $purchaseDetail["title"]?></label>
						                    </div>
						                    <div class="col-lg-2">
						                  	 	<input type="text" <?php echo $isDisabled?> value="<?php echo $purchaseDetail["netrate"]?>"  class="form-control">
							                </div>
						                     <div class="col-lg-2">
						                  	 	<input type="text" <?php echo $isDisabled?> value="<?php echo $purchaseDetail["quantity"]?>"  class="form-control">
							                </div>
							               
							          </div>
					                 <div class="form-group row">
					                 	<label class="col-lg-1 col-form-label"></label>
					                 	 <div class="col-lg-2">
						               	 		<input type="text" <?php echo $isDisabled?>  value="<?php echo $purchaseDetail["lotnumber"]?>"  class="form-control">
							           		 </div>
						                 	 <div class="col-lg-2">
							              	 	<input type="text" value="<?php echo $purchaseDetail["discount"]?>" <?php echo $isDisabled?>  class="form-control">
								             </div>
							                 <div class="col-lg-2">
						                  	 	<input type="text" value="<?php echo $purchaseDetail["expirydate"]?>" <?php echo $isDisabled?> class="form-control dateControl">
							                </div>
							                <div class="col-lg-2" id="returnqty">
						                  	 	<input type="text" value="<?php echo $quantity?>" <?php echo $readonly?>  id="quantity" onkeyup="calculateAmount()" name="quantity[]" required placeholder="Return Qty."  class="form-control">
							                </div>
							         </div>	  
		                             <div class="form-group row">
		                             	<label class="col-lg-1 col-form-label"></label>
					                 	 <div class="col-lg-8">
					                 		<textarea class="form-control" <?php echo $readonly?> placeholder="Enter Return Note" name="comments[]" id="comments" rows="2" cols="81"><?php echo $comments?></textarea> 	
					                 	 </div>
		                             </div>
	                             </div>
                              <?php }?>
			                   <div class="form-group row">
                               	<hr>
                               		<label class="col-lg-1 col-form-label"></label>
                               		<div class="col-lg-6">
	                               		<button class="btn btn-primary" type="button" onclick="javascript:submitReturnForm()" 
	                               				id="rzp-button">
	                               			Submit
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
    </div>
</body>
</html>
<script type="text/javascript">
	$(document).ready(function(){
	    $('.i-checks').iCheck({
			checkboxClass: 'icheckbox_square-green',
		   	radioClass: 'iradio_square-green',
		});
	    $('.i-checks').on('ifChanged', function(event){
    		var ischecked  = $(this).is(':checked');
    		var qtyInput = $(this).closest("div.returnDiv").find("input[name='quantity[]']");
    		var commentTextarea = $(this).closest("div.returnDiv").find("textarea[name='comments[]']");
    		if(ischecked){
    			qtyInput.attr("required", true);
    			commentTextarea.attr("required", true);
    			qtyInput.removeAttr('readonly');
    			commentTextarea.removeAttr('readonly');
    		}else{
    			qtyInput.attr('readonly', true);
    			commentTextarea.attr('readonly', true);
    			commentTextarea.removeAttr('required');
    			qtyInput.removeAttr('required');		
    		}
		});
	    initDateControl()
    });
    function submitReturnForm(action){
    	if($("#returnPurchaseForm")[0].checkValidity()) {
    		var this_master =  $('#returnPurchaseForm');
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
        	 $('#returnPurchaseForm').ajaxSubmit(function( data ){
	    		 var obj = $.parseJSON(data);
	    		 if(obj.success == 1){
		    		 	location.href = "showPurchases.php";
		   		 }else{
	        		 alert("Error" + obj.message);
	    		 }	 
	    	 });
    	}else{
    		$("#returnPurchaseForm")[0].reportValidity();
    	}
    } 
    function cancel(){
    	location.href = "showPurchases.php";
    }
   
    function initDateControl(){
    	$('.dateControl').datetimepicker({
            timepicker:false,
            format:'d-m-Y',
            minDate:new Date()
       });
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