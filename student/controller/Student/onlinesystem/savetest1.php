<?php 
include("class.database.php");
$db = new Database();  
$db->connect();
$test_id=$_POST['test_id'];
$candidate=$_POST['candidate'];
$question_id=$_POST['question_id'];
$answer=$_POST['answer'];
$etime=$_POST['etime'];
$stime=$_POST['stime'];
$instance=$_POST['instance'];
$sql="select * from `temp_test_result` where (test_id='".$test_id."' AND question_id='".$question_id."' AND candidate='".$candidate."' AND instance='".$instance."')";
$rs=mysql_query($sql)or die(mysql_error());
$count=mysql_num_rows($rs);
if($count=='0'){
mysql_query("insert into `temp_test_result` values(NULL, '$test_id', '$candidate', '$question_id', '$answer', '$stime', '$etime', '$instance')");
}else{
if($row=mysql_fetch_array($rs)){
$sstime=$row['stime'];
$eetime=$row['etime'];
}
//$stime=$stime+$sstime;
//$etime=$etime+$eetime;
mysql_query("update `temp_test_result` set  test_id='".$test_id."', candidate='".$candidate."', question_id='".$question_id."', answer='".$answer."', stime='".$stime."', etime='".$etime."' where (test_id='".$test_id."' AND question_id='".$question_id."' AND candidate='".$candidate."' AND instance='".$instance."') ");
}
$db->disconnect();
?>