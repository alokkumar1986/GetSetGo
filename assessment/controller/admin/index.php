<?PHP session_start();
$path="http://www.induseducation.in/";
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
    <!--<script src="../../js/bootstrap.js"></script>-->
   <script src="../../js/bootstrap.min.js"></script>
    <!--<script src="../../js/typica-login.js"></script>-->
     <!--<script type='text/javascript'>
	$(window).load(function(){
	$('#sidebar a').on('click', function () {
    $(this).closest('div').find('.collapse').collapse('hide');
    $(this).collapse('show');
		});
		});
 </script> -->
 <script type="text/javascript" src="../../js/ddaccordion.js"></script>

<script type="text/javascript">
ddaccordion.init({
	headerclass: "submenuheader", //Shared CSS class name of headers group
	contentclass: "submenu", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["", ""], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["suffix", "<img src='../../image/plus.gif' class='statusicon' />", "<img src='../../image/minus.gif' class='statusicon' />"], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})
</script>
<script type="text/javascript">
$(window).load(function() {
	$(".loader").fadeOut("slow");
})
</script>
<style>
.loader {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url(../../../student/controller/Student/onlinesystem/images/loading.gif) 50% 50% no-repeat rgb(249,249,249);
}
</style>
  </head>
  <body style="background:url('<?php echo $path; ?>images/background1.png');padding-top:0px !important;">
    <div class="loader"><p style="padding-top:350px;font-size:24px;color:red" align="center">Please Wait.</p></div>
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
               <img src="../example/profile.jpg" alt="User Photo" width="43" height="43" style="border:2px solid #ddd;border-radius:4px;float:left;margin-right:3px;"> Hello, <?php echo ucwords($_SESSION['name_of_user']); ?> <br/>
        <a href="?id=profile&sid=<?php echo $_SESSION['email_of_user']; ?>">Profile</a> | <a href="?id=change password">Change Password</a> | <a href="../../logout.php">Logout</a>
            </div>
            </div>
        </div>
  
     <div class="clear">&nbsp;</div>
<!--- Head Section end -->
    <div class="container">
    <!--Breadcrumb Start-->
<!--<div class="row">
<div class="breadcrumb">
    <a><span class="badge"></span>Home</a>
        <a class="current"><span class="badge badge-inverse"></span><?php if($page!=''){ echo $page; }else { ?>Dashboard<?php } ?></a>
   </div>
</div>-->
<div class="row">
<ol class="breadcrumb">
  <li><a href="index.php">Home</a></li>
 
  <li class="active"><?php if($page!=''){ echo ucwords($page); }else { ?>Dashboard<?php } ?></li>
</ol></div>
<!-- Breadcrumb End-->
<div class="clear" style="height:5px;"></div>

         <div class="row">

     <!-- <div class="col-md-3" style="background-color: #F0F0F0;box-shadow: 
         inset 1px -1px 1px #444, inset -1px 1px 1px #444;">-->
          <div class="col-md-2" >
         
    <div class="sidebarmenu">
             <a class="menuitem_green" href="?id=dashboard">Dashboard</a>
                
               <!-- <a class="menuitem submenuheader" href="">Faculty Management</a>
                <div class="submenu">
                    <ul>
                    <li><a href="?id=add faculty">Add Faculty</a></li>
                    <li><a href="?id=upload faculty">Upload Faculty</a></li>
                    <li><a href="?id=view faculty">View Faculty</a></li>
                    </ul>
                </div>-->
                <a class="menuitem submenuheader" href="" >Student Management</a>
                <div class="submenu">
                    <ul>
                    <li><a href="?id=add student">Add Student</a></li>
                    <li><a href="?id=upload student">Upload Student</a></li>
                    <li><a href="?id=view student">View Student</a></li>
                                      </ul>
                </div>
               
                <a class="menuitem submenuheader" href="">Report Management</a>
                 <div class="submenu">
                    <ul>
                    <li><a href="?id=p i report">PI Report</a></li>
                    <li><a href="?id=tech report">TI Report</a></li>
										<li><a href="?id=combine report">Combine Report</a></li>
                    <li><a href="?id=attendance report">Attendance Report</a></li>
                    <li><a href="?id=personalised report">Personalised(PI,TI) Report</a></li>
                    </ul>
                </div>  
                <a class="menuitem submenuheader" href="">College Management</a>
                 <div class="submenu">
                    <ul>
					<li><a href="?id=add university">Add University</a></li>
                    <li><a href="?id=add college">Add College</a></li>
                    <li><a href="?id=add course">Add Course</a></li>
                    <li><a href="?id=add branch">Add Branch</a></li>
                   
                    </ul>
                    </div>
                    <a class="menuitem submenuheader" href="">Notice Management</a>
                 <div class="submenu">
                    <ul>
                    <li><a href="?id=add notice">Add Notice</a></li>
                    <li><a href="?id=view notice">View Notice</a></li>
                   
                    </ul>
                </div> 
				  <a class="menuitem submenuheader" href="">User Management</a>
                 <div class="submenu">
                    <ul>
                    <li><a href="?id=add user">Add User</a></li>
                    <li><a href="?id=upload faculty">Upload User</a></li>
                    <li><a href="?id=view user">View User</a></li>
                   
                    </ul>
                </div> 
                 <a class="menuitem submenuheader" href="">Settings</a>
                 <div class="submenu">
                    <ul>
                    <li><a href="?id=interview setting"> Interview Setting</a></li>
                    <li><a href="?id=profie search setting">Profile Search Setting</a></li>
                   <li><a href="?id=add category">Add Test Category</a></li>
                    </ul>
                    </div>
                    <a class="menuitem submenuheader" href="">Knowledge Base</a>
                 <div class="submenu">
                    <ul>
                    <li><a href="?id=knowledgebase content">All Content</a></li>
                    <li><a href="?id=add knowledgebase content">Add Content</a></li>
                   
                    </ul>
                    </div>
					 <a class="menuitem submenuheader" href="">Materials</a>
                 <div class="submenu">
                    <ul>
                    <li><a href="?id=all materials">All Materials</a></li>
                    <li><a href="?id=add material">Add Material</a></li>
                   
                    </ul>
                    </div>
					
					 <a class="menuitem submenuheader" href="">Messages</a>
                 <div class="submenu">
                    <ul>
                    <li><a href="?id=inbox">Inbox</a></li>
                    <li><a href="?id=sent messages">Sent Messages</a></li>
                   <li><a href="?id=compose">Compose</a></li>
                    </ul>
                    </div>
					
					<a class="menuitem submenuheader" href="">Database </a>
                 <div class="submenu">
                    <ul>
                    <li><a href="?id=back up">Back Up</a></li>
                    <!--<li><a href="?id=create csv">Create .CSV</a></li> -->
                   
                    </ul>
                    </div>
            </div>

      </div>
<!--<div class="col-md-9" style="box-shadow: 
         inset 1px -1px 1px #444, inset -1px 1px 1px #444;padding-left:20px;">-->
		 
		 <div <?php if($page=='dashboard'){ ?>class="col-md-9" <?php }else{ ?> class="col-md-7" <?php } ?> style="padding-left:20px;">
         <div class="panel panel-success" style="padding:10px;">
         
         <?php if($page!=""){ include("$page.php"); }else {
include("dashboard.php");} ?>

         </div>
         
         
    </div>
    
   <?php
    if(($page!='dashboard') ){ ?> <div class="col-md-3" style="padding-left:20px;">
         <div  style="padding:10px;">
        <img src="../../image/assm.gif" >

         </div>
		 
         
         
    </div><?php } ?>

		 
		 
      <!--<div class="col-md-7" style="padding-left:20px;">
         <div class="panel panel-success" style="padding:10px;">
         
         <?php //if($page!=""){ include("$page.php"); }else {
//include("dashboard.php");} ?>

         </div>
         
         
    </div>
    
    <div class="col-md-3" style="padding-left:20px;">
         <div  style="padding:10px;">
        <img src="../../image/assm.gif" >

         </div>
         
         
    </div>

    </div> -->
</div>
    <div id="wrapper" style="width:100%; height:25px;background-color: #B20EFF;position: fixed;bottom: 0;border-top:2px solid #000;box-shadow:0px 2px 2px 2px #888888;">
 <div id="footer1"> 
		<p align='center' style="padding:3px;">Copyright &copy; 2013 Indus Education. All rights reserved.</p>
		     </div>
     </div>
 
   
  </body></html>