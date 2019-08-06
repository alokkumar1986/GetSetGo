<?PHP
require_once("../../include/membersite_config.php");
$fgmembersite->DBLogin();
$instance=$_GET['instance'];
$test_id=$_GET['test'];
$candidate=$_GET['candidate'];
$query="INSERT INTO `test_status` (`id`, `test_id`, `candidate`, `status`, `instance`) VALUES (NULL, '$test_id', '$candidate', 'finish', '$instance')";
mysql_query($query);
?>

      <title>Activity Log</title>
      
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
<legend><font color="#330099" ><strong>Test Log</strong></font></legend>

<div>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
	<thead>
		<tr>
			<th>Reg No.</th>
			<th>Name</th>
			<th>Test</th>
		    <th>STime</th>
			<th>Instance</th>
			<th>Activity</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	 $sql="SELECT `candidate`,`test_id`,`instance`,`stime` from `test_timer` where `test_id`='".$_REQUEST['test']."' group by `candidate`,`instance` ORDER BY `instance`";
	$rs=mysql_query($sql);
	while($row=mysql_fetch_array($rs)){
	$sql11="select * from test_status where `candidate`='".$row['candidate']."' and `test_id`='".$row['test_id']."' and `instance`='".$row['instance']."'";
	$rs1=mysql_query($sql11);
	$count=mysql_num_rows($rs1);
	if($count=='0'){
	$sql22="select * from `student_data` where REG_NO='".$row['candidate']."'";
	$rs22=mysql_query($sql22);
	if($row22=mysql_fetch_array($rs22)){
	$name=$row22['NAME'];
	}
		?>
		<tr class="odd gradeX">
			<td><?php echo $row['candidate']; ?></td>
			<td><?php echo $name; ?></td>
			<td><?php  echo $row['test_id']; ?></td>
			<td><?php  echo $row['stime']; ?></td>
			<td><?php echo $row['instance']; ?></td>
			<td><?php echo "Not Submitted"; ?></td>
			<td><a href="?id=test log1&candidate=<?php echo $row['candidate']; ?>&test=<?php  echo $row['test_id']; ?>&instance=<?php echo $row['instance']; ?>" class="btn-danger">Submit</a></td>
		</tr>		
	<?php } }	?>
		
		</tbody>
		</table>
	
	
</div>
</fieldset>
</form>
</div>
 
