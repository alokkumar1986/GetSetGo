<?php session_start(); 
error_reporting(0);
$user=$_SESSION["regno_of_user"]; 
$test1=base64_decode($test12);
$path="http://".$_SERVER['SERVER_ADDR']."/new/";
include("../onlinesystem/class.database.php");
$db = new Database();  
$db->connect(); 
?>
<!-- saved from url=(0088)http://www.digialm.com/EForms/Mock/167/CWE_Online_Assessment_Mock_Test/instructions.html -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	
	<title>Verbal Test </title>
  <link rel="shortcut icon" href="../../../../../images/favicon.ico" />
	<link rel="stylesheet" href="../onlinesystem/css1/mock_style.css">
	<link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/onlinestyle.css" rel="stylesheet">
  <link href="css/api.css" rel="stylesheet">
  <link href="css/reset.css" rel="stylesheet">
     	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
    <style>
   #txt {
border:2px solid red;
font-family:verdana;
font-size:16pt;
font-weight:bold;
background: #FECFC7;
width:80px;
text-align:center;
color:#000000;
float:right;
 }
 </style>
  <style>
    .btn,pre{
    margin:10px;
}
 </style>
   <script src="js/jquery.min.js" type="text/javascript"></script>     
   <script src="js/bootstrap.min.js"></script>
	 <script src="js/jquery.textareaCounter.plugin.js" type="text/javascript"></script>
	 <script type="text/javascript">
			var info;
			$(document).ready(function(){
				var options = {
					'maxCharacterSize': -2,
					'originalStyle': 'originalTextareaInfo',
					'warningStyle' : 'warningTextareaInfo',
					'warningNumber': 40
				};
				$('#testTextarea').textareaCount(options);

				var options2 = {
						'maxCharacterSize': 200,
						'originalStyle': 'originalTextareaInfo',
						'warningStyle' : 'warningTextareaInfo',
						'warningNumber': 40,
						'displayFormat' : '#input/#max | #words words'
				};
				$('#testTextarea2').textareaCount(options2);

				var options3 = {
						'maxCharacterSize': 200,
						'originalStyle': 'originalTextareaInfo',
						'warningStyle' : 'warningTextareaInfo',
						'warningNumber': 40,
						'displayFormat' : '#left Characters Left / #max'
				};
				$('#testTextarea3').textareaCount(options3, function(data){
					$('#showData').html(data.input + " characters input. <br />" + data.left + " characters left. <br />" + data.max + " max characters. <br />" + data.words + " words input.");
				});
			});
		</script>
    <script type="text/javascript" src="../js/bootstrap-modal.js"></script> 
    <script>
        // function : show_confirm()
				
function show_confirm(){
    // shows the modal on button press
    $('#confirmModal').modal('show');
    $("#output").html("");
}
function show_confirm1(){
    // shows the modal on button press
    $('#confirmModal1').modal('show');
    $("#output").html("");
}

// function : ok_hit()
function ok_hit(){
    // hides the modal
    $('#confirmModal').modal('hide');
    $("#output").html("OK Pressed");
    
    // all of the functions to do with the ok button being pressed would go in here
}
</script>
	<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<style>
#titlebar {display: none !important;}
#main-window {-moz-appearance:none !important;}
#dyna{
    border-collapse: collapse;
}


#dyna td{
    padding: 15px;
}


#dyna th{
    background-color: #FC6E22;
    color: #FFFFFF;
}
ul li{
margin-bottom:4px;
font-size:13px;
}
</style>
<body  onselectstart="return false;" ondrag="return false;" oncontextmenu="return false" style="background:url('<?php echo $path; ?>images/background1.png');">
<!--Container Started-->
<div id="header" style="background-color:rgb(55, 55, 255) !important;">
		<div style="background-color: #FFFF00;padding:2px;width:247px"><img src="../onlinesystem/images/77.gif" height="35"/></div>
    <div style="height:100%;float: right"> </div>
</div>
<div id="container">
			<div id="mainleft">
				<?php
/* If you refresh the page
   or
   leave the page to browse and come back
   then the timer will continue to count down until finished. */

// $minutes and $seconds are added together to get total time.
$asql=mysql_query("select * from `verbaltest_result` where (college='".$_SESSION['college']."' AND regd_no='".$_SESSION['regno_of_user']."' AND started_time='0000-00-00 00:00:00')")or die(mysql_error());
$acnt=mysql_num_rows($asql);
if($acnt>='0'){
mysql_query("update `verbaltest_result` set started_time=now() where (college='".$_SESSION['college']."' AND regd_no='".$_SESSION['regno_of_user']."' AND started_time='0000-00-00 00:00:00')")or die(mysql_error());;
}

$rs= "SELECT * from `verbaltest` where (college='".$_SESSION['college']."')"; 
$rs1=mysql_query($rs);
//$i=1;
$dur1=0;
if($row=mysql_fetch_array($rs1)){
$dur1=$dur1+$row['duration'];
}
$v2=$dur1;
//date_default_timezone_set('Asia/Kolkata');
$date=date('Y-m-d H:i:s');
//echo "select * from `test_timer` where test_id='".$test_name."' AND candidate='".$_SESSION['regno_of_user']."' AND instance='$cab'";
$timer=mysql_query("select * from `verbaltest_result` where college='".$_SESSION['college']."' AND regd_no='".$_SESSION['regno_of_user']."'"); 
if($rowtim=mysql_fetch_array($timer)){
$date1=$rowtim['started_time'];
}
$all = round((strtotime($date) - strtotime($date1)) / 60);
$d = floor ($all / 1440);
$h = floor (($all - $d * 1440) / 60);
$m = $all - ($d * 1440);

if($v2<=$m){
$dur1=0;
}
if($v2>$m){
$dur1=$v2-$m;
}


$minutes = $dur1; // Enter minutes
$seconds = 0; // Enter seconds
$time_limit = ($minutes * 60) + $seconds + 1; // Convert total time into seconds
$start_time = mktime(date(G),date(i),date(s),date(m),date(d),date(Y)) + $time_limit; // Add $time_limit (total time) to start time. And store into session variable.

?>

      
<br />
	<div class="panel panel-primary"> <div class="panel-heading"><font size="5" color="#fff"><center><strong>Verbal Ability Test</strong></center></font> </div>
	<table class="table" >
	<tr><td>
  <input id="txt" readonly>
  <br/>
<?php 
$sql1 = "SELECT * FROM `verbaltest_result` where college='".$_SESSION['college']."' AND regd_no='".$_SESSION['regno_of_user']."'";
$result1 = mysql_query($sql1)or die(mysql_error());
if($row=mysql_fetch_array($result1))
{
	echo "<div style='margin-left:10px;font-size:17px;font-weight:normal;'><font color='black'> Que) </font><font color='#ff3333'>".$row['commonarea']."</font></div>";
  echo "<div style='margin-left:10px;font-size:19px;font-weight:normal;'><font color='black'> ".$row['question'].".</font></div>";

} 
?>
<form  action='x.php' method='post' enctype="multipart/form-data" style="margin-left:14px;" id="formd">
<input type='hidden' name='submitted' id='submitted' value='1'/>
<input type='hidden' name='queid'  value='<?php echo $id; ?>'/>
<input type='hidden' name='REG_NO'  value='<?php echo  $_SESSION['REG_NO']; ?>'/>
    <br/>
    <textarea id="testTextarea" name="answer" cols="148" rows="8" spellcheck="false"></textarea>
    <p><input type="button" name="submit" class="btn btn-success" value="Submit" onClick="show_confirm()" ></p>
     
    <pre id="output"></pre> 
 
  <div id="confirmModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
  <div class="modal-header"> 
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="../img/g_close.gif" alt=""></button> 
   <!-- <h3 id="myModalLabel">Delete?</h3>  -->
  </div> 
  <div class="modal-body"> 
    <h1>Are you sure you want to submit the answer?</h1> 
  </div> 
  <div class="modal-footer"> 
    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true">Cancel</button> <button onClick="ok_hit()" class="btn btn-success">OK</button> 
  </div> 
</div>
<div id="confirmModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
  <div class="modal-header"> 
    <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> -->
   <!-- <h3 id="myModalLabel">Delete?</h3>  -->
  </div> 
  <div class="modal-body"> 
    <h1>Your time is finished and click OK to submit your test.<br/> Don't close this browser, Because you will loose your data. </h1> 
  </div> 
  <div class="modal-footer"> 
    <button onClick="ok_hit()" class="btn btn-success">OK</button> 
  </div> 
</div> 
</form>
</td></tr></table>
</div>
</div>
<br/>
				
<div id="mainright" style="height:100%;">
		  <div style="top:5%;position:relative">
				<center>
				<?php $row=mysql_query("select * from `student_data` where REG_NO='".$_SESSION['regno_of_user']."'")or die(mysql_error());
if($rs=mysql_fetch_array($row)or die(mysql_error())){ 
$pic=$rs['PIC'];
}
?><img <?php if($pic!=''){ ?>src="../uploads/<?php echo $pic; ?>" <?php }else { ?>src="../../example/profile.jpg" <?php } ?> alt="User Photo" width="150" height="150" style="border:1px solid #ddd;border-radius:4px;margin-right:3px;padding:4px;"/>
				
				<p style="font-size:18px;color:#0000CC;font-weight:bold;"> <?php echo ucwords($_SESSION['name_of_user2']); ?>  </p> 
				<p>&nbsp;</p>
				<p style="font-size:16px;color:#000;font-weight:bold;">Welcome to Indus Education Verbal Test/Email Writting Test </p>
				</center>
				<!--<div align="center" style="bottom:110px;position:fixed;right:110px;"><a href="instruction.php" class="btn3" alt="">Next </a></div>
			     -->
				 <span class="highlightText">
				 <p>&nbsp;</p>
					 </div>
		</div>
		
	</div>
	<!--<div id="footer"></div>-->
<div id="header" style="height:30px;position: fixed;bottom: 0;text-align:center;padding:10px 0 0 0;">Copyright &copy; 2014 Indus Education</div>

</body><span id="skype_highlighting_settings" display="none" autoextractnumbers="1"></span><object id="skype_plugin_object" location.href="index1.php" location.hostname="" style="position: absolute; visibility: hidden; left: -100px; top: -100px; " width="0" height="0" type="application/x-vnd.skype.toolbars.npplugin.4.2.0"></object></html>
<script>
var ct = setInterval("calculate_time()",100); // Start clock.
function calculate_time()
{

 var end_time = "<?php echo $start_time; ?>"; // Get end time from session variable (total time in seconds).
 var dt = new Date(); // Create date object.
 var time_stamp = dt.getTime()/1000; // Get current minutes (converted to seconds).
 var total_time = end_time - Math.round(time_stamp); // Subtract current seconds from total seconds to get seconds remaining.
 var mins = Math.floor(total_time / 60); // Extract minutes from seconds remaining.
 var secs = total_time - (mins * 60); // Extract remainder seconds if any.
 if(secs < 10){secs = "0" + secs;} // Check if seconds are less than 10 and add a 0 in front.
 document.getElementById("txt").value = mins + ":" + secs; // Display remaining minutes and seconds.
 // Check for end of time, stop clock and display message.
 if(mins <= 0)
 {
  if(secs <= 0 || mins < 0)
  {
   clearInterval(ct);
   document.getElementById("txt").value = "0:00";
   //alert("The time is up.");
	 show_confirm1();
	 //window.location.href="x.php";
	 //$('#formd').submit();
   }
  }
 }
</script>	
<?php
$db->disconnect();
?>