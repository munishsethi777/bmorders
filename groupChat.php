<?
require_once('IConstants.inc');
require_once ($ConstantsArray ['dbServerUrl'] . "Managers/ChatMessageMgr.php");
require_once ($ConstantsArray ['dbServerUrl'] . "Managers/UserMgr.php");
include ("sessioncheck.php");
$messagesArr = array ();
$user = new User();
$isChatExists = 0;
$toUserSeq = 0;
$fromUserSeq = SessionUtil::getInstance()->getUserLoggedInSeq();
$fromName = SessionUtil::getInstance()->getUserLoggedInName();
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
					<div class="col-md-12" style="padding: 0px">
						<div class="chat-discussion">
	                     	
	                     </div>
					</div>
					<div class="col-lg-12">
                                <div class="chat-message-form">
                                    <div class="form-group" style="height:50px">
                                    	<form method="get" action="Actions/ChatMessageAction.php" class="sendMessageForm">
                                    		<input type="hidden" name="chatLoadedTillSeq" class="chatLoadedTillSeq" value="0"/>
                                    		<input type="hidden" name="fromuser" id="fromuserseq" value="<?php echo $fromUserSeq?>"/>
                                    		<input type="hidden" name="orderid" id="orderid" value="0 "/>
                                    		<input type="hidden" name="isgroupchat" id="isgroupchat" value="1"/>
                                    		<input type="hidden" name="readon" id="readon" value="0"/>
                                    		<input type="hidden" name="touser" id="touserseq" value="0"/>
                                    		<input type="hidden" name="call" value="sendMessageChat"/>
                                    		<div class="col-md-11">
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
</body>
</html>
<script type="text/javascript">
var userName = "<?php echo $fromName?>";
var messasgeQueue = 0;
var fromUserSeq = "<?php echo $fromUserSeq?>";
$(document).ready(function(){
	$(".sendMessage").click(function(){
		if($(".msg-input").val() != ""){
			sendMessageCall();	
		}
	});
	var $t = $('.chat-discussion');
    $t.animate({"scrollTop": $('.chat-discussion')[0].scrollHeight}, "slow");
    autoLoadMessages();
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
        return date;
      };
    
})
function autoLoadMessages(){
	if(messasgeQueue < 1){
		chatLoadedTill = $(".chatLoadedTillSeq").val();
		toUserSeq = $("#touserseq").val();
		orderId = $("#orderid").val();
		$url = "Actions/ChatMessageAction.php?call=getGroupMessagesChat&chatLoadedTillSeq="+chatLoadedTill;
		$.getJSON($url, function(data){
			if(data.success == 1){
				loadMessages(data.messages);
			}
		})
	}
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
	$.each(messages, function(index , message){
		leftOrRight = "left";
		name = message.fromusername;
		if(message.fromuser == fromUserSeq){
			leftOrRight = "right";
			name = userName;
			$("#touserseq").val(message.touser);
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
}
</script>

