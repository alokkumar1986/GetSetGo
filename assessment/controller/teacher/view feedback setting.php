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
	$rs=mysql_query("delete from feedback where `id`='$_GET[fid]'");
	/*$rs1=mysql_query("delete from test_setting where `test_id`='$_GET[test_id]'");
	$rs2=mysql_query("delete from test_section_setting where `test_id`='$_GET[test_id]'");
	$rs3=mysql_query("delete from test_section_category where `test_id`='$_GET[test_id]'");
	$rs4=mysql_query("delete from test_questionset where `test_id`='$_GET[test_id]'");
	$rs5=mysql_query("delete from online_test where `test_id`='$_GET[test_id]'");
	$rs6=mysql_query("delete from temp_test_result where `test_id`='$_GET[test_id]'");
	$rs7=mysql_query("delete from student_result where `test_id`='$_GET[test_id]'");
	$rs8=mysql_query("delete from questions where `test`='$_GET[test_id]'");
	$rs9=mysql_query("delete from test_question where `test_id`='$_GET[test_id]'"); */
}
?>

      <title>Feedback Setting List</title>
      
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
<legend><font color="#330099" ><strong>View Feedback Setting</strong></font></legend>
<?php if($_GET['test_id']!='' and $_GET['action']==''){ ?><div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <?php echo "Test ".$_GET['test_id']." is created successfully...You need to configure this test under Test Configuration menu."; ?> </div> <?php } ?>
<div>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
	<thead>
		<tr>
			<th>Feedback ID</th>
			<th>College</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Attempt</th>
		   	<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$sql="select * from `feedback`";
	$rs=mysql_query($sql);
	while($row=mysql_fetch_array($rs)){
		?>
		<tr class="odd gradeX">
        <td><?php echo $row['id']; ?></td>
			<td><?php echo $row['college']; ?></td>
			<td><?php echo $row['startdate']; ?></td>
            <td><?php echo $row['enddate']; ?></td>
            <td><?php echo $row['attempt']; ?></td>
			<td><!--<a href="?id=update subcategory&action=edit&category=<?php echo $row['category_id']; ?>"><img src="../../image/edit.jpg" height="20" width="20" title="Edit"/></a> -->&nbsp;&nbsp;<a href="?id=view feedback setting&action=delete&fid=<?php echo $row['id']; ?>"><img src="../../image/delete.jpg" height="20" width="20" title="Delete" onclick="return confirm('Are You Sure to delete this entry?')"></a></td>
		</tr>		
	<?php }
	?>
		
		</tbody>
		</table>
	
	
</div>
</fieldset>
</form>
</div>
 
