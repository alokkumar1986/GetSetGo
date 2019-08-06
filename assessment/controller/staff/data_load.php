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
$db2->select('student_data','REG_NO,NAME,COLLEGE,BRANCH,COURSE_YOP,GENDER,PIC',"((`COLLEGE` IN ($college)) AND (`COURSE_YOP` IN ($yop)) AND (REG_NO='$data3'))","COURSE_YOP,NAME",null);  	
}else{
	if($data2==""){
$data2=$data3;	
}
	$db2->select('student_data','REG_NO,NAME,COLLEGE,BRANCH,COURSE_YOP,GENDER,PIC',"((`COLLEGE` IN ($college)) AND (`COURSE_YOP` IN ($yop)) AND (REG_NO LIKE '$data3%' || NAME LIKE '$data2%'))","COURSE_YOP,NAME",null);  
} 

$resg2 = $db2->get_name();
if($resg2['REG_NO']!='')
{
?>
<div align=left  style='width:250px;height:190px;float:left;border:1px solid #ddd;box-shadow:0px 1px 1px 1px #ccc;margin:30px;padding:10px;border-radius:7px;'>
<div style="height:100px">
<?php if($resg2[GENDER]=='Male')
{
?>

<img border="0" src="img/male.jpg" height="60" width="100" style="float: left;margin-right:2px;"><?php
}
else
{
?>
<img border="0" src="img/female.jpg" height="60" width="100" style="float: left;margin-right:2px;">
<?php
}

?>

<?php
echo "<font color=black font size=3>".$resg2['REG_NO']."</font> <br/><font color=blue size=1>".$resg2['NAME']."</font><br/><font color=green size=1>(".$resg2['BRANCH'].", ".$resg2['COLLEGE'].", ".$resg2['COURSE_YOP'].")</font> 
".$img_verify." <br/><b>
"; ?>
</div>
<div class="clear"></div>
<div>
<p align="center" style="margin-top:7px;">
<?php if($_SESSION['actingrole']=='PI'){ ?>
<a href='hr.php?id=<?php echo $resg2['REG_NO']; ?>' class="btn btn-danger">
Personal Interview</a>	
<?php }if($_SESSION['actingrole']=='TI') { ?>
&nbsp; <a href='technical.php?id=<?php echo $resg2['REG_NO']; ?>' class="btn btn-success">
Technical Interview</a>
<?php } if($_SESSION['actingrole']=='BOTH'){ ?>
	<a href='hr.php?id=<?php echo $resg2['REG_NO']; ?>' class="btn btn-danger">
Personal</a> &nbsp;<a href='technical.php?id=<?php echo $resg2['REG_NO']; ?>' class="btn btn-success">
Technical</a>
<?php } if($_SESSION['actingrole']=='COMBINE'){ ?>
	
<a href='combine.php?id=<?php echo $resg2['REG_NO']; ?>' class="btn btn-info">
Combine HR+Tech</a>
<?php } ?>	
</p></div></div>
<?php }
else
{
foreach($resg2 as $tids)
{ 
?>
</b>
<div align=left  style='width:250px;height:190px;float:left;border:1px solid #ddd;box-shadow:0px 1px 1px 1px #ccc;margin:30px;padding:10px;border-radius:7px;'>
<div style="height:100px">
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

<img border="0" src="img/male.jpg" height="60" width="100" style="float: left;margin-right:2px;"><?php
}
else
{
?>
<img border="0" src="img/female.jpg" height="60" width="100" style="float: left;margin-right:2px;">
<?php
}
//}
?><?php 
echo "<font color=black font size=3>".$tids['REG_NO']." </font><br/><font color=blue size=1>".strtoupper($tids['NAME'])."</font><br/><font color=green size=1>(".$tids['BRANCH'].", ".$tids['COLLEGE'].", ".$tids['COURSE_YOP'].")</font>
 ".$img_verify."<br/><b>";
 
 
 ?>
</div>
<div class="clear"></div>
<div>
<p align="center" style="margin-top:7px;">
<?php if($_SESSION['actingrole']=='PI'){ ?>
<a href='hr.php?id=<?php echo $tids['REG_NO']; ?>' class="btn btn-danger">
Personal Interview</a>	
<?php }if($_SESSION['actingrole']=='TI') { ?>
&nbsp; <a href='technical.php?id=<?php echo $tids['REG_NO']; ?>' class="btn btn-success">
Technical Interview</a>
<?php } if($_SESSION['actingrole']=='BOTH'){ ?>
	<a href='hr.php?id=<?php echo $tids['REG_NO']; ?>' class="btn btn-danger">
Personal</a>&nbsp; <a href='technical.php?id=<?php echo $tids['REG_NO']; ?>' class="btn btn-success">
Technical</a>
<?php } if($_SESSION['actingrole']=='COMBINE'){ ?>
	
<a href='combine.php?id=<?php echo $tids['REG_NO']; ?>' class="btn btn-danger">Combine
(HR+TECH)</a>
<?php } ?>
</p></div>
 </div>

 <?php
 }
}

?>
<div class="clear"></div>