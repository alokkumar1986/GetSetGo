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
    <title>Assessment Student Search</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

   <link href="../../css/bootstrap1.css" rel="stylesheet">
    <link href="../../css/bootstrap-responsive.css" rel="stylesheet">
<!--<link href="css/jquery-ui.css" rel="stylesheet">-->
    <link rel="stylesheet" href="../../css/typica-login.css">
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../../css/style.css">
<link rel="stylesheet" type="text/css" href="../../css/jquery.autocomplete.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

   
    <link rel="shortcut icon" href="http://induseducation.in/favicon.ico" />
 <script src="../../js/jquery-latest.js"></script>
    <script src="../../js/bootstrap.js"></script>
    <!--<script src="../../js/backstretch.js"></script>-->
    <!--<script src="../../js/typica-login.js"></script>-->
    <script src="../../js/jquery.autocomplete.js"></script>
    
    <script type="text/javascript">
$(document).ready(function(){
$("#s").autocomplete("data.php");

$.ajaxSetup ({
		cache: false
	});
	var ajax_load = "Loading..";

//	load() functions
	$("#search").click(function(){
	var q1=document.getElementById('s').value;
	
  htmlobj=$.ajax({url:"data_load.php?q="+q1,async:false,cache:false});
  $("#result").html(htmlobj.responseText);
	});
});
</script>
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
     <div class="row" style="margin:0px 15px 0px 15px;">
<ol class="breadcrumb">
  <li><a href="index.php">Home</a></li>
 
  <li class="active">Search Student</li>
</ol></div>
     
      <div id="login-wraperb" style="margin:0px auto;">
      
            <form class="form login-form" action="" name='login' method="post">
                    
                <div class="body">
                <h4>Type Your Search Query :</h4>
                    <input placeholder="Search by Name Or Registration Number" name='s' id='s' type="text" style="width:49%;line-height: 25px !important;margin-bottom: 0px !important">
                    
                    <input type=button value='Search' class="btn btn-success" id="search" style="">
                    
                                  </div>            
            </form>
        </div>
        <div style="width:500px;margin:0px auto;">
<?php if($_SESSION['data']!=''){ ?><div class="alert alert-success alert-dismissable">
   <button type="button" class="close" data-dismiss="alert" 
      aria-hidden="true">
      &times;
   </button><?php echo $_SESSION['data']; ?></div><?php }$_SESSION['data']=''; ?> 
<?php if($_SESSION['data1']!=''){ ?><div class="alert alert-success alert-dismissable">
   <button type="button" class="close" data-dismiss="alert" 
      aria-hidden="true">
      &times;
   </button><?php echo $_SESSION['data1']; ?></div><?php }$_SESSION['data1']=''; ?> 
   </div>
        <div id="result" style="padding:10px;"></div>

   
          <div class="clear">&nbsp;</div>
</div>
  <div id="wrapper" style="width:100%; height:25px;background-color: #B20EFF;position: fixed;bottom: 0;border-top:2px solid #000;box-shadow:0px 2px 2px 2px #888888;">
 <div id="footer1"> 
		<p align='center' style="padding:3px;">Copyright &copy; 2013 Indus Education. All Rights Reserved.</p>
		     </div>
     </div>
 
   <!-- <script src="jquery.js"></script>
    <script src="bootstrap.js"></script>
    <script src="backstretch.js"></script>
    <script src="typica-login.js"></script> -->
</body></html>