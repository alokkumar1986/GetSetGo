<?php session_start();
require_once("./include/membersite_config.php");
$fgmembersite->DBLogin();
$qry1 = "Update `activitylog` set `activity`='off', `out`=now() where (`reg_no`='".$_SESSION['regno_of_user']."')";
$result1 = mysqli_query($fgmembersite->connection, $qry1) or die(mysql_error());

unset($_COOKIE['PHPSESSID']);
unset($_COOKIE["name_of_user2"]);
unset($_COOKIE["regno_of_user"]);
unset($_COOKIE["email_of_user"]);
unset($_COOKIE["college"]);
unset($_COOKIE["branch"]);
unset($_COOKIE["role"]);

setcookie('PHPSESSID', '', time()- 3600);
setcookie("name_of_user2", '', time()- 3600);
setcookie("regno_of_user", '', time()- 3600);
setcookie("email_of_user", '', time()- 3600);
setcookie("college", '', time()-  3600);
setcookie("branch", '', time()- 3600);
setcookie("role", "", time()- 3600);

session_destroy();
header("location: index.php");
?>