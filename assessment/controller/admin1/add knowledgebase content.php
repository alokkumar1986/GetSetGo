<?php
require_once("../../include/membersite_config.php");
$fgmembersite->DBLogin();
if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

if(isset($_POST['submitted']))
{
   if($fgmembersite->Addknowledgebasecontent())
   {
        $fgmembersite->RedirectToURL("?id=added knowlegdebase content");
   }
}
$fgmembersite->DBLogin();
?>
 <fieldset>
<legend><font color="#330099" ><strong>Add Content</strong></font></legend>
		<form id='changepwd' action='' method='post' enctype="multipart/form-data">

<fieldset>
<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
<div>
<input type='hidden' name='submitted' id='submitted' value='1'/>
<p><select name="category" style="color: grey;">
<option value="">-Select Category-</option>
<?php $sql="select * from knowledgebase_category where weight='0'";
	$rs=mysql_query($sql);
	while($row=mysql_fetch_array($rs)){ ?>
<option value="<?php echo $row['category']; ?>"><?php echo $row['category']; ?></option>
<?php } ?>
</select></p>
<p><input type="text" id="name" name="name" placeholder="Name Of The File" style="width:220px;"/><br />
<input type="file" id="file" name="file" placeholder="Choose File to Upload" /></p>

<p><input type="submit" name="submit" id="button" value="Save" class="btn btn-success"/></p>	
	
</div>
</fieldset>
</form>
<script type='text/javascript' src="../../../../javascript/bootstrap.min.js"></script>
       <script>
 
 $(document).ready(function(){
 $('#button').button();

 $('#button').click(function() {
 	var a=document.getElementById('name').value;
 	var b=document.getElementById('file').value;
 	
 	if(a!='' && b!='' ){
		$(this).button('loading');
	}
   
 });  
});
</script>