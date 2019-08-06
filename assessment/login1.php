<?PHP
$path="http://www.induseducation.in/";
error_reporting(0);
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


<!DOCTYPE HTML>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
   <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta charset="utf-8">
    <title>Assessment Login Evaluator</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
<link rel="stylesheet" href="<?php echo $path; ?>validate/css/validationEngine.jquery.css" type="text/css"/>
	<script src="<?php echo $path; ?>javascript/jquery.min.js"></script>
	<script src="<?php echo $path; ?>validate/js/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8">
	</script>
	<script src="<?php echo $path; ?>validate/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8">
	</script>
	<script>
		function validate() {
			
		}
		function formSuccess() {
			alert('Success!');
		}
		
		function formFailure() {
			alert('Failure!');
		}
		jQuery(document).ready(function(){
			// binds form submission and fields to the validation engine
			jQuery("#formID").validationEngine({
				onFormSuccess:formSuccess,
				onFormFailure:formFailure
			});
		});

		/**
		*
		* @param {jqObject} the field where the validation applies
		* @param {Array[String]} validation rules for this field
		* @param {int} rule index
		* @param {Map} form options
		* @return an error string if validation failed
		*/
		function checkHELLO(field, rules, i, options){
			if (field.val() != "HELLO") {
				// this allows to use i18 for the error msgs
				return options.allrules.validate2fields.alertText;
			}
		}
	</script> 
    
   </head>
<body style="background:url('<?php echo $path; ?>images/background1.png');">
<div class="row-fluid" id="header-pane" style="background-color: #B20EFF;padding-top:6px;padding-bottom:6px;border-top:2px solid #000;box-shadow:0px 5px 5px 5px #888888;">
            <div id="top_home" class="clear">
                <header class="clear">
                    
                    <a href="index.php"><img src="<?php echo $path; ?>images/77.gif" ></a>
                    
                   
                </header>
            </div>
        </div>
<link rel="STYLESHEET" type="text/css" href="<?php echo $path; ?>css/style.css" />
    <script type='text/javascript' src='<?php echo $path; ?>javascript/gen_validatorv31.js'></script>
    <link rel="STYLESHEET" type="text/css" href="<?php echo $path; ?>css/bootstrap.min.css" />
    
      <link rel="STYLESHEET" type="text/css" href="<?php echo $path; ?>css/bootstrap.min.css" /> 
	<div class="row-fluid container" id="showcase-pane">
        <div id="login-signup-container" class="container">
             <div id="login-Signup-box" style="padding-top: 5px;">
             
             <div style="margin-bottom: 50px;text-align: center !important;"><!--<p align="center" style="font-size: 80px;color:#ff0013;font-weight: bold;">Login </p>--></div>

    <div style="background-color: #B20EFF;border: 0px solid #000;width:380px;margin: auto;border-radius:7px;box-shadow: 10px 10px 5px #888888;">
	
        <div id="login-wrapera" style="width:350px;padding:20px;margin: auto;">
            <form id="FormID" class="form login-form" action='<?php echo $fgmembersite->GetSelfScript(); ?>' name='login' method="post" autocomplete="off" style="width:290px;margin: auto;" onSubmit="return jQuery(this).validationEngine('validate');">
             <h2 style="color: #fff;text-align: center;">Evaluator Login</h2>
                 
                <div class="body">
                <p align="center"><img src="<?php echo $path; ?>images/parents.png" style="margin-top: -20px;"/>
                
                 <br /><font color="#000"><?php echo $fgmembersite->GetErrorMessage(); ?></font></p>	
				<input type='hidden' name='submitted' id='submitted' value='1'/>
				
                   <p>
                    <input placeholder="Enter Username" name="username" type="text" value='' style="width:280px !important;height:30px !important;" class="validate[required] text-input" >
                    </p>
                    
                   <p> <input placeholder="Enter Password" name="password" type="password" style="width:280px !important;height:30px !important;" class="validate[required] text-input" ></p>
                </div>
            
                <div class="footer">
                    <label class="checkbox inline" style="width:120px;">
                        <input type="checkbox" name="remember" value="yes" <?php if($_COOKIE['username']!=''){ ?> checked <?php } ?>> <b>Remember me</b>
                    </label>
                                 <button type="submit" class="btn btn-success" name="submit" style="float: right;"><strong>Login</strong></button>
			
                </div>
            
            </form>
        </div></div>
		
</div>
                    </div>
                </div>
			</div>
	    </div> 
<div id="wrapper" style="height:25px;background-color: #B20EFF;position: fixed;bottom: 0;border-top:2px solid #000;box-shadow:0px 2px 2px 2px #888888;">
 <div id="footer1"> 
		<p align='center' style="padding:3px;"> Copyright &copy; 2013 Indus Education. All Rights Reserved.</p>
		     </div>
     </div>
