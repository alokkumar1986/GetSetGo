<?php session_start();
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}
$fgmembersite->DBLogin();
function RandomizeArray($array){
// error check:
$array = (!is_array($array)) ? array($array) : $array;
$a = array();
$max = count($array) + 10;
while(count($array) > 0){        
$e = array_shift($array);
$r = rand(0, $max);
// find a empty key:
while (isset($a[$r])){
$r = rand(0, $max);
}        
$a[$r] = $e;
}
ksort($a);
$a = array_values($a);
return $a;
}
//error_reporting(E_ALL ^ E_NOTICE);
$testid=$_REQUEST['test'];
$data11='';
$sql=mysql_query("SELECT * FROM test_tests where test_id='$testid'");
$result=mysql_fetch_array($sql);
$test_name=$result['test_name'];
$rs2= "SELECT * from online_test where (test_id='".$testid."' and  STATUS='ACTIVE')  order by id"; 
$rs3=mysql_query($rs2);
$j=1;
//$counta=mysql_num_rows($rs1);
$totalque=0;
$totaltime=0;
while($row=mysql_fetch_array($rs3)){ 
$totalque+=$row['TOTAL_NO_QUESTION'];
$totaltime+=$row['duration'];
$test=$row['test_id'];
$sub=$row['CAT_NAME'];
$cor=$row['EACH_QUE_MARK_CORRECT'];
$wrong=$row['EACH_QUE_MARK_WRONG'];
$cat_name=base64_encode($row['CATEGORY']);
}
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=".$testid."_QUESTIONS.doc");

?><div style='border:6px solid #000;width:600px;margin: auto;padding:20px;'>
    <table width='100%'><tr><td style='border:2px solid #000;' width='20%'><img width='172' height='53' src='http://localhost/new/images/77.gif'/></td><td style='border:2px solid #000;' valign='middle'><h2 align='center' style='padding-top: 14px;'><?php echo $test_name; ?></h2></td></tr></table>
<div align='right'>
<b>Date : <?php echo date('d M Y'); ?></b>
<br/><b>No of Question : <?php echo $totalque; ?></b>
<br/><b>Time Duration : <?php echo $totaltime; ?> Min</b>
</div>
<table width='100%' border='1' cellspacing='2' cellpadding='2'>
  <tr>
    <td width='15%'><strong>Name</strong></td>
    <td width='33%'>&nbsp;</td>
    <td width='15%'><strong>College</strong> </td>
    <td width='37%'>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Reg.No.</strong></td>
    <td width='33%'>&nbsp;</td>
    <td><strong>Branch</strong></td>
    <td width='37%'>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Expected Score</strong></td>
    <td width='33%'>&nbsp;</td>
    <td><strong>Marks Secured</strong> </td>
    <td width='37%'>&nbsp;</td>
  </tr>
</table>
<div align='left'>
<br/>
<b>Instruction
<ul>
<li>Write  your expected  score  at end of test.</li>
<li>Each correct answer carries <?php echo $cor; ?> mark.</li>
<li>Put a tick (v) mark against the most appropriate choice. </li>
<li>There will be a penalty of <?php echo $wrong; ?> marks for each wrong answer.</li>
</ul></b>
</div>
</div>
<table>

<?php

$rs4= "SELECT * from online_test where (test_id='".$testid."' and  STATUS='ACTIVE')  order by id"; 
$rs5=mysql_query($rs4);
$j=1;
while($row1=mysql_fetch_array($rs5)){ 
$test=$row1['test_id'];
$sub=$row1['CAT_NAME'];
//$cat_name=base64_encode($row['CATEGORY']);

?>
<tr><td colspan="2"><h2 align='center' style="border:2px solid #000;"><?php echo $sub; ?></h2></td></tr>
<?php
$sqlq=mysql_query("SELECT * FROM test_question where c_id='$sub' AND test_id='$testid'");
$res=mysql_fetch_array($sqlq);
$data=$res['question_id'];
$row2=explode(",",$data);
$l=sizeof($row2);
$tid=RandomizeArray($row2);
$comma = implode(",", $tid);
$i=1;
$ans='';
foreach($tid as $tids)
{ 
if($tids!='')
{
$db=mysql_query("select * from `questions` where id='$tids'");  
$rows = mysql_fetch_array($db);
?>
<tr><td colspan=2><b>Q<?php echo $i; ?>)&nbsp;<?php echo $rows['question']; ?></b></td></tr>
<tr><td>a) <?php echo strip_tags($rows['ans1']); ?></td>
<td>b) <?php echo strip_tags($rows['ans2']); ?></td></tr>
<tr><?php if($rows['ans3']!=''){ ?>
<td>c) <?php echo strip_tags($rows['ans3']); ?></td>
<?php } 
if($rows['ans4']!='') {?><td>d) <?php echo strip_tags($rows['ans4']); ?></td>
<?php } ?>
</tr>

<tr>
<?php
if($rows['ans5']!=''){
?><td>e) <?php echo strip_tags($rows['ans5']); ?></td><td></td></tr>
<?php
}

$i++;
}
?>
<tr><td colspan="2">&nbsp;</td></tr>
<?php
}
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