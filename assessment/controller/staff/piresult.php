<?PHP //session_start();
error_reporting(0);
require_once("../../include/membersite_config.php");
require_once("../../include/student_config.php");
if(!$fgmembersite->CheckLogin())
{
 $fgmembersite->RedirectToURL("../login.php");
    exit;
}
if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}
//echo $_POST['submitted'];
if(isset($_POST['submitted']))
{
   if($fgstudent->AddresultPi())
   {
   	  
        $fgstudent->RedirectToURL("search.php");
   }
}
if($_POST['student']==''){
	$fgmembersite->RedirectToURL("index.php");
}
$var = $_POST['prepfeedback'];
$prepfeedback=implode(",",$var);
$var1 = $_POST['communifeedback'];
$communifeedback=implode(",",$var1);
?>

      <title>Change password</title>
      <link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css" />
      <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
      <link rel="STYLESHEET" type="text/css" href="style/pwdwidget.css" />
      <script src="scripts/pwdwidget.js" type="text/javascript"></script>
         <script type="text/javascript" src="../../js/jquery-1.9.1.min.js"></script>
	    <script type="text/javascript" src="../../js/jquery-ui.js"></script>
	    <script type="text/javascript" src="../../js/bootbox.js"></script>
	<script src="../../js/jquery-ui-1.8.21.custom.min.js"></script>
 	<link rel="stylesheet" href="../../css/jquery-ui.css"> 
      	<script>
      	$(function() {
		$( "#slider-range-min8" ).slider({
			range: "min",
			value: 0,
			min: 0,
			max: 5,
			step: 0.5,
			slide: function( event, ui ) {
				$( "#amount8" ).val( ui.value );
			}
		});
		$( "#amount8" ).val( $( "#slider-range-min8" ).slider( "value" ) );
	});
	</script> 
	  
<div id='fg_membersite' >
<form id='changepwd' action='' method='post' accept-charset='UTF-8'>

<fieldset >
<legend><center><font color="#330099" ><strong>Overall Rating Of <?php echo $_POST['student']; ?></strong></font></center></legend>

<div><span class='error'><?php echo $fgstudent->GetErrorMessage(); ?></span></div>
<input type='hidden' name='submitted' id='submitted' value='1'/>
<input type='hidden' name='student' value='<?php echo $_POST['student']; ?>'/>
<input type="hidden" name="reg_no" value="<?php echo $_POST['reg_no']; ?>" />
<input type="hidden" name="interviewer" value="<?php echo $_SESSION['name_of_user']; ?>" />
<input type="hidden" name="timestarted" value="<?php echo $_POST['timestarted']; ?>" />
<input type="hidden" name="clarity" value="<?php echo $_POST['clarity']; ?>" />
<input type="hidden" name="articulation" value="<?php echo $_POST['articulation']; ?>" /> 
<input type="hidden" name="usage" value="<?php echo $_POST['usage']; ?>" /> 
<input type="hidden" name="confidence" value="<?php echo $_POST['confidence']; ?>" />
<input type="hidden" name="bodylang" value="<?php echo $_POST['bodylang']; ?>" /> 
<input type="hidden" name="listening" value="<?php echo $_POST['listening']; ?>" /> 
<input type="hidden" name="appearance" value="<?php echo $_POST['appearance']; ?>" /> 
<input type="hidden" name="manners" value="<?php echo $_POST['manners']; ?>" /> 
<input type="hidden" name="otherfeedback" value="<?php echo $_POST['otherfeedback']; ?>" /> 
<input type="hidden" name="communifeedback" value="<?php echo $communifeedback; ?>" />
<input type="hidden" name="prepfeedback" value="<?php echo $prepfeedback; ?>" /><br/><br/>
 <table style="margin:auto"><tr><td width="400px">  <div id="slider-range-min8"></div></td><td>&nbsp;&nbsp;&nbsp;</td><td><input type="text" id="amount8" name="overallrating" style="border:1; width:40px; color:#f6931f; font-weight:bold;"> </td></tr></table><br/>
        <center> <strong> 1-Bad, 2-Average, 3-Good, 4-Very Good, 5-Excellent</strong></center>
<!--<div class='short_explanation'>* required fields</div>-->
<br/>
<p align="center">
    <!--<a href="javascript:window.history.go(-1);" class="btn btn-danger">Go Back</a>--> <input type='submit' class="btn btn-success" name='Submit' value='Save Results' />
</p>

</fieldset>
</form>
<!-- client-side Form Validations:
Uses the excellent form validation script from JavaScript-coder.com-->

<script type='text/javascript'>
// <![CDATA[
    var pwdwidget = new PasswordWidget('oldpwddiv','oldpwd');
    pwdwidget.enableGenerate = false;
    pwdwidget.enableShowStrength=false;
    pwdwidget.enableShowStrengthStr =false;
    pwdwidget.MakePWDWidget();
    
    var pwdwidget = new PasswordWidget('newpwddiv','newpwd');
    pwdwidget.MakePWDWidget();
    
    
    var frmvalidator  = new Validator("changepwd");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();

    frmvalidator.addValidation("oldpwd","req","Please provide your old password");
    
    frmvalidator.addValidation("newpwd","req","Please provide your new password");

// ]]>
</script>



</div>
<!--
Form Code End (see html-form-guide.com for more info.)
-->
