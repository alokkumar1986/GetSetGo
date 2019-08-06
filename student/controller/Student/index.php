<?PHP session_start();
error_reporting(1);
require_once("../../include/membersite_config.php");
if(!$fgmembersite->CheckLogin())
{
 $fgmembersite->RedirectToURL("../../login.php");
 exit;
}
$fgmembersite->DBLogin();
if($_GET['action']=='delete'){
	//$fgmembersite->Deletenotice($_GET['id1']);
	$rs=mysqli_query($fgmembersite->connection, "delete from `message` where id='$_GET[id1]'");
}
$page=base64_decode($_GET['id']);
$arrConditions = array('regdno' => $_SESSION['regno_of_user']);

$student_data = $fgmembersite->getWhereCustomActionValues("USP_STUDENT_DATA", "A", $arrConditions);
if(!empty($student_data['result'])){
   $student_data  = $student_data['result'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="en" />
	<meta name="robots" content="noindex,nofollow" />	   
  	<link rel="shortcut icon" href="../../../img/favicon.ico" />
	<link rel="stylesheet" media="screen,projection" type="text/css" href="css/reset.css" /> <!-- RESET -->
	<link rel="stylesheet" media="screen,projection" type="text/css" href="css/menu.css" />
	<link rel="stylesheet" media="screen,projection" type="text/css" href="css/main.css" /> <!-- MAIN STYLE SHEET -->
	<link rel="stylesheet" media="screen,projection" type="text/css" href="css/2col.css" title="2col" /> <!-- DEFAULT: 2 COLUMNS -->
	<link rel="alternate stylesheet" media="screen,projection" type="text/css" href="css/1col.css" title="1col" /> <!-- ALTERNATE: 1 COLUMN -->
	<!--[if lte IE 6]><link rel="stylesheet" media="screen,projection" type="text/css" href="css/main-ie6.css" /><![endif]--> <!-- MSIE6 -->
	<link rel="stylesheet" media="screen,projection" type="text/css" href="css/style.css" /> <!-- GRAPHIC THEME -->
	<link rel="stylesheet" media="screen,projection" type="text/css" href="css/mystyle.css" /> <!-- WRITE YOUR CSS CODE HERE -->
	<script type="text/javascript" src="js/jquery.js"></script>
	<!--<script type="text/javascript" src="js/switcher.js"></script>
	<script type="text/javascript" src="js/toggle.js"></script>
	<script type="text/javascript" src="js/ui.core.js"></script>
	<script type="text/javascript" src="js/ui.tabs.js"></script>-->
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/font-awesome.min.css">
<style>
/*body {
  font-family: Arial, Helvetica, sans-serif;
}*/

.navbar {
  overflow: hidden;
  background-color: #333;
}

.navbar a {
  float: left;
  font-size: 16px;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

.dropdown {
  float: left;
  overflow: hidden;
}

.dropdown .dropbtn {
  font-size: 16px;  
  border: none;
  outline: none;
  color: white;
  padding: 14px 0px;
  background-color: inherit;
  font-family: inherit;
  margin: 0;
}

.navbar a:hover, .dropdown:hover .dropbtn {
  background-color: #306bcf;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 200px;
  box-shadow: 5px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  float: none;
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-align: left;
}

.dropdown-content a:hover {
  background-color: #ddd;
}

.dropdown:hover .dropdown-content {
  display: block;
}
</style>
	<title>Indus Education Online Student Services</title>
</head>
<body>

<div id="main">
<!-- Tray -->
	<div class="row-fluid" id="header-pane" style="background-color: #306bcf;padding-top:0px;padding-bottom:0px;border-top:0px solid #000;box-shadow:0px 2px 2px 2px #888888;">
	<div id="top_home" class="clear">
        <div class="col-md-4" style="width:200px;padding-left: 10px;">
        <a href="index.php"><img src="design/77.gif" alt="logo" style="width:70%;padding-top:4px"></a>
        </div>
        <div class="col-md-4" style="padding-top:14px;padding-left: 0px;float: right;width: 290px;margin-top: -63px;color: #f0eb0f" >
	<?php
	// $row=mysqli_query($fgmembersite->connection, "select * from `student_data` where REG_NO='".$_SESSION['regno_of_user']."'")or die(mysqli_error());
	// if($rs=mysqli_fetch_array($row, MYSQLI_NUM)or die(mysqli_error())){ 
	$pic=$student_data['PIC'];
	?>
	<img <?php if($pic!='' && file_exists(dirname(__FILE__).'/uploads/'.$pic)){ ?>src="uploads/<?php echo $pic; ?>" <?php }else { ?>src="../example/profile.jpg" <?php } ?>
	 alt="User Photo" width="43" height="43" style="border:1px solid #000;border-radius:50%;float:left;margin-right:3px;"/>
	 

	<div class="dropdown">
    <button class="dropbtn"> Hello, <?php echo substr(ucwords($_SESSION['name_of_user2']), 0, 15); ?>
    &nbsp; <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="?id=<?php echo base64_encode('profile'); ?>&sid=<?php echo base64_encode($_SESSION['regno_of_user']); ?>"><strong> <i class="fa fa-user"></i> Profile</strong></a>
      <a href="?id=<?php echo base64_encode('change password'); ?>" ><strong><i class="fa fa-cogs"></i> Change Password</strong></a> 
      <a href="../../logout.php"><strong><i class="fa fa-window-close-o"></i> Logout</strong></a>
    </div>
  </div> 
        <!-- <a href="?id=<?php echo base64_encode('profile'); ?>&sid=<?php echo base64_encode($_SESSION['regno_of_user']); ?>" style="color: #ffffff"><strong>Profile</strong></a>
        | <a href="?id=<?php echo base64_encode('change password'); ?>" style="color: #ffffff"><strong>Change Password</strong></a> 
        | <a href="../../logout.php" style="color: #ffffff"><strong>Logout</strong></a> -->
        </div>
        </div>
        </div>
<!--  /tray -->
<div class="clear" style="clear: both;"></div>
<hr class="noscreen" />

<!-- Columns -->
<div id="cols" class="box">
  <!-- Aside (Left Column) -->
	<div id="aside" class="box">
	<!-- /padding -->
	<div class="padding box">
		<p id="logo"><a href="#"><img src="tmp/logo2.png" alt="Profile Photo" title="Profile Photo" style="background:#fff;"/></a></p>
	</div>
	<!-- /padding -->
	<div id="startmenu">
    	<ul id="programs">
		<li><a href="index.php"><img src="design/Home1.png" alt="">Home</a></li>
    	<li><a href="?id=<?php echo base64_encode('messages'); ?>"><img src="design/email.png" alt="">Messages</a></li>
		<li><a href="?id=<?php echo base64_encode('email'); ?>"><img src="design/msg.png" alt="">Email Writting</a></li>
		<li><a href="?id=<?php echo base64_encode('onlinetest'); ?>"><img src="design/test.png" alt="">Online Test</a></li>
    	<li><a href="?id=<?php echo base64_encode('onlinetest report'); ?>"><img src="design/reports.png" alt="">Test Reports</a></li>
   		<li><a href="?id=<?php echo base64_encode('tehnical interview report'); ?>"><img src="design/perso.png" alt="">TI-Report</a></li>
    	<li><a href="?id=<?php echo base64_encode('personal interview report'); ?>"><img src="design/chart.png" alt="">PI-Report</a></li>
		<li><a href="?id=<?php echo base64_encode('knowledge base'); ?>"><img src="design/safari.png" alt="">Knowledge Base</a></li>
        <li><a href="feedback.php" class="example5 reply"><img src="design/feedback1.png" alt="">Feedback</a></li>
    	<li><a href="../../logout.php"><img src="design/X1.png" alt="">LogOut</a></li>
        </ul>
  	</div>
	</div>
  <!-- /aside -->
<hr class="noscreen" />

<!-- Content (Right Column) -->
<div id="content" class="box">
	<?php if($page==""){ ?>
	<div class="col50">
			<h1>Quick Links</h1>
				<section class="icons">
						<ul>
						<li>
							<a href="index.php">
								<img src="design//Home.png">
								<span>Home</span>
							</a>
						</li>
						<li>
							<a href="?id=<?php echo base64_encode('messages'); ?>">
								<img src="design/Speech-Bubble.png">
								<span>Messages</span>
							</a>
						</li>
						<li>
							<a href="?id=<?php echo base64_encode('email'); ?>">
								<img src="design/Mail.png">
								<span>Email Writting</span>
							</a>
						</li>
						
						<li>
							<a href="?id=<?php echo base64_encode('onlinetest'); ?>">
								<img src="design/Paper.png">
								<span>Online Test</span>
							</a>
						</li>
						
						<li>
							<a href="?id=<?php echo base64_encode('onlinetest report'); ?>">
								<img src="design/Photo.png">
								<span>Test Reports</span>
							</a>
						</li>
						<!--<li>
							<a href="#">
								<img src="design/Speech-Bubble.png">
								<span>Photos</span>
							</a>
						</li>-->
						<li>
							<a href="?id=<?php echo base64_encode('tehnical interview report'); ?>">
								<img src="design/Folder.png">
								<span>TI-Report</span>
							</a>
						</li>
						<li>
							<a href="?id=<?php echo base64_encode('personal interview report'); ?>">
								<img src="design/Person-group.png">
								<span>PI-Report</span>
							</a>
						</li>
						<!--<li>
							<a href="#">
								<img src="design/Config.png">
								<span>Settings</span>
							</a>
						</li>
						<li>
							<a href="#">
								<img src="design/Piechart.png">
								<span>Statistics</span>
							</a>
						</li> 
						<li>
							<a href="#">
								<img src="design/Info.png">
								<span>About</span>
							</a>
						</li>-->
						<li>
							<a href="?id=<?php echo base64_encode('knowledge base'); ?>">
								<img src="design/Paper-pencil.png">
								<span>Knowledge Base</span>
							</a>
						</li>
                        <li>
							<a href="feedback.php" class="example5 reply">
								<img src="design/feedback.png">
								<span>Feedback</span>
							</a>
						</li>
						<li>
							<a href="../../logout.php">
								<img src="design/X.png">
								<span>Logout</span>
							</a>
						</li>
					</ul>
			</section>
	</div>
	<!-- /col50 -->

	<div class="col50 f-right">
		<h1>Calendar</h1>
		<br />
		<?php 
 		//This gets today's date 
		$date =time () ; 
		//This puts the day, month, and year in seperate variables 

 		$day = date('d', $date) ; 

 		$month = date('m', $date) ; 

		$year = date('Y', $date) ;
//Here we generate the first day of the month 

 $first_day = mktime(0,0,0,$month, 1, $year) ; 



 //This gets us the month name 

 $title = date('F', $first_day) ;

 //Here we find out what day of the week the first day of the month falls on 
 $day_of_week = date('D', $first_day) ; 



 //Once we know what day of the week it falls on, we know how many blank days occure before it. If the first day of the week is a Sunday then it would be zero

 switch($day_of_week){ 

 case "Sun": $blank = 0; break; 

 case "Mon": $blank = 1; break; 

 case "Tue": $blank = 2; break; 

 case "Wed": $blank = 3; break; 

 case "Thu": $blank = 4; break; 

 case "Fri": $blank = 5; break; 

 case "Sat": $blank = 6; break; 

 }
 //We then determine how many days are in the current month

 $days_in_month = cal_days_in_month(0, $month, $year) ; 

 //Here we start building the table heads 

 echo "<table border=1 width=100%>";

 echo "<tr><th colspan=7 style='text-align:center;background: #8FC04D''> $title $year </th></tr>";

 echo "<tr style='text-align:center;height:50px;background:#182A42;color:#fff;'><td width=42><strong>Sun</strong></td>
 <td width=42><strong>Mon</strong></td><td 
width=42><strong>Tue</strong></td><td width=42><strong>Wed</strong></td><td width=42><strong>Thu</strong></td><td 
width=42><strong>Fri</strong></td><td width=42><strong>Sat</strong></td></tr>";



 //This counts the days in the week, up to 7

 $day_count = 1;



 echo "<tr style='text-align:center;height:35px;'>";

 //first we take care of those blank days

 while ( $blank > 0 ) 

 { 

 echo "<td></td>"; 

 $blank = $blank-1; 

 $day_count++;

 } 

 //sets the first day of the month to 1 

 $day_num = 1;



 //count up the days, untill we've done all of them in the month

 while ( $day_num <= $days_in_month ) 

 { 

 ?><td <?php if($day==$day_num){ ?>class="currentdate" style="background:#F86411;color:#fff;font-size:16px;font-weight:bold;" <?php } ?>><a href="#" style="color:#000"><strong><?php echo $day_num; ?></strong></a>
  <?php if($day==$day_num){ ?><br /><a href="birthday.php" class="example5 reply"> <span style="background:Red;color: white;padding:2px;font-size:15px;float:top;box-shadow:0px 0px 1px 1px;"><i class="fa fa-birthday-cake" aria-hidden="true"></i></span>
  </a><?php } ?>
  </td>
 <?php

 $day_num++; 

 $day_count++;



 //Make sure we start a new row every week

 if ($day_count > 7)

 {

 echo "</tr><tr style='text-align:center;height:35px;'>";

 $day_count = 1;

 }

 } 

 //Finaly we finish out the table with some blank details if needed

 while ( $day_count >1 && $day_count <=7 ) 

 { 

 echo "<td> </td>"; 

 $day_count++; 

 } 

 
 echo "</tr></table>";
 
 //echo  "select * from birthday where `EMAIL_ID`='".$_SESSION['email_of_user']."'";
 //$birthday=mysqli_query($fgmembersite->connection, "select * from birthday where `EMAIL_ID`='".$_SESSION['email_of_user']."'");
 $birthdaycount=$student_data['bcount'];
 if($birthdaycount>=1){
     ?>
        <p align="center"> <span style="background:#ccc;color:#ff;padding:3px;"> Dear <?php  echo ucwords($_SESSION['name_of_user2']); ?>, Indus Education Wishes You a happy birthday. </span> </p>
 <?php } 
?>
	</div>
	<div class="fix"></div>
			<div>
			<h1>Recent Messages</h1>
			<ul class="comments">
			<?php 
			// $sql1="select * from student_data where `EMAIL_ID`='".$_SESSION['email_of_user']."'";
			// $rs1=mysqli_query($fgmembersite->connection,$sql1);
			// if($row1=mysqli_fetch_array($rs1,MYSQLI_NUM)){
			$yop=$student_data['COURSE_YOP'];
			$college=$student_data['COLLEGE'];
			$course=$student_data['COURSE'];
			$branch=$student_data['BRANCH'];
			//}
			$arrConditions = array('yop' => $yop, 'college' => $college, 'course' => $course, 'branch'=>$branch, 'email'=>$_SESSION['email_of_user']);
			$message = $fgmembersite->getWhereCustomActionValues("USP_STUDENT_DATA", "MSG", $arrConditions,1, 1, 2);
			if(!empty($message['result'])){
			   $messages  = $message['result'];
			}
			//print_r($message);exit;

	// 		 $sql="select * from `message` where ((`to` ='".$_SESSION['email_of_user']."') or (`college` LIKE '%".$college."%' AND `branch` LIKE '%".$branch."%' AND `to` LIKE '%".$yop."%') or (`to`='Administrator' and `sentfrom`='".$_SESSION['email_of_user']."')) order by `date` desc limit 0,2";
	// // $sql="select * from `message` where ((`to` ='".$_SESSION['email_of_user']."') or (`college` LIKE '%".$college."' AND `branch` LIKE '%".$branch."' AND `to`='".$yop."') or (`to`='Administrator' and `sentfrom`='".$_SESSION['email_of_user']."')) order by `date` desc limit 0,2";
	// 		$rs=mysqli_query($fgmembersite->connection, $sql);
			$count=count($messages);
			if($count!='0'){
			foreach($messages as $row){
			?>
				<li>
				<div class="comment-body clearfix">
				<img class="comment-avatar" src="design/dummy.gif" style="float: left;margin-right: 12px;">
				<a href="#"><?php echo ucwords($row['sentfrom']); ?></a> :
				 <div><?php echo ucwords($row['message']); ?></div>
				</div>
				<div class="links">
				<span class="date"><?php echo date('d/m/Y',strtotime($row['date'])); ?></span>
				<a href="reply.php?id=<?php echo $row['id']; ?>" class="example5 reply">Reply</a>
				<a href="?id=messages&action=delete&id1=<?php echo $row['id']; ?>" class="delete" onclick="return confirm('Are You Sure to delete this entry?')">Delete</a>
				</div>
				</li>
				<?php } }else{ ?>
				<h2>No Messages</h2>
				<?php } ?>
				</ul>
			</div>
			<?php }else{
			     //mysql_close();
				include("$page.php");
			} 
			// 
			?>
	</div> <!-- /content -->

	</div> <!-- /cols -->

<hr class="noscreen" />
</div> <!-- /main -->
	<div  style="width:100%;height:23px;position: fixed;bottom: 0;background-color: #306bcf;border-top:0px solid #000;box-shadow:2px 2px 2px 3px #888888;">
 	<div id="footer1"> 
		<p align='center' style="padding:3px;margin: auto !important;color:#fff;">Copyright &copy; <?php echo date('Y'); ?> Indus Education. All Rights Reserved.
		</p>
	</div>
     	</div>
</body>
</html>
<link rel="stylesheet" href="../../../css/colorbox.css" />
<script src="../../../js/jquery.colorbox.js"></script>
<script>
$(document).ready(function(){
$(".example5").colorbox({iframe:true, innerWidth:900, innerHeight:600,
onCleanup:function(){ //window.location="calculator.php";
}});
});
</script>
