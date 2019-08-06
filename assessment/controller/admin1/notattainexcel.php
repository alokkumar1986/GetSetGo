<?php require_once("../../include/membersite_config.php");
//error_reporting(0);
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
        $college=$_POST['college'];
$branch=$_POST['stream'];
$dateofinterview=$_POST['date'];
$interviewer=$_POST['interviewer'];
$interviewtype=$_POST['interviewtype'];
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=$college$dateofinterview.xls");

if($college!='' and $branch==''){
	$qry = "select * from student_data where COLLEGE='$college'";
}
if($college=='' and $branch!=''){
	$qry = "select * from student_data where BRANCH='$branch'";
}
if($college!='' and $branch!=''){
$qry = "select * from student_data where COLLEGE='$college' and BRANCH='$branch'";	
}

$rs=mysql_query($qry);
?>
<table border="1">
<tr>
<td align="center" colspan="4"><h4><?php if($interviewtype!=""){ echo $interviewtype; } ?> Interview Non-Attendance Report (Date : <?php echo $dateofinterview; ?>)<br/><?php if($college!=''){ ?>College : <?php echo $college; ?> <?php } ?> <?php if($branch!=''){ ?>Branch : <?php echo $branch; ?><?php } ?></h4></td></tr>
<tr valign="top"><th>REGD NO</th><th>NAME </th><th>BRANCH </th><th>STATUS</th></tr>
<?php
while($row=mysql_fetch_array($rs)){
	if($interviewer!=''){
		if($interviewtype=="PI")
		$qry1="select * from pi where (REGD_NO='$row[REG_NO]' and DATE='$dateofinterview' and INTERVIEWER='$interviewer')";
		if($interviewtype=="TI")
		$qry1="select * from ti where (REGD_NO='$row[REG_NO]' and DATE='$dateofinterview' and INTERVIEWER='$interviewer')";
	}
	if($interviewer==''){
		if($interviewtype=="PI")
		$qry1="select * from pi where (REGD_NO='$row[REG_NO]' and DATE='$dateofinterview' )";
		if($interviewtype=="TI")
		$qry1="select * from ti where (REGD_NO='$row[REG_NO]' and DATE='$dateofinterview' )";
	}
	$rs1=mysql_query($qry1);
	$count=mysql_num_rows($rs1);
	
		//$row1=mysql_fetch_array($rs1);
		?>
		<tr valign="top">
		<td ><?php echo $row['REG_NO']; ?></td>
		<td><?php echo $row['NAME']; ?> </td>
		<td><?php echo $row['BRANCH']; ?></td>
		<td><?php if($count==1){ ?> Attended <?php }else { ?>Not Attended <?php } ?></td>
		</tr>
		<?php  } ?>
</table>