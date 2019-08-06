<?PHP session_start();
$path="http://".$_SERVER['SERVER_NAME']."/";
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
    <title>Online Test Teacher Control</title>
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
   
<link rel="shortcut icon" href="http://www.induseducation.in/favicon.ico" />
  
<script src="../../js/jquery.min.js"></script>

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

$(window).load(function(){
	$(".loader").fadeOut("slow");
})
</script>
  </head><body style="background:url('<?php echo $path; ?>images/background1.png');padding-top:0px !important;">
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
               <?php
               $row=mysql_query("select * from staff where Email='".$_SESSION['email_of_user']."'")or die(mysql_error());
if($rs=mysql_fetch_array($row)or die(mysql_error())){ $photo=$rs['Photo'];  ?>

               <img <?php if($photo!=''){ ?>src="../admin/uploads1/<?php echo $photo; ?>" <?php }else { ?>src="../example/profile.jpg" <?php } ?> alt="User Photo" width="43" height="" style="border:2px solid #ddd;border-radius:4px;float:left;margin-right:3px;">  Hello, <?php echo ucwords($_SESSION['name_of_user']); ?> <br/>
        <a href="index.php?id=profile&sid=<?php echo $_SESSION['email_of_user']; ?>">Profile</a> | <a href="index.php?id=change password">Change Password</a> | <a href="../../logout.php">Logout</a>
        <?php } ?>
            </div>
        </div>
  </div>
     <div class="clear">&nbsp;</div>

   <!-- <div class="navbar navbar-fixed-top">-->
	
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
                    <li><a href="?id=test report">Test Report(Bulk)</a></li>
					
					<li><a href="?id=test report(individual)">Test Report(individual)</a></li>
					<li><a href="?id=interview report">Interview Report</a></li>
                    </ul>
                </div>  
                <!--<a class="menuitem submenuheader" href="">Interview</a>
                 <div class="submenu">
                    <ul>
                    <li><a href="search.php"> Interview</a></li>
                    
                   
                    </ul>
                    </div>-->
                  <!-- <a class="menuitem submenuheader" href="">Test Management</a>
                 <div class="submenu">
                    
                </div> -->
				<a class="menuitem submenuheader" href="">Others</a>
                 <div class="submenu">
                    <ul>
				<li><a href="?id=activity log">Activity Log </a></li>
				<li><a href="?id=test log">Test Log </a> </li>
				</ul>
				</div>
                <!--
                 <a class="menuitem submenuheader" href="">Settings</a>
                 <div class="submenu">
                    <ul>
                    <li><a href="?id=interview setting"> Interview Setting</a></li>
                    <li><a href="#">XXXX</a></li>
                   
                    </ul>
                    </div>-->
            </div>

      </div>
<!--<div class="col-md-9" style="box-shadow: 
         inset 1px -1px 1px #444, inset -1px 1px 1px #444;padding-left:20px;">-->
      <div class="col-md-10" style="padding-left:20px;">
         <div class="panel panel-success" style="padding:10px;">
         
         <?php if($page!=""){ include("$page.php"); }else {
include("dashboard.php");} ?>

         </div>
         
         
    </div>
    

    </div>
</div>
      <div id="wrapper" style="width:100%; height:25px;background-color: #B20EFF;position: fixed;bottom: 0;border-top:2px solid #000;box-shadow:0px 2px 2px 2px #888888;">
 <div id="footer1"> 
		<p align='center' style="padding:3px;">Copyright &copy; 2013 Indus Education. All Rights Reserved.</p>
		     </div>
     </div>
 
   
  </body></html>