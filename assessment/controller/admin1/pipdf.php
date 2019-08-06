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
header("Content-type: application/pdf");
header("Content-Disposition: attachment;Filename=$college$dateofinterview.pdf");

if($college!='' and $branch==''){
	$qry = "select REG_NO from student_data where COLLEGE='$college'";
}
if($college=='' and $branch!=''){
	$qry = "select REG_NO from student_data where BRANCH='$branch'";
}
if($college!='' and $branch!=''){
$qry = "select REG_NO from student_data where COLLEGE='$college' and BRANCH='$branch'";	
}
if($college=='' and $branch==''){
$qry = "select REG_NO from student_data ";	
}

$rs=mysql_query($qry);

?>
<table border="1"><tr style="border-bottom: 1px solid #000;background: #000;color: #ffffff"><td align="center" colspan='10'><h4>Personal Interview Report (Date : <?php echo $dateofinterview; ?>)<br/><?php if($college!=''){ ?>College : <?php echo $college; ?>,<?php } ?> <?php if($branch!=''){ ?>Branch : <?php echo $branch; ?><?php } ?></h4></td></tr>
<tr valign="top" style="background: #ccc;color: green"><td rowspan="2">REGD NO</td><td align="center">Verbal Communication</td><td align="center">Non-Verbal Communication</td><td align="center">Physical Appearance & Mannerism</td><td rowspan="2">Communication Feedback </td><td rowspan="2">Preparation Feedback </td><td rowspan="2">Other Feedback </td><td rowspan="2">Overall Rating </td><td rowspan="2">Interviewer </td><td rowspan="2">Time Taken </td></tr>
<tr><td>
<table border="1"> <tr style="background: #ccc;color: green"><td>Clarity</td><td>Career</td><td>Articulation</td><td>Usage</td></tr></table>
</td>
<td>
<table border="1"> <tr style="background: #ccc;color: green"><td>Confidence</td><td>Body Language</td><td>Listening</td></tr></table>
</td>
<td>
<table border="1"> <tr style="background: #ccc;color: green"><td>Appearance</td><td>Mannerism</td></tr></table>
</td>
</tr>
<?php
while($row=mysql_fetch_array($rs)){
	if($interviewer!=''){
		$qry1="select * from pi where (REGD_NO='$row[REG_NO]' and DATE='$dateofinterview' and INTERVIEWER='$interviewer')";
	}
	if($interviewer==''){
		$qry1="select * from pi where (REGD_NO='$row[REG_NO]' and DATE='$dateofinterview' )";
	}
	//$qry1="select * from pi where (REGD_NO='$row[REG_NO]' and DATE='$dateofinterview')";
	$rs1=mysql_query($qry1);
	$count=mysql_num_rows($rs1);
	if($count==1){
		$row1=mysql_fetch_array($rs1);
		?>
		<tr valign="top" ><td ><?php echo $row1['REGD_NO']; ?></td>
		<td> <table border="1"> <tr valign="top" style="height:100%"><td><?php echo $row1['CLARITY']; ?></td><td><?php echo $row1['ARTICULATION']; ?></td><td><?php echo $row1['USAGES']; ?></td></tr></table></td>
		<td> <table border="1"> <tr valign="top" style="height:100%"><td><?php echo $row1['CONFIDENCE']; ?></td><td><?php echo $row1['BODY_LANG']; ?></td><td><?php echo $row1['LISTENING']; ?></td></tr></table></td>
		<td> <table border="1"> <tr valign="top" style="height:100%"><td><?php echo $row1['APPEARANCE']; ?></td><td><?php echo $row1['MANNERS']; ?></td></tr></table></td>
		
		<td>
		<?php $count=1;
						 $choice=explode(",", $row1['COMM_FEEDBACK']);
						foreach($choice as $a) {
							if($a!='')
							echo $count." - ".$a;
						$count++; } ?>
							
						</td>
						<td><?php $count=1;
						 $choice=explode(",", $row1['PREP_FEEDBACK']);
						foreach($choice as $a) {
							if($a!='')
							echo $count." - ".$a ; 
						$count++; } ?></td><td><?php echo $row1['OTHER_FEEDBACK']; ?> </td>
		<td><?php echo $row1['RATING']; ?> </td><td><?php echo $row1['INTERVIEWER']; ?> </td><td><?php echo $row1['TIME_TAKEN']; ?> </td></tr>

		<?php
	}
}
		
?></table>