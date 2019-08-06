<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}
if(isset($_POST['submitted']))
{
   if($fgmembersite->testsetting())
   {
     $fgmembersite->RedirectToURL("?id=setting&test_id=$_POST[test]&college=$_POST[college]");
   }
}

$fgmembersite->DBLogin();

?>

<div>
<form id='changepwd' action='?id=test log1' method='post' enctype="multipart/form-data">

<fieldset style="float:center;" >
<legend><font color="#330099" ><strong> Test Log</strong></font></legend>

<input type='hidden' name='submitted' id='submitted' value='1' />

<p><select name="test" id="test" style="color: grey;">
<option value="">-Select Test-</option>
<?php $sql=mysql_query("select distinct(test_id),test_name from test_tests")or die(mysql_error());
                   	while($rs=mysql_fetch_array($sql)){ ?>
					<option value="<?php echo $rs['test_id']; ?>"><?php echo $rs['test_name']; ?></option>
<?php } ?>
</select>
</p>

 <input type='submit' class="btn btn-success" id="button1" name='Submit' value='See Result' />

    <!--&nbsp;&nbsp;&nbsp;<a href="?id=view sections" class="btn btn-danger" style="float: right;margin-left:10px;margin-right:10px;">View All Secions</a>&nbsp;&nbsp;&nbsp;<a href="?id=create test" class="btn btn-info" style="float: right;">Create Test</a> -->
</fieldset>
</form>

</div>