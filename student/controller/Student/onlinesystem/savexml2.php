<?php //session_start();
//error_reporting(0);
$test_name=base64_decode($_GET['test_id']);
$cat_name=base64_decode($_GET['cat']);
$instance=base64_decode($_GET['instance']);
 
$rs4= "SELECT * from `online_test` where (test_id='".$test_name."' and CATEGORY='".$cat_name."' and  STATUS='ACTIVE')  order by id"; 
$rs5=mysql_query($rs4)or die(mysql_error());
while($row=mysql_fetch_array($rs5)){ 
$dur=$row['TOTAL_NO_QUESTION'];
$test=$row['test_id'];
$sub=$row['CAT_NAME'];
$cat_name=base64_encode($row['CATEGORY']);

echo "<div><h1 align='center' style='border-bottom:1px solid #ddd;'>".$sub."</h1>";
 $user=$_SESSION["regno_of_user"];
 $dbqry="select `question_id` from `test_question` where (c_id='$sub' AND test_id='$test_name')";  
$dat= mysql_query($dbqry)or die(mysql_error());
while($res=mysql_fetch_array($dat)){
$data=$res['question_id'];
$row=explode(",",$data);
$l=sizeof($row);
$tid=$row;
$comma = implode(",", $tid);
$i=1;
$ans='';
foreach($tid as $tids)
{ 
if($tids!='')
{
//echo "select id,question,subject_id,ans1,ans2,ans3,ans4,ans5,corans from `questions` where id='$tids'";
$dbqry1=mysql_query("select id,question,subject_id,ans1,ans2,ans3,ans4,ans5,corans from `activetestquestions` where id='$tids'")or die(mysql_error());
if($rows = mysql_fetch_array($dbqry1)){
$ans.=$rows['corans'];
if($rows['corans']){
$ans.=",";
}
//echo $ans;
//echo $i;

?>
<div style="width:222px;float:left;margin:0px auto;padding-left:30px;" id="<?php echo $rows['id']; ?>">
<b><font color=#306BCF>Question:<?php echo $i?>)</font></b>
<input type="hidden" id="<?php echo $i?>"  value="<?php echo $rows['id']; ?>" />
<?php //$db = new Database();  
//$db->connect();  
//echo "select * from `temp_test_result` where test_id='$test_name' AND candidate='$user' AND instance='$cab' AND question_id='$rows[id]'";
$findque=mysql_query("select * from `temp_test_result` where test_id='$test_name' AND candidate='$user' AND instance='$instance' AND question_id='$rows[id]'");
if($findres=mysql_fetch_array($findque)){
$ansresult=$findres['answer'];
}else{
$ansresult=0;
}
?>
&nbsp; &nbsp;
<input name="" id="" type="hidden" value="<?php echo $rows['id']; ?>" /><?php //echo $rows['question']; ?> <?php if($ansresult=='1' ||  $ansresult=='2' || $ansresult=='3' || $ansresult=='4' || $ansresult=='5'){ ?> <span id="A<?php echo $rows['id']; ?>" style="color:#009900;"><font>Answered and Saved</font></span> <?php } else { ?><span id="A<?php echo $rows['id']; ?>" style="color:#FF0000;"><font size=2.0em>Not Answered</font></span> <?php } ?><br />
<br />
</div>
<?php
$i++;
}
}
}
}
echo "<div style='clear:both;'></div></div>";
}
?>
