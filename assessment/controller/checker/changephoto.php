<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

if(isset($_POST['submitted']))
{
   if($fgmembersite->changephoto())
   {
        $fgmembersite->RedirectToURL("?id=changedphoto");
   }
}
if(isset($_GET['faculty'])){
	$rs=$fgmembersite->Selectfaculty($_GET['faculty']);
}

?>

      <title>Profile Photo Change</title>
      
      
	 
<!--<div id='fg_membersite'>--><div>
<?php while($row=mysql_fetch_array($rs)){
	$name=explode(" ",$row['Staff_Name']);
	$fname=$name[0];
	$lname=$name[1];
	?> 
<form id='changepwd' action='' method='post' enctype="multipart/form-data" >

<fieldset>
<legend><font color="#330099" ><strong>Change Your Profile Photo</strong></font></legend>
<div onload="readURL();"><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
<input type='hidden' name='submitted' id='submitted' value='1'/>
<input type='hidden' name='user' value='<?php echo $_GET['faculty']; ?>' />
<!--<img src="../../image/winter.jpg" width="100px"height="100px" id="blah" style="float:right;margin-top:10px;"/>-->
<br/>
<div style="float:right;width:120px;"> <img <?php if($row['Photo']!=''){ ?>src="../admin/uploads1/<?php echo $row['Photo']; ?>" <?php }else { ?>src="../../image/winter.jpg" <?php } ?> width="100px"height="100px" style=";margin-top:10px;" id="previewHolder" alt="Uploaded Image Preview Holder" width="250px" height="250px"/>
</div>
<table style="width:68% !important;">
<tr><td>
<input type="file" name="filePhoto" value="" id="filePhoto" class="required borrowerImageFile" data-errormsg="PhotoUploadErrorMsg" onclick="readURL(input);">
   </td></tr>
<tr><td>
<p>
</p></td></tr>
<tr><td>
    <input type='submit' class="btn btn-success" name='Submit' value='Submit' /></td></tr></table>
</fieldset>
</form>
<?php } ?>
</div>
<script type="javascript">
	  	function readURL(input) {
           if (input.files && input.files[0]) {
               var reader = new FileReader();
               reader.onload = function(e) {
                   $('#previewHolder').attr('src', e.target.result);
               }

               reader.readAsDataURL(input.files[0]);
           }
       }
       $("#filePhoto").change(function() {
           readURL(this);
       });
	  </script>
 