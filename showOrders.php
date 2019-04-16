<?include("SessionCheck.php");
$sessionUtil = SessionUtil::getInstance();
$isRep = $sessionUtil->isRepresentative();
$loggedInUserName = $sessionUtil->getUserLoggedInName();
$rep = 0;
if($isRep){
	$rep = 1;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders List</title>
    <?include "ScriptsInclude.php"?>
    <style>
    	.datacell{
    	overflow: hidden;
		text-overflow: ellipsis;
		padding-bottom: 2px;
		text-align: left;
		margin-right: 2px;
		margin-left: 4px;
		margin-top: 4px;
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
									<h4 class="p-h-sm font-normal"> Orders Information</h4>
							</nav>
	                    </div>
	                    <div class="ibox-content">
	                        <div id="orderGrid" style="margin-top:8px"></div>
	                    </div>
	                </div>
	            </div>
        	</div>
       </div>
    </div>
    <form id="form1" name="form1" method="post" action="createOrder.php">
     	<input type="hidden" id="seq" name="seq"/>
   	</form>
   	<form id="form2" name="form2" method="post" action="createOrderPayment.php">
     	<input type="hidden" id="orderSeq" name="orderSeq"/>
     	<input type="hidden" id="orderid" name="orderid"/>
     	<input type="hidden" id="touser" name="touser"/>
   	</form>
   	<form id="exportForm" name="exportForm" method="GET" action="Actions/OrderAction.php">
     	<input type="hidden" id="call" name="call" value="exportOrders"/>
     	<input type="hidden" id="queryString" name="queryString"/>
   	</form>
   	<div  id="startChatModelForm" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Select Admin to Start Chat</h4>
                </div>
                <div class="modal-body">
                    <div class="row" >
                        <div class="col-sm-12">
                            <form role="form"  method="post" class="form-horizontal">
                                <input type="hidden" value="setProfile" name="call">
                                <input type="hidden" id="ids" name="ids" value="0">
                                <div id="adminDiv" class="form-group i-checks">
                                    
                                </div>
                                <div class="modal-footer">
                                     <button class="btn btn-primary ladda-button" data-style="expand-right" id="startNewChat" type="button">
                                        <span class="ladda-label">Start Chat</span>
                                    </button>
                                     <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
   </body>
</html>
	<script type="text/javascript">
	 isSelectAll = false;
	 var isRep = <?php echo $rep?>;
	 var loggedInUser = "<?php echo $loggedInUserName?>";
        $(document).ready(function(){
           $.getJSON("Actions/CustomerAction.php?call=getCustomerTitlesForFilter",function( response ){
            	loadGrid(response.customers)
           })
           $.getJSON("Actions/UserAction.php?call=getAllAdmins",function( response ){
            	populateAdmins(response)
           })  
           $('.i-checks').iCheck({
	        	checkboxClass: 'icheckbox_square-green',
	        	radioClass: 'iradio_square-green',
	    	});
        });
        function populateAdmins(admins){
            var html = "";
            $("#adminDiv").html("");
            checked = "checked";
        	$.each(admins, function(index , value){
            	 html += '<div class="col-sm-5"><input type="radio" name="adminRadio" '+checked+' value="'+value.seq+'"> '+value.fullname+'<small> ('+value.usertype+')</small> </div>';		
            	 checked = ""; 
        	}); 
        	$("#adminDiv").html(html); 
        	$('.i-checks').iCheck({
        		checkboxClass: 'icheckbox_square-green',
        	   	radioClass: 'iradio_square-green',
        	});
        	$("#startNewChat").click(function(e){
        		startNewChat();
        	});
        }
        function deleteCustomers(gridId,deleteURL){
            var selectedRowIndexes = $("#" + gridId).jqxGrid('selectedrowindexes');
            if(selectedRowIndexes.length > 0){
                bootbox.confirm("Are you sure you want to delete selected row(s)?", function(result) {
                    if(result){
                        var ids = [];
                        $.each(selectedRowIndexes, function(index , value){
                            if(value != -1){
                                var dataRow = $("#" + gridId).jqxGrid('getrowdata', value);
                                ids.push(dataRow.seq);
                            }
                        });
                        $.get( deleteURL + "&ids=" + ids,function( data ){
                            if(data != ""){
                                var obj = $.parseJSON(data);
                                var message = obj.message;
                                if(obj.success == 1){

                                    toastr.success(message,'Success');
                                   //$.each(selectedRowIndexes, function(index , value){
                                      //  var id = $("#"  + gridId).jqxGrid('getrowid', value);
                                        var commit = $("#"  + gridId).jqxGrid('deleterow', ids);
                                        $("#"+gridId).jqxGrid('updatebounddata');
                                        $("#"+gridId).jqxGrid('clearselection');
                                    //});
                                }else{
                                    toastr.error(message,'Failed');
                                }
                            }

                        });

                    }
                });
            }else{
                 bootbox.alert("No row selected.Please select row to delete!", function() {});
            }
        }
        
        function loadGrid(customers){
        	var chaticons = function (row, columnfield, value, defaulthtml, columnproperties) {
                data = $('#orderGrid').jqxGrid('getrowdata', row);
                if(data["haschat"] == "1"){
					return "<div class='datacell'>" + data['seq'] + " <a href='javascript:startChat("+data['seq']+",\""+ data['fullname']+"\")'><i class='fa fa-whatsapp'></i></a>" +"</div>";
                }
                return defaulthtml;                   
            }
           var columns = [
				{ text: 'id', datafield: 'seq',hidden:true },
				{ text: 'Order No.', datafield: 'orders.seq',width:"8%",cellsrenderer:chaticons},
				{ text: 'Order Date', datafield: 'orders.createdon',width:"15%",filtertype: 'date' ,cellsformat: 'd-M-yyyy hh:mm tt'},
				{ text: 'User', datafield: 'fullname',width:"15%"},
				{ text: 'Company', datafield: 'customers.title', width:"32%",filtertype: 'checkedlist',filteritems:customers}, 			
				//{ text: 'Comments', datafield: 'comments',width:"25%"},
				{ text: 'Amount', datafield: 'totalamount',width:"15%"},
				{ text: 'Pending', datafield: 'pendingamount',width:"15%",filterable:false,sortable:false}
				//{ text: 'Qty', datafield: 'totalproducts',width:"10%",filterable:false},
				//{ text: 'Payment Completed', datafield: 'ispaymentcompletelypaid',width:"14%",columntype: 'checkbox'}
            ]
           
            var source =
            {
                datatype: "json",
                id: 'id',
                pagesize: 20,
                sortcolumn: 'orders.createdon',
                sortdirection: 'desc',
                datafields: [{ name: 'seq', type: 'integer' },
                            { name: 'orders.seq', type: 'integer' },
                            { name: 'customers.title', type: 'string' },
                            { name: 'comments', type: 'string'},
                            { name: 'totalamount', type: 'string' },
                            { name: 'pendingamount', type: 'string' },
                            { name: 'totalproducts', type: 'integer' },
                            { name: 'discountpercent', type: 'string' },
                            { name: 'orders.createdon', type: 'date' },
                            { name: 'fullname', type: 'string' },
                            { name: 'ispaymentcompletelypaid', type: 'boolean' },
                            { name: 'haschat', type: 'integer' }
                            ],                          
                url: 'Actions/OrderAction.php?call=getAllOrders',
                root: 'Rows',
                cache: false,
                beforeprocessing: function(data)
                {        
                    source.totalrecords = data.TotalRows;
                },
                filter: function()
                {
                    // update the grid and send a request to the server.
                    $("#orderGrid").jqxGrid('updatebounddata', 'filter');
                },
                sort: function()
                {
                    // update the grid and send a request to the server.
                    $("#orderGrid").jqxGrid('updatebounddata', 'sort');
                }
            };
            
            var dataAdapter = new $.jqx.dataAdapter(source);
            // initialize jqxGrid
            $("#orderGrid").jqxGrid(
            {
            	width: '100%',
    			height: '75%',
    			source: dataAdapter,
    			filterable: true,
    			showfilterrow: true,
    			sortable: true,
    			autoshowfiltericon: true,
    			columns: columns,
    			pageable: true,
    			altrows: true,
    			enabletooltips: true,
    			columnsresize: true,
    			columnsreorder: true,
    			showstatusbar: true,
    			virtualmode: true,
    			selectionmode: 'singlerow',
    			rendergridrows: function (toolbar) {
                  return dataAdapter.records;     
           		 },
                renderstatusbar: function (statusbar) {
                    // appends buttons to the status bar.
                    var container = $("<div style='overflow: hidden; position: relative; margin: 5px;height:30px'></div>");
                    var addButton = $("<div style='float: left; margin-left: 5px;'><i class='fa fa-plus-square'></i><span style='margin-left: 4px; position: relative;'>    Add</span></div>");
                    var deleteButton = $("<div style='float: left; margin-left: 5px;'><i class='fa fa-times-circle'></i><span style='margin-left: 4px; position: relative;'>Delete</span></div>");
                    var editButton = $("<div style='float: left; margin-left: 5px;'><i class='fa fa-edit'></i><span style='margin-left: 4px; position: relative;'>Edit</span></div>");
                    var paymentButton = $("<div style='float: left; margin-left: 5px;'><i class='fa fa-credit-card'></i><span style='margin-left: 4px; position: relative;'>Payment</span></div>");
                    var chatButton = $("<div style='float: left; margin-left: 5px;'><i class='fa fa-whatsapp'></i><span style='margin-left: 4px; position: relative;'>Chat</span></div>");
                    
                    var exportButton = $("<div style='float: left; margin-left: 5px;'><i class='fa fa-file-excel-o'></i><span style='margin-left: 4px; position: relative;'>Export</span></div>");
                    var reloadButton = $("<div style='float: left; margin-left: 5px;'><i class='fa fa-refresh'></i><span style='margin-left: 4px; position: relative;'>Reload</span></div>");
                    

                    container.append(addButton);
                    container.append(editButton);
                    container.append(deleteButton);
                    container.append(paymentButton);
                    container.append(chatButton);
                    container.append(exportButton);
                    container.append(reloadButton);

                    statusbar.append(container);
                    addButton.jqxButton({  width: 65, height: 18 });
                    deleteButton.jqxButton({  width: 70, height: 18 });
                    editButton.jqxButton({  width: 65, height: 18 });
                    paymentButton.jqxButton({  width: 90, height: 18 });
                    chatButton.jqxButton({  width: 80, height: 18 });
                    exportButton.jqxButton({  width: 70, height: 18 });
                    
                    reloadButton.jqxButton({  width: 65, height: 18 });

                    // create new row.
                    addButton.click(function (event) {
                        location.href = ("createOrder.php");
                    });
                    chatButton.click(function (event) {
                    	var selectedrowindex = $("#orderGrid").jqxGrid('selectedrowindexes');
                        var value = -1;
                        indexes = selectedrowindex.filter(function(item) { 
                            return item !== value
                        })
                        if(indexes.length != 1){
                            bootbox.alert("Please Select single row for payment detail.", function() {});
                            return;    
                        }
                        var row = $('#orderGrid').jqxGrid('getrowdata', indexes);
                        startChat(row.seq,row.fullname);
                    });
                    paymentButton.click(function (event) {
                    	var selectedrowindex = $("#orderGrid").jqxGrid('selectedrowindexes');
                        var value = -1;
                        indexes = selectedrowindex.filter(function(item) { 
                            return item !== value
                        })
                        if(indexes.length != 1){
                            bootbox.alert("Please Select single row for payment detail.", function() {});
                            return;    
                        }
                        var row = $('#orderGrid').jqxGrid('getrowdata', indexes);
                        $("#orderSeq").val(row.seq);                        
                        $("#form2").attr("action", "createOrderPayment.php"); 
                        $("#form2").submit(); 
                    });
                    // update row.
                    editButton.click(function (event){
                    	var selectedrowindex = $("#orderGrid").jqxGrid('selectedrowindexes');
                        var value = -1;
                        indexes = selectedrowindex.filter(function(item) { 
                            return item !== value
                        })
                        if(indexes.length != 1){
                            bootbox.alert("Please Select single row for edit.", function() {});
                            return;    
                        }
                        var row = $('#orderGrid').jqxGrid('getrowdata', indexes);
                        $("#seq").val(row.seq);                        
                        $("#form1").submit();    
                    });
                    // delete row.
                    deleteButton.click(function (event) {
                        gridId = "orderGrid";
                        deleteUrl = "Actions/OrderAction.php?call=deleteOrders";
                        deleteCustomers(gridId,deleteUrl);
                    });
                    reloadButton.click(function (event) {
                    	$("#orderGrid").jqxGrid({ source: dataAdapter });
                    });
                    exportButton.click(function (event){
						filterQstr = getFilterString("orderGrid");
						exportOrders(filterQstr);
                    });
                }
            });
        }
        function exportOrders(filterString){
            $("#queryString").val(filterString);
        	$('#exportForm').submit();
        }

        function startChat(orderid,orderUser){
        	$("#form2").attr("action", "orderChat.php");        
       		$("#orderid").val(orderid); 
            if(isRep > 0){
	       		$('#startChatModelForm').modal('show');
		    }else{
                if(orderUser == loggedInUser){
                   alert("You can't start chat with your self!"); 
                }else{
                   $("#form2").submit();    
                }
            	 
            }
       }
       function startNewChat(){
    	  var touser = $('input[name=adminRadio]:checked').val();
    	  $("#touser").val(touser);
    	  $("#form2").submit();  
       }
        
</script>