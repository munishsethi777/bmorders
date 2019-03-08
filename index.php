<?php 
require_once('IConstants.inc');
//require_once($ConstantsArray['dbServerUrl'] ."Utils/SessionUtil.php");
//$session = SessionUtil::getInstance();
//$bool = $session->isSessionAdmin();
//if($bool == true){
//	header("location: showReports.php");
//	die;
//}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Administration - Ordering</title>
        <?include "ScriptsInclude.php"?>
        <script type="text/javascript">
            $(document).ready(function () {
                //$('.form-control').jqxInput({  });
                $('#loginForm').jqxValidator({
                    rules: [
                           { input: '#usernameInput', message: 'Email is required!', action: 'keyup, blur', rule: 'required' },
                           { input: '#usernameInput', message: 'Email must be less than 250 characters!', action: 'keyup, blur', rule: 'length=0,250' },

                           { input: '#passwordInput', message: 'Password is required!', action: 'keyup, blur', rule: 'required' },
                           { input: '#passwordInput', message: 'Password must be less than 250 characters!', action: 'keyup, blur', rule: 'length=0,250' },
                           ]
                });
                //$('#loginButton').jqxButton({ width: 100, height: 25 });
                $("#loginButton").click(function (e) {
                    validateAndSave(e,this);
                });
                $("#loginForm").on('validationSuccess', function () {
                    $("#loginForm-iframe").fadeIn('fast');
                });
                $('#usernameInput').keypress(function (e) {
                    btn = $("#loginButton")[0];
                    if (e.which == 13) {
                        validateAndSave(e,btn);
                        return false;
                    }
                })
                $('#passwordInput').keypress(function (e) {
                    btn = $("#loginButton")[0];
                    if (e.which == 13) {
                        validateAndSave(e,btn);
                        return false;
                    }
                })
            });

            function validateAndSave(e,btn){
                var validationResult = function (isValid) {
                    if (isValid) {
                        submitLogin(e,btn);
                    }
                }
                $('#loginForm').jqxValidator('validate', validationResult);
            }
            function submitLogin(e,btn){
                var l = Ladda.create(btn);
                l.start();
                $formData = $("#loginForm").serializeArray();
                $.getJSON( "Actions/UserAction.php?call=loginUser", $formData,function( data ){
                    l.stop();
                    if(data.success == 0){
                        toastr.error("Invaid username or Password",'Login Failed');
                    }else{
                        window.location = "dashboard.php";
                    }
                });
            }
            </script>
    </head>
<body class="gray-bg">
<div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
        	<img src="images/newlogo.jpg" style="width:200px;height:auto;margin-bottom:20px;">
            <h3 style="line-height: 20px">Welcome to Batra Marketing Administrator Area</h3>
            <p>Login, To see it in action.</p>
            <form class="form-horizontal" id="loginForm" method="POST" name="loginForm">
                  <div class="form-group">
                  		<input type="text" name="username" class="form-control" id="usernameInput" placeholder="EmailId" value="munishsethi777@gmail.com">
                  </div>
                  <div class="form-group">
                      <input type="password" name="password" class="form-control" id="passwordInput" placeholder="Password" value="a">
                  </div>

                  <div class="form-group">
                        <button class="btn btn-primary block full-width m-b ladda-button" data-style="expand-right" id="loginButton" type="button">
                            <span class="ladda-label">Login</span>
                        </button>
                    </div>
                </form>
            
            
            <p class="m-t"> <small>Login Credentials/Rights Reserved</small> </p>
        </div>
    </div>


</body>
</html>



