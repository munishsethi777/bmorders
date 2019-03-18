<?include("SessionCheck.php");?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products List</title>
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
   	</form>
   </body>
</html>

	<script type="text/javascript">
	 isSelectAll = false;
        $(document).ready(function(){
           $.getJSON("Actions/CustomerAction.php?call=getCustomerTitlesForFilter",function( response ){
            	loadGrid(response.customers)
           }) 
           $('.i-checks').iCheck({
	        	checkboxClass: 'icheckbox_square-green',
	        	radioClass: 'iradio_square-green',
	    	});
        });
        
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
           var columns = [
				{ text: 'id', datafield: 'seq' , hidden:true},
				{ text: 'Order Date', datafield: 'orders.createdon',width:"14%",filtertype: 'date' ,cellsformat: 'd-M-yyyy hh:mm tt'},
				{ text: 'Company', datafield: 'title', width:"24%",filtertype: 'checkedlist',filteritems:customers}, 			
				//{ text: 'Comments', datafield: 'comments',width:"25%"},
				{ text: 'Amount', datafield: 'totalamount',width:"10%"},
				{ text: 'Pending', datafield: 'pendingamount',width:"10%",filterable:false,sortable:false},
				{ text: 'Qty', datafield: 'totalproducts',width:"10%",filterable:false},
				

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
                            { name: 'title', type: 'string' },
                            { name: 'comments', type: 'string'},
                            { name: 'totalamount', type: 'string' },
                            { name: 'pendingamount', type: 'string' },
                            { name: 'discountpercent', type: 'string' },
                            { name: 'orders.createdon', type: 'date' },
                            { name: 'ispaymentcompletelypaid', type: 'boolean' }
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
    			selectionmode: 'checkbox',
    			rendergridrows: function (toolbar) {
                  return dataAdapter.records;     
           		 },
                renderstatusbar: function (statusbar) {
                    // appends buttons to the status bar.
                    var container = $("<div style='overflow: hidden; position: relative; margin: 5px;height:30px'></div>");
                    var addButton = $("<div style='float: left; margin-left: 5px;'><i class='fa fa-plus-square'></i><span style='margin-left: 4px; position: relative;'>    Add</span></div>");
                    var deleteButton = $("<div style='float: left; margin-left: 5px;'><i class='fa fa-times-circle'></i><span style='margin-left: 4px; position: relative;'>Delete</span></div>");
                    var editButton = $("<div style='float: left; margin-left: 5px;'><i class='fa fa-edit'></i><span style='margin-left: 4px; position: relative;'>Edit</span></div>");
                    var paymentButton = $("<div style='float: left; margin-left: 5px;'><i class='fa fa-edit'></i><span style='margin-left: 4px; position: relative;'>Payment</span></div>");
					

                    container.append(addButton);
                    container.append(editButton);
                    container.append(deleteButton);
                    container.append(paymentButton);

                    statusbar.append(container);
                    addButton.jqxButton({  width: 65, height: 18 });
                    deleteButton.jqxButton({  width: 70, height: 18 });
                    editButton.jqxButton({  width: 65, height: 18 });
                    paymentButton.jqxButton({  width: 90, height: 18 });

                    // create new row.
                    addButton.click(function (event) {
                        location.href = ("createOrder.php");
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
                }
            });
        }
		
        
</script>