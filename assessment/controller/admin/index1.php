<?PHP session_start();
ob_start();
error_reporting(0);
require_once("../../include/membersite_config.php");
if(!$fgmembersite->CheckLogin())
{
 $fgmembersite->RedirectToURL("../login.php");
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
   
    <link rel="shortcut icon" href="http://induseducation.in/favicon.ico" />
  
<!--<script src="../../js/jquery.min.js"></script>
 -->  <script src="../../js/jquery-1.9.1.js"></script>
    <script src="../../js/bootstrap.js"></script>
   <script src="../../js/bootstrap.min.js"></script>
    <!--<script src="../../js/typica-login.js"></script>-->
     <script type='text/javascript'>
	$(window).load(function(){
	$('#sidebar a').on('click', function () {
    $(this).closest('div').find('.collapse').collapse('hide');
    $(this).collapse('show');
		});
		});
 </script> 
  </head><body>

   <!-- <div class="navbar navbar-fixed-top">-->
	  <div class="container">
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="navbar-inner">
      <div class="row" style="padding-left:25px;padding-right:15px;">

      <div class="col-md-3" style="padding:10px;" >
      <img src="../../image/77.gif" alt="" >  
      </div>

      <div class="col-md-6" style="padding:20px;" >
         <span style="text-transform:uppercase;"> <font size="5" color="#33CCFF" > <strong>Careers & Employability Service </strong></font></span>
            </div>
            <div class="col-md-3" style="padding-top:10px;" >
               <img src="../example/profile.jpg" alt="User Photo" width="43" height="43" style="border:2px solid #ddd;border-radius:4px;float:left;margin-right:3px;"> Hello, <?php echo ucwords($_SESSION['name_of_user']); ?> <br/>
        <a href="?id=profile&sid=<?php echo $_SESSION['email_of_user']; ?>">Profile</a> | <a href="?id=change password">Change Password</a> | <a href="../../logout.php">Logout</a>
            </div>
         </div>
      </div></nav>
	 </div>
     <div class="clear" style="height:35px;">&nbsp;</div>
<!--- Head Section end -->
    <div class="container">
<div class="clear" style="height:40px;"></div>

         <div class="row">

     <!-- <div class="col-md-3" style="background-color: #F0F0F0;box-shadow: 
         inset 1px -1px 1px #444, inset -1px 1px 1px #444;">-->
          <div class="col-md-3" >
         <div class="panel panel-default">
    <div class="panel-heading" align="center">
        
    </div>
    <div id="sidebar" class="list-group"> 
    <a href="#" class="list-group-item active"><i class="icon-dashboard"></i> Dashboard</a>
    
    <a href="#users" class="list-group-item" data-toggle="collapse" data-parent="#sidebar"><i class="icon-group"></i> Faculty Management<span class="badge bg_danger">+</span></a>

        <div id="users" class="list-group subitem collapse in">	<a href="?id=addfaculty" class="list-group-item"><i class="icon-caret-right"></i> Add Faculty</a><a href="?id=uploadfaculty" class="list-group-item"><i class="icon-caret-right"></i>Upload Faculty </a><a href="?id=viewfaculty" class="list-group-item"><i class="icon-caret-right"></i> View Faculty</a>
        </div>	
        
    <a href="#articles" class="list-group-item" data-toggle="collapse" data-parent="#sidebar"><i class="icon-file-text"></i> Student Management<span class="badge bg_danger">+</span></a>

        <div id="articles" class="list-group subitem collapse">	<a href="?id=addstudent" class="list-group-item bg_warning"><i class="icon-caret-right"></i> Add Student</a><a href="?id=uploadstudent" class="list-group-item"><i class="icon-caret-right"></i> Upload Student</a> <a href="?id=viewstudent" class="list-group-item"><i class="icon-caret-right"></i> View Student</a>  </div>
      
      <a href="#report" class="list-group-item" data-toggle="collapse" data-parent="#sidebar"><i class="icon-file-text"></i> Report Management<span class="badge bg_danger">+</span></a>

        <div id="report" class="list-group subitem collapse">	<a href="?id=pireport" class="list-group-item bg_warning"><i class="icon-caret-right"></i> PI Report</a><a href="?id=tecreport" class="list-group-item"><i class="icon-caret-right"></i> Technical Report</a>
</div>
      <!-- <a href="?id=viewstudent" class="list-group-item"><i class="icon-caret-right"></i> View Student</a>  </div> -->
    </div>
</div>
      </div>
<!--<div class="col-md-9" style="box-shadow: 
         inset 1px -1px 1px #444, inset -1px 1px 1px #444;padding-left:20px;">-->
      <div class="col-md-6" style="padding-left:20px;">
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
    <footer class="white navbar-fixed-bottom">
    <font color="grey">copyright@IndusEducation. All rights reserved.</font>
    </footer>
 
   
  </body></html>