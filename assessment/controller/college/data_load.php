<?php session_start();
error_reporting(E_ALL ^ E_NOTICE);
echo "<br/><b>Search Result For </b><i><font color=red>".$data=$_GET['q'];
echo "</font></i><hr/>";
include("../class.database.php");
$data1=explode(",",$data);
$data2=$data1[1];
$data3=$data1[0];

$db2 = new Database();  
$db2->connect(); 
$rs1=mysql_query("select * from search where id='1'");
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
} 
if($data2!="" and $data3!=""){
$db2->select('student_data','REG_NO,NAME,COLLEGE,BRANCH,COURSE_YOP,GENDER,PIC',"((`COLLEGE` = '".$_SESSION['actingrole']."') AND (REG_NO='$data3'))","COURSE_YOP,NAME",null);  	
}else{
	if($data2==""){
$data2=$data3;	
}
	$db2->select('student_data','REG_NO,NAME,COLLEGE,BRANCH,COURSE_YOP,GENDER,PIC',"((`COLLEGE` = '".$_SESSION['actingrole']."') AND (REG_NO LIKE '$data3%' || NAME LIKE '$data2%'))","COURSE_YOP,NAME",null);  
} 

$resg2 = $db2->get_name();
if($resg2['REG_NO']!='')
{
?>
<div align=left  style='width:850px;height:120px;float:left;border:1px solid #ddd;box-shadow:0px 1px 1px 1px #ccc;margin:30px;padding:10px;border-radius:7px;'>
<div style="width:130px;float:left;height:100px">
<?php if($resg2[GENDER]=='Male')
{
?>

<img border="0" src="../staff/img/male.jpg" height="60" width="100" style="float: left;margin-right:2px;"><?php
}
else
{
?>
<img border="0" src="../staff/img/female.jpg" height="60" width="100" style="float: left;margin-right:2px;">
<?php
}
?>
</div>
<div style="width:500px;float:left;">
&nbsp;<br />
<?php
echo "<font color=blue size=4><b>".strtoupper($tids['NAME'])."</b></font>( <font color=black font size=3><b>".$tids['REG_NO']." </b></font>)<br/><font color=green size=2>(".$tids['BRANCH'].", ".$tids['COLLEGE'].", ".$tids['COURSE_YOP'].")</font>
 ".$img_verify."<br/><b>";
 ?>
</div>

<div style="float:right;">
<p align="center" style="margin-top:7px;">

<a href='?id=viewprofile&id1=<?php echo $resg2['REG_NO']; ?>' class="btn btn-danger">
View </a>	

</p>
<p align="center" style="margin-top:7px;">
<a href='?id=editprofile&id1=<?php echo $resg2['REG_NO']; ?>&action=edit' class="btn btn-success">
Edit</a>
	
</p></div></div>
<?php }
else
{
foreach($resg2 as $tids)
{ 
?>
</b>
<div align=left  style='width:850px;height:120px;float:left;border:1px solid #ddd;box-shadow:0px 1px 1px 1px #ccc;margin:30px;padding:10px;border-radius:7px;'>
<div style="width:130px;float:left;height:100px;">
<?php //if($tids['PIC']!=''){?>
							<!-- <font face="Tahoma" size="2">
						
<img border="0" src="thumb.php?size=60&file=../student/uploads/<?php echo $tids['PIC'];?>" ></font>-->
							<?php
							

//}
//else
//{
if($tids[GENDER]=='Male')
{
?>

<img border="0" src="../staff/img/male.jpg" height="60" width="100" style="float: left;margin-right:2px;"><?php
}
else
{
?>
<img border="0" src="../staff/img/female.jpg" height="60" width="100" style="float: left;margin-right:2px;">
<?php
}
//}
?>
</div><div style="width:500px;float:left;">
&nbsp;<br />
<?php 
echo "<font color=blue size=4><b>".strtoupper($tids['NAME'])."</b></font>( <font color=black font size=3><b>".$tids['REG_NO']." </b></font>)<br/><font color=green size=2>(".$tids['BRANCH'].", ".$tids['COLLEGE'].", ".$tids['COURSE_YOP'].")</font>
 ".$img_verify."<br/><b>";
 
 
 ?>
</div>

<div style="float:right;">
<p align="center" style="margin-top:7px;">

<a href='?id=viewprofile&id1=<?php echo $tids['REG_NO']; ?>' class="btn btn-danger">
View </a>	

</p>
<p align="center" style="margin-top:7px;">
<a href='?id=editprofile&id1=<?php echo $tids['REG_NO']; ?>&action=edit' class="btn btn-success">
Edit</a>
	
</p></div>
 </div>

 <?php
 }
}

?>
<div class="clear"></div>