<?php session_start();
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}
error_reporting(0);
$college=$_REQUEST['shortname'];
$sdate=$_REQUEST['sdate'];
$edate=$_REQUEST['edate'];
$attempt=$_REQUEST['attempt'];
$fgmembersite->DBLogin();
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=".$college."_feedback.xls");
?>
<div style='border:6px solid #000;width:600px;margin: auto;padding:20px;'>
    <table width='100%'><tr><td style='border:2px solid #000;'><img width='172' height='53' src='http://localhost/new/images/77.gif'/></td><td style='border:2px solid #000;' valign='middle'><h2 align='center' style='padding-top: 14px;'>Feedbak Report of <?php echo $college; ?> college (Attempt : <?php echo $attempt; ?>)</h2></td></tr></table>
<div align='right'>
<b>Date : <?php echo date('d M Y', strtotime($sdate)); ?> to <?php echo date('d M Y', strtotime($edate)); ?></b>
</div>
<table width='100%' border='1' cellspacing='2' cellpadding='2'>
  <tr>
    <td width='15%'><strong>Regd No</strong></td>
    
    <td width='15%'><strong>Do you like to attend more of these kind of Program? </strong> </td>
    <td width='15%'><strong>Quality of classes conducted? </strong> </td>
    <td width='15%'><strong>How do you find the trainers who have conducted Training? </strong> </td>
    <td width='15%'><strong>Overall Assessment of the training Program ? </strong> </td>
     <td width='15%'><strong>Please write a few lines about the training program. Your feedback could be negative or positive? </strong> </td>
  </tr>
<?php

//echo "SELECT * FROM feedbackans where regno in (select REG_NO from student_data where COLLEGE='$college') 
//and attempt='$attempt' and date between '$sdate' and '$edate'";
$sql=mysql_query("SELECT * FROM feedbackans where regno in (select REG_NO from student_data where COLLEGE='$college') 
and attempt='$attempt' and date between '$sdate' and '$edate'")or die(mysql_error());
//exit;
while($result=mysql_fetch_array($sql)){
	
/*header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=".$testid."_QUESTIONS.doc");*/

?>
  <tr>
    <td><strong><?php echo $result['regno']; ?></strong></td>
    <td><strong><?php echo $result['ans1']; ?></strong></td>
    <td><strong><?php echo $result['ans2']; ?></strong></td>
    <td><strong><?php echo $result['ans3']; ?></strong></td>
    <td><strong><?php echo $result['ans4']; ?></strong></td>
    <td><strong><?php echo $result['ans5']; ?></strong></td>
  </tr>
  
<?php
}
?>
</table>
<p></p>
<p></p>
<hr />
<p></p>
<p align="center">
<h2 style="text-align:center"> -The End- </h2>
</p>