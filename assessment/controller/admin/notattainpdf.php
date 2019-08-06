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
        $college=$_POST['college'];
$branch=$_POST['stream'];
$dateofinterview=$_POST['date'];
$interviewer=$_POST['interviewer'];
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=$college$dateofinterview.xls");

if($college!='' and $branch==''){
	$qry = "select REG_NO from student_data where COLLEGE='$college'";
}
if($college=='' and $branch!=''){
	$qry = "select REG_NO from student_data where BRANCH='$branch'";
}
if($college!='' and $branch!=''){
$qry = "select REG_NO from student_data where COLLEGE='$college' and BRANCH='$branch'";	
}

$rs=mysql_query($qry);

?>
<table border="1"><tr style="border-bottom: 1px solid #000;"><td align="center" colspan='7'><h4>Technical Interview Report (Date : <?php echo $dateofinterview; ?>)<br/><?php if($college!=''){ ?>College : <?php echo $college; ?>,<?php } ?> <?php if($branch!=''){ ?>Branch : <?php echo $branch; ?><?php } ?></h4></td></tr>
<tr valign="top"><td rowspan="2">REGD NO</td><td align="center">Tech Interview Assesment </td><td rowspan="2">Technical Feedback </td><td rowspan="2">Other Feedback </td><td rowspan="2">Overall Rating </td><td rowspan="2">Inrviewer </td><td rowspan="2">Time Taken </td></tr>
<tr><td>
<table border="1"> <tr><td>Disposiotion</td><td>Career</td><td>Communication</td><td>Knowledge in own area</td><td>IT Awareness</td><td>Confidence</td></tr></table>
</td></tr>
<?php
while($row=mysql_fetch_array($rs)){
	if($interviewer!=''){
		$qry1="select * from ti where (REGD_NO='$row[REG_NO]' and DATE='$dateofinterview' and INTERVIEWER='$interviewer')";
	}
	if($interviewer==''){
		$qry1="select * from ti where (REGD_NO='$row[REG_NO]' and DATE='$dateofinterview' )";
	}
	$rs1=mysql_query($qry1);
	$count=mysql_num_rows($rs1);
	if($count==1){
		$row1=mysql_fetch_array($rs1);
		?>
		<tr valign="top"><td ><?php echo $row1['REGD_NO']; ?></td><td> <table border="1"> <tr valign="top"><td><?php echo $row1['PER_DISPOSITION']; ?></td><td><?php echo $row1['CAREER']; ?></td><td><?php echo $row1['COMMUNICATION']; ?></td><td><?php echo $row1['KNOWLEDGE_AREA']; ?></td><td><?php echo $row1['IT_AWARNESS']; ?></td><td><?php echo $row1['CONFIDENCE']; ?></td></tr></table></td><td><?php echo $row1['TECH_FEEDBACK']; ?></td><td><?php echo $row1['OTHER_FEEDBACK']; ?> </td>
		<td><?php echo $row1['RATING']; ?> </td><td><?php echo $row1['INTERVIEWER']; ?> </td><td><?php echo $row1['TIME_TAKEN']; ?> </td></tr>

		<?php
	}
}
		
?></table>