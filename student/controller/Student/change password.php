<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}

if(isset($_POST['submitted']))
{
   if($fgmembersite->ChangePassword())
   {

    include("changed password.php");exit;
   // $url=base64_encode('changed password');
   // $fgmembersite->RedirectToURL("?id=$url");
   }else{
    $fgmembersite->HandleDBError("Something went wrong");
    //return false;
   }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
      <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
      <title>Change password</title>
      <link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css" />
      <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
      <link rel="STYLESHEET" type="text/css" href="style/pwdwidget.css" />
      <script src="scripts/pwdwidget.js" type="text/javascript"></script>    
	  <style>
	  body{
	  background-image:url(images/bigpic.jpg);
	  background-repeat:no-repeat;
	  background-size:cover;
	  }
	  </style>   
	  <style>
	   table,tr, td{
	 border:none !important;
	 }
	 .btn2 {
  background: #1aad41;
  background-image: -webkit-linear-gradient(top, #1aad41, #198a4e);
  background-image: -moz-linear-gradient(top, #1aad41, #198a4e);
  background-image: -ms-linear-gradient(top, #1aad41, #198a4e);
  background-image: -o-linear-gradient(top, #1aad41, #198a4e);
  background-image: linear-gradient(to bottom, #1aad41, #198a4e);
  -webkit-border-radius: 5;
  -moz-border-radius: 5;
  border-radius: 5px;
  font-family: Georgia;
  color: #ffffff;
  font-size: 18px;
  padding: 4px 8px 4px 8px;
  text-decoration: none;
    color:#FFFFFF !important;

}

.btn2:hover {
  background: #249113;
  background-image: -webkit-linear-gradient(top, #249113, #0d8f16);
  background-image: -moz-linear-gradient(top, #249113, #0d8f16);
  background-image: -ms-linear-gradient(top, #249113, #0d8f16);
  background-image: -o-linear-gradient(top, #249113, #0d8f16);
  background-image: linear-gradient(to bottom, #249113, #0d8f16);
  text-decoration: none;
}
	  </style>
</head>
<body>
<!-- Form Code Start -->
<div id='fg_membersite'>
<form id='changepwd' action='' method='post' accept-charset='UTF-8'>

<fieldset>
<legend>Change Password</legend>

<input type='hidden' name='submitted' id='submitted' value='1'/>

<!--<div class='short_explanation'>* required fields</div>
-->
<div><?php if(!empty($fgmembersite->GetErrorMessage())){ ?>
<div class="alert alert-danger alert-dismissible fade in">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
</strong> <?php echo $fgmembersite->GetErrorMessage(); ?>
</div>
<?php } ?></div>
<table><tr><td width="124">    <label for='oldpwd' ><strong>Old Password</strong>*:</label></td>
<td width="201">    <div class='pwdwidgetdiv' id='oldpwddiv' ></div>
    <input type='password' name='oldpwd' id='oldpwd' placeholder="Old Password" maxlength="50" />
    <span id='changepwd_oldpwd_errorloc' class='error'></span>
</td></tr>
<tr><td>
    <label for='newpwd' ><strong>New Password</strong>*:</label></td>
 <td>   <div class='pwdwidgetdiv' id='newpwddiv' ></div>
    <input type='password' name='newpwd' id='newpwd' placeholder="New Password" maxlength="50" /><br/>
    <span id='changepwd_newpwd_errorloc' class='error'></span>
</td></tr>
<tr><td>
    <label for='newpwd' ><strong>Re-type Password</strong>*:</label></td>
 <td>   <div class='pwdwidgetdiv' id='newpwddiv' ></div>
    <input type='password' name='renewpwd' id='renewpwd' placeholder="Retype Password" maxlength="50" /><br/>
    <span id='changepwd_newpwd_errorloc' class='error'></span>
</td></tr>


<tr><td colspan="2">
    <input type='submit' name='Submit' value='Change Password Now' class="btn2" />
</td></tr></table>


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

</body>
</html>