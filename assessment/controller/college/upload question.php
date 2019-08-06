
<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

if(isset($_POST['submitted']))
{
   if($fgmembersite->Uploadquestion())
   {
       $fgmembersite->HandleDBError("Question Uploaded Successfully");
   }
}

?>

      <title>Upload Faculty(csv format)</title>
      
<div>
<form id='changepwd' action='' method='post' enctype="multipart/form-data">

<fieldset>
<legend><font color="#330099" ><strong>Upload Question(.csv file)</strong></font></legend>
<?php if($fgmembersite->GetErrorMessage()){ ?><div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <?php echo $fgmembersite->GetErrorMessage(); ?> </div> <?php } ?>
   <input type='hidden' name='submitted' id='submitted' value='1'/>
   <input type='hidden' name='user' id='user' value='<?php echo $_SESSION['email_of_user']; ?>' />
<p><select name="subject" id="subject" class="validate[required] text-input" style="color: grey;width:98% !important;">
			  <option value="">-Select Type-</option>
			  <option value="Multiple-Option">Multiple Option</option>
			  <option value="True/False">True/False</option>
			   <option value="Block-Level">Block Level</option>
			  </select>
</p>
<p>
 <select name="category" id="cat" class="validate[required] text-input" style="color: grey;width:98% !important;">
                   	
                   	<option value="" selected="selected">-Select Parent Category-</option>
                   	<?php $sql=mysql_query("select * from test_category where parent_category_id='0' order by name")or die(mysql_error());
                   	while($rs=mysql_fetch_array($sql)){ ?>
					<optgroup label="<?php echo $rs['name']; ?>">
					<?php $sql1=mysql_query("select * from test_category where parent_category_id='".$rs['category_id']."'")or die(mysql_error());
                   	while($rs1=mysql_fetch_array($sql1)){ ?>
					<option value="<?php echo $rs1['category_id']; ?>"><?php echo $rs['name']; ?>&rarr;<?php echo $rs1['name']; ?></option>	
					
					<?php $sql11=mysql_query("select * from test_category where parent_category_id='".$rs1['category_id']."'")or die(mysql_error());
                   	while($rs11=mysql_fetch_array($sql11)){ ?>
					<option value="<?php echo $rs11['category_id']; ?>"><?php echo $rs['name']; ?>&rarr;<?php echo $rs1['name']; ?>&rarr;<?php echo $rs11['name']; ?></option>	
					
					<?php $sql111=mysql_query("select * from test_category where parent_category_id='".$rs11['category_id']."'")or die(mysql_error());
                   	while($rs111=mysql_fetch_array($sql111)){ ?>
					<option value="<?php echo $rs111['category_id']; ?>"><?php echo $rs['name']; ?>&rarr;<?php echo $rs1['name']; ?>&rarr;<?php echo $rs11['name']; ?>&rarr;<?php echo $rs111['name']; ?></option>	
					
					<?php } } }
					 } ?>
					 </optgroup>
                   </select>
</p>
<p>
<input type="file" name="pic" placeholder="Photo" id="imgInp" accept=".csv" /></p>

    <input type='submit' id="button" class="btn btn-success" name='Submit' value='Submit' />
</fieldset>
</form>
</div>
 <script type='text/javascript' src="../../../../javascript/bootstrap.min.js"></script>
       <script>
        $(document).ready(function(){
 		$('#button').button();

 		$('#button').click(function() {
 	
		$(this).button('loading');
	 
 });
 
</script>
