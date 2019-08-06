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
	$rs=mysql_query("delete from college where id='$_GET[college]'");
}
?>

      <title>Faculty List</title>
      
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
<!--<div id='fg_membersite'>--><div onload="readURL(input);">
<form id='changepwd' action='' method='post' enctype="multipart/form-data">

<fieldset>
<legend><font color="#330099" ><strong>View Subject/Category</strong></font></legend>
<div>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
	<thead>
		<tr>
			<th>Name</th>
			<th>Parent</th>
			
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$sql="select * from test_category";
	$rs=mysql_query($sql);
	while($row=mysql_fetch_array($rs)){
		?>
		<tr class="odd gradeX">
			<td><?php echo $row['name']; ?></td>
			<td><?php echo $row['short_name']; ?></td>
			<td><?php echo $row['university']; ?></td>
			<td><a href="?id=updatecollege&action=edit&college=<?php echo $row['id']; ?>"><img src="../../image/edit.jpg" height="20" width="20" title="Edit"/></a>&nbsp;&nbsp;<a href="?id=view college&action=delete&college=<?php echo $row['id']; ?>"><img src="../../image/delete.jpg" height="20" width="20" title="Delete" onclick="return confirm('Are You Sure to delete this entry?')"></a></td>
		</tr>		
	<?php }
	?>
		
		</tbody>
		</table>
	
	
</div>
</fieldset>
</form>
</div>
 
