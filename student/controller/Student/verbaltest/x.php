<?php session_start(); ?>
<script language="JavaScript">
function refreshAndClose() {
      window.opener.location.reload(true);
      setTimeout("window.close()", 1000);
	  
    }
</script>

<title>Online Test</title>
</head>
<body onload='refreshAndClose();'>
<?php include("../onlinesystem/class.database.php");
$db = new Database();  
$db->connect(); 
$asql=mysql_query("select * from `verbaltest_result` where (college='".$_SESSION['college']."' AND regd_no='".$_SESSION['regno_of_user']."')")or die(mysql_error());
$acnt=mysql_num_rows($asql);
if($acnt>='0'){
mysql_query("update `verbaltest_result` set answer='".$_POST['answer']."', status='finish',`finished_time`=now()  where (college='".$_SESSION['college']."' AND regd_no='".$_SESSION['regno_of_user']."')")or die(mysql_error());;
}

 ?>
<h1 style="margin-top:300px;text-align:center;color:#0000CC;font-weight:bold;">Your Test Has Been Submitted Successfully</h1>
<p align="center">This window will be closed automatically. Redireting to test section...</a></p>
</body>
</html>

