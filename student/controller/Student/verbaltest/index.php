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
	
	<title>Instructions - Verbal Test </title>
  <link rel="shortcut icon" href="../../../../../images/favicon.ico" />
	<link rel="stylesheet" href="../onlinesystem/css1/mock_style.css">
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
<script type="text/javascript">
function start(){
		var a= document.getElementById("disclaimer").checked;
		if(a){
		window.location.href="test2.php?college=<?php echo $_SESSION['college']; ?>";
		return true;
		}else{
		alert("Please accept terms and conditions before proceeding.");
		return false;
		}
		}

</script>
<body  onselectstart="return false;" ondrag="return false;" style="background:url('<?php echo $path; ?>images/background1.png');">
<!--Container Started-->
<div id="header" style="background-color:rgb(55, 55, 255) !important;">
		<div style="background-color: #FFFF00;padding:2px;width:247px"><img src="../onlinesystem/images/77.gif" height="35"/></div>
        <div style="height:100%;float: right"> </div>
		</div>
		<div id="container">
	<?php	
$sql = 'SELECT * FROM `verbalquestion` WHERE id in (select id from `verbalquestion`) order by rand() limit 0,1';
$result = mysql_query($sql);
$row=mysql_fetch_array($result);
$sqry1=mysql_query("select * from `verbaltest_result` where college='".$_SESSION['college']."' AND regd_no='".$_SESSION['regno_of_user']."' AND status=''");
$count1=mysql_num_rows($sqry1);
if($count1=='0'){
mysql_query("INSERT INTO `verbaltest_result` (`id`, `regd_no`, `college`,`commonarea`, `question`, `answer`, `started_time`, `status`) VALUES (NULL, '".$_SESSION['regno_of_user']."', '".$_SESSION['college']."', '".$row['COMMON_AREA']."', '".$row['VERBAL_QUESTION']."', '', '', '');");
}

$sqry=mysql_query("select * from `verbaltest_result` where college='".$_SESSION['college']."' AND candidate='".$_SESSION['regno_of_user']."' AND status='finish'");
$count=mysql_num_rows($sqry);
$instance;
if($count>='1'){ ?>
<script language="JavaScript">
//function refreshParent() {
//window.location="mod3.php?test_id=<?php //echo $test_id; ?>";
//}
    function refreshAndClose() {
        window.opener.location.reload(true);
       setTimeout("window.close()", 10);
    }
</script>

<h1 align="center" style="padding:100px 0px 0px 0px;"><font color="#000000">You have appeared the test successfully.
	</font></h1>
	<p align="center"><a href="#" onClick='refreshAndClose();' class="btn4">Close Window</a></p>
	</div>
	<div id="header" style="height:30px;position: fixed;bottom: 0;"></div>

<?php exit;} ?>

		<div id="mainleft">
			<div style="clear:both;float:left;width:99%;margin-top:1%;height:96%">
				<div id="firstPage" style="height:100%;overflow:auto;border:1px #CCC solid;padding:2px">
				<br>
					<div id="instEnglish">
					
					<p>&nbsp;	</p>		
<center><span><b>Please read the following instructions carefully</b></span></center>
<br />		
<?php  ?>
		<div class="panel panel-primary"> <div class="panel-heading" style="padding:20px 50px 0px 50px; "><font size="5" color="#000066"><strong>Instruction Set</strong></font> </div>
	<table class="table" >
	<tr><td>
	<ul style="list-style:disc;padding:20px 50px 0px 50px; ">
   <li>The test will begin with the Verbal ability Section.
   <li> The test duration for the Verbal Ability Section is 10 minutes .
   <li>The countdown timer displayed on the test screen will display the time left to complete each section.
   <li> Click Exit in the Verbal Ability Section  to log out of the test.
   <li> To answer a question, enter free text in the space provided and click Submit Answer.
   <li> The Word Counter on the screen will help you keep an account of the total number of words typed by you.
   <li> You will be automatically logged out of the Verbal Ability Section after 10 minutes. 
   <li>The text entered by you will be submitted and considered as the final answer.
   <li> There will be No Negative marking for this section.
   </ul>
    <p align="justify" style="padding:4px;margin-top:15px !important; ">
					<input type="checkbox" id="disclaimer" value="ok">I have read and understood the instructions.All Computer Hardwares allotted to me are in proper working condition.I agree that in case of not adhering to the instructions, I will be disqualified from giving the exam.</input></p></span>
					</span>
					
<p align="center"> <a href="#" id="readylink" class="btn4" alt=""  onClick="return start();" style="background-color:#CC3300 !important;"><font size="5">Click For Next</font></a></p>

	</td></tr>
	</table>
	</div>
<br></div></div>
				<br/>
				
			<div style="margin-bottom:20px;"><center>
				<br>
				<!--<center><a href="index.php" class="btn3" alt="">Previous</a></center> --><br/>
					
					<br/>	<br/>	<br/>
				<!--<a href="#" id="readylink" class="btn4" alt="" onClick="return start();" style="background-color:#CC3300 !important;"><font size="5">I am ready to begin</font>
				</a> --></center>
				</div>

			</div>
		</div><div id="mainright" style="height:100%;border-left:1px #000 solid">
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
<?php
$db->disconnect();
?>