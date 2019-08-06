<?php session_start();
if(isset($_COOKIE["name_of_user2"]) && isset($_COOKIE["regno_of_user"]) && isset($_COOKIE["email_of_user"]) && isset($_COOKIE["college"]) && isset($_COOKIE["branch"]) && isset($_COOKIE["role"])){
             $_SESSION['name_of_user2']  = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['name_of_user2']); 
             $_SESSION['regno_of_user']  = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['regno_of_user']);;
             $_SESSION['email_of_user'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['email_of_user']);;
             $_SESSION['college'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['college']);;
             $_SESSION['branch'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['branch']);;
             $_SESSION['role'] = 'Student';
 } 
//print_r(ini_get("session.gc_maxlifetime")); 
error_reporting(0);
$test_name=base64_decode($_GET['test_id']);
include("class.database.php");
$db = new Database();  
$db->connect(); 
?>

<style type="text/css">
#link:hover{
background:#FC6E22;
border-radius:4px;
}
.fixed-size-square {
    width: 170px;
    height: 170px;
    background: #8FC04D;
	float:left;
	margin:10px;
	padding:10px;
	border-radius:2px;
}
.fixed-size-square2 {
    width: 170px;
    height: 170px;
    background: #CCCCCC;
	float:left;
	margin:10px;
	padding:10px;
	border-radius:2px;
}
.fixed-size-square1 {
    width: 170px;
    height: 170px;
    background: #B7B90F;
	float:left;
	margin:10px;
	padding:10px;
	border-radius:2px;
}
.fixed-size-square span {
    
    text-align: center;
    vertical-align: middle;
    color: white
}
.loader {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url(images/loading.gif) 50% 50% no-repeat rgb(249,249,249);
}
#header {
	 background: rgb(55, 55, 255) repeat-x scroll left bottom transparent;
	background-color : rgb(55, 55, 255);
	width:101% !important;
    height: 7%;
	margin :-7px 0px 0px -8px;
}
#left{
width: 256px;
float:left;

height:100%;
background: #E4EDF7;
margin :-51px 0px 0px -8px;
}
#right{
width: 74%;
float:right;
margin-top :-71px;
}
</style>
<script type='text/javascript' src="js/jquery.min.js"> </script>
<!--<script type="text/javascript">
$(window).load(function() {
	$(".loader").fadeOut("slow");
	$(".wait").fadeout("slow");
})
</script>-->
<title>Online test - <?php echo $test_name; ?></title>
<link rel="shortcut icon" href="http://induseducation.in/favicon.ico" />
<html>
<body background="../../../../../images/background1.png">
<div id="header" style="background-color:rgb(55, 55, 255) !important;">
		<div style="background-color: #FFFF00;padding:5px;width:247px"><img src="images/77.gif" height="35"/></div>
        <div style="height:100%;float: right"> </div>
		<div style="float:left;width:253px;margin-top:0px;padding:2px; background-color:#E4EDF7;"><p> 
<?php $row=mysql_query("select * from `student_data` where REG_NO='".$_SESSION['regno_of_user']."'")or die(mysql_error());
if($rs=mysql_fetch_array($row)or die(mysql_error())){ 
$pic=$rs['PIC'];
}
?><img <?php if($pic!=''){ ?>src="../uploads/<?php echo $pic; ?>" <?php }else { ?>src="../../example/profile.jpg" <?php } ?> alt="User Photo" width="50" height="50" style="float:left;margin-right:5px;margin-top:-10px;"/>
 <strong><?php echo ucwords($_SESSION['name_of_user2']); ?></strong><br /><font size="1" color="#0033CC"><?php echo ucwords($_SESSION['branch']); ?>, <?php echo ucwords($_SESSION['college']); ?></font></p> </div>
		</div>
		<div style="clear:both;"></div>
		<div id="container">
		<p>&nbsp;</p>
		<div id="left">
		<div style="">
		</div>
				</div>
		<div id="right">
		<h3 align="left">Test has the following sections.</h3>

<?php 
$squery=mysql_query("select * from `test_setting` where (test_id='".$test_name."' and for_college='".$_SESSION['college']."')")or die(mysql_error());
if($rquery=mysql_fetch_array($squery)){
$instcount=$rquery['instance'];
}
$rs1= "SELECT * from `online_test` where (test_id='".$test_name."' and  STATUS='ACTIVE') order by id"; 
$rs11=mysql_query($rs1);
$countcat=mysql_num_rows($rs11);
while($row=mysql_fetch_array($rs11)){
$qry=mysql_query("select distinct(instance) from `test_timer2` where test_id='".$test_name."' AND category='".$row['CATEGORY']."' AND candidate='".$_SESSION['regno_of_user']."'");
$c=mysql_num_rows($qry);
$d=$c;
$d=($c==0 ? 1 : $c);
$c=($c==0 ? 1 : $c+1);

$sql=mysql_query("select * from `test_timer2` where test_id='".$test_name."' and category='".$row['CATEGORY']."'  and candidate='".$_SESSION['regno_of_user']."' and instance='".$d."' and status='no'")or die(mysql_error());
$numcount=mysql_num_rows($sql);


if($numcount=='0'){
if($c<=$instcount){
mysql_query("insert into `test_timer2` set test_id='".$test_name."', category='".$row['CATEGORY']."', candidate='".$_SESSION['regno_of_user']."', duration='".$row['duration']."', status='no',instance='".$c."'")or die(mysql_error());

//$d=$c;
}
}
}


//echo $d;
//echo "select * from `test_timer2` where (test_id='".$test_name."' and category='".$cat."' and candidate='".$_SESSION['regno_of_user']."' and status='no') ";
$sqlactive=mysql_query("select * from `test_timer2` where (test_id='".$test_name."' and candidate='".$_SESSION['regno_of_user']."' and status='no') order by id limit 0,1 ")or die(mysql_error());
if($rowactive=mysql_fetch_array($sqlactive)){
$cat=$rowactive['category'];
}
$rs1= "SELECT * from `online_test` where (test_id='".$test_name."' and  STATUS='ACTIVE') order by id"; 
$rs11=mysql_query($rs1);
while($row=mysql_fetch_array($rs11)){

$sql=mysql_query("select * from `test_timer2` where test_id='".$test_name."' and category='".$row['CATEGORY']."' and candidate='".$_SESSION['regno_of_user']."' and instance='".$d."' and status='no'" )or die(mysql_error());
if($rows=mysql_fetch_array($sql)){
$status=$rows['status'];
}
?>
<div <?php if($cat==$row['CATEGORY']){ ?> class="fixed-size-square" <?php }else { if($status=='no'){ ?>class="fixed-size-square1" <?php } else { ?>class="fixed-size-square2" <?php } } ?>>
    <h3 align="center" style="color:#FFFFFF;border-bottom:1px dotted #FFFFFF;"><?php echo $row['CATEGORY']; ?>  </h3>
	<p align="center">Time : <font color="#FFFFFF" size="+1"><?php echo $row['duration']; ?> Minutes </font> </p>
	<p align="center">Number Of Questions : <font color="#FFFFFF" size="+1"><?php echo $row['TOTAL_NO_QUESTION']; ?> </font></p>
	<p align="center">
	<a <?php if($cat==$row['CATEGORY']){ ?>  href="test31.php?test_id=<?php echo base64_encode($test_name); ?>&cat=<?php echo base64_encode($row['CATEGORY']); ?>&instance=<?php echo base64_encode($d); ?>" <?php }else{ ?> href="#" <?php } ?> id="link" <?php if($cat==$row['CATEGORY']){ ?>  style="background:#FB7934;padding:6px;border-radius:4px;" <?php }else { if($status=='no'){ ?>  style="background:#0000FF;padding:6px;border-radius:4px;" <?php }else{ ?>  style="background:#fff;padding:6px;border-radius:4px;" <?php } } ?>>
	<?php if($cat==$row['CATEGORY']){ ?> <img style="padding:3px;" src="img/start.png" width="" height="40" alt="dashboard" align="absmiddle" /><?php } else { if($status=='no'){ ?> <img style="padding:3px;" src="img/inna.png" width="" height="40" alt="dashboard" align="absmiddle" /> <?php } else { ?>  <img style="padding:3px;" src="img/complete.gif" width="" height="40" alt="dashboard" align="absmiddle" /> <?php } }?></a></p>
	
</div>
<?php }
$qry= "SELECT * from `online_test` where (test_id='".$test_name."' and  STATUS='ACTIVE') order by id"; 
$qry1=mysql_query($qry);
$countrows=mysql_num_rows($qry1);
$i=0;
while($qryrow=mysql_fetch_array($qry1)){
$qry11=mysql_query("select distinct(instance) from `test_timer2` where test_id='".$test_name."' AND category='".$row['CATEGORY']."' AND candidate='".$_SESSION['regno_of_user']."' and status='yes'");
$c1=mysql_num_rows($qry11);
$d1=$c1;
if($c1=="0")
{
$c1=1;
$d1=1;
}else{

$c1+=1; 
}
//echo "select * from `test_timer2` where test_id='".$test_name."' and category='".$qryrow['CATEGORY']."' and candidate='".$_SESSION['regno_of_user']."' and instance='".$d."' and status='yes'";
$sql1=mysql_query("select * from `test_timer2` where test_id='".$test_name."' and category='".$qryrow['CATEGORY']."' and candidate='".$_SESSION['regno_of_user']."' and instance='".$d."' and status='yes'")or die(mysql_error());
$numcount1=mysql_num_rows($sql1);
$i+=$numcount1;
if($i==$countrows){
$sql22="INSERT INTO `test_status` (`id`, `test_id`, `candidate`, `status`, `instance`,`etime`) VALUES (NULL, '".$test_name."', '".$_SESSION['regno_of_user']."', 'finish', '".$d."', now());";
if(mysql_query($sql22)or die(mysql_error())){
?>
<script language="JavaScript">
        window.location.href="x3.php";
</script>
<?php 
}
}
/*
?>
<!--<script language="JavaScript">
        window.opener.location.reload(true);
       setTimeout("window.close()", 1000);
</script>-->
<?php }*/
}

?> 


<div style="clear:both;"></div>
<p>&nbsp;</p>
<!--background:#B7B90F; -->
<table>

<tr><td><div style="width:40px;height:40px;margin:0px auto"><img src="img/active.png" width="30px" height="30px" align="absmiddle"> </div></td><td>This Pallete refers that the section is active.</td></tr>
<tr><td><div style="width:40px;height:40px;margin:0px auto"><img src="img/inactive.png" width="30px" height="30px" align="absmiddle"> </div></td><td>This Pallete refers that the section is inactive.</td></tr>
<tr><td><div style="width:40px;height:40px;margin:0px auto"><img src="img/completed.png" width="30px" height="30px" align="absmiddle"> </div></td><td>This Pallete refers that the section is completed.</td></tr>
</table>
</div>
</div>
<div style="clear:both;"></div>
<div id="header" style="height:30px;position: fixed;bottom: 0;"></div>
<?php 
$db->disconnect(); ?>
</body>
</html>