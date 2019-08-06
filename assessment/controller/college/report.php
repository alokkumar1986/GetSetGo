<?php require_once("../../include/membersite_config.php");
error_reporting(0);
if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}
$fgmembersite->DBLogin();

?>
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
		
<div>
<form id='changepwd' action='report.php' method='post' target="_blank" enctype="multipart/form-data">

<fieldset>
<legend><font color="#330099" ><strong><?php echo $_POST['test']; ?> Report for <?php echo $_POST['shortname']; ?>-<?php echo  $yop=str_replace("multiselect-all,",'',implode(",",$_POST['yop'])); ?> </strong></font></legend>
<table  cellpadding="0" cellspacing="0" border="1" class="display" id="example" width="100%"><thead><tr><th rowspan="2">Name</th><th rowspan="2">Regd No.</th><th rowspan="2">Branch</th>
<?php $at=mysql_query("select * from online_test where (test_id='".$_POST['test']."' and  STATUS='ACTIVE') order by CATEGORY");
$count=mysql_num_rows($at);
?><td colspan="<?php echo $count; ?>">
<table cellpadding="0" cellspacing="0" border="1" width="100%">

<tr><th colspan="<?php echo $count; ?>">
Module & Score</th></tr>
<tr>
<?php
while($rat=mysql_fetch_array($at)){ ?>
<th><?php echo $rat['CATEGORY']; ?></th>
<?php } ?>
</tr></table>
</td><th rowspan="2">Instance</th></tr></thead>
<tbody>
<?php $rs1=mysql_query("select * from `student_data` where (`COLLEGE`='".$_POST['shortname']."' and `COURSE_YOP` in ($yop)) order by REG_NO");
$i=1;
while($row1=mysql_fetch_array($rs1)){
$sql=mysql_query("select * from `test_status` where candidate='".$row1['REG_NO']."' and test_id='$_POST[test]' and status='finish' group by instance ");
$countres=mysql_num_rows($sql);
if($countres>=1){
while($res=mysql_fetch_array($sql)){
?>
<tr><td><?php echo $row1['NAME'];; ?></td>
<td><?php echo $row1['REG_NO']; ?></td>
<td><?php echo $row1['BRANCH']; ?></td>
<?php $rs=mysql_query("select * from online_test where (test_id='".$_POST['test']."' and  STATUS='ACTIVE') order by CATEGORY");
$count=mysql_num_rows($rs);
while($row=mysql_fetch_array($rs)){ 
$mark=$row['EACH_QUE_MARK_CORRECT'];
$minus=$row['EACH_QUE_MARK_WRONG'];
$rs12=mysql_query("select * from student_result where cat_id='$row[CATEGORY]' AND reg_no='".$row1['REG_NO']."'");  
$count12=mysql_num_rows($rs12);
if($count12){
while($row12=mysql_fetch_array($rs12)){

$queid=explode(",",$row12['question_attend']);
$ia=count(explode(",",$row12['question_attend']));
	$ans=explode(",",$row12['correct_ans']);
	$un=0;
	$cor=0;
	for($j=0;$j<$ia;$j++){
	//echo $queid[$j];
	
	$rs2=mysql_query("select * from `temp_test_result` where question_id='$queid[$j]' AND candidate='".$row1['REG_NO']."' AND instance='".$res['instance']."'");  
	?>
	
	<?php 
	while($row2=mysql_fetch_array($rs2)){
	//echo $row2[answer];
	if($row2[question_id]==$queid[$j]){
	if($row2[answer]){
	$un++;
	}
	}
	if($row2[answer]==$ans[$j]){
	$cor++;
	}
	//echo $instance=$row2['instance'];
	}
	
	}
	$c=((($mark*$cor)-($minus*($ia-($ia-$un)-$cor)))/$ia)*100;
?>

 <td><table ><tr><td><?php  echo round($c,2); ?>%</td>

</tr></table></td>
<?php }

 }else{
 }
 } ?><td><?php if($res['instance']>=1){ echo $res['instance']; }else { echo "Not Attempted"; }?></td> <?php }  ?>


	</tr>
<?php }else{ ?>
<tr>
<tr><td><?php echo $row1['NAME'];; ?></td>
<td><?php echo $row1['REG_NO']; ?></td>
<td><?php echo $row1['BRANCH']; ?></td>
<?php $rs=mysql_query("select * from online_test where (test_id='".$_POST['test']."' and  STATUS='ACTIVE') order by CATEGORY");
$count=mysql_num_rows($rs);
while($row=mysql_fetch_array($rs)){  ?>
<td><table  ><tr><td><?php  echo "0"; ?>%</td>

</tr></table></td>

<?php } ?>
<td>Not Attempted</td>
</tr>
<?php } } ?>
</tbody></table>
</fieldset>
</form>
</div>