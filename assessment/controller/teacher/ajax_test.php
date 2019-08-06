<?php require_once("../../include/membersite_config.php");
$fgmembersite->DBLogin();
if($_POST['id'])
{
$id1=$_POST['id'];
$sql="select * from test_setting where test_id='".$id1."' and for_college='".$_POST['college']."'";
$result=mysql_query($sql);
$count=mysql_num_rows($result);
if($row=mysql_fetch_array($result)){
$yop=$row['for_yop'];
$id=$row['test_id'];
$college=$row['for_college'];
}
if($count=='0'){
echo 'Test is not activated for '.$_POST['college'];
}
else{
echo 'Test is already activated for '.$_POST['college'].'('.$yop.')..<a href="?id=edit setting&test='.$id.'&college='.$college.'" style="color:red">Edit Now</a>';
}
}
?>