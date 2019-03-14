<?php
include("SessionCheck.php");
require_once('IConstants.inc');
require_once ($ConstantsArray ['dbServerUrl'] . "Managers/ExpenseLogMgr.php");

$expenseLog = new ExpenseLog();
$expenseLogMgr = ExpenseLogMgr::getInstance();
if(isset($_POST["seq"])){
	$seq = $_POST["seq"];
	$expenseLog = $expenseLogMgr->findBySeq($seq);
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
		        	<form id="cashBookForm" method="post" enctype="multipart/form-data" action="Actions/ExpenseLogAction.php" class="m-t-lg">
		                <input type="hidden" id ="call" name="call"  value="saveExpenseLog"/>
		                <input type="hidden" id ="seq" name="seq"  value="<?php echo $expenseLog->getSeq()?>"/>
		                <div class="form-group row">
		                	<label class="col-lg-1 col-form-label">Title</label>
		                    <div class="col-lg-7">
		                    	<input type="text" value="<?php echo $expenseLog->getTitle()?>"  id="title" name="title" required placeholder="Title" class="form-control">
		                    </div>
		                </div>
		                <div class="form-group row">
		                	<label class="col-lg-1 col-form-label">Description</label>
		                    <div class="col-lg-7">
		                    	<input type="text" value="<?php echo $expenseLog->getDescription()?>"  id="description" name="description" required placeholder="Description" class="form-control">
		                    </div>
		                </div>
		                <div class="form-group row">
		                	<label class="col-lg-1 col-form-label">Amount</label>
		                    <div class="col-lg-7">
		                    	<input type="text" value="<?php echo $expenseLog->getAmount()?>"  id="amount" name="amount" required placeholder="Amount" class="form-control">
		                    </div>
		                </div>
		                <div class="form-group row">
                              <label class="col-lg-1 col-form-label"></label>
                              <div class="col-lg-6">
		                          	<button class="btn btn-primary" type="button" onclick="javascript:submitCashBookForm('save')" 
	                               				id="rzp-button">
	                               			Save
		                           	</button>
		                           	<?php if(empty($expenseLog->getSeq())){?>
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
function submitCashBookForm(action){
	if($("#cashBookForm")[0].checkValidity()) {
    	 $('#cashBookForm').ajaxSubmit(function( data ){
    		 var obj = $.parseJSON(data);
    		 showResponseToastr(data,null,"cashBookForm","mainDiv");
    		 if(obj.success == 1 && action == "save"){
 		    	location.href = "showCashBook.php";
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
