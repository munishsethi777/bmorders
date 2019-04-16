<?php 
include("SessionCheck.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Payments</title>
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
									<h4 class="p-h-sm font-normal"> Order Payments</h4>
							</nav>
	                    </div>
	                    <div class="ibox-content">
	                        <div id="orderPaymentDetailGrid" style="margin-top:8px"></div>
	                    </div>
	                </div>
	            </div>
        	</div>
       </div>
    </div>
    <form id="form1" name="form1" method="post" action="createOrderPayment.php">
     	<input type="hidden" id="orderSeq" name="orderSeq"/>
     	<input type="hidden" id="isEdit" name="isEdit" value="1"/>
   	</form>
   	 <form id="exportForm" name="exportForm" method="GET" action="Actions/OrderPaymentDetailAction.php">
     	<input type="hidden" id="call" name="call" value="exportPayments"/>
     	<input type="hidden" id="queryString" name="queryString"/>
   	</form>
   </body>
</html>

	<script type="text/javascript">
	 isSelectAll = false;
        $(document).ready(function(){
           //$.getJSON("Actions/UserAction.php?call=getUserTypes",function( response ){
            	loadGrid()
           //}) 
           $('.i-checks').iCheck({
	        	checkboxClass: 'icheckbox_square-green',
	        	radioClass: 'iradio_square-green',
	    	});
        });
        
        function deleteUsers(gridId,deleteURL){
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
        
        function loadGrid(){
         	var columns = [
				{ text: 'id', datafield: 'seq' , hidden:true},
				{ text: 'Order No.', datafield: 'orders.seq', width:"8%"}, 	
				{ text: 'Customer', datafield: 'customers.title',width:"20%"},
				{ text: 'Order Date', datafield: 'orders.createdon',width:"14%",filtertype: 'date' ,cellsformat: 'd-M-yyyy hh:mm tt'},
				{ text: 'Amount', datafield: 'amount',width:"8%"},
				{ text: 'Payment Mode', datafield: 'paymentmode',width:"10%"},
				{ text: 'Payment Date', datafield: 'orderpaymentdetails.createdon',width:"14%",filtertype: 'date' ,cellsformat: 'd-M-yyyy hh:mm tt'},
				{ text: 'Paid', datafield: 'ispaid',width:"5%",columntype:'checkbox',filtertype: 'bool'},
				{ text: 'Confirmed', datafield: 'isconfirmed',width:"7%",columntype:'checkbox',filtertype: 'bool'},
				{ text: 'Expected Date', datafield: 'expectedon',width:"14%",filtertype: 'date' ,cellsformat: 'd-M-yyyy hh:mm tt'}
            ]
           
            var source =
            {
                datatype: "json",
                id: 'id',
                pagesize: 20,
                sortcolumn: 'orderpaymentdetails.createdon',
                sortdirection: 'desc',
                datafields: [{ name: 'seq', type: 'integer' },
                            { name: 'orders.seq', type: 'string' },
                            { name: 'orderseq', type: 'integer' },
                            { name: 'customers.title', type: 'string'},
                            { name: 'orders.createdon', type: 'date' },
                            { name: 'amount', type: 'string' },
                            { name: 'paymentmode', type: 'string' },
                            { name: 'ispaid', type: 'integer' },
                            { name: 'isconfirmed', type: 'integer' },
                            { name: 'createdon', type: 'date' },
                            { name: 'expectedon', type: 'date' },
                            { name: 'orderpaymentdetails.createdon', type: 'date' },
                            { name: 'Enabled', type: 'integer' },
                            ],                          
                url: 'Actions/OrderPaymentDetailAction.php?call=getOrderPaymentDetails',
                root: 'Rows',
                cache: false,
                beforeprocessing: function(data)
                {        
                    source.totalrecords = data.TotalRows;
                },
                filter: function()
                {
                    // update the grid and send a request to the server.
                    $("#orderPaymentDetailGrid").jqxGrid('updatebounddata', 'filter');
                },
                sort: function()
                {
                    // update the grid and send a request to the server.
                    $("#orderPaymentDetailGrid").jqxGrid('updatebounddata', 'sort');
                }
            };
            
            var dataAdapter = new $.jqx.dataAdapter(source);
            // initialize jqxGrid
            $("#orderPaymentDetailGrid").jqxGrid(
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
                    var exportButton = $("<div style='float: left; margin-left: 5px;'><i class='fa fa-file-excel-o'></i><span style='margin-left: 4px; position: relative;'>Export</span></div>");
                    var reloadButton = $("<div style='float: left; margin-left: 5px;'><i class='fa fa-refresh'></i><span style='margin-left: 4px; position: relative;'>Reload</span></div>");
                    var editButton = $("<div style='float: left; margin-left: 5px;'><i class='fa fa-edit'></i><span style='margin-left: 4px; position: relative;'>Edit</span></div>");
                    
                    container.append(reloadButton);
                    container.append(exportButton);
                    container.append(editButton);

                    statusbar.append(container);
                    editButton.jqxButton({  width: 65, height: 18 });
                    reloadButton.jqxButton({  width: 65, height: 18 });
                    exportButton.jqxButton({  width: 65, height: 18 });
                   
                    exportButton.click(function (event) {
						filterQstr = getFilterString("orderPaymentDetailGrid");
						exportPayments(filterQstr);
                    });
                    reloadButton.click(function (event) {
                    	$("#orderPaymentDetailGrid").jqxGrid({ source: dataAdapter });
                    });
                    editButton.click(function (event) {
                    	var selectedrowindex = $("#orderPaymentDetailGrid").jqxGrid('selectedrowindexes');
                        var value = -1;
                        indexes = selectedrowindex.filter(function(item) { 
                            return item !== value
                        })
                        if(indexes.length != 1){
                            bootbox.alert("Please Select single row for payment detail.", function() {});
                            return;    
                        }
                        var row = $('#orderPaymentDetailGrid').jqxGrid('getrowdata', indexes);
                        $("#orderSeq").val(row.orderseq);                        
                        $("#form1").submit(); 
                    });
                }
            });
        }
        function exportPayments(filterString){
            $("#queryString").val(filterString);
        	$('#exportForm').submit();
        }
        
</script>