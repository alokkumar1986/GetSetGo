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
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=$college.xls");

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

$rs=mysql_query($qry);

?>
<table border="1"><tr ><td style="border-bottom: 1px solid #000;background: yellow;color: #000" align="center" colspan='9' valign='top'><h4>Email Writting Report <?php if($college!=''){ ?>College : <?php echo $college; ?><?php } ?> </h4></td></tr>
<tr valign="top" ><td style="background: #000;color: #fff">REGD NO</td><td align="center" style="background: #000;color: #fff">Name</td><td align="center" style="background: #000;color: #fff">No Of Words</td>
<td align="center" style="background: #000;color: #fff">No Of Phrases</td>
<td align="center" style="background: #000;color: #fff">% Words </td>
<td align="center" style="background: #000;color: #fff">% Phrases </td>
<td align="center" style="background: #000;color: #fff">Total Time </td>
<td align="center" style="background: #000;color: #fff">Time Taken </td>
<td align="center" style="background: #000;color: #fff">Status </td></tr>

<?php
while($row=mysql_fetch_array($rs)){
	
	$qry1="select * from `verbaltest_eval` where (regd_no='$row[REG_NO]' and college='$college2')";
		//$qry1="select * from pi where (REGD_NO='$row[REG_NO]' and DATE='$dateofinterview')";
	$rs1=mysql_query($qry1);
	$count=mysql_num_rows($rs1);
	if($count==1){
		$row1=mysql_fetch_array($rs1);
		?>
		<tr><td><?php echo $row1['regd_no']; ?></td>
		<td><?php echo $row['NAME']; ?></td>
		<td><?php echo $row1['no_word']; ?></td>
		<td><?php echo $row1['matched_phrase']; ?></td>
		<td><?php echo $row1['per_word']; ?></td>
		
		<td><?php echo $row1['per_phrase']; ?></td>
		<td><?php echo $row1['total_time']; ?>Mins</td>
		<td><?php echo $row1['time_taken']; ?>Mins</td>
		<td><?php echo $row1['status']; ?></td>
		</tr>
		
		
		<?php
	}
}
		
?></table>