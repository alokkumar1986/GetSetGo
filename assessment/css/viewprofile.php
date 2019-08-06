<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}
$fgmembersite->DBLogin();
if(isset($_POST['submitted']))
{
   $reg_no=$_POST['reg_no'];
        $username=$_POST['username'];
        
        $fname=$_POST['fname'];
        
        $email=$_POST['email'];
        $mobileno=$_POST['mobileno'];
        $college=$_POST['college'];
		$branch=$_POST['branch'];
        $yop=$_POST['yop'];
        $user=$_POST['user'];
       
 $qry = "Update `student_data` SET `REG_NO` = '".$reg_no."',`USERNAME`='".$username."',
`NAME` = '".$fname."',
`MOBILE_NO` = '".$mobileno."',
`EMAIL_ID` = '".$email."',
`COLLEGE_FULLNAME` = '".$college."', `BRANCH` = '".$branch."',
`COURSE_YOP` = '".$yop."' WHERE `REG_NO` = '".$reg_no."'";	
		
        
        
        if(!mysql_query( $qry ,$fgmembersite->connection))
        {
            $this->HandleDBError("Error inserting data into database \nquery:$qry");
            return false;
        }   
		$url=base64_encode('editedprofile');
       $fgmembersite->RedirectToURL("?id=editedprofile");
   
}
if($_GET['action']='edit'){
	$rs=mysql_query("select * from `student_data` where REG_NO='$_GET[id1]'");
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
<!--<div id='fg_membersite'>--><div onload="readURL(input);">
<?php while($row=mysql_fetch_array($rs)){
	
	?> 
<form id='changepwd' action='' method='post' enctype="multipart/form-data">

<fieldset>
<legend><font color="#330099" ><strong>View Profile</strong></font></legend>
<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
<input type='hidden' name='submitted' id='submitted' value='1'/>
<input type='hidden' name='user' value='<?php echo $_GET['student']; ?>' />
<!--<img src="../../image/winter.jpg" width="100px"height="100px" id="blah" style="float:right;margin-top:10px;"/>-->
<br/>
<table height="364" style="width:68% !important;">
<tr><td width="25%" height="38">
   <strong>REG. No</strong>:</td>
<td width="75%"><?php echo $row['REG_NO']; ?></td></tr>
   <tr><td height="37">
   <strong>Username</strong>:</td>
   <td> <?php echo $row['USERNAME']; ?></td></tr>
  <!--<tr> <td>Password:</td><td> <input type="text" name="password" placeholder="Password" value="<?php echo $row['Password']; ?>" /></td></tr>-->
  <!--<tr valign="top"><td>Generate A new Password:</td><td height="40"><button type="button" class="btn btn-custom" id="genPass" onclick="generate();">Generate A new Password</button><br /></td></tr>-->
<tr><td height="34"><strong>Name</strong>: </td>
<td><?php echo $row['NAME']; ?></td></tr>
<!--<tr><td>Last Name: </td><td><input type="text" name="lname" placeholder="Lastname" value="<?php echo $lname; ?>"/></td></tr>-->
<tr><td height="34"><strong>Email</strong>:</td>
<td> <?php echo $row['EMAIL_ID']; ?></td></tr>
<tr><td height="34"><strong>Mobile Number</strong>:</td>
<td> <?php echo $row['MOBILE_NO']; ?></td></tr>
<tr><td height="34"><strong>College</strong>:</td>
<td> <?php echo $row['COLLEGE_FULLNAME']; ?></td></tr>
<tr><td height="35"><strong>Branch</strong>:</td>
<td><?php echo $row['BRANCH']; ?></td></tr>
<tr><td height="52"><strong>Year Of Passing Out</strong>:</td>
<td> <?php echo $row['COURSE_YOP']; ?></td></tr>
<tr><td colspan="2">
<p>
</p></td></tr>
<tr>
<td>&nbsp;</td><td align="left">
    </td></tr></table>
</fieldset>
</form>
<?php } ?>
</div>
 