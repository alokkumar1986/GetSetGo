<?PHP
require_once("../../include/membersite_config.php");
include("../class.database.php");
$db2 = new Database();  
$db2->connect();
if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
if($_GET['action']=='delete'){
	//$fgmembersite->Deletecollege($_GET['college']);
	$fgmembersite->DBLogin();
	$rs=mysql_query("delete from `verbaltest` where `id`='$_GET[id1]'");
	/*$rs1=mysql_query("delete from test_setting where `test_id`='$_GET[test_id]'");
	$rs2=mysql_query("delete from test_section_setting where `test_id`='$_GET[test_id]'");
	$rs3=mysql_query("delete from test_section_category where `test_id`='$_GET[test_id]'");
	$rs4=mysql_query("delete from test_questionset where `test_id`='$_GET[test_id]'");
	$rs5=mysql_query("delete from online_test where `test_id`='$_GET[test_id]'");
	$rs6=mysql_query("delete from temp_test_result where `test_id`='$_GET[test_id]'");
	$rs7=mysql_query("delete from student_result where `test_id`='$_GET[test_id]'");
	$rs8=mysql_query("delete from questions where `test`='$_GET[test_id]'");
	$rs9=mysql_query("delete from test_question where `test_id`='$_GET[test_id]'");
	*/
}
?>

      <title>Email Writting/Verbal Test List</title>
     
    <style type="text/css" title="currentStyle">
			
			@import "../../css/jquery.dataTables.css";
		</style>
		<script type="text/javascript" language="javascript" src="../../js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="../../js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#example').dataTable({
        "bProcessing": true
    } );
			} );
		</script>
		<style>
			#example_length select {
				width:53px !important;
			}
			
		</style>
		<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	
	$('table.display th') .click(
		function() {
			$(this) .parents('table.display') .children('tbody') .toggle();
		}
	)
	
	$('table.StateTable tr.statetablerow th') .click(
		function() {
			$(this) .parents('table.StateTable') .children('tbody') .toggle();
		}
	)
	

	
});
</script>-->
<!--<div id='fg_membersite'>--><div onload="readURL(input);">
<form id='changepwd' action='' method='post' enctype="multipart/form-data">

<fieldset>
<legend><font color="#330099" ><strong>View Verbal (Email Writting)Tests For College</strong></font></legend>
<?php if($_GET['id1']!='' and $_GET['action']==''){ ?><div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <?php echo "Test is created/updated successfully..."; ?> </div> <?php } ?>
<div>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
	<thead>
		<tr>
			
			<th>College Name</th>
		
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$sql="select * from `verbaltest`";
	$rs=mysql_query($sql);
	while($row=mysql_fetch_array($rs)){
		?>
		<tr class="odd gradeX">
			
			<td><?php echo $row['college']; ?></td>
			<td><a href="?id=update email test&action=edit&id1=<?php echo $row['id']; ?>"><img src="../../image/edit.jpg" height="20" width="20" title="Edit"/></a> &nbsp;&nbsp;<a href="?id=view email tests&action=delete&id1=<?php echo $row['id']; ?>"><img src="../../image/delete.jpg" height="20" width="20" title="Delete" onclick="return confirm('Are You Sure to delete this entry?')"></a></td>
		</tr>		
	<?php }
	?>
		
		</tbody>
		</table>
	
	
</div>
</fieldset>
</form>
</div>
 
