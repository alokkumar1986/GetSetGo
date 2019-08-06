<?php session_start();
if(isset($_COOKIE["name_of_user2"]) && isset($_COOKIE["regno_of_user"]) && isset($_COOKIE["email_of_user"]) && isset($_COOKIE["college"]) && isset($_COOKIE["branch"]) && isset($_COOKIE["role"])){
             $_SESSION['name_of_user2']  = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['name_of_user2']); 
             $_SESSION['regno_of_user']  = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['regno_of_user']);;
             $_SESSION['email_of_user'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['email_of_user']);;
             $_SESSION['college'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['college']);;
             $_SESSION['branch'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['branch']);;
             $_SESSION['role'] = 'Student';
 } 
error_reporting(0);  ?>
<title>Online Test</title>
</head>
<body onload='refreshAndClose();'>
<?php
if($_SESSION['email_of_user']==''){ ?>
 
 <script language="JavaScript">
//function refreshParent() {
//window.location="mod3.php?test_id=<?php //echo $test_id; ?>";
//}
    function refreshAndClose() {
        window.opener.location.reload(true);
       setTimeout("window.close()", 100000);
    }
</script>


    
    
 <h1 style="margin-top:300px;text-align:center;color:#0000CC;font-weight:bold;">Your Session Has Been Expired. Please Log In and Submit the Test</h1>
<p align="center"><a href="#" onClick='refreshAndClose();' class="btn4">Close Window</a></p>
<?php 
exit;
}
$user=$_SESSION["regno_of_user"];
$cat_id=$_GET['cat_id'];
$test_id=$_GET['test_name'];
$instance1=$_GET['instance'];
include("class.database.php");
$db2 = new Database();  
$db2->connect();
$qryab=mysql_query("select distinct(instance) from `test_status` where test_id='".$test_id."' AND candidate='".$_SESSION['regno_of_user']."' AND status='finish'");
$cab=mysql_num_rows($qryab);
$ins=$cab+1; 
$quest=explode(',',$_POST['quest']);
$answ=explode(',',$_POST['answ']);
$l=sizeof($quest);

for($k=1;$k<$l;$k++){
$find=mysql_query("select * from `temp_test_result` where test_id='".$test_id."' AND candidate='".$_SESSION['regno_of_user']."' AND question_id='".$quest[$k]."' AND instance='".$ins."'");
$findcount=mysql_num_rows($find);
if($findcount=='0'){
mysql_query("insert into `temp_test_result` values('NULL','$test_id','$user',$quest[$k],$answ[$k],CURTIME(),CURTIME(),$ins)")or die(mysql_error());
}else{
mysql_query("update `temp_test_result` set test_id='$test_id',candidate='$user',question_id=$quest[$k],answer=$answ[$k],stime=CURTIME(),etime=CURTIME(),instance=$ins where test_id='".$test_id."' AND candidate='".$_SESSION['regno_of_user']."' AND question_id='".$quest[$k]."' AND instance='".$ins."'")or die(mysql_error());
}
}
$qry=mysql_query("select * from `test_setting` where for_college='".$_SESSION['college']."' AND test_id='$test_id'");
if($sel=mysql_fetch_array($qry)){
$instance=$sel['instance'];
}

$sql1="select * from `test_status` where candidate='$user' and test_id='$test_id' and instance='$instance'";  
$rs1=mysql_query($sql1);
$count=mysql_num_rows($rs1);
if($count=='0'){
$qrya=mysql_query("select distinct(instance) from `test_status` where test_id='".$test_id."' AND candidate='".$_SESSION['regno_of_user']."' AND status='finish'");
$ca=mysql_num_rows($qrya);  
$ca+=1;
mysql_query("update `test_timer2` set status='yes' where (test_id='".$test_id."' and category='".$cat_id."' and candidate='".$_SESSION['regno_of_user']."' and instance='".$instance1."')")or die(mysql_error());
}
$db2->disconnect();

?>

<script language="JavaScript">
    function refreshAndClose() {
        window.location.href="test21.php?test_id=<?php echo base64_encode($test_id); ?>";
    }
</script>

<title>Online Test</title>
</head>
<body onload='refreshAndClose();'>
<h1 style="margin-top:300px;text-align:center;color:#0000CC;font-weight:bold;">Your Section Has Been Submitted Successfully</h1>
<p align="center">This window will be closed automatically. Redireting to test section...</a></p>
</body>
</html>

