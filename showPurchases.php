<?include("SessionCheck.php");
$sessionUtil = SessionUtil::getInstance();
$isSuperUser = $sessionUtil->isSuperAdmin();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase List</title>
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
									<h4 class="p-h-sm font-normal"> Purchase Informaiton</h4>
							</nav>
	                    </div>
	                    <div class="ibox-content">
	                        <div id="purchaseGrid" style="margin-top:8px"></div>
	                    </div>
	                </div>
	            </div>
        	</div>
       </div>
    </div>
    <form id="form1" name="form1" method="post" action="createPurchase.php">
     	<input type="hidden" id="seq" name="seq"/>
   	</form>
   	 <form id="exportForm" name="exportForm" method="GET" action="Actions/PurchaseAction.php">
     	<input type="hidden" id="call" name="call" value="exportPurchase"/>
     	<input type="hidden" id="queryString" name="queryString"/>
   	</form>
   </body>
</html>

	<script type="text/javascript">
	 isSelectAll = false;
	 var isSuperUser = "<?php echo $isSuperUser?>";
        $(document).ready(function(){
        	$.getJSON("Actions/SupplierAction.php?call=getSupplierTitlesForFilter",function( response ){
             	loadGrid(response.suppliers)
            })
           $('.i-checks').iCheck({
	        	checkboxClass: 'icheckbox_square-green',
	        	radioClass: 'iradio_square-green',
	    	});
           
        });
        
        function deletePurchase(gridId,deleteURL){
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
        
        function loadGrid(suppliers){
			var columns = [
				{ text: 'id', datafield: 'seq' , hidden:true},
				{ text: 'Invoice Date', datafield: 'invoicedate',width:"15%",filtertype: 'range' ,cellsformat: 'd-M-yyyy'},
				{ text: 'Invoice No.', datafield: 'invoicenumber', width:"20%"}, 			
				{ text: 'Supplier', datafield: 'title',width:"50%",filtertype: 'checkedlist',filteritems:suppliers},
				{ text: 'Amount', datafield: 'netamount',width:"15%"},
				
            ]
            var source =
            {
                datatype: "json",
                id: 'id',
                pagesize: 20,
                sortcolumn: 'lastmodifiedon',
                sortdirection: 'desc',
                datafields: [{ name: 'seq', type: 'integer' },
                            { name: 'invoicenumber', type: 'string' },
                            { name: 'title', type: 'string' },
                            { name: 'netamount', type: 'string' },
                            { name: 'invoicedate', type: 'date'},
                            ],                          
                url: 'Actions/PurchaseAction.php?call=getAllPurchases',
                root: 'Rows',
                cache: false,
                beforeprocessing: function(data)
                {        
                    source.totalrecords = data.TotalRows;
                },
                filter: function()
                {
                    // update the grid and send a request to the server.
                    $("#purchaseGrid").jqxGrid('updatebounddata', 'filter');
                },
                sort: function()
                {
                    // update the grid and send a request to the server.
                    $("#purchaseGrid").jqxGrid('updatebounddata', 'sort');
                }
            };
            
            var dataAdapter = new $.jqx.dataAdapter(source);
            // initialize jqxGrid
            $("#purchaseGrid").jqxGrid(
            {
            	width: '100%',
    			height: '75%',
    			source: dataAdapter,
    			filterable: true,
    			sortable: true,
    			showfilterrow: true,
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
                  //  var exportButton = $("<div style='float: left; margin-left: 5px;'><i class='fa fa-file-excel-o'></i><span style='margin-left: 4px; position: relative;'>Export</span></div>");
                    var reloadButton = $("<div style='float: left; margin-left: 5px;'><i class='fa fa-refresh'></i><span style='margin-left: 4px; position: relative;'>Reload</span></div>");
                    


                    container.append(addButton);
                    container.append(editButton);
                    if(isSuperUser){
                    	container.append(deleteButton);
                    }
                  //  container.append(exportButton);
                    container.append(reloadButton);
                    

                    statusbar.append(container);
                    addButton.jqxButton({  width: 65, height: 18 });
                    deleteButton.jqxButton({  width: 70, height: 18 });
                    editButton.jqxButton({  width: 65, height: 18 });
                    //exportButton.jqxButton({  width: 65, height: 18 });
                    reloadButton.jqxButton({  width: 65, height: 18 });
                    // create new row.
                    addButton.click(function (event) {
                        location.href = ("createPurchase.php");
                    });
                    // update row.
                    editButton.click(function (event){
                    	var selectedrowindex = $("#purchaseGrid").jqxGrid('selectedrowindexes');
                        var value = -1;
                        indexes = selectedrowindex.filter(function(item) { 
                            return item !== value
                        })
                        if(indexes.length != 1){
                            bootbox.alert("Please Select single row for edit.", function() {});
                            return;    
                        }
                        var row = $('#purchaseGrid').jqxGrid('getrowdata', indexes);
                        $("#seq").val(row.seq);                        
                        $("#form1").submit();    
                    });
                    // delete row.
                    deleteButton.click(function (event) {
                        gridId = "purchaseGrid";
                        deleteUrl = "Actions/PurchaseAction.php?call=deletePurchase";
                        deletePurchase(gridId,deleteUrl);
                    });
                    exportButton.click(function (event) {
						filterQstr = getFilterString("purchaseGrid");
						exportCustomers(filterQstr);
                    });
                    reloadButton.click(function (event) {
                    	$("#purchaseGrid").jqxGrid({ source: dataAdapter });
                    });
                }
            });
        }

        function exportCustomers(filterString){
            $("#queryString").val(filterString);
        	$('#exportForm').submit();
        }
		
        
</script>