<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}
if(isset($_POST['submitted']))
{
   if($fgmembersite->Addsection())
   {
         $_SESSION['successsection']="Section Added Successfully";
   	    //$fgmembersite->HandleDBError("Section Added Successfully");
   }
} 
$fgmembersite->DBLogin();

?>
<script type="text/javascript" src="../../../../javascript/bootstrap-2.3.2.min.js"></script>
<link rel="stylesheet" href="../../../../css/bootstrap-multiselect.css" type="text/css">
<script type="text/javascript" src="../../../../javascript/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="../../../../css/prettify.css" type="text/css">
<script type="text/javascript" src="../../../../javascript/prettify.js"></script>
<script>
$('.dropdown input, .dropdown label').click(function (event) {
 event.stopPropagation();
 });
</script>
<script type="text/javascript">
$(document).ready(function() {
window.prettyPrint() && prettyPrint();
 $('.text-input').multiselect({
	includeSelectAllOption: true
	});
   
});
</script>
<div>
<form id='changepwd' action='' method='post' enctype="multipart/form-data">

<fieldset style="float:center;" >
<legend><font color="#330099" ><strong>Add Section</strong></font></legend>
<?php if($_SESSION['successsection']!=''){ ?><div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <?php echo $_SESSION['successsection']; ?> </div> <?php } $_SESSION['successsection']=''; ?>
<?php if($fgmembersite->GetErrorMessage()){ ?><div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <?php echo $fgmembersite->GetErrorMessage(); ?> </div> <?php } ?>
<input type='hidden' name='submitted' id='submitted' value='1' />
<p><select name="category[]" class="validate[required] text-input" style="color: grey;width:98% !important;" multiple="multiple">
                   	
                   <!--	<option value="" selected="selected">-Select Parent Category-</option> -->
                   	<?php $sql=mysql_query("select * from test_category where parent_category_id='0' order by name")or die(mysql_error());
                   	while($rs=mysql_fetch_array($sql)){ ?>
					
					<!--<option value="<?php //echo $rs['category_id']; ?>"><?php //echo $rs['name']; ?></option> -->
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
                   </select> &nbsp;<span>Select Category </span> 
                   </p>
<p><input name="sections" id="sections" type="text" placeholder="Section Name" /></p>

    <input type='submit' class="btn btn-success" id="button1" name='Submit' value='Submit' /> &nbsp;&nbsp;&nbsp;<a href="?id=view sections" class="btn btn-danger" style="float: right;margin-left:10px;margin-right:10px;">View All Secions</a>&nbsp;&nbsp;&nbsp;<a href="?id=create test" class="btn btn-info" style="float: right;">Create Test</a>
</fieldset>
</form>
</div>
<script type='text/javascript' src="../../../../javascript/bootstrap.min.js"></script>