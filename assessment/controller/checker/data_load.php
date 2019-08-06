<?php 
$data=$_GET['college'];
$data1=explode("-",$data);
$college=$data1[1];
$branch2=implode(",",$_GET['branch']);
$branch1=explode(",",$branch2);
$count=count($branch1);
$branch='';
	 for($i=0;$i<$count;$i++){
	 	$branch.= "'$branch1[$i]'";
	 	if($i<($count-1)){
			$branch.=",";
		}
	 }
echo "<br/><b>Search Result For </b><i><font color=red>".$data1[0]."(".$branch.")";
echo "</font></i><hr/>";
include("../class.database.php");
$db2 = new Database();  
$db2->connect(); 
if($college!="" and $branch!=""){
//echo $qry="select * from 'student_data' where (`COLLEGE`=$college AND `BRANCH` IN ($branch))";
$db2->select('student_data','REG_NO,NAME,COLLEGE,BRANCH,COURSE_YOP,GENDER,PIC',"(`COLLEGE`='$college' AND `BRANCH` IN ($branch))","COURSE_YOP,NAME",null);  	
}
$resg2 = $db2->get_name();
//echo $numresult=sizeof($resg2);

if($resg2['REG_NO']!=''){
$sql="select * from `verbaltest_result` where `regd_no`='$tids[REG_NO]'";
$rs=mysql_query($sql);
$rcnt=mysql_num_rows($rs);
if($row=mysql_fetch_array($rs)){
$status=$row['status'];
}
$sql1="select * from `verbaltest_eval` where `regd_no`='$tids[REG_NO]'";
$rs1=mysql_query($sql1);
$rcnt1=mysql_num_rows($rs1);
if($row1=mysql_fetch_array($rs1)){
$status1=$row['status'];
}

if($status=='finish'){
if($rcnt1<1){
echo "<p style='padding: 5px;box-shadow:1px 1px 1px 1px #ccc;'><font color=black font size=3>".$tids['REG_NO']." </font> &nbsp;<font color=blue size=3><a href='javascript:window.open('document.aspx','mywindowtitle','width=500,height=150')' style='color:blue;font-size:3;font-weight:bold;'>".strtoupper($tids['NAME'])."</a></font>&nbsp;<font color=green size=3>(".$tids['BRANCH'].", ".$tids['COLLEGE'].", ".$tids['COURSE_YOP'].")</font>
 ".$img_verify."<br/><b></p>"; ?>
<?php } } }
else{
foreach($resg2 as $tids)
{ 
?>
</b>
<?php 
$sql="select * from `verbaltest_result` where `regd_no`='$tids[REG_NO]'";
$rs=mysql_query($sql);
$rcnt=mysql_num_rows($rs);
if($rcnt>='1'){
if($row=mysql_fetch_array($rs)){
$status=$row['status'];
}
$sql1="select * from `verbaltest_eval` where `regd_no`='$tids[REG_NO]'";
$rs1=mysql_query($sql1);
$rcnt1=mysql_num_rows($rs1);
if($row1=mysql_fetch_array($rs1)){
$status1=$row['status'];
}

if($status=='finish'){
if($rcnt1<1){
?>
<p style='padding: 5px;box-shadow:1px 1px 1px 1px #ccc;'><img src='img/open.gif' height='10' width='10' alt=''><a href="#" onclick="javascript:window.open('resultsave.php?regd_no=<?php echo $tids['REG_NO']; ?>','mywindowtitle','width='+screen.width+', height='+screen.height+',statusbar=no,toolbar=no,location=no,directories=no,menubar=no,resizable=no,scrollbars=auto, status=no, fullscreen=yes, minimizable=no, titlebar=0, channelmode=1');" style='color:#000;font-size:3;font-weight:bold;text-decoration:none'><font color=black font size=3><?php echo $tids['REG_NO']; ?>
 </font>,  &nbsp;<font color=blue size=3><?php echo strtoupper($tids['NAME']); ?></font>&nbsp;<font color=green size=3>(<?php echo $tids['BRANCH']; ?>, <?php echo $tids['COLLEGE']; ?>, <?php echo $tids['COURSE_YOP']; ?>)</font>
 <?php echo $img_verify; ?><img src='img/check.png' height='20' width='20' alt='' style='float:right;'></a><br/><b></p>
 <?php
}else{
echo "No records found for ".$data1[0]."(".$branch.")";
exit;
}
} } } } ?>
<div class="clear"></div>