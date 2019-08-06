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
$branch1= $_POST['branch'];
$l=sizeof($branch1);
$branch='';
for($i=0;$i<$l;$i++){
$branch.="'".$branch1[$i]."'";
if($i<($l-1)){
$branch.=",";
}
}
$dateofinterview=$_POST['date'];
$interviewer=$_POST['interviewer'];
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=$college$dateofinterview.xls");

if($college!='' and $branch==''){
	$qry = "select REG_NO from student_data where COLLEGE_FULLNAME='$college'";
}
if($college=='' and $branch!=''){
	$qry = "select REG_NO from student_data where BRANCH in ($branch)";
}
if($college!='' and $branch!=''){
$qry = "select REG_NO from student_data where COLLEGE_FULLNAME='$college' and BRANCH in ($branch)";	
}
if($college=='' and $branch==''){
$qry = "select REG_NO from student_data ";	
}

$rs=mysql_query($qry);

?>
<table border="1"><tr style="border-bottom: 1px solid #000;background: #000;color: #ffffff"><td align="center" colspan='7'><h4>Technical Interview Report (Date : <?php echo $dateofinterview; ?>)<br/><?php if($college!=''){ ?>College : <?php echo $college; ?>,<?php } ?> </h4></td></tr>
<tr valign="top" style="background: #ccc;color: green"><td rowspan="2">REGD NO</td><td align="center">Tech Interview Assesment </td><td rowspan="2">Technical Feedback </td><td rowspan="2">Other Feedback </td><td rowspan="2">Overall Rating </td><td rowspan="2">Inrviewer </td><td rowspan="2">Time Taken </td></tr>
<tr><td>
<table border="1"> <tr style="background: #ccc;color: green"><td>Disposiotion</td><td>Career</td><td>Communication</td><td>Knowledge in own area</td><td>IT Awareness</td><td>Confidence</td></tr></table>
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
		<tr valign="top"><td ><?php echo $row1['REGD_NO']; ?></td><td> <table border="1"> <tr valign="top"><td><?php echo $row1['PER_DISPOSITION']; ?></td><td><?php echo $row1['CAREER']; ?></td><td><?php echo $row1['COMMUNICATION']; ?></td><td><?php echo $row1['KNOWLEDGE_AREA']; ?></td><td><?php echo $row1['IT_AWARNESS']; ?></td><td><?php echo $row1['CONFIDENCE']; ?></td></tr></table></td><td><?php $count=1;
						 $choice=explode(",", $row1['TECH_FEEDBACK']);
						foreach($choice as $a) {
							if($a!='')
							echo $count." - ".$a;
						$count++; } ?></td><td><?php echo $row1['OTHER_FEEDBACK']; ?> </td>
		<td><?php echo $row1['RATING']; ?> </td><td><?php echo $row1['INTERVIEWER']; ?> </td><td><?php echo $row1['TIME_TAKEN']; ?> </td></tr>

		<?php
	}
}
		
?></table>