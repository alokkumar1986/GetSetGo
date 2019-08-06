<?PHP
// require_once("../class.database.php");
// $db2 = new Database();  
// $db2->connect();

// $sid=base64_decode($_GET['sid']);
// $row=mysql_query("select * from `student_data` where REG_NO='".$sid."'")or die(mysql_error());
// while($rs=mysql_fetch_array($row)or die(mysql_error())){
$rs = $student_data;
?>

      <title>User Profile</title>
      <!--<link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css" />-->
      <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
     <!-- <link rel="STYLESHEET" type="text/css" href="style/pwdwidget.css" />-->
      <script src="scripts/pwdwidget.js" type="text/javascript"></script>    
	 <style type="text/css">
	 label{
	 font-size:16px;
	 font-weight:bold;
	 }
	 tr, td{
	 border:none !important;
	 }
	 .btn {

  background: #3491d9;
  background-image: -webkit-linear-gradient(top, #3491d9, #2980b9);
  background-image: -moz-linear-gradient(top, #3491d9, #2980b9);
  background-image: -ms-linear-gradient(top, #3491d9, #2980b9);
  background-image: -o-linear-gradient(top, #3491d9, #2980b9);
  background-image: linear-gradient(to bottom, #3491d9, #2980b9);
  -webkit-border-radius: 5;
  -moz-border-radius: 5;
  border-radius: 5px;
  font-family: Georgia;
  color: #ffffff;
  font-size: 18px;
  padding: 5px 10px 5px 10px;
  text-decoration: none;
  margin-top:20px;
margin-bottom:20px;s
}

.btn:hover {
  background: #3cb0fd;
  background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
  background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
  background-image: linear-gradient(to bottom, #3cb0fd, #3498db);
  text-decoration: none;
    color:#FFFFFF !important;

}
.btn1 {
  background: #d93434;
  background-image: -webkit-linear-gradient(top, #d93434, #b82b7f);
  background-image: -moz-linear-gradient(top, #d93434, #b82b7f);
  background-image: -ms-linear-gradient(top, #d93434, #b82b7f);
  background-image: -o-linear-gradient(top, #d93434, #b82b7f);
  background-image: linear-gradient(to bottom, #d93434, #b82b7f);
  -webkit-border-radius: 5;
  -moz-border-radius: 5;
  border-radius: 0px;
  font-family: Georgia;
  color: #ffffff;
  font-size: 14px;
  padding: 2px 4px 2px 4px;
  text-decoration: none;
}

.btn1:hover {
  background: #db1561;
  background-image: -webkit-linear-gradient(top, #db1561, #d93463);
  background-image: -moz-linear-gradient(top, #db1561, #d93463);
  background-image: -ms-linear-gradient(top, #db1561, #d93463);
  background-image: -o-linear-gradient(top, #db1561, #d93463);
  background-image: linear-gradient(to bottom, #db1561, #d93463);
  text-decoration: none;
  color:#FFFFFF !important;
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
  padding: 10px 20px 10px 20px;
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
<!--<div id='fg_membersite'>--><div>
<form id='changepwd' action='' method='post' accept-charset='UTF-8'>

<fieldset>
<legend><font color="#330099" ><strong>Profile Of <?php echo $_SESSION['name_of_user2']; ?></strong></font></legend>


<!--<div class='short_explanation'>* required fields</div>

<div><span class='error'><?php //echo $fgmembersite->GetErrorMessage(); ?></span></div> -->

<div style="float:left;margin-left:20px;margin-right:50px;width:105px;"> 
  <img <?php if($rs['PIC']!='' && file_exists(dirname(__FILE__).'/uploads/'.$rs['PIC'])){ ?>src="uploads/<?php echo $rs['PIC']; ?>" <?php }else { ?>src="../example/profile.jpg" <?php } ?> width="100px"height="100px" style="margin-top:10px;border:2px solid #ccc;" id="previewHolder" alt="Uploaded Image Preview Holder"/>
<p align="center">
<a href="?id=<?php echo base64_encode('changephoto'); ?>&student=<?php echo $rs['REG_NO']; ?>" class='btn1'> Change Photo </a></p>
</div>
<div >   
<table style="border:none !important;" width='60%'><tr><td width="287">
 <div>
 
    <label for='username' >Reg. No.:</label> <?php echo $rs['REG_NO']; ?>
    
</div>
</td>
<td width="319">
   
<div>
    <label for='username' >Username:</label> <?php echo $rs['USERNAME']; ?>
    
</div>
</td></tr>
<tr><td>

<div>
    <label for='name' >Name:</label> <?php echo $rs['NAME']; ?>
    
</div></td>
<td><div>
    <label for='email' >Email:</label> <?php echo $rs['EMAIL_ID']; ?>
    
</div>
</td>
</<br />
<tr><td>
<div>
 <label for='mobile' >Mobile No:</label> <?php echo $rs['MOBILE_NO']; ?>
</div>
</td>
<td>
<div>
    <label for='status' >Collge:</label> <?php echo $rs['COLLEGE_FULLNAME']; ?>
    
</div>
</td>
</tr>
<tr>
<td>
<div>
    <label for='type' >Branch:</label> <?php echo $rs['BRANCH']; ?>
    
</div></td><td>

<a href="?id=<?php echo base64_encode('edit'); ?>&action=edit&student=<?php echo $rs['REG_NO']; ?>" class="btn">Edit Profile</a>
</td></tr></table>
</fieldset>
</form>
<?php //} ?>
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
</div>
<!--
Form Code End (see html-form-guide.com for more info.)
-->
