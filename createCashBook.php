<?php
include("SessionCheck.php");
require_once('IConstants.inc');
require_once ($ConstantsArray ['dbServerUrl'] . "Managers/CashbookMgr.php");
require_once ($ConstantsArray ['dbServerUrl'] . "Utils/DropdownUtil.php");
require_once($ConstantsArray['dbServerUrl'] ."Enums/ExpenseType.php");

$cashbook = new Cashbook();
$cashbookMgr = CashbookMgr::getInstance();
$receiptChecked = "checked";
$paymentChecked = "";

if(isset($_POST["seq"])){
	$seq = $_POST["seq"];
	$cashbook = $cashbookMgr->findBySeq($seq);
	$type = $cashbook->getTransactionType();
	if($type == "payment"){
		$paymentChecked = "checked";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cash Book</title>
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
								<h4 class="p-h-sm font-normal"> Create Cash Book</h4>
						</nav>
	                    </div>
	                </div>
	            </div>
	            <div class="ibox-content mainDiv">
		        	<form id="cashBookForm" method="post" enctype="multipart/form-data" action="Actions/CashbookAction.php" class="m-t-lg">
		                <input type="hidden" id ="call" name="call"  value="saveCashbook"/>
		                <input type="hidden" id ="seq" name="seq"  value="<?php echo $cashbook->getSeq()?>"/>
		                <div class="form-group row">
		                	<label class="col-lg-1 col-form-label"></label>
		                    <div class="col-lg-2 col-form-label">
		                    	Receipt <input type="radio" name="transactiontype" value="receipt" class="i-checks" <?php echo $receiptChecked?>>
		                    </div>
		                    <div class="col-lg-2 col-form-label">
		                    	Payment <input type="radio" name="transactiontype" value="payment" class="i-checks" <?php echo $paymentChecked?>>
		                    </div>
		                </div>
		                 <div class="form-group row">
		                	<label class="col-lg-1 col-form-label">Type</label>
		                    <div class="col-lg-7">
		                    	<?php 
		                             	$select = DropDownUtils::getExpenseTypeDD("category", null, $cashbook->getCategory());
		                                echo $select;
	                             	?>
		                    </div>
		                </div>
		                <div class="form-group row">
		                	<label class="col-lg-1 col-form-label">Title</label>
		                    <div class="col-lg-7">
		                    	<input type="text" value="<?php echo $cashbook->getTitle()?>"  id="title" name="title" required placeholder="Title" class="form-control">
		                    </div>
		                </div>
		                <div class="form-group row">
		                	<label class="col-lg-1 col-form-label">Description</label>
		                    <div class="col-lg-7">
		                    	<input type="text" value="<?php echo $cashbook->getDescription()?>"  id="description" name="description" required placeholder="Description" class="form-control">
		                    </div>
		                </div>
		                <div class="form-group row">
		                	<label class="col-lg-1 col-form-label">Amount</label>
		                    <div class="col-lg-7">
		                    	<input type="text" value="<?php echo $cashbook->getAmount()?>"  id="amount" name="amount" required placeholder="Amount" class="form-control">
		                    </div>
		                </div>
		                <div class="form-group row">
                              <label class="col-lg-1 col-form-label"></label>
                              <div class="col-lg-6">
		                          	<button class="btn btn-primary" type="button" onclick="javascript:submitCashBookForm('save')" 
	                               				id="rzp-button">
	                               			Save
		                           	</button>
		                           	<?php if(empty($cashbook->getSeq())){?>
			                           <button class="btn btn-primary" type="button" onclick="javascript:submitCashBookForm('saveandnew')" 
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
    $('.i-checks').iCheck({
		checkboxClass: 'icheckbox_square-green',
	   	radioClass: 'iradio_square-green',
	});
});
function submitCashBookForm(action){
	if($("#cashBookForm")[0].checkValidity()) {
    	 $('#cashBookForm').ajaxSubmit(function( data ){
    		 var obj = $.parseJSON(data);
    		 
    		 if(obj.success == 1 && action == "save"){
    			showResponseToastr(data,null,null,"mainDiv");
    	    	location.href = "showCashBook.php";
 		     }else{
 		    	showResponseToastr(data,null,"cashBookForm","mainDiv");
 		     }   
    	 });
	}else{
		$("#cashBookForm")[0].reportValidity();
	}
}
function cancel(){
	location.href = "showCashBook.php";
}
</script>
