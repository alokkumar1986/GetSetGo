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
			.reply{ color: #fff;
background: #aaa;
font: 10px Tahoma,sans-serif;
padding: 2px 3px;
margin: 0 0 0 1px;
border: none; }
.reply:hover{
color: #fff;
background: #000;
font: 10px Tahoma,sans-serif;
padding: 2px 3px;
margin: 0 0 0 1px;
text-decoration:none;
border: none; }
.delete { color: #fff; background-color: #f06c6c;
font: 10px Tahoma,sans-serif;
padding: 2px 3px;
margin: 0 0 0 1px;
border: none; 
}
.delete:hover{
color: #fff;
background: #FF0000;
font: 10px Tahoma,sans-serif;
padding: 2px 3px;
margin: 0 0 0 1px;
border: none; text-decoration:none;}
			
		</style>
   <fieldset>
<legend><font color="#330099" ><strong>Inbox </strong></font></legend>
		<form id='changepwd' action='' method='post' enctype="multipart/form-data">

<fieldset>
<div>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
	<thead style="border-bottom: 1px solid #ddd;">
		<tr >
			
			<th>Message</th>
			<th>From</th>
			<th>Date</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$sql="select * from `message` where `to` ='Adminstrator'";
	$rs=mysql_query($sql);
	while($row=mysql_fetch_array($rs)){
		?>
		<tr class="odd gradeX">
			<td><?php echo substr($row['message'],0,200); ?></td>
			<td><?php echo $row['sentfrom']; ?></td>
			<td><?php echo date('d/m/Y',strtotime($row['date'])); ?></td>
			
			<td><a href="?id=reply&id1=<?php echo $row['id']; ?>" class="reply">Reply</a> &nbsp;&nbsp;&nbsp; <a href="?id=inbox&action=delete&id1=<?php echo $row['id']; ?>" class="delete" onclick="return confirm('Are You Sure to delete this entry?')">Delete </a></td>
		</tr>		
	<?php }
	?>
		
		</tbody>
		</table>
	
	
</div>
</fieldset>