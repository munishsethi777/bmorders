<?include("SessionCheck.php");
?>
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
									<h4 class="p-h-sm font-normal"> Products Information</h4>
							</nav>
	                    </div>
	                    <div class="ibox-content">
	                        <div id="productGrid" style="margin-top:8px"></div>
	                    </div>
	                </div>
	            </div>
        	</div>
       </div>
    </div>
    <form id="form1" name="form1" method="post" action="createProduct.php">
     	<input type="hidden" id="seq" name="seq"/>
     	<input type="hidden" id="isCopy" name="isCopy"/>
   	</form>
   	<form id="exportForm" name="exportForm" method="GET" action="Actions/ProductAction.php">
     	<input type="hidden" id="call" name="call" value="exportProducts"/>
     	<input type="hidden" id="queryString" name="queryString"/>
   	</form>
   </body>
</html>

	<script type="text/javascript">
	 isSelectAll = false;
        $(document).ready(function(){
           $.getJSON("Actions/ProductAction.php?call=getFilterMenusForGrid",function( response ){
            	loadGrid(response)
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
        
        function loadGrid(menus){
            var brands = menus.brands;
            var categories = menus.categories;
            var flavours = menus.flavours;
            var measureUnits = menus.measureUnits;
			var columns = [
				{ text: 'id', datafield: 'seq' , hidden:true},
				{ text: 'Title', datafield: 'p.title', width:"30%"}, 			
				{ text: 'Brand', datafield: 'pb.title',width:"14%",filtertype: 'checkedlist',filteritems:brands},
				{ text: 'Category', datafield: 'pc.title',width:"13%",filtertype: 'checkedlist',filteritems:categories},
				{ text: 'Flavour', datafield: 'pf.title',width:"14%",filtertype: 'checkedlist',filteritems:flavours},
				{ text: 'Stock', datafield: 'stock',width:"5%"},
				{ text: 'Qty', datafield: 'quantity',width:"4%"},
				{ text: 'MsrType', datafield: 'measuringunit',width:"5%",filtertype: 'checkedlist',filteritems:measureUnits},
				{ text: 'Last Modified', datafield: 'p.lastmodifiedon',width:"15%",filtertype: 'date' ,cellsformat: 'd-M-yyyy hh:mm tt'}
            ]
           
            var source =
            {
                datatype: "json",
                id: 'id',
                pagesize: 20,
                sortcolumn: 'p.lastmodifiedon',
                sortdirection: 'desc',
                datafields: [{ name: 'seq', type: 'integer' },
                            { name: 'p.title', type: 'string' },
                            { name: 'pb.title', type: 'string'},
                            { name: 'pc.title', type: 'string' },
                            { name: 'pf.title', type: 'string' },
                            { name: 'stock', type: 'string' },
                            { name: 'quantity', type: 'string' },
                            { name: 'measuringunit', type: 'string' },
                            { name: 'p.lastmodifiedon', type: 'date' },
                            { name: 'isenabled', type: 'boolean' }
                            ],                          
                url: 'Actions/ProductAction.php?call=getAllProducts',
                root: 'Rows',
                cache: false,
                beforeprocessing: function(data)
                {        
                    source.totalrecords = data.TotalRows;
                },
                filter: function()
                {
                    // update the grid and send a request to the server.
                    $("#productGrid").jqxGrid('updatebounddata', 'filter');
                },
                sort: function()
                {
                    // update the grid and send a request to the server.
                    $("#productGrid").jqxGrid('updatebounddata', 'sort');
                }
            };
            
            var dataAdapter = new $.jqx.dataAdapter(source);
            // initialize jqxGrid
            $("#productGrid").jqxGrid(
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
                    var exportButton = $("<div style='float: left; margin-left: 5px;'><i class='fa fa-file-excel-o'></i><span style='margin-left: 4px; position: relative;'>Export</span></div>");
                    var copyButton = $("<div style='float: left; margin-left: 5px;'><i class='fa fa-copy'></i><span style='margin-left: 4px; position: relative;'>Copy</span></div>");
                    var reloadButton = $("<div style='float: left; margin-left: 5px;'><i class='fa fa-refresh'></i><span style='margin-left: 4px; position: relative;'>Reload</span></div>");
                	

                    container.append(addButton);
                    container.append(editButton);
                    container.append(deleteButton);
                    container.append(copyButton);
                    container.append(exportButton);
                    container.append(reloadButton);

                    statusbar.append(container);
                    addButton.jqxButton({  width: 65, height: 18 });
                    deleteButton.jqxButton({  width: 70, height: 18 });
                    editButton.jqxButton({  width: 65, height: 18 });
                    exportButton.jqxButton({  width: 65, height: 18 });
                    copyButton.jqxButton({  width: 65, height: 18 });
                    reloadButton.jqxButton({  width: 65, height: 18 });

                    // create new row.
                    addButton.click(function (event) {
                        location.href = ("createProduct.php");
                    });
                    // update row.
                    editButton.click(function (event){
                    	editAndCopy(0);  
                    });
                    copyButton.click(function (event) {
                    	editAndCopy(1);  
                    });
                    // delete row.
                    deleteButton.click(function (event) {
                        gridId = "productGrid";
                        deleteUrl = "Actions/ProductAction.php?call=deleteProducts";
                        deleteCustomers(gridId,deleteUrl);
                    });
                    exportButton.click(function (event) {
						filterQstr = getFilterString("productGrid");
						exportProducts(filterQstr);
               			
                    });
                    reloadButton.click(function (event) {
                    	$("#productGrid").jqxGrid({ source: dataAdapter });
                    });
                }
            });
        }
        function exportProducts(filterString){
            $("#queryString").val(filterString);
        	$('#exportForm').submit();
        }

        function editAndCopy(isCopy){
        	var selectedrowindex = $("#productGrid").jqxGrid('selectedrowindexes');
            var value = -1;
            indexes = selectedrowindex.filter(function(item) { 
                return item !== value
            })
            if(indexes.length != 1){
                bootbox.alert("Please Select single row for edit.", function() {});
                return;    
            }
            var row = $('#productGrid').jqxGrid('getrowdata', indexes);
            $("#seq").val(row.seq); 
            $("#isCopy").val(isCopy);                       
            $("#form1").submit();   
        }
		
        
</script>