<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

if(isset($_POST['submitted']))
{
   if($fgmembersite->Updatestudent())
   {
        $fgmembersite->RedirectToURL("?id=updatedstudent");
   }
}
if($_GET['action']='edit'){
	$rs=$fgmembersite->Getstudent($_GET['student']);
}

?>
<title>Update Student Details</title>
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
	$name=$row['NAME'];
	$fname=$name[0];
	$lname=$name[1];
	?> 
<form id='changepwd' action='' method='post' enctype="multipart/form-data">

<fieldset>
<legend><font color="#330099" ><strong>Update Student Details</strong></font></legend>
<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
<input type='hidden' name='submitted' id='submitted' value='1'/>
<input type='hidden' name='user' value='<?php echo $_GET['student']; ?>' />
<!--<img src="../../image/winter.jpg" width="100px"height="100px" id="blah" style="float:right;margin-top:10px;"/>-->
<br/>
<table style="width:68% !important;">
<tr><td>
   User Name:</td><td> <input type="text" name="username" placeholder="Username" value="<?php echo $row['USERNAME']; ?>"/></td></tr>
  <tr> <td>Password:</td><td> <input type="text" name="password" placeholder="Password" value="" /></td></tr>
  <tr valign="top"><td>Generate A new Password:</td><td height="40"><button type="button" class="btn btn-custom" id="genPass" onclick="generate();">Generate A new Password</button><br /></td></tr>
<tr><td>Name: </td><td><input type="text" name="name" placeholder="Name" value="<?php echo $name; ?>"/></td></tr>
<tr><td>Reg No.:</td><td> <input type="text" name="reg_no" placeholder="Reg no." value="<?php echo $row['REG_NO']; ?>"/></td></tr>
<tr><td>Email:</td><td> <input type="text" name="email" placeholder="Email" value="<?php echo $row['EMAIL_ID']; ?>"/></td></tr>
<tr><td>Gender: </td><td><input type="text" name="gender" placeholder="Gender" value="<?php echo $row['GENDER']; ?>"/></td></tr>
<tr><td>Mobile Number:</td><td> <input type="text" name="mobileno" placeholder="Mobileno" value="<?php echo $row['MOBILE_NO']; ?>"/></td></tr>
<tr><td>State:</td><td> <input type="text" name="state" placeholder="State" value="<?php echo $row['STATE']; ?>"/></td></tr>
<tr><td>University:</td><td> <input type="text" name="university" placeholder="University" value="<?php echo $row['UNIVERSITY']; ?>"/></td></tr>
<tr><td>College:</td><td> <input type="text" name="college" placeholder="College" value="<?php echo $row['COLLEGE']; ?>"/></td></tr>
<tr><td>Course:</td><td> <input type="text" name="course" placeholder="Course" value="<?php echo $row['COURSE']; ?>"/></td></tr>
<tr><td>Branch:</td><td> <input type="text" name="branch" placeholder="Branch" value="<?php echo $row['BRANCH']; ?>"/></td></tr>
<tr><td>Year Of Pass Out:</td><td> <input type="text" name="yop" placeholder="Year Of Passing Out" value="<?php echo $row['COURSE_YOP']; ?>"/></td></tr>
<tr><td>
<p>
</p></td></tr>
<tr><td>
    <input type='submit' class="btn btn-success" name='Submit' value='Submit' /></td></tr></table>
</fieldset>
</form>
<?php } ?>
</div>
 
      