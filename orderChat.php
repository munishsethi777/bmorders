<?
require_once('IConstants.inc');
require_once ($ConstantsArray ['dbServerUrl'] . "Managers/OrderMgr.php");
require_once ($ConstantsArray ['dbServerUrl'] . "Managers/ChatMessageMgr.php");
require_once ($ConstantsArray ['dbServerUrl'] . "Managers/UserMgr.php");
include ("sessioncheck.php");
$messagesArr = array ();
$orderSeq = 0;
$chatLoadedTillSeq = 0;
$order = new Order();
$user = new User();
$isChatExists = 0;
$toUserSeq = 0;
if(isset($_POST["orderid"])){
	$orderSeq = $_POST["orderid"];
	$orderMgr = OrderMgr::getInstance();
	$order  = $orderMgr->findBySeq($orderSeq);
	$userMgr = UserMgr::getInstance();
	$user = $userMgr->findBySeq($order->getUserSeq());
	$chatMessageMgr = ChatMessageMgr::getInstance();
}
$fromUserSeq = SessionUtil::getInstance()->getUserLoggedInSeq();
$fromName = SessionUtil::getInstance()->getUserLoggedInName();
$toUserName = $user->getFullName();
$toUserSeq = $order->getUserSeq();
if(isset($_POST["touser"]) && !empty($_POST["touser"])){
	$toUserSeq = $_POST["touser"];
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Chat</title>
<?include "ScriptsInclude.php"?>
</head>
<body>
	<div id="wrapper">
    	<?php include("menuInclude.php")?>  
    	<div id="page-wrapper" class="gray-bg">
			<div class="row border-bottom"></div>
			<div class="row">
				<div class="col-lg-12">
					<div class="ibox">
						<div class="ibox-title">
							<nav class="navbar navbar-static-top" role="navigation"
								style="margin-bottom: 0">
								<a class="navbar-minimalize minimalize-styl-2 btn btn-primary "
									href="#"><i class="fa fa-bars"></i> </a>
								<h4 class="p-h-sm font-normal">Order Chat</h4>
							</nav>
							
						</div>
					</div>
				</div>
				<div class="ibox-content mainDiv">
					<div class="row" style="margin:0px !important">
						<div class="col-md-12" style="padding: 0px">
							<div class="chat-discussion">
		                     	<?php
								foreach ( $messagesArr as $message ) {
									$leftOrRight = "left";
									$messageAvatar = $chatUserImage;
									$name = $chattingName;
									if ($message ['fromadminseq'] == $adminSeq) {
										$leftOrRight = "right";
										$messageAvatar = $userImageName;
										$name = $userName;
									}
									$chatLoadedTillSeq = $message ['seq'];
								?>
								<div class="chat-message <?php echo $leftOrRight ?>" >
									<img class="message-avatar" src="<?php echo $messageAvatar?>"
										alt="">
									<div class="message">
										<a class="message-author" href="#"> <?php echo $name?> </a> <span
											class="message-date"> <?php echo $message['dated']?> </span> <span
											class="message-content"><?php echo $message['messagetext']?></span>
									</div>
								</div>
								<?php } ?>
		                     </div>
						</div>
					
						<div class="col-lg-12 m-t-sm">
                                <div class="chat-message-form">
                                    <div class="form-group" style="height:50px">
                                    	<form method="get" action="Actions/ChatMessageAction.php" class="sendMessageForm">
                                    		<input type="hidden" name="chatLoadedTillSeq" class="chatLoadedTillSeq"/>
                                    		<input type="hidden" name="fromuser" id="fromuserseq" value="<?php echo $fromUserSeq?>"/>
                                    		<input type="hidden" name="orderid" id="orderid" value="<?php echo $orderSeq?> "/>
                                    		<input type="hidden" name="isgroupchat" id="isgroupchat" value="0"/>
                                    		<input type="hidden" name="readon" id="readon"/>
                                    		<input type="hidden" name="touser" id="touserseq" value="<?php echo $toUserSeq?>"/>
                                    		<input type="hidden" name="call" value="sendMessageChat"/>
                                    		<div class="col-md-11" style="padding-left:0px">
                                    			<textarea class="form-control msg-input" name="message" placeholder="Enter message text"></textarea>
	                                        </div>
	                                        <div class="col-md-1" style="padding:0px">
                                    			<input style="height:100%" type="button" value="Send" class="btn btn-primary sendMessage"/>
                                    		</div>
                                        </form>
                                    </div>
                                </div>
                         </div>
                      </div>  
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<script type="text/javascript">
var userName = "<?php echo $fromName?>";
var chattingName = "<?php echo $toUserName?>";
var messasgeQueue = 0;
var fromUserSeq = "<?php echo $fromUserSeq?>";
$(document).ready(function(){
	$(".chatLoadedTillSeq").val(<?php echo $chatLoadedTillSeq?>);
	$(".sendMessage").click(function(){
		if($(".msg-input").val() != ""){
			sendMessageCall();	
		}
	});
	var $t = $('.chat-discussion');
    $t.animate({"scrollTop": $('.chat-discussion')[0].scrollHeight}, "slow");
    autoLoadMessages();
    markAsRead();
    setInterval(function(){ autoLoadMessages();}, 3000);
    $.currentDateFormat = function() {
        var d = new Date();
        var day = d.getDate();
        var month = d.getMonth() + 1;
        var year = d.getFullYear();
        if (day < 10) {
            day = "0" + day;
        }
        if (month < 10) {
            month = "0" + month;
        }
        var hours = d.getHours();
        var minutes = d.getMinutes();
        var seconds = d.getSeconds();
        if(seconds < 10){
            seconds = "0" + seconds; 
        }
            
        var date = year + ":" + month + ":" + day + " " + hours + ":" + minutes + ":" + seconds;
       // var time = formatAMPM(d);
        return date;
      };
    
})

function autoLoadMessages(){
	if(messasgeQueue < 1){
		chatLoadedTill = $(".chatLoadedTillSeq").val();
		toUserSeq = $("#touserseq").val();
		orderId = $("#orderid").val();
		$url = "Actions/ChatMessageAction.php?call=getMessagesChat&chatLoadedTillSeq="+chatLoadedTill+"&toUserSeq="+toUserSeq+"&orderid="+orderId;
		$.getJSON($url, function(data){
			if(data.success == 1){
				loadMessages(data.messages);
				markAsRead();
			}
		})
	}
}

function markAsRead(){
	orderId = $("#orderid").val();
	url = "Actions/ChatMessageAction.php?call=markAsRead&orderid="+orderId;
	$.post(url, function(data){});
}


function sendMessageCall(){
	 messasgeQueue++;
	 $formData = $(".sendMessageForm").serialize();
	 addMessage($formData);
	 $('.sendMessageForm').ajaxSubmit(function( data ){
    	 var obj = $.parseJSON(data);
    	 if(obj.success == 1){
    		$(".msg-input").val("");
    		setLastMessageSeq(obj.lastMessageSeq);
			messasgeQueue--;
	     }
     });
}

// function sendMessageCall(){
// 	messasgeQueue++;
// 	$formData = $(".sendMessageForm").serialize();
// 	addMessage($formData);
// 	$.ajax({
// 	    url: 'Actions/ChatMessageAction.php',
// 	    type: "GET",
// 	    data: $formData,
// 	    dataType: 'json',
// 	    success: function(data){
// 	    	$str="";
// 			if(data.success == 1){
// 				setLastMessageSeq(data.messages);
// 				messasgeQueue--;
// 				sendMessageNotification(data);
// 			}
			
// 	    }
// 	});
// }

function sendMessageNotification(data){
	$.ajax({
	    url: 'Actions/ChatMessageAction.php?call=sendMessageNotification',
	    type: "GET",
	    data: data,
	    dataType: 'json',
	    success: function(data){
	    	if(data.success < 1){
	    		toastr.error(message,'Failed to send message');
	    	}
	    }
	});
}



function addMessage(formData){
	$name = userName;
	$str = '<div class="chat-message right">';
	$str += '<div class="message">';
	$str += '<a class="message-author" href="#">'+ $name +'</a>';
	$str += '<span class="message-date"> '+ $.currentDateFormat() +' </span>';
	$str += '<span class="message-content">'+ $(".msg-input").val() +'</span>';
	$str += '</div>';
	$str += '</div>';
	$(".chat-discussion").append($str);	
	var $t = $('.chat-discussion');
    $t.animate({"scrollTop": $('.chat-discussion')[0].scrollHeight}, "slow");
}

function setLastMessageSeq(messageSeq){
	$(".chatLoadedTillSeq").val(messageSeq);
}

function loadMessages(messages){
	str="";
	var i = 0;
	var fromUser = 0;
	var hasReceivedMessage = false;
	$.each(messages, function(index , message){
		leftOrRight = "left";
		name = message.fromusername;
		fromUser = message.fromuser;
		if(message.fromuser == fromUserSeq){
			leftOrRight = "right";
			name = userName;
			$("#touserseq").val(message.touser);
			hasReceivedMessage = true;
		}
		str = '<div class="chat-message '+leftOrRight+'">';
		str += '<div class="message">';
		str += '<a class="message-author" href="#">'+ name +'</a>';
		str += '<span class="message-date"> '+ message.createdon +' </span>';
		str += '<span class="message-content">'+ message.message +'</span>';
		str += '</div>';
		str += '</div>';
		$(".chat-discussion").append(str);
		$(".chatLoadedTillSeq").val(message.seq);
		$(".orderid").val(message.orderid);
		var $t = $('.chat-discussion');
	    $t.animate({"scrollTop": $('.chat-discussion')[0].scrollHeight}, "slow");
	    $(".msg-input").val("");
	});
	if(!hasReceivedMessage && fromUser > 0){
		$("#touserseq").val(fromUser);
	}
}

function populateUserMessages(flag){
	if(typeof flag == 'undefined'){
		$(".messages").html('<i class="fa fa-spinner" aria-hidden="true"></i>');
	}
	var pagenum = $("#pagenum").val();
	var pagesize = $("#pagesize").val();
	var searchText = $("#searchText").val();
	$.getJSON("Actions/ChatMessageAction.php?call=getReceivedMessagesJSON&pagenum="+pagenum+"&pagesize="+pagesize+"&searchText="+searchText, function(data){
		$(".messages").html('');		
			var rows = data.Rows;
			var total = data.TotalRows;
			$(".totalMessages").html(" Inbox("+total+") ");
			if(rows.length > 0){			
				$("#totalrows").val(total)			
				str = '<table class="table table-hover table-mail"><tbody>'
				$.each(rows, function(index , row){
					if(row.isread == "0"){
						str += '<tr class="unread">';
					}else{
						str += '<tr class="read">';
					}
					str += '<td class="mail-ontact"><a href="#" onClick="javascript:viewMessageDetail('+row.id+')">'+row.from+'</a></td>';
					str += '<td class="mail-subject"><a href="#" onClick="javascript:viewMessageDetail('+row.id+')">'+row.messagetext+'</a></td>';			    
					str += '<td class="mail-date">'+ row.formateddate +'</td>'
					str += "<td class='text-left'>";
					str += "<a href='javascript:replyMessage("+row.id+")'><i class='fa fa-mail-reply' title='Reply'></i></a> ";
					str += "&nbsp; <a href='javascript:deleteMessage("+row.id+")'><i class='fa fa-trash-o' title='Delete'></i></a>";
					str += "</td></tr>";
				});
				str += '</tobody></table>';
				$(".messages").html(str);
			}else{
				$(".messages").html("<br><div class='text-center'><h4>No Message Found</h4></div>");	
			}
	})
}
function replyMessage(id){	
	$('#replyMessageModelForm').modal('show');
	$.getJSON("Actions/ChatMessageAction.php?call=getMessageActionForReply&replyToSeq="+id, function(data){
		if(data != ""){
			$("#replyingToSeq").val(data['message'][0]['userseq']);
			$("#toUserText").val(data['message'][0]['username']);
			$("#actualMessage").val(data['message'][0]['messagetext']);
			$isReplyToAdmin = data['message'][0]['isreplytoadmin'];
			if($isReplyToAdmin){
				$("#sendTo").val("admin");			
			}
		}
	})
}
function deleteMessage(seq){ 
    bootbox.confirm("Are you sure you want to delete the selected message?", function(result){ 
       if(result){
            if(seq > 0){
               $.ajax({
                   type: 'POST',
                   url: "Actions/ChatMessageAction.php",
                   data: {
                       call: "deleteMessage",
                       ids: seq,
                   },                           
                   complete: function (response) {
                      responseText = response.responseText; 
                      var obj = $.parseJSON(responseText);
                      var message = obj.message;
                      if(obj.success == 1){
                    	  populateUserMessages();
                          toastr.success(message,'Success');
                          $("#jqxgrid").jqxGrid('updatebounddata');
                      }else{
                          toastr.error(message,'Failed');
                      }
                   }
               });  
            }
        } 
});
}
</script>
