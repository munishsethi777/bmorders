<?include("SessionCheck.php");?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Messages</title>
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
									<h4 class="p-h-sm font-normal"> Chat Information</h4>
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
     	<input type="hidden" id="isreadonly" name="isreadonly"/>
     	<input type="hidden" id="chatthreadseq" name="chatthreadseq"/>
     	<input type="hidden" id="touser" name="touser"/>
   	</form>
   	<form id="exportForm" name="exportForm" method="GET" action="Actions/OrderAction.php">
     	<input type="hidden" id="call" name="call" value="exportOrders"/>
     	<input type="hidden" id="queryString" name="queryString"/>
   	</form>
   </body>
</html>

	<script type="text/javascript">
	    $(document).ready(function(){
           $.getJSON("Actions/CustomerAction.php?call=getCustomerTitlesForFilter",function( response ){
            	loadGrid(response.customers)
           })
        });
        function loadGrid(customers){
        	var chaticons = function (row, columnfield, value, defaulthtml, columnproperties) {
                data = $('#orderGrid').jqxGrid('getrowdata', row);
                if(data["haschat"] == "1"){
					return "<div class='datacell'>" + data['orderid'] + " <a href='javascript:startChat("+data['orderid']+",\""+ data['chatthreadseq']+"\")'><i class='fa fa-whatsapp'></i></a>" +"</div>";
                }
                return defaulthtml;                   
            }
           var columns = [
				{ text: 'id', datafield: 'seq',hidden:true },
				{ text: 'Order No.', datafield: 'orderid',width:"15%",cellsrenderer:chaticons},
				{ text: 'From', datafield: 'fullname',width:"17%"},
				{ text: 'To', datafield: 'touser',width:"17%",sortable:false,$filterable:false},
				{ text: 'Company', datafield: 'customers.title', width:"30%",filtertype: 'checkedlist',filteritems:customers}, 			
				{ text: 'Last Message Date', datafield: 'chatmessages.createdon',width:"20%",filtertype: 'range' ,cellsformat: 'd-M-yyyy hh:mm tt'}
            ]
           
            var source =
            {
                datatype: "json",
                id: 'id',
                pagesize: 20,
                sortcolumn: 'chatmessages.createdon',
                sortdirection: 'desc',
                datafields: [{ name: 'seq', type: 'integer' },
                            { name: 'orderid', type: 'integer' },
                            { name: 'chatthreadseq', type: 'integer' },
                            { name: 'fullname', type: 'string' },
                            { name: 'touser', type: 'string' },
                            { name: 'customers.title', type: 'string' },
                            { name: 'chatmessages.createdon', type: 'date' },
                            { name: 'haschat', type: 'integer' },
                            { name: 'isreadonly', type: 'integer' }
                            ],                          
                url: 'Actions/ChatMessageAction.php?call=getAllChats',
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
                    var deleteButton = $("<div style='float: left; margin-left: 5px;'><i class='fa fa-times-circle'></i><span style='margin-left: 4px; position: relative;'>Delete</span></div>");
                    var chatButton = $("<div style='float: left; margin-left: 5px;'><i class='fa fa-whatsapp'></i><span style='margin-left: 4px; position: relative;'>Chat</span></div>");
                    var exportButton = $("<div style='float: left; margin-left: 5px;'><i class='fa fa-file-excel-o'></i><span style='margin-left: 4px; position: relative;'>Export</span></div>");
                    var reloadButton = $("<div style='float: left; margin-left: 5px;'><i class='fa fa-refresh'></i><span style='margin-left: 4px; position: relative;'>Reload</span></div>");
                    

                    
                    container.append(chatButton);
                   // container.append(exportButton);
                   // container.append(deleteButton);
                    container.append(reloadButton);

                    statusbar.append(container);
                    deleteButton.jqxButton({  width: 70, height: 18 });
                    chatButton.jqxButton({  width: 80, height: 18 });
                    exportButton.jqxButton({  width: 70, height: 18 });
                    reloadButton.jqxButton({  width: 65, height: 18 });

                    // create new row.
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
                        startChat(row.orderid,row.chatthreadseq,row.isreadonly);
                    });
                    // update row.
                    reloadButton.click(function (event) {
                    	$("#orderGrid").jqxGrid({ source: dataAdapter });
                    });
                    exportButton.click(function (event) {
						filterQstr = getFilterString("orderGrid");
						exportOrders(filterQstr);
                    });
                }
            });
        }
        function startChat(orderid,chatthreadseq,isreadonly){
        	$("#form2").attr("action", "orderChat.php");        
       		$("#orderid").val(orderid);
       		$("#isreadonly").val(isreadonly);
       		$("#chatthreadseq").val(chatthreadseq) 
            $("#form2").submit();
        }  
</script>