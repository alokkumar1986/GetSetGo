//  <?PHP
// require_once("../../include/membersite_config.php");

// if(!$fgmembersite->CheckLogin())
// {
//     $fgmembersite->RedirectToURL("../../login.php");
//     exit;
// }

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
        $arrConditions = array('regdno' => $reg_no, 'username' => $username, 'fname'=>$fname, 'email'=>$email, 'mobileno'=>$mobileno, 'college'=>$college, 'branch'=>$branch, 'yop'=>$yop, 'user'=>$user );
        $student_data = $fgmembersite->getWhereCustomActionValues("USP_STUDENT_DATA", "UU", $arrConditions);
        if(!empty($student_data['result'])){
          include('editedprofile.php');
          exit;
        }
        else
        {
            $this->HandleDBError("Error inserting data into database \nquery:$qry");
            return false;
        }   
		
}
if($_GET['action']='edit'){
	$rs=$student_data;
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
<?php $row=$rs;	?> 
<form id='changepwd' action='' method='post' enctype="multipart/form-data">

<fieldset>
<legend><font color="#330099" ><strong>Edit Profile</strong></font></legend>
<div><?php if(!empty($fgmembersite->GetErrorMessage())){ ?>
<div class="alert alert-danger alert-dismissible fade in">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
</strong> <?php echo $fgmembersite->GetErrorMessage(); ?>
</div>
<?php } ?></div>
<input type='hidden' name='submitted' id='submitted' value='1'/>
<input type='hidden' name='user' value='<?php echo $_GET['student']; ?>' />
<!--<img src="../../image/winter.jpg" width="100px"height="100px" id="blah" style="float:right;margin-top:10px;"/>-->
<br/>
<table style="width:68% !important;">
<tr><td width="25%">
   <strong>REG. No</strong>:</td>
<td width="75%"> <input type="text" name="reg_no" placeholder="Reg No." value="<?php echo $row['REG_NO']; ?>" readonly="readonly" style="background:#CCCCCC;"/></td></tr>
   <tr><td>
   <strong>Username</strong>:</td><td> <input type="text" name="username" placeholder="Username" value="<?php echo $row['USERNAME']; ?>" /></td></tr>
  <!--<tr> <td>Password:</td><td> <input type="text" name="password" placeholder="Password" value="<?php echo $row['Password']; ?>" readonly="readonly"/></td></tr>-->
  <!--<tr valign="top"><td>Generate A new Password:</td><td height="40"><button type="button" class="btn btn-custom" id="genPass" onclick="generate();">Generate A new Password</button><br /></td></tr>-->
<tr><td><strong>Name</strong>: </td><td><input type="text" name="fname" placeholder="Firstname" value="<?php echo $row['NAME']; ?>"/></td></tr>
<!--<tr><td>Last Name: </td><td><input type="text" name="lname" placeholder="Lastname" value="<?php echo $lname; ?>"/></td></tr>-->
<tr><td><strong>Email</strong>:</td><td> <input type="text" name="email" placeholder="Email" value="<?php echo $row['EMAIL_ID']; ?>" readonly="readonly" style="background:#CCCCCC;"/></td></tr>
<tr><td><strong>Mobile Number</strong>:</td><td> <input type="text" name="mobileno" placeholder="Mobileno" value="<?php echo $row['MOBILE_NO']; ?>"/></td></tr>
<tr><td><strong>College</strong>:</td><td> <input type="text" name="college" placeholder="College" value="<?php echo $row['COLLEGE_FULLNAME']; ?>" readonly="readonly" style="background:#CCCCCC;"/></td></tr>
<tr><td><strong>Branch</strong>:</td><td> <input type="text" name="branch" placeholder="Branch" value="<?php echo $row['BRANCH']; ?>" readonly="readonly" style="background:#CCCCCC;"/></td></tr>
<tr><td><strong>Year Of Passing Out</strong>:</td><td> <input type="text" name="yop" placeholder="Year Of Passing Out" value="<?php echo $row['COURSE_YOP']; ?>" readonly="readonly" style="background:#CCCCCC;"/></td></tr>
<tr><td colspan="2">
<p>
</p></td></tr>
<tr><td colspan="2" align="left">
    <input type='submit' class="btn2 btn-success" name='Submit' value='Submit' /></td></tr></table>
</fieldset>
</form>

</div>
 