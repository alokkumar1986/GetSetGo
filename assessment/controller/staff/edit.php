<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

if(isset($_POST['submitted']))
{
   if($fgmembersite->Updatefaculty())
   {
        $fgmembersite->RedirectToURL("?id=editedprofile");
   }
}
if($_GET['action']='edit'){
	$rs=$fgmembersite->Selectfaculty($_GET['faculty']);
}

?>

      <title>Edit Profile</title>
      
      <script type="javascript">
	  	function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInp").change(function(){
        readURL(this);
    });
	
	  </script>
	  <script>
	  	function generate() {
    
        var password = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for (var i = 0; i < 6; i++){
			        password += possible.charAt(Math.floor(Math.random() * possible.length));
		}
        $('input[name="password"]').val(password);
    
}
	  </script>
<!--<div id='fg_membersite'>--><div onload="readURL(input);">
<?php while($row=mysql_fetch_array($rs)){
	$name=explode(" ",$row['Staff_Name']);
	$fname=$name[0];
	$lname=$name[1];
	?> 
<form id='changepwd' action='' method='post' enctype="multipart/form-data">

<fieldset>
<legend><font color="#330099" ><strong>Edit Profile</strong></font></legend>
<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
<input type='hidden' name='submitted' id='submitted' value='1'/>
<input type='hidden' name='user' value='<?php echo $_GET['faculty']; ?>' />
<!--<img src="../../image/winter.jpg" width="100px"height="100px" id="blah" style="float:right;margin-top:10px;"/>-->
<br/>
<table style="width:68% !important;">
<tr><td>
   User Name:</td><td> <input type="text" name="username" placeholder="Username" value="<?php echo $row['User_Name']; ?>" readonly="readonly"/></td></tr>
  <!--<tr> <td>Password:</td><td> <input type="text" name="password" placeholder="Password" value="<?php echo $row['Password']; ?>" readonly="readonly"/></td></tr>-->
  <!--<tr valign="top"><td>Generate A new Password:</td><td height="40"><button type="button" class="btn btn-custom" id="genPass" onclick="generate();">Generate A new Password</button><br /></td></tr>-->
<tr><td>Name: </td><td><input type="text" name="fname" placeholder="Firstname" value="<?php echo $fname; ?>"/></td></tr>
<!--<tr><td>Last Name: </td><td><input type="text" name="lname" placeholder="Lastname" value="<?php echo $lname; ?>"/></td></tr>-->
<tr><td>Email:</td><td> <input type="text" name="email" placeholder="Email" value="<?php echo $row['Email']; ?>"/></td></tr>
<tr><td>Mobile Number:</td><td> <input type="text" name="mobileno" placeholder="Mobileno" value="<?php echo $row['Mobile']; ?>"/></td></tr>
<tr><td>Interview Type:</td><td> <select name="typeinteviewer" style="width:206px;color:grey" readonly="readonly"><option value="<?php echo $row['actingrole']; ?>" <?php if($row['actingrole']=='PI'){ ?> selected="selected" <?php } ?>><?php echo $row['actingrole']; ?></option></select></td></tr>
<tr><td>
<p>
</p></td></tr>
<tr><td>
    <input type='submit' class="btn btn-success" name='Submit' value='Submit' /></td></tr></table>
</fieldset>
</form>
<?php } ?>
</div>
 