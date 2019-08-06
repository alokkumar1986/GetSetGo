<?php require_once("../../include/membersite_config.php");
error_reporting(0);
if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
if(!$fgmembersite->DBLogin())
{
    $fgmembersite->HandleError("Database login failed!");
    return false;
} 
$college2=$_POST['college'];
$college1=explode('-',$college2);
$college=$college1['0'];
$college2=$college1['1'];
$branch1= $_POST['branch'];
$l=sizeof($branch1);
$branch='';
for($i=0;$i<$l;$i++){
$branch.="'".$branch1[$i]."'";
if($i<($l-1)){
$branch.=",";
}
}
//header("Content-type: application/vnd.ms-excel");
//header("Content-Disposition: attachment;Filename=$college.xls");

if($college!='' and $branch==''){
	$qry = "select * from student_data where COLLEGE_FULLNAME='$college'";
}
if($college=='' and $branch!=''){
	$qry = "select * from student_data where BRANCH in ($branch)";
}
if($college!='' and $branch!=''){
$qry = "select * from `student_data` where COLLEGE_FULLNAME='$college' and BRANCH in ($branch)";	
}
if($college=='' and $branch==''){
$qry = "select * from `student_data` ";	
}
//echo $qry;
$rs11=mysql_query($qry);

?>
<table border="1"><tr ><td style="border-bottom: 1px solid #000;background: yellow;color: #000" align="center" colspan='10' valign='top'><h4>Email Writting Report <?php if($college!=''){ ?>College : <?php echo $college; ?><?php } ?> </h4></td></tr>
<tr valign="top" ><td style="background: #000;color: #fff">REGD NO</td><td align="center" style="background: #000;color: #fff">Name</td><td align="center" style="background: #000;color: #fff">No Of Words</td>
<td align="center" style="background: #000;color: #fff">No Of Phrases</td>
<td align="center" style="background: #000;color: #fff">% Words </td>
<td align="center" style="background: #000;color: #fff">% Phrases </td>
<td align="center" style="background: #000;color: #fff">Answer</td>
<td align="center" style="background: #000;color: #fff">Total Time </td>
<td align="center" style="background: #000;color: #fff">Time Taken </td>
<td align="center" style="background: #000;color: #fff">Status </td></tr>

<?php
while($row=mysql_fetch_array($rs11)){
	
	$qry1="select * from `verbaltest_result` where (regd_no='$row[REG_NO]' and college='$college2' and status='finish')";
		//$qry1="select * from pi where (REGD_NO='$row[REG_NO]' and DATE='$dateofinterview')";
	$rs1=mysql_query($qry1);
	$count2=mysql_num_rows($rs1);
	if($count2==1){
		$row1=mysql_fetch_array($rs1); ?>
		<tr><td><?php echo $row1['regd_no']; ?></td>
		<td><?php echo $row['NAME']; ?></td>
		<td><?php echo str_word_count($row1['answer']); ?></td>
		<td><?php $arr1 = explode('-', $row1['question']);
$length=sizeof($arr1);
$count=0;
for($i=0;$i<$length;$i++){
if (strchr(str_replace(array("?","!",",",";","."), " ", strtolower($row['answer'])), "$arr1[$i]")) {
    $count++;
}
} 
echo $count; ?></td>
		<td><?php $perword=(int)((str_word_count($row1['answer'])/70)*100); if($perword<100){ echo $perword; ?>%<?php }else{ echo 100; ?>% <?php } ?></td>
		
		<td><?php $perphrase=(int)(($count/$length)*100); if($perphrase<100){ echo $perphrase; ?>%<?php }else{ echo 100; ?>% <?php } ?></td>
		<td><?php echo $row1['answer']; ?></td>
		<td><?php $sqlqry=mysql_query("select `duration` from `verbaltest` where `college`='".$college2."'")or die(mysql_error()); 
$rs=mysql_fetch_array($sqlqry);
echo $rs['duration'];
?> Mins</td>
		<td><?php $all = round((strtotime($row1['finished_time']) - strtotime($row1['started_time'])) / 60);
$all1 = round((strtotime($row1['finished_time']) - strtotime($row1['started_time'])) / 60,2);
$d = floor ($all / 1440);
$d1= floor ($all1 / 1440);
$m1 = $all1 - ($d1 * 1440);
$h = floor (($all - $d * 1440) / 60);
echo $m = $all - ($d * 1440);  ?>:<?php echo (int)(($m1-$m)*60); ?> Mins</td>
		<td>--</td>
		</tr>
		
		
		<?php
	}
}
		
?></table>