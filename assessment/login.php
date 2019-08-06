<?PHP error_reporting(1);
$path = $_SERVER['SERVER_NAME']."/GetSetGo/";
require_once("./include/membersite_config.php");
if($fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("controller");
    exit;
}

if(isset($_POST['submitted']))
{  
   if($fgmembersite->Login())
   {    
        $fgmembersite->RedirectToURL("controller/$_SESSION[role] ");
   }
}

?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Assessment Login Evaluator</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
<!--===============================================================================================-->  
    <link rel="icon" type="image/png" href="../img/favicon.ico"/>
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../loginassets/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../loginassets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../loginassets/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../loginassets/vendor/animate/animate.css">
<!--===============================================================================================-->  
    <link rel="stylesheet" type="text/css" href="../loginassets/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../loginassets/vendor/select2/select2.min.css">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../loginassets/css/util.css">
    <link rel="stylesheet" type="text/css" href="../loginassets/css/main.css">
<!--===============================================================================================-->
<style type="text/css">
.container-login100::before {   
    background: -webkit-linear-gradient(bottom,  #3689dd, #fe0909) !important;
    opacity: 0.9;
}
.fade {
    opacity: 1 !important;
}
</style>
</head>
<body>
    
    <div class="limiter">
                <div class="container-login100" style="background-image: url('../loginassets/images/img1.jpg');">
                <p style="top: 16px;right: 18px;position: fixed;color:#fff"><a href="../" style="color:#fff"><i class="fa fa-long-arrow-left"></i> Back to Home</a></p>
            <div class="wrap-login100 p-t-190 p-b-30">
                <form class="login100-form validate-form" action='<?php echo $fgmembersite->GetSelfScript(); ?>' name='login' method="post">
                    <input type='hidden' name='submitted' id='submitted' value='1'/>
                    <div class="login100-form-avatar">
                        <img src="../loginassets/images/parents.png" alt="AVATAR" style="background:#FFEB3B">
                    </div>

                    <span class="login100-form-title p-t-20 p-b-45">
                        Sign In
                    </span>
                    <?php if(!empty($fgmembersite->GetErrorMessage())){ ?>
                        <div class="alert alert-danger alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                       </strong> <?php echo $fgmembersite->GetErrorMessage(); ?>
                      </div>
                    <?php } ?>
                    <div class="wrap-input100 validate-input m-b-10" data-validate = "Username is required">
                        <input class="input100" type="text" name="username" placeholder="Username" autocomplete="off">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-10" data-validate = "Password is required">
                        <input class="input100" type="password" name="password" placeholder="Password" autocomplete="off">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn p-t-10">
                        <button class="login100-form-btn" style="background:#f60707 !important;">
                            Login
                        </button>
                    </div>

                    <div class="text-center w-full p-t-25 p-b-230">
                        <a href="#" class="txt1">
                            Forgot Username / Password?
                        </a>
                    </div>

                    <div class="text-center w-full">
                        <a class="txt1" href="#">
                            Create new account
                            <i class="fa fa-long-arrow-right"></i>                      
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    

    
<!--===============================================================================================-->  
    <script src="../loginassets/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
    <script src="../loginassets/vendor/bootstrap/js/popper.js"></script>
    <script src="../loginassets/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
    <script src="../loginassets/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
    <script src="../loginassets/js/main.js"></script>

</body>
</html>