<?php session_start(); 
require_once("../../include/membersite_config.php");
error_reporting(0);
if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}
$fgmembersite->DBLogin(); 
$qry=mysql_query("select count(*) from feedbackans where regno='".$_SESSION['regno_of_user']."'") or die(mysql_error());
$row1=mysql_fetch_array($qry);
$attempt=$row1['count(*)']+1;
$sql=mysql_query("insert into feedbackans values('".$_SESSION['regno_of_user']."', '".$_POST['1']."', '".$_POST['2']."', '".$_POST['3']."', '".$_POST['4']."', '".$_POST['5']."', '".$attempt."', CURDATE())") or die(mysql_error())
?>

<h1 align="center" style="margin: 10px 0px 0px 36px">You have successfully submitted your valuable feedback. Thank You Very Much.</h1>