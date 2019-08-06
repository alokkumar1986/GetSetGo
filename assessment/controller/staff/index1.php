<?PHP session_start();
$path="http://www.induseducation.in/";
ob_start();
error_reporting(0);
require_once("../../include/membersite_config.php");
$fgmembersite->DBLogin();
if(!$fgmembersite->CheckLogin())
{
 $fgmembersite->RedirectToURL("../../login.php");
    exit;
}
$page=$_GET['id'];
?>
<!DOCTYPE HTML>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">

  
    <meta charset="utf-8">
    <title>Assessment Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="../../css/bootstrap1.css" rel="stylesheet">
    <link href="../../css/bootstrap-responsive.css" rel="stylesheet">
<!--<link href="css/jquery-ui.css" rel="stylesheet">-->
    <link rel="stylesheet" href="../../css/typica-login.css">
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../../css/style.css">
<style type='text/css'> 
    div.subitem a.list-group-item {
    padding-left: 30px;
}
  </style> 
<!--<script type='text/javascript'>
$(window).load(function(){
$('#sidebar a').on('click', function () {
    $(this).closest('div').find('.collapse').collapse('hide');
    $(this).collapse('show');
});
});
 
</script>--> 
    <link rel="shortcut icon" href="http://induseducation.in/favicon.ico" />
  
<!--<script src="../../js/jquery.min.js"></script> -->
<script src="../../js/jquery-1.7.2.min.js"></script>
<!--<script src="../../js/bootstrap.js"></script>-->
<script src="../../js/bootstrap.min.js"></script>
<!--<script src="../../js/typica-login.js"></script>-->
    
  </head><body style="background:url('<?php echo $path; ?>images/background1.png');padding-top:0px !important;">
<div class="row-fluid" id="header-pane" style="background-color: #B20EFF;padding-top:6px;padding-bottom:6px;border-top:2px solid #000;box-shadow:0px 5px 5px 5px #888888;">
            <div id="top_home" class="clear">
               <div class="col-md-2" style="padding-left:10px;"> <header class="clear">
                    
                    <a href="index.php"><img src="<?php echo $path; ?>images/77.gif" ></a>
                    
                   
                </header>
                </div>
                <div class="col-md-6" style="padding-left:10px;padding-top:7px;padding-bottom:7px;text-align: right;" >
         <span style="text-transform:uppercase;"> <font size="5" color="#33CCFF" > <strong><!--Careers & Employability Service--> </strong></font></span>
            </div>
            <div class="col-md-4" style="padding-top:5px;padding-left: 100px;font-weight: bold;" >
               <?php
               $row=mysql_query("select * from staff where Email='".$_SESSION['email_of_user']."'")or die(mysql_error());
if($rs=mysql_fetch_array($row)or die(mysql_error())){ $photo=$rs['Photo'];  ?>

               <img <?php if($photo!=''){ ?>src="../admin/uploads1/<?php echo $photo; ?>" <?php }else { ?>src="../example/profile.jpg" <?php } ?> alt="User Photo" width="43" height="" style="border:2px solid #ddd;border-radius:4px;float:left;margin-right:3px;">  Hello, <?php echo ucwords($_SESSION['name_of_user']); ?> <br/>
        <a href="index1.php?id=profile&sid=<?php echo $_SESSION['email_of_user']; ?>">Profile</a> | <a href="index1.php?id=change password">Change Password</a> | <a href="../../logout.php">Logout</a>
        <?php } ?>
            </div>
        </div>
  </div>
     <div class="clear">&nbsp;</div>
     
<!--- Head Section end -->
    <div class="container">
    <div class="row">
<ol class="breadcrumb">
  <li><a href="index.php">Home</a></li>
 
  <li class="active"><?php if($page!=''){ echo ucwords($page); }else { ?>Dashboard<?php } ?></li>
</ol></div>
<div class="clear" style="height:10px;"></div>

         <div class="row">

     <div class="col-md-2" >
         
    <div class="sidebarmenu">
             <a class="menuitem_green" href="?id=dashboard">Dashboard</a>
                
                <!--<a class="menuitem submenuheader" href="">Faculty Management</a>
                <div class="submenu">
                    <ul>
                    <li><a href="?id=add faculty">Add Faculty</a></li>
                    <li><a href="?id=upload faculty">Upload Faculty</a></li>
                    <li><a href="?id=view faculty">View Faculty</a></li>
                    </ul>
                </div>
                <a class="menuitem submenuheader" href="" >Student Management</a>
                <div class="submenu">
                    <ul>
                    <li><a href="?id=add student">Add Student</a></li>
                    <li><a href="?id=upload student">Upload Student</a></li>
                    <li><a href="?id=view student">View Student</a></li>
                                      </ul>
                </div>-->
               
                <a class="menuitem submenuheader" href="">Report Management</a>
                 <div class="submenu">
                    <ul>
                    <li><a href="?id=interview report">Report</a></li>
                   
                    </ul>
                </div>  
                <a class="menuitem submenuheader" href="">Interview</a>
                 <div class="submenu">
                    <ul>
                    <li><a href="search.php"> Interview</a></li>
                    
                   
                    </ul>
                    </div>
                   <!-- <a class="menuitem submenuheader" href="">Notice Management</a>
                 <div class="submenu">
                    <ul>
                    <li><a href="?id=add notice">Add Notice</a></li>
                    <li><a href="?id=view notice">View Notice</a></li>
                   
                    </ul>
                </div> 
                 <a class="menuitem submenuheader" href="">Settings</a>
                 <div class="submenu">
                    <ul>
                    <li><a href="?id=interview setting"> Interview Setting</a></li>
                    <li><a href="#">XXXX</a></li>
                   
                    </ul>
                    </div>-->
            </div>

      </div>
      <div class="col-md-7" style="padding-left:20px;">
         <div class="panel panel-success" style="padding:10px;">
         
         <?php if($page!=""){ include("$page.php"); }else {
include("dashboard.php");} ?>

         </div>
         
         
    </div>
    
    <div class="col-md-3" style="padding-left:20px;">
         <div  style="padding:10px;">
        <img src="../../image/assm.gif" >

         </div>
         
         
    </div>

    </div>
</div>
     <div id="wrapper" style="width:100%; height:25px;background-color: #B20EFF;position: fixed;bottom: 0;border-top:2px solid #000;box-shadow:0px 2px 2px 2px #888888;">
 <div id="footer1"> 
		<p align='center' style="padding:3px;">copy right &copy; 2013 Indus Education. All rights reserved.</p>
		     </div>
     </div>
 
   
  </body></html>