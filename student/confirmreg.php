<?PHP
require_once("./include/membersite_config.php");
$path="http://localhost/new/";

if(isset($_GET['code']))
{
   if($fgmembersite->ConfirmUser())
   {
        $fgmembersite->RedirectToURL("thank-you.html");
   }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html lang="en"> 
<head> 
<link rel="shortcut icon" href="http://induseducation.in/favicon.ico" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<TITLE>Indus Education</TITLE>
<script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
<style>
input{
	margin:auto;
}
</style>
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
</head>
<body style="background:url('<?php echo $path; ?>images/background1.png');">
<div class="row-fluid" id="header-pane" style="background-color: #306bcf;padding-top:6px;padding-bottom:6px;border-top:2px solid #000;box-shadow:0px 2px 2px 2px #888888;">
            <div id="top_home" class="clear">
                <header class="clear">
                    
                    <a href="index.php"><img src="<?php echo $path; ?>images/77.gif" ></a>
                    
                   
                </header>
            </div>
        </div>

    <script type='text/javascript' src='<?php echo $path; ?>javascript/gen_validatorv31.js'></script>
   
  <link rel="stylesheet" href="<?php echo $path; ?>validate/css/validationEngine.jquery.css" type="text/css"/>

	<script src="<?php echo $path; ?>validate/js/jquery-1.8.2.min.js" type="text/javascript">
	</script>
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

<div class="row-fluid container" id="showcase-pane">
        	<div id="login-signup-container" class="container">
                <div id="login-Signup-box">
                	<div id="login-box-inner" style="text-align: center;padding-top:100px;">
                    	      

                        <span style="font-size:35px; font-family: 'Trebuchet MS', Arial, Helvetica, sans-serif">Confirm Registration</span>
                        <hr>
                        
                        
                        <div class="form-horizontal" style="text-align: center;">

<p>
Please enter the confirmation code in the box below
</p>

<!-- Form Code Start -->
<div id='fg_membersite'>
<form id='confirm' action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='get' accept-charset='UTF-8' onsubmit="return jQuery(this).validationEngine('validate');">

<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
<div>
    <label for='code' >Confirmation Code:<font color="#ff0000">*</font> </label>
    <input type='text' name='code' id='code' maxlength="50" class="validate[required] text-input" /><br/>
    <span id='register_code_errorloc' class='error'></span>
</div>
<p></p>
<div>
    <input type='submit' name='Submit' value='Confirm' class="btn btn-primary" />
</div>

</form>
<!-- client-side Form Validations:
Uses the excellent form validation script from JavaScript-coder.com-->

<script type='text/javascript'>
// <![CDATA[

    var frmvalidator  = new Validator("confirm");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();
    frmvalidator.addValidation("code","req","Please enter the confirmation code");

// ]]>
</script>
</div>
<!--
Form Code End (see html-form-guide.com for more info.)
-->
</div>
                </div>
			</div>
	    </div> 
</div>
<div id="wrapper" style="width:100%;height:24px;position: fixed;bottom: 0;background-color: #306bcf;border-top:2px solid #000;box-shadow:0px 2px 2px 2px #888888;">
 <div id="footer1"> 
		<p align='center' style="padding:3px;">copy right &copy; 2013 Indus Education. All rights reserved.</p>
		     </div>
     </div>
</body>
<html> 	