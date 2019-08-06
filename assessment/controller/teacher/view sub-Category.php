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
	$rs=mysql_query("delete from test_category where category_id='".$_GET[category]."'")or die(mysql_error());
	$rs1=mysql_query("delete from test_question_multiple_choice where category='".$_GET[category]."'")or die(mysql_error());
	$rs2=mysql_query("delete from test_question_true_false where category='".$_GET[category]."'")or die(mysql_error());
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
	$sql="select * from test_category where parent_category_id !='0' order by parent_category_id";
	$rs=mysql_query($sql);
	while($row=mysql_fetch_array($rs)){
		?>
		<tr class="odd gradeX">
			<td><?php echo $row['name']; ?></td>
			<td><?php $sql1=mysql_query("select * from test_category where category_id='".$row['parent_category_id']."'")or die(mysql_error());
			if($rs1=mysql_fetch_array($sql1)){ ?>
					<?php echo $rs1['name']; ?>	
					
					<?php $sql11=mysql_query("select * from test_category where category_id='".$rs1['parent_category_id']."'")or die(mysql_error());
                   	if($rs11=mysql_fetch_array($sql11)){ ?>
					&rarr;<?php echo $rs11['name']; ?>
					<?php $sql111=mysql_query("select * from test_category where category_id='".$rs11['parent_category_id']."'")or die(mysql_error());
                   	if($rs111=mysql_fetch_array($sql111)){ ?>
			&rarr;<?php echo $rs111['name']; ?>
			<?php }}}?><td><a href="?id=update subcategory&action=edit&category=<?php echo $row['category_id']; ?>"><img src="../../image/edit.jpg" height="20" width="20" title="Edit"/></a>&nbsp;&nbsp;<a href="?id=view sub-Category&action=delete&category=<?php echo $row['category_id']; ?>"><img src="../../image/delete.jpg" height="20" width="20" title="Delete" onclick="return confirm('Are You Sure to delete this entry?')"></a></td>
		</tr>		
	<?php }
	?>
		
		</tbody>
		</table>
	
	
</div>
</fieldset>
</form>
</div>
 
