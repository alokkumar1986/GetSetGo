<?PHP session_start();
ob_start();
error_reporting(0);
require_once("../include/membersite_config.php");
if(!$fgmembersite->CheckLogin())
{
 $fgmembersite->RedirectToURL("../login.php");
    exit;
}

?>


<!doctype html>
<html lang="en-US">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	<title>Online Exam</title>
<!--
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Varela+Round">-->
	
    <link href="../css/bootstrap.min.css" rel="stylesheet">
 	<link href="../css/onlinestyle.css" rel="stylesheet">
	 <link href="../css/api.css" rel="stylesheet">
 	<link href="../css/reset.css" rel="stylesheet">
   <link rel="shortcut icon" href="http://induseducation.in/favicon.ico" />
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
<script src="../js/bootstrap.min.js"></script>
</head>

<!--<body style="background:url(image/test.jpg) no-repeat center center fixed ;">-->
<body>
<div class="container">
 <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="navbar-inner">
 <div class="row" style="padding-left:25px;padding-right:15px;">

      <div class="col-xs-3 col-sm-3 col-md-3" style="padding:10px;" >
      <img src="../image/77.gif" alt="" >  
      </div>

      <div class="col-xs-6 col-sm-6 col-md-6" style="padding:20px;text-align: center" >
        <span style="text-transform:uppercase;"> <font size="5" color="#33CCFF" > <strong>Employability Service </strong></font></span>
            </div>
          <div class="col-xs-3 col-sm-3 col-md-3" style="padding-top:10px; color:white;" >
               <img src="../image/profile.jpg" alt="User Photo" width="43" height="43" style="border:2px solid #ddd;border-radius:4px;float:left;margin-right:3px;"> Hello, <?php echo ucwords($_SESSION['name_of_user']); ?> <br/>
        <a href="?id=profile&sid=">Profile</a> | <a href="?id=change password">Change Password</a> | <a href="../logout.php">Logout</a>
            </div>
			 </div><!--Header Row End-->
			</div>
			</nav>
			<div class="clear" style="padding:45px;"></div>
			<div class="row">
			<div class="col-xs-2 col-sm-2 col-md-2" ></div>
			<div class="col-xs-8 col-sm-8 col-md-8" >
         <!--Panel Start-->
<div class="panel panel-primary"> <div class="panel-heading"><font size="5" color="#000066"><center><strong>Dashboard</strong></center></font> </div>
	<table class="table" >
	<tr><td>
	<form id='changepwd' action='' method='post' enctype="multipart/form-data">

<fieldset>


                       <!-- Dashboard icons --> 
            <div > 
            	
               
                <a href="test.php" class="dashboard-module"> 
                	<img src="../image/test.gif" tppabs="" width="64" height="64" alt="edit" /> 
 
                	<span>Test</span> 
                </a> 
                             
                <a href="" class="dashboard-module"> 
                	<img src="../image/assessment.gif" tppabs="" width="64" height="64" alt="edit" /> 
 
                	<span>PI Report</span> 
                </a> 
				<a href="" class="dashboard-module"> 
                	<img src="../image/assessment1.gif" tppabs="" width="64" height="64" alt="edit" /> 
 
                	<span>Technical Report</span> 
                </a> 
				
				
                <a href="" class="dashboard-module"> 
                	<img src="../image/Crystal_Clear_calendar.gif" tppabs="" width="64" height="64" alt="edit" /> 
                	<span>Calendar</span> 
                </a> 
                <div style="clear: both"></div> </div> 
                    
              
</fieldset>
</form>

	</td></tr>
	</table>
	</div>
	<!--Panel End-->
	</div>
	<div class="col-xs-2 col-sm-2 col-md-2" ></div>
	</div>
    <!--Footer Start-->
    <footer class="white navbar-fixed-bottom">
    <font color="white">copyright©IndusEducation. All rights reserved.</font>
    </footer><!--Footer End-->
       
</div><!--Wrapper End-->
</body>	
</html>