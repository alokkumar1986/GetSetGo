<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
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
 $('#modules').multiselect({
	includeSelectAllOption: true
	});
  
});
</script>
<div>
<form id='changepwd' action='download.php' target="_blank" method='post' enctype="multipart/form-data">

<fieldset style="float:center;" >
<legend><font color="#330099" ><strong>Download Test Paper (Word Format)</strong></font></legend>
<?php if($_SESSION['successsection']!=''){ ?><div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <?php echo $_SESSION['successsection']; ?> </div> <?php } $_SESSION['successsection']=''; ?>
<?php if($fgmembersite->GetErrorMessage()){ ?><div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <?php echo $fgmembersite->GetErrorMessage(); ?> </div> <?php } ?>
<!--<input type='hidden' name='submitted' id='submitted' value='1' /> -->
<p><select name="test" id="test" style="color: grey;width:30% !important;" onchange="">
<option value="">-Select Test-</option>
<?php 
$query=mysql_query("select distinct(test_id)  from `online_test`");
while($row=mysql_fetch_array($query)){
$sql=mysql_query("select * from `test_tests` where test_id='".$row['test_id']."'")or die(mysql_error());
                   	while($rs=mysql_fetch_array($sql)){ ?>
					<option value="<?php echo $rs['test_id']; ?>"><?php echo $rs['test_name']; ?></option>
<?php } }?>
</select></p>
    <input type='submit' class="btn btn-success" id="button1" name='Submit' value='Download Now' /> <!--&nbsp;&nbsp;&nbsp;<a href="?id=view sections" class="btn btn-danger" style="float: right;margin-left:10px;margin-right:10px;">View All Secions</a>&nbsp;&nbsp;&nbsp;<a href="?id=create test" class="btn btn-info" style="float: right;">Create Test</a> -->
</fieldset>
</form>
<!-- client-side Form Validations:
Uses the excellent form validation script from JavaScript-coder.com-->





</div>