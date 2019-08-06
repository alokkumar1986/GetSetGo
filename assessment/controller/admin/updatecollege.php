<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

if(isset($_POST['submitted']))
{
   if($fgmembersite->Updatecollege())
   {
        $fgmembersite->RedirectToURL("?id=updatedcollege");
   }
}
if($_GET['action']='edit'){
	$rs=$fgmembersite->Selectcollege($_GET['college']);
}

?>

      <title>Update College</title>
      
     <!--<div id='fg_membersite'>--><div onload="readURL(input);">
<?php while($row=mysql_fetch_array($rs)){
	$name=explode(" ",$row['Staff_Name']);
	$fname=$name[0];
	$lname=$name[1];
	?> 
<form id='changepwd' action='' method='post' enctype="multipart/form-data">

<fieldset>
<legend><font color="#330099" ><strong>Update College</strong></font></legend>
<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
<input type='hidden' name='submitted' id='submitted' value='1'/>
<input type='hidden' name='id' value='<?php echo $_GET['college']; ?>' />
<!--<img src="../../image/winter.jpg" width="100px"height="100px" id="blah" style="float:right;margin-top:10px;"/>-->
<br/>
<table style="width:68% !important;">
<tr><td>
    Name:</td><td> <input type="text" name="name" placeholder="College Name" value="<?php echo $row['name']; ?>"/></td></tr>
  
<tr><td>Short Name: </td><td><input type="text" name="short_name" placeholder="College Short Name" value="<?php echo $row['short_name']; ?>"/></td></tr>
<tr><td>State: </td><td><input type="text" name="state" placeholder="State" value="<?php echo $row['state']; ?>"/></td></tr>
<tr><td>University:</td><td> <input type="text" name="university" placeholder="University" value="<?php echo $row['university']; ?>"/></td></tr>
<tr><td>College Code:</td><td> <input type="text" name="college_code" placeholder="College Code" value="<?php echo $row['college_code']; ?>"/></td></tr>
<tr><td>College Email:</td><td> <input type="text" name="college_email" placeholder="College Email" value="<?php echo $row['college_email']; ?>"/></td></tr>
<tr><td>
<p>
</p></td></tr>
<tr><td>
    <input type='submit' class="btn btn-success" name='Submit' value='Submit' /></td></tr></table>
</fieldset>
</form>
<?php } ?>
</div>
 
