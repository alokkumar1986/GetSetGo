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
        $fgmembersite->RedirectToURL("?id=updatedfaculty");
   }
}
if($_GET['action']='edit'){
	$rs=$fgmembersite->Selectfaculty($_GET['faculty']);
}

?>

      <title>Update Faculty</title>
      
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
<!--<div id='fg_membersite'>--><div onload="readURL(input);">
<?php while($row=mysql_fetch_array($rs)){
	$name=explode(" ",$row['Staff_Name']);
	$fname=$name[0];
	$lname=$name[1];
	?> 
<form id='changepwd' action='' method='post' enctype="multipart/form-data">

<fieldset>
<legend><font color="#330099" ><strong>Update Faculty</strong></font></legend>
<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
<input type='hidden' name='submitted' id='submitted' value='1'/>
<img src="../../image/winter.jpg" width="100px"height="100px" id="blah" style="float:right;margin-top:10px;"/>
<br/>
   User Name: <input type="text" name="username" placeholder="Username" value="<?php echo $row['User_Name']; ?>"/><br />
   Password: <input type="text" name="password" placeholder="Password" value="<?php echo $row['Password']; ?>" readonly="readonly"/><br /><button style="margin-left:80px;" id="btn">Generate A new Password</button></br></br>
First Name: <input type="text" name="fname" placeholder="Firstname" value="<?php echo $fname; ?>"/><br />
Last Name: <input type="text" name="lname" placeholder="Lastname" value="<?php echo $lname; ?>"/><br />
Email: <input type="text" name="email" placeholder="Email" value="<?php echo $row['Email']; ?>"/><br />
Mobile Number: <input type="text" name="mobileno" placeholder="Mobileno" value="<?php echo $row['Mobile']; ?>"/><br />
Interview Type: <select name="typeinteviewer" style="width:206px;"><option value="">Interviewer Type</option><option value="PI">PI</option><option value="TI">TI</option><option value="BOTH">BOTH</option></select><br />
<p>
Photo: <input type="file" name="pic" placeholder="Photo" id="imgInp" /></p>

    <input type='submit' class="btn btn-success" name='Submit' value='Submit' />
</fieldset>
</form>
<?php } ?>
</div>
 
