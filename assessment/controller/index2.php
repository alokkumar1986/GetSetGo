<?PHP session_start();
ob_start();
error_reporting(0);
require_once("../include/membersite_config.php");
$page=$_GET['id'];
if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../login.php");
    exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="style.css" />
<title>Adminstration</title>
</head>

<body>
<div id="heading"><div id="welcome">ADMINISTRATION</div><div id="logout"><div id="mws-user-photo" style="width:20px;float:left;">
                	<img src="example/profile.jpg" alt="User Photo" width="43" height="43" style="border:2px solid #ddd;border-radius:4px;">
                </div>

<div id="mws-user-functions" style="float:right;padding-right:10px;padding-top:4px;">
                    <div id="mws-username" style="color:#FFFF00">
                        Hello, <?php echo $_SESSION['name_of_user']; ?>
                    </div>
                    <a href="?id=profile&sid=<?php echo $_SESSION['email_of_user']; ?>">Profile</a> | <a href="?id=change password">Change Password</a> | <a href="../logout.php">Logout</a>
                </div>
                </div></div>
<div id="container">
<div id="left"><div id="menu">
<ul><li><a href="#">DashBoard</a></li>
<li><a href="?id=create user">Create User</a></li>
<li><a href="#">Notice Board</a></li>

</ul>
</div></div>
<div id="right">
<div id="breadcrum" style="padding-left:70px;padding-bottom:6px;padding-top:20px;"><div style="background:#f2f2f2;padding:8px;box-shadow:2px 2px 2px #ccc;"><a href="index.php">Home</a><?php if($page){ ?>- <a href="?id=<?php echo $page; ?>"><?php echo ucwords($page); ?></a><?php } ?></div></div>
<div style="padding-left:70px;padding-bottom:40px;"><?php if($page!=""){ include("$page.php"); }else {
include("dashboard.php");} ?></div></div>
<div class="clear"></div>
</div>
<div id="footer">&copy;copyright 2014, All Rights Reserved.</div>
</body>
</html>

