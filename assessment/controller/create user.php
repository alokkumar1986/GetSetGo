<?PHP
require_once("../include/membersite_config.php");

if(isset($_POST['submitted']))
{
   if($fgmembersite->RegisterUser())
   {
        $fgmembersite->RedirectToURL("?id=thank-you");
   }
}

?>
<!-- Form Code Start -->
<!-- client-side Form Validations:
Uses the excellent form validation script from JavaScript-coder.com-->

<script type='text/javascript'>
// <![CDATA[
    var pwdwidget = new PasswordWidget('thepwddiv','password');
    pwdwidget.MakePWDWidget();
    
    var frmvalidator  = new Validator("register");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();
    frmvalidator.addValidation("name","req","Please provide your name");

    frmvalidator.addValidation("email","req","Please provide your email address");

    frmvalidator.addValidation("email","email","Please provide a valid email address");

    frmvalidator.addValidation("username","req","Please provide a username");
    
    frmvalidator.addValidation("password","req","Please provide a password");

// ]]>
</script>

<div id='fg_membersite'>
<form id='register' action='' method='post' accept-charset='UTF-8'>
<h2>Creating a New User</h2>

<fieldset >
<legend>New User Creation</legend>

<input type='hidden' name='submitted' id='submitted' value='1'/>

<div class='short_explanation'>* required fields</div>
<input type='hidden'  class='spmhidip' name='<?php echo $fgmembersite->GetSpamTrapInputName(); ?>' />

<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
<div class='container'>
    <label for='name' >Your Full Name*: </label><br/>
    <input type='text' name='name' id='name' value='<?php echo $fgmembersite->SafeDisplay('name') ?>' maxlength="50" /><br/>
    <span id='register_name_errorloc' class='error'></span>
</div>
<div class='container'>
    <label for='email' >Email Address*:</label><br/>
    <input type='text' name='email' id='email' value='<?php echo $fgmembersite->SafeDisplay('email') ?>' maxlength="50" /><br/>
    <span id='register_email_errorloc' class='error'></span>
</div>
<div class='container'>
    <label for='username' >UserName*:</label><br/>
    <input type='text' name='username' id='username' value='<?php echo $fgmembersite->SafeDisplay('username') ?>' maxlength="50" /><br/>
    <span id='register_username_errorloc' class='error'></span>
</div>
<div class='container' style='height:80px;'>
    <label for='password' >Password*:</label><br/>
    <div class='pwdwidgetdiv' id='thepwddiv' ></div>
    <input type='password' name='password' id='password' maxlength="50" />
    <div id='register_password_errorloc' class='error' style='clear:both'></div>
</div>

<div>
    <input type='submit' name='Submit' value='Submit' />
</div>

</fieldset>
</form>
</div>
