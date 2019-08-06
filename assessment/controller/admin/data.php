<?php 
error_reporting(0);
$data=$_REQUEST['q'];
include("../class.database.php");
$db2 = new Database();  
$db2->connect();  
$db2->select('student_data',"DISTINCT(NAME),REG_NO","(NAME LIKE '%$data%' || REG_NO LIKE '$data%')",'NAME',null);  
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