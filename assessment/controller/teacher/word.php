<?php 
require_once("../../include/membersite_config.php");
error_reporting(0);
if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}
$fgmembersite->DBLogin();

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=$_POST[test].$_POST[shortname].xls"); 
?>
<div>
<form id='changepwd' action='report.php' method='post' target="_blank" enctype="multipart/form-data">

<fieldset>
<legend><font color="#330099" ><strong><?php echo $_POST['test']; ?> Report for <?php echo $_POST['shortname']; ?>-<?php echo  $yop=str_replace("multiselect-all,",'',implode(",",$_POST['yop'])); ?> </strong></font></legend>
<table  cellpadding="0" cellspacing="0" border="1" class="display" id="example" width="100%"><thead><tr><th rowspan="2">Name</th><th rowspan="2">Regd No.</th><th rowspan="2">Branch</th>
<?php $at=mysql_query("select * from online_test where (test_id='".$_POST['test']."' and  STATUS='ACTIVE') order by CATEGORY");
$count=mysql_num_rows($at);
?><td rowspan="2">
<table cellpadding="0" cellspacing="0" border="1" width="100%">

<!--<tr><th colspan="<?php echo $count; ?>">
Module & Score</th></tr>-->
<tr>
<?php
while($rat=mysql_fetch_array($at)){ ?>
<th><?php echo $rat['CATEGORY']; ?></th>
<?php } ?>
</tr></table>
</td>
<th rowspan="2">Total Question</th><th rowspan="2">Corrrect</th><th rowspan="2">Incorrect</th><th rowspan="2">Unattempted</th>
<th rowspan="2">Instance</th></tr></thead>
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
$rs12=mysql_query("select * from student_result where test_id='".$row['test_id']."' and cat_id='$row[CATEGORY]' AND reg_no='".$row1['REG_NO']."'");  
$count12=mysql_num_rows($rs12);
if($count12){
while($row12=mysql_fetch_array($rs12)){

$queid=explode(",",$row12['question_attend']);
$ia=count(explode(",",$row12['question_attend']));
	//$ans=explode(",",$row12['correct_ans']);
	$un=0;
	$cor=0;
	for($j=0;$j<$ia;$j++){
	//echo $queid[$j];
	$quest=mysql_query("select * from `questions` where id='".$queid[$j]."'");
if($rowquest=mysql_fetch_array($quest)){
$ans=$rowquest['corans'];
}
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
	if($row2[answer]==$ans){
	$cor++;
	}
	//echo $instance=$row2['instance'];
	}
	
	}
	$c=((($mark*$cor)-($minus*($un-$cor)))/$ia)*100;
?>

 <td><table ><tr><td><?php  echo round($c,2); ?>%</td>

</tr></table></td>
<td><?php echo $ia; ?></td>
<td><?php echo $cor; ?></td>
<td><?php echo ($un-$cor); ?></td>
<td><?php echo ($ia-$un); ?></td>
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
<td><?php echo $ia; ?></td>
<td>0</td>
<td>0</td>
<td>0</td>
<?php } ?>
<td>Not Attempted</td>
</tr>
<?php } } ?>
</tbody></table>
</fieldset>
</form>
</div>