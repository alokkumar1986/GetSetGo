<?php session_start();
ob_start();
error_reporting(0);
require_once("../../onlinetest/include/membersite_config.php");
if(!$fgmembersite->CheckLogin())
{
 $fgmembersite->RedirectToURL("../login.php");
    exit;
}
$fgmembersite->DBLogin();
error_reporting(0);
$queid=$_POST['queid'];
$regno= $_POST['REG_NO'];
$answer= $_POST['answer'];
$sql="INSERT INTO result (Q_ID, REG_NO, VERBAL_QUESTION)
VALUES
('$_POST[queid]','$_POST[REG_NO]','$_POST[answer]')";
if(mysql_query($sql)){
	header("location: dashboard.php");
}
?>