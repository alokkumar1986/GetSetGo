<?PHP
require_once("../../include/membersite_config.php");
$fgmembersite->DBLogin();
$reg_no=$_GET['candidate'];
$query="update `activitylog` set `activity`='off', `out`=now() where reg_no='$reg_no'";
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
<legend><font color="#330099" ><strong>Activity Log</strong></font><span style="float:right;"><font color="#FF0000" size="2" style="font-weight:bold;" >
<?php $countuser=mysql_num_rows($rs=mysql_query("SELECT *
FROM `activitylog` a, `student_data` s
WHERE (a.`reg_no` = s.`REG_NO`
AND s.`COLLEGE` = '".$_SESSION['actingrole']."' AND a.`activity`='on')"));
echo $countuser; ?> User(s) is/are online.</font></span></legend>

<div>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
	<thead>
		<tr>
		<th>Activity</th>
			<th>Reg No.</th>
			<th>Name</th>
		
			<th>Last Logged In</th>
			<th>Last Logged Out</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	$sql="SELECT *
FROM `activitylog` a, `student_data` s
WHERE a.`reg_no` = s.`REG_NO`
AND s.`COLLEGE` = '".$_SESSION['actingrole']."' order by a.`activity` asc";
	$rs=mysql_query($sql);
	while($row=mysql_fetch_array($rs)){
		?>
		<tr class="odd gradeX">
		<td><?php if($row['activity']=='on'){ echo "<font color=green size=4> Online</font>"; }if($row['activity']=='off'){ echo "<font color=red size=2>Offline</font>"; } ?></td>
			<td><?php echo $row['reg_no']; ?></td>
			<td>
		<?php $sql22="select * from `student_data` where REG_NO='".$row['reg_no']."' and COLLEGE='".$_SESSION['actingrole']."'";
	$rs22=mysql_query($sql22);
	if($row22=mysql_fetch_array($rs22)){
	$name=$row22['NAME'];
	} 
	echo $name; ?></td>
			<td><?php echo $row['in']; ?></td>
			<td><?php echo $row['out']; ?></td>
			<td><?php if($row['activity']=='on'){ ?><a href="?id=activity log&candidate=<?php echo $row['reg_no']; ?>" class="btn-primary">LogOut</a><?php } ?>
			<?php if($row['activity']=='off'){ ?><a href="#" class="btn-danger">Offline</a><?php } ?></td>
		</tr>		
	<?php }
	?>
		
		</tbody>
		</table>
	
	
</div>
</fieldset>
</form>
</div>
 
