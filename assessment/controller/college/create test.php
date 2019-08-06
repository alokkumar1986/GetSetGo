<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}
if(isset($_POST['submitted']))
{
   if($fgmembersite->Createtest())
   {
      $fgmembersite->RedirectToURL("?id=view tests&test_id=$_POST[test_unique_code]");   
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
 $('#modules').multiselect({
	includeSelectAllOption: true
	});
   
});
</script>
<style>
.radio, .checkbox{
height:0px !important;
}
label{
height:0px !important;
}
</style>
<?php function randomCode($length=4) {
 
/* Only select from letters and numbers that are readable - no 0 or O etc..*/
$characters = "23456789ABCDEFHJKLMNPRTVWXYZ";
 
for ($p = 0; $p < $length; $p++)
{
$string .= $characters[mt_rand(0, strlen($characters)-1)];
}
 
return $string;
 
} ?>
<script type="text/javascript">
function createcode(){
var a=document.getElementById("test_name").value;
if(a!=''){
var b=document.getElementById("code").value;
document.getElementById("test_unique_code").value=b;
}
}
</script>
<script type='text/javascript' src="../../../../javascript/bootstrap.min.js"></script>
<div>
<form id='changepwd' action='' method='post' enctype="multipart/form-data">

<fieldset style="float:center;" >
<legend><font color="#330099" ><strong>Create A Test</strong></font></legend>

<?php if($fgmembersite->GetErrorMessage()){ ?><div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <?php echo $fgmembersite->GetErrorMessage(); ?> </div> <?php } ?>
   
    <input type='hidden' name='code' id='code' value='<?php echo $a=randomCode(); ?>' />
   <input type='hidden' name='submitted' id='submitted' value='1' />
<p><input name="test_name" id="test_name" type="text" placeholder="Test Name" onblur="createcode()"/></p>
<p><input type="text" name="test_unique_code" id="test_unique_code" placeholder="Test Unique Code" /></p>
<p><select name="modules[]" id="modules" style="color: grey;width:30% !important;" multiple="multiple" >
<!--<option value="">-Select-</option> -->
<?php $sql=mysql_query("select * from test_section order by section_id desc")or die(mysql_error());
                   	while($rs=mysql_fetch_array($sql)){ ?>
					<option value="<?php echo $rs['section_id']; ?>"><?php echo $rs['section_name']; ?></option>
<?php } ?>
</select> Select Sections </p>


<br/>
    <input type='submit' class="btn btn-success" id="button1" name='Submit' value='Submit' /> &nbsp;&nbsp;&nbsp;<a href="?id=view tests" class="btn btn-danger" style="float: right;margin-left:10px;margin-right:10px;">View All Tests</a>&nbsp;&nbsp;&nbsp;<a href="?id=add section" class="btn btn-info" style="float: right;">Add Sections </a>
</fieldset>
</form>
<!-- client-side Form Validations:
Uses the excellent form validation script from JavaScript-coder.com-->





</div>