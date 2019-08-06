<?PHP require_once("checklogin.php");
$fgmembersite->DBLogin();
if($_GET['action']=='delete'){
	//$fgmembersite->Deletenotice($_GET['id1']);
	
	$rs=mysql_query("delete from `message` where id='$_GET[id1]'");
}
?>
<style type="text/css" title="currentStyle">
			
			@import "../../css/jquery.dataTables.css";
		</style>
		<script type="text/javascript" language="javascript" src="../../js/jquery.js"></script>
		<script type="text/javascript" language="javascript" src="../../js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf-8">
			$(document).ready(function() {
				$('#example').dataTable();
			} );
		</script>
        <style>
			#example_length select {
				width:53px !important;
			}
			
		</style>
   <fieldset>
<legend><font color="#330099" ><strong>Sent Messages </strong></font></legend>
		<form id='changepwd' action='' method='post' enctype="multipart/form-data">

<fieldset>
<div>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
	<thead style="border-bottom: 1px solid #ddd;">
		<tr >
			
			<th>Message</th>
			<th>To</th>
			<th>Date</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$sql="select * from `message` where `sentfrom` ='Adminstrator' order by id desc";
	$rs=mysql_query($sql);
	while($row=mysql_fetch_array($rs)){
		?>
		<tr class="odd gradeX">
			<td><?php echo substr($row['message'],0,120); ?></td>
			<td><?php echo $row['to']; ?> Passout <?php echo $row['branch']; ?>,<?php echo $row['college']; ?></td>
			<td><?php echo date('d/m/Y',strtotime($row['date'])); ?></td>
			
			<td><a href="?id=sent messages&action=delete&id1=<?php echo $row['id']; ?>"><img src="images/trash.png" height="16" width="16" title="Delete" onclick="return confirm('Are You Sure to delete this entry?')"></a></td>
		</tr>		
	<?php }
	?>
		
		</tbody>
		</table>
	
	
</div>
</fieldset>