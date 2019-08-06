<?php //session_start();
//error_reporting(0);
include("onlinesystem/class.database.php");
$db = new Database();
$db->connect(); 

$user=$_SESSION["regno_of_user"];
$test=$_GET['test'];
$result=mysql_query("select * from `test_tests` where test_id='".$test."'");
if($rows=mysql_fetch_array($result)){
$testname=$rows['test_name'];
}

?>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title>Online Test Result</title>
<link class="include" rel="stylesheet" type="text/css" href="onlinesystem/jquery.jqplot.min.css" />
<style type="text/css">
table tr:hover{
background:#E5E5E5;
}
p{ margin-bottom:-15px;}
</style>
<div style="margin:auto;width:1000px;">
<h1 align="center"><?php echo $testname; ?>, Instance - <?php echo $_GET['instance']; ?> Review</h1>
<table>
<?php  
$i=1;
$c=0;
//$db->select('online_test','*',"STATUS='active'",null,null,null);  
//echo "select * from online_test where (test_name='".$test."' and  STATUS='ACTIVE') group by test_name";
$rs=mysql_query("select * from `online_test` where (test_id='".$test."' and  STATUS='ACTIVE') order by id");
$count=mysql_num_rows($rs);
while($row=mysql_fetch_array($rs)){ 
//$rs1=mysql_query("select * from `review` where (test_id='".$test."' AND category='".$row['CATEGORY']."' AND regno='$user' AND instance='".$_GET['instance']."')");  
$rs1=mysql_query("select * from student_result where test_id='".$test."' and cat_id='".$row['CATEGORY']."' AND reg_no='$user'"); 
?>
<tr><td colspan="2" align="center"><h2 align="center"><?php echo $row['CATEGORY']; ?></h2></td></tr> 
<?php
if($row1=mysql_fetch_array($rs1)){
$i=1;
$ia=count(explode(",",$row1['question_attend'])); 
$queid=explode(",",$row1['question_attend']);
//$ans=explode(",",$row1['correct_ans']);
for($j=0;$j<$ia;$j++){
$quest=mysql_query("select * from `questions` where id='".$queid[$j]."'");
if($rowquest=mysql_fetch_array($quest)){
$selstures=mysql_query("select * from `temp_test_result` where (test_id='".$test."' AND candidate='$user' AND instance='".$_GET['instance']."' AND question_id='".$queid[$j]."' and instance='".$_GET['instance']."')");
//echo "select * from `temp_test_result` where (test_id='".$test."' AND candidate='$user' AND instance='".$_GET['instance']."' AND question_id='".$queid[$j]."')";
$cn=mysql_num_rows($selstures);
if($rowstures=mysql_fetch_array($selstures)){
$ans=$rowstures['answer'];
}
?>
<tr>
<td><?php if(($cn=='0') or ($ans=='0')){ ?> <img src="img/error.png" alt="not attempted" width="50%" height="" /> <?php } 
else if($ans==$rowquest['corans']){  ?>  <img src="img/edit.png" alt="not attempted" width="50%" height="" /><?php  }
else{  ?> <img src="img/delete.png" alt="not attempted" width="50%" height="" /> <?php } ?>

</td>
<td>
<p><strong>Question:<?php echo $i; ?>)</strong>
<?php echo $rowquest[question]; ?></p>

<?php if(strip_tags($rowquest[ans1])!=''){ ?>
<p style="background:<?php if($cn=='0' AND $rowquest['corans']=='1'){ ?>#226A20;color:#FFFFFF;<?php } ?><?php if($cn!='0' AND $ans=='1' AND $rowquest['corans']!='1'){ ?>#FF4646;color:#FFFFFF;<?php } ?><?php if($cn!='0' AND $rowquest['corans']=='1'){ ?>#226A20;color:#FFFFFF;<?php } ?>;padding:5px;width:95%"><input   type=radio  value="1" <?php if($cn!='0' AND $ans=='1'){ ?> checked="checked" <?php } if($rowquest['corans']=='1' AND $cn=='0'){ ?>checked="checked" <?php } ?>>&nbsp;<?php echo strip_tags($rowquest[ans1]); ?> 
<?php if((($cn=='0') or ($ans=='0')) AND $rowquest['corans']=='1'){ ?> <img src="img/error.png" alt="not attempted" width="20" height="" style="float:right"/> <?php } ?>
<?php  if($cn!='0' AND $ans=='1' AND $rowquest['corans']!='1'){ ?>  <img src="img/wrong_mark.png" alt="not attempted" style="float:right" width="20" height="" /><?php } if($cn!='0' AND $ans!='0' AND $rowquest['corans']=='1'){  ?> <img src="img/tick-mark.png" alt="not attempted" style="float:right" width="20" height="" /> <?php } ?>

</p> <?php } ?>
<?php if(strip_tags($rowquest[ans2])!=''){ ?>
<p style="background:<?php if($cn=='0' AND $rowquest['corans']=='2'){ ?>#226A20;color:#FFFFFF;<?php } ?><?php if($cn!='0' AND $ans=='2' AND $rowquest['corans']!='2'){ ?>#FF4646;color:#FFFFFF;<?php } ?><?php if($cn!='0' AND $rowquest['corans']=='2'){ ?>#226A20;color:#FFFFFF;<?php } ?>;padding:5px;width:95%"><input  type=radio value=2 <?php if($cn!='0' AND $ans=='2'){ ?> checked="checked" <?php } if($rowquest['corans']=='2' AND $cn=='0'){ ?>checked="checked" <?php } ?>>&nbsp;<?php echo strip_tags($rowquest[ans2]); ?>

<?php if((($cn=='0') or ($ans=='0')) AND $rowquest['corans']=='2'){ ?> <img src="img/error.png" alt="not attempted" width="20" style="float:right" height="" /> <?php } ?>
<?php  if($cn!='0' AND $ans=='2' AND $rowquest['corans']!='2'){ ?>  <img src="img/wrong_mark.png" alt="not attempted" style="float:right" width="20" height="" /><?php } if($cn!='0' AND $ans!='0' AND $rowquest['corans']=='2'){  ?> <img src="img/tick-mark.png" alt="not attempted" style="float:right" width="20" height="" /> <?php } ?>
</p><?php } ?>
<?php if(strip_tags($rowquest[ans3])!=''){ ?>
<p style="background:<?php if($cn=='0' AND $rowquest['corans']=='3'){ ?>#226A20;color:#FFFFFF;<?php } ?><?php if($cn!='0' AND $ans=='3' AND $rowquest['corans']!='3'){ ?>#FF4646;color:#FFFFFF;<?php } ?><?php if($cn!='0' AND $rowquest['corans']=='3'){ ?>#226A20;color:#FFFFFF;<?php } ?>;padding:5px;width:95%"><input type=radio value=3 <?php if($cn!='0' AND $ans=='3'){ ?> checked="checked" <?php } if($rowquest['corans']=='3' AND $cn=='0'){ ?>checked="checked" <?php } ?>>&nbsp;<?php echo strip_tags($rowquest[ans3]); ?>
<?php if((($cn=='0') or ($ans=='0')) AND $rowquest['corans']=='3'){ ?> <img src="img/error.png" alt="not attempted" width="20" style="float:right" height="" /> <?php } ?>
<?php  if($cn!='0' AND $ans=='3' AND $rowquest['corans']!='3'){ ?>  <img src="img/wrong_mark.png" alt="not attempted" style="float:right" width="20" height="" /><?php } if($cn!='0' AND $ans!='0' AND $rowquest['corans']=='3'){  ?> <img src="img/tick-mark.png" alt="not attempted" style="float:right" width="20" height="" /> <?php } ?>
</p> <?php } ?>
<?php if(strip_tags($rowquest[ans4])!=''){ ?>
<p style="background:<?php if($cn=='0' AND $rowquest['corans']=='4'){ ?>#226A20;color:#FFFFFF;<?php } ?><?php if($cn!='0' AND $ans=='4' AND $rowquest['corans']!='4'){ ?>#FF4646;color:#FFFFFF;<?php } ?><?php if($cn!='0' AND $rowquest['corans']=='4'){ ?>#226A20;color:#FFFFFF;<?php } ?>;padding:5px;width:95%"><input type=radio  value=4 <?php if($cn!='0' AND $ans=='4'){ ?> checked="checked" <?php } if($rowquest['corans']=='4' AND $cn=='0'){ ?>checked="checked" <?php } ?>>&nbsp;<?php echo strip_tags($rowquest[ans4]); ?>
<?php if((($cn=='0') or ($ans=='0')) AND $rowquest['corans']=='4'){ ?> <img src="img/error.png" alt="not attempted" style="float:right" width="20" height="" /> <?php } ?>
<?php  if($cn!='0' AND $ans=='4' AND $rowquest['corans']!='4'){ ?>  <img src="img/wrong_mark.png" alt="not attempted" style="float:right" width="20" height="" /><?php } if($cn!='0' AND $ans!='0' AND $rowquest['corans']=='4'){  ?> <img src="img/tick-mark.png" alt="not attempted" style="float:right" width="20" height="" /> <?php } ?>
</p> <?php } ?>
<?php if(strip_tags($rowquest[ans5])!=''){ ?>
<p style="background:<?php if($cn=='0' AND $rowquest['corans']=='5'){ ?>#226A20;color:#FFFFFF;<?php } ?><?php if($cn!='0' AND $ans=='5' AND $rowquest['corans']!='5'){ ?>#FF4646;color:#FFFFFF;<?php } ?><?php if($cn!='0' AND $rowquest['corans']=='5'){ ?>#226A20;color:#FFFFFF;<?php } ?>;padding:5px;width:95%"><input  type=radio value=5 <?php if($cn!='0' AND $ans=='5'){ ?> checked="checked" <?php } if($rowquest['corans']=='5' AND $cn=='0'){ ?>checked="checked" <?php } ?>>&nbsp;<?php echo strip_tags($rowquest[ans5]); ?>
<?php if((($cn=='0') or ($ans=='0')) AND $rowquest['corans']=='5'){ ?> <img src="img/error.png" alt="not attempted" style="float:right" width="20" height="" /> <?php } ?>
<?php  if($cn!='0' AND $ans=='5' AND $rowquest['corans']!='5'){ ?>  <img src="img/wrong_mark.png" alt="not attempted" style="float:right" width="20" height="" /><?php } if($cn!='0' AND $ans!='0' AND $rowquest['corans']=='5'){  ?> <img src="img/tick-mark.png" alt="not attempted" style="float:right" width="20" height="" /> <?php } ?>
</p> <?php } ?>
<br/>

</td>
</tr>
<?php
}$i++;
}
?>
<?php
//$i++;
}
}

?>
</table>
</div>
