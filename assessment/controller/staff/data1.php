<?php 
error_reporting(0);
$data=$_REQUEST['q'];
include("../class.database.php");
$db2 = new Database();  
$db2->connect();
/*$rs1=mysql_query("select * from search where id='1'");
if($row1=mysql_fetch_array($rs1)){
	 $college1=explode(",",$row1['college']);
	 $count=count($college1);
	 //exit;
	 for($i=0;$i<$count;$i++){
	 	$college.= "'$college1[$i]'";
	 	if($i<($count-1)){
			$college.=",";
		}
	 }
	//echo $college;
}  
$r1=mysql_query("select * from search where id='1'");
if($rw1=mysql_fetch_array($r1)){
	 $yop1=explode(",",$row1['yop']);
	 $count1=count($yop1);
	 //exit;
	 for($i=0;$i<$count1;$i++){
	 	$yop.= "'$yop1[$i]'";
	 	if($i<($count1-1)){
			$yop.=",";
		}
	 }
	 //echo $yop;
}*/  
$db2->select('student_data',"DISTINCT(NAME),REG_NO","((`NAME` LIKE '%$data%' || `REG_NO` LIKE '$data%'))",'NAME',null);  
$resg2 = $db2->get_name();
if(!is_numeric($data)){
	if(sizeof($resg2)<=5)
{
echo strtoupper($resg2['NAME'])."
 ".$resg2['']."";}
else
{
foreach($resg2 as $tids)
{ 
echo strtoupper($tids['NAME'])."
 ".$tids['']."";
}
}
}
if(is_numeric($data)){
	if(sizeof($resg2)<=5)
{
echo strtoupper($resg2['REG_NO'])."
 ".$resg2['']."";}
else
{
foreach($resg2 as $tids)
{ 
echo strtoupper($tids['REG_NO'])."
 ".$tids['']."";
}
}
}


?>