<?PHP
require_once("../class.database.php");
$db2 = new Database();  
$db2->connect();

$sid=$_GET['sid'];
$row=mysql_query("select * from staff where Email='".$sid."'")or die(mysql_error());
while($rs=mysql_fetch_array($row)or die(mysql_error())){

?>

      <title>User Profile</title>
      <!--<link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css" />-->
      <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
     <!-- <link rel="STYLESHEET" type="text/css" href="style/pwdwidget.css" />-->
      <script src="scripts/pwdwidget.js" type="text/javascript"></script>    
	  
<!--<div id='fg_membersite'>--><div>
<form id='changepwd' action='' method='post' accept-charset='UTF-8'>

<fieldset>
<legend><font color="#330099" ><strong>Profile Of <?php echo $_SESSION['name_of_user']; ?></strong></font></legend>


<!--<div class='short_explanation'>* required fields</div>

<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>-->

<div style="float:right;width:120px;"> <img <?php if($rs['Photo']!=''){ ?>src="../admin/uploads1/<?php echo $rs['Photo']; ?>" <?php }else { ?>src="../../image/winter.jpg" <?php } ?> width="100px"height="100px" style=";margin-top:10px;" id="previewHolder" alt="Uploaded Image Preview Holder" width="250px" height="250px"/>
<a href="?id=changephoto&faculty=<?php echo $rs['ID']; ?>" style="color: #000;align:right;"> Change Photo </a>
</div>
   
    
<div>
    <label for='username' >Username:</label> <?php echo $rs['User_Name']; ?>
    
</div>


<div>
    <label for='name' >Name:</label> <?php echo $rs['Staff_Name']; ?>
    
</div>
<div>
    <label for='email' >Email:</label> <?php echo $rs['Email']; ?>
    
</div>
<div>
 <label for='mobile' >Mobile No:</label> <?php echo $rs['Mobile']; ?>
</div>
<div>
    <label for='status' >Status:</label> <?php echo $rs['Status']; ?>
    
</div>
<div>
    <label for='type' >Interviwer Type:</label> <?php echo $rs['actingrole']; ?>
    
</div>

<a href="?id=edit&action=edit&faculty=<?php echo $rs['ID']; ?>" class="btn btn-warning">Edit Profile</a>
</fieldset>
</form>
<?php } ?>
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
