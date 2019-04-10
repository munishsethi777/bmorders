<?include("SessionCheck.php");?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
									<h4 class="p-h-sm font-normal"> Administrator Dashboard</h4>
							</nav>
	                      
	                    </div>
	                    <div class="ibox-content">
	                    <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Orders</h5>
                            </div>
                            <div class="ibox-content">
	                             <div class="row pull-right">
	                            	<div class="col-lg-12 text-muted p-xs">
	                            		<label>Users</label>
	                            		<select class="usersDD" id="usersDD">
	                                    	<option value='0'>All Users</option>
	                                    </select>
	                             		<label>Last</label>
	                            		<select  id="daysDD">
	                                    	<option value="7">7</option>
	                                    	<option value="10">10</option>
	                                    	<option value="15">15</option>
	                                    	<option value="30">30</option>
	                                    </select>
	                                    <label>Days</label>
	                             		<button type="button" onclick="populateOrdersNew()" class="btn btn-primary btn-xs">Show</button>
	                             	</div>
	                             </div>
	                                <div class="row">
		                                <div class="col-lg-12">
		                                   <div id='chartContainer' style="height:400px">
		                                </div>
	                                </div>
                                </div>

                            </div>
                        </div>
                    </div>
	                        <div class="row">
			                    <div class="col-lg-4">
			                        <div class="ibox float-e-margins">
			                            <div class="ibox-title">
			                                <h5>Messages</h5>
			                                <div class="ibox-tools">
			                                    <a class="collapse-link">
			                                        <i class="fa fa-chevron-up"></i>
			                                    </a>
			                                    <a class="close-link">
			                                        <i class="fa fa-times"></i>
			                                    </a>
			                                </div>
			                            </div>
			                            <div class="ibox-content ibox-heading">
			                                <h3><i class="fa fa-envelope-o"></i> New messages</h3>
			                               <a href="showOrderChats.php"> <small><i class="fa fa-tim"></i> You have <label id="totalMessageLabel" >0</label> new messages</small></a>
			                            </div>
			                            <div class="ibox-content">
				                             <div class="feed-activity-list" id="messagesDiv">
				                             </div>
				                         </div>
				                    </div>
				                </div>
				                <div class="col-lg-8">
                            <div class="ibox">
			       				<div class="ibox-content no-padding" style="border:0px">
			       				<div class="ibox-title">
			                                <h5>Expected Payments</h5>
			                                <div class="ibox-tools">
			                                    <a class="collapse-link">
			                                        <i class="fa fa-chevron-up"></i>
			                                    </a>
			                                    <a class="close-link">
			                                        <i class="fa fa-times"></i>
			                                    </a>
			                                </div>
			                            </div>
                                    <div class="table-responsive" id="expectedPaymentDiv">
                                        <table class="table table-striped">
                                            <tbody>
                                            <tr>
                                            	<th>Date</th>
                                            	<th>Amount</th>
                                                <th>Order#</th>
                                                <th>Customer</th>
                                            </tr>
                                            </tbody>
                                        </table>
                                        
                                    </div>
									<div class="pull-right">
	            							<a href="showOrderPayments.php"><small>more</small></a>
	            					</div>
                                </div>
                            </div>
				          </div>
				       
                    </div>
	                </div>
	            </div>
        	</div>
       </div>
    </div>
    <form id="form1" name="form1" method="post" action="adminEditBooking.php">
     	<input type="hidden" id="seq" name="seq"/>
     	<input type="hidden" id="isView" name="isView" value="0"/>
   	</form>
   </body>
   
</html>

	<script type="text/javascript">
        $(document).ready(function(){
        	populateUnreadMessages();
        	populateOrdersNew();
        	populateUsers();
        	populateRecentOrders();
        	populateExpectedPayments();
        });
        function populateExpectedPayments(){
           
               $("#expectedPaymentDiv").html("");
               var str = "";
	           $.getJSON("Actions/OrderPaymentDetailAction.php?call=getRecentExpectedPayments",function( payments ){
	        	   var html = '<table class="table table-striped">';
	                html += '<tbody>';
	            	html += '<tr><th>Date</th><th>Amount</th><th>Order#</th><th>Customer</th></tr>';
	            	$.each(payments, function(index , payment){
	            		str += '<tr>';
	            		str += '<td>'+payment.expectedon+'</td>';
	            		str += '<td>'+payment.amount+'</td>';
	            		str += '<td>'+payment.orderseq+'</td>';
	            		str += '<td>'+payment.title+'</td>';
	            		str += '</tr>';
	            	});
	            	html += str;
	            	html += '</tbody></table>';
	            	$("#expectedPaymentDiv").html(html);
	           });
           
        }
        function populateUnreadMessages(){
            var html = ""
            $("messagesDiv").html(html);
            $.getJSON("Actions/ChatMessageAction.php?call=getAllUnreadMessages",function( messages ){
            	$("#totalMessageLabel").text(messages.length)
        		$.each(messages, function(index , message){
            		html += '<div class="feed-element">';
  					html += '<div>';
                    html += '<strong'+message.fullname+'</strong>';
                    html += '<div>'+message.message+'</div>';
                    html += '<small class="text-muted">'+message.createdon+'</small>';
                	html += '</div>';
            		html += '</div>';
            	});
            	$("#messagesDiv").html(html);
        	})
        }
        function populateUsers(){
            var html = ""
            $("messagesDiv").html(html);
        	$.getJSON("Actions/UserAction.php?call=getAllUsersForDD",function( users ){
            	$.each(users, function(key, value) {   
				     $('.usersDD')
				         .append($("<option></option>")
				                    .attr("value",value.seq)
				                    .text(value.fullname)); 
				});	
        })
        }

        function populateOrdersNew(){
        	var userSeq = $("#usersDD").val()
            var days = $("#daysDD").val()
            $("#chartContainer").html('<i class="fa fa-spinner"></i>');
        	$.getJSON("Actions/OrderAction.php?call=getOrderAndPaymentForDashboard&userSeq="+userSeq + "&days="+days,function( response ){
            		var orderAndPayments = response.orders;
            		var sampleData = [];
            		$.each(orderAndPayments, function(key, orderAndPayment) {
                		var order =  orderAndPayment.order;
                		var payment = orderAndPayment.payment;
                		
                		var orderAmount = 0
                		if(order != null){
                			orderAmount = parseInt(order.amount);
                		}
                		var paymentAmount = 0
                		if(payment != null){
                			paymentAmount = parseInt(payment.amount)
                		}
                		var obj = { Date: key, Orders: orderAmount, Payments: paymentAmount }	
                		sampleData.push(obj);
               		});
        	              	var settings = {
        	              		title: "Order & Payment Details ",
        	              		description: "For Last "+days+" Days By All Users",
        	              		enableAnimations: true,
        	              		showLegend: true,
        	              		padding: { left: 5, top: 5, right: 5, bottom: 5 },
        	              		titlePadding: { left: 90, top: 0, right: 0, bottom: 10 },
        	              		source: sampleData,
        	              		colorScheme: 'scheme17',
        	              		borderLineColor: '#888888',
        	              		xAxis:
        	              		{
        	              			dataField: 'Date',
        	              			tickMarks:
        	              			{
        	              				visible: true,
        	              				interval: 1,
        	              				color: '#888888'
        	              			},
        	              			gridLines:{
        	              				visible: false,
        	              				interval: 1,
        	              				color: '#888888'
        	              			},
        	              			axisSize: 'auto'
        	              		},
        	              		valueAxis:
        	              		{
        	              			visible: true,
        	              			minValue: 0,
        	              			title: { text: 'Amount' },
        	              			tickMarks: {color: '#888888'},
        	              			gridLines: {color: '#888888'},
        	              			axisSize: 'auto'
        	              		},
        	              		seriesGroups:
        	              		[
        	              		{
        	              			type: 'splinearea',
        	              			series: [
        	              			{ dataField: 'Payments', displayText: 'Payments', opacity: 0.7 }
        	              			]
        	              		},
        	              		{
        	              			type: 'stackedcolumn',
        	              			columnsGapPercent: 50,
        	              			seriesGapPercent: 5,
        	              			series: [
        	              				{ dataField: 'Orders', displayText: 'Orders' }
        	              			]
        	              		}
        	              		]
        	              	};
        	              	// setup the chart
        	              	$('#chartContainer').jqxChart(settings);
        	});
        }
        
        function populateOrders(){
            var userSeq = $("#usersDD").val()
            var days = $("#daysDD").val()
            $("#flot-dashboard-chart").html('<i class="fa fa-spinner"></i>');
        	$.getJSON("Actions/OrderAction.php?call=getOrderAndPaymentForDashboard&userSeq="+userSeq + "&days="+days,function( orderAndPayments ){
            		var orders = orderAndPayments.orders;
            		var payments = orderAndPayments.payments;
            		var data2 = [];
            		var data3 = []
            		$.each(orders, function(key, order) {
                		var amount = 0
                		$.each(order, function(key, detail) {
                			amount += parseInt(detail.totalamount);
                		}); 
                		var orderData = [gd(key),amount];
                		data2.push(orderData);
            		});
            		$.each(payments, function(key, payment) {
                		var amount = 0
                		$.each(payment, function(key, detail) {
                			amount += parseInt(detail.amount);
                		}); 
                		var paymentData = [gd(key),amount];
                		data3.push(paymentData);
            		});
            		       var dataset = [
            		                {
            		                    label: "Total Sale Amount",
            		                    data: data2,
            		                    color: "#1ab394",
            		                    bars: {
            		                        show: true,
            		                        align: "center",
            		                        barWidth: 24 * 60 * 60 * 600,
            		                        lineWidth:0
            		                    }

            		                }, {
            		                    label: "Payments",
            		                    data: data3,
            		                    yaxis: 2,
            		                    color: "#1C84C6",
            		                    lines: {
            		                        lineWidth:1,
            		                            show: true,
            		                            fill: true,
            		                        fillColor: {
            		                            colors: [{
            		                                opacity: 0.2
            		                            }, {
            		                                opacity: 0.4
            		                            }]
            		                        }
            		                    },
            		                    splines: {
            		                        show: false,
            		                        tension: 0.6,
            		                        lineWidth: 1,
            		                        fill: 0.1
            		                    },
            		                }
            		            ];


            		            var options = {
            		                xaxis: {
            		                    mode: "time",
            		                    tickSize: [3, "day"],
            		                    tickLength: 0,
            		                    axisLabel: "Date",
            		                    axisLabelUseCanvas: true,
            		                    axisLabelFontSizePixels: 12,
            		                    axisLabelFontFamily: 'Arial',
            		                    axisLabelPadding: 10,
            		                    color: "#d5d5d5"
            		                },
            		                yaxes: [{
            		                    position: "left",
            		                    color: "#d5d5d5",
            		                    axisLabelUseCanvas: true,
            		                    axisLabelFontSizePixels: 12,
            		                    axisLabelFontFamily: 'Arial',
            		                    axisLabelPadding: 3
            		                }, {
            		                    position: "right",
            		                    clolor: "#d5d5d5",
            		                    axisLabelUseCanvas: true,
            		                    axisLabelFontSizePixels: 12,
            		                    axisLabelFontFamily: ' Arial',
            		                    axisLabelPadding: 67
            		                }
            		                ],
            		                legend: {
            		                    noColumns: 1,
            		                    labelBoxBorderColor: "#000000",
            		                    position: "nw"
            		                },
            		                grid: {
            		                    hoverable: false,
            		                    borderWidth: 0
            		                }
            		            };

            		            var previousPoint = null, previousLabel = null;

            		            $.plot($("#flot-dashboard-chart"), dataset, options);
        	});
        }
        function populateRecentOrders(){
        	var userSeq = $("#usersDD1").val()
            var days = $("#daysDD1").val()
            $("#flot-dashboard5-chart").html('<i class="fa fa-spinner"></i>');
        	$.getJSON("Actions/OrderAction.php?call=getRecentOrdersForDashboard&userSeq="+userSeq + "&days="+days,function( orderAndPayments ){
            		var orderArr = orderAndPayments.orders;
            		var mainData = [];
            		$.each(orderArr, function(key, orders) {
            			var data1 = [];
            			var $i = 0;
	            		$.each(orders, function(key, order) {
	                		var orderCount = 0
	                		$.each(order, function(key, detail) {
	                			orderCount++;
	                		}); 
	                		var orderData = [$i,orderCount];
	                		data1.push(orderData);
	                		$i++;
	            		});
	            		mainData.push(data1);
            		});
            		var data1 = [
             	                [0,4],[1,8],[2,5],[3,10],[4,4],[5,16],[6,5],[7,11],[8,6],[9,11],[10,20],[11,10],[12,13],[13,4],[14,7],[15,8],[16,12]
             	            ];
             	            var data2 = [
             	                [0,0],[1,2],[2,7],[3,4],[4,11],[5,4],[6,2],[7,5],[8,11],[9,5],[10,4],[11,1],[12,5],[13,2],[14,5],[15,2],[16,0]
             	            ];
             	            $("#flot-dashboard5-chart").length && $.plot($("#flot-dashboard5-chart"), mainData,
             	                    {
             	                        series: {
             	                            lines: {
             	                                show: false,
             	                                fill: true
             	                            },
             	                            splines: {
             	                                show: true,
             	                                tension: 0.4,
             	                                lineWidth: 1,
             	                                fill: 0.4
             	                            },
             	                            points: {
             	                                radius: 0,
             	                                show: true
             	                            },
             	                            shadowSize: 2
             	                        },
             	                        grid: {
             	                            hoverable: true,
             	                            clickable: true,

             	                            borderWidth: 2,
             	                            color: 'transparent'
             	                        },
             	                        colors: ["#1ab394", "#1C84C6","#1C84C6","#1C84C6","#1C84C6","#1C84C6","#1C84C6","#1C84C6","#1C84C6"],
             	                        xaxis:{
                 	                          },
             	                        yaxis: {
             	                        },
             	                        tooltip: false
             	                    }
             	            );
        	});
        	 
        }
        function gd(date) {
            var dataArr = date.split(",");
            var year = parseInt(dataArr[0]);
            var month = parseInt(dataArr[1]);
            var day = parseInt(dataArr[2]);
            return new Date(year, month - 1, day).getTime();
        }
       
</script>