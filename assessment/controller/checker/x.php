<script language="JavaScript">
function refreshAndClose() {
      window.opener.location.reload(true);
      setTimeout("window.close()", 1000);
	  
    }
</script>

<title>Online Test</title>
</head>
<body onload='refreshAndClose();'>
<?php 
include("../class.database.php");
$db = new Database();  
$db->connect(); 
$sqry="select * from `verbaltest_eval` where `regd_no`='".$_POST['regd_no']."' AND `college`='".$_POST['regd_no']."'";
$srs=mysql_query($sqry)or die(mysql_error());
$scount=mysql_num_rows($srs);
if($scount>=1){
}else{
mysql_query("insert into `verbaltest_eval` (`regd_no`, `college`, `no_word`, `matched_phrase`, `per_word`, `per_phrase`, `total_time`, `time_taken`, `status`) VALUES ('".$_POST['regd_no']."', '".$_POST['college']."', '".$_POST['no_words']."', '".$_POST['match_phrase']."', '".$_POST['per_word']."', '".$_POST['per_phrase']."', '".$_POST['total_time']."', '".$_POST['time_taken']."', '".$_POST['status']."');")or die(mysql_error());
}

 ?>


<h1 style="margin-top:300px;text-align:center;color:#0000CC;font-weight:bold;">Evaluation For Regd No- <?php echo $_POST['regd_no']; ?> is successfully completed..</h1>
<p align="center">This window will be closed automatically. Redireting to test section...</a></p>
</body>
</html>

