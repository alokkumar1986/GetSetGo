<?php  session_start();
if (isset ($_COOKIE["name_of_user2"]) && isset ($_COOKIE["regno_of_user"]) && isset ($_COOKIE["email_of_user"]) && isset ($_COOKIE["college"]) && isset ($_COOKIE["branch"]) && isset ($_COOKIE["role"])) {
  $_SESSION['name_of_user2'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['name_of_user2']);
  $_SESSION['regno_of_user'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['regno_of_user']);
  $_SESSION['email_of_user'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['email_of_user']);
  $_SESSION['college'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['college']);
  $_SESSION['branch'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['branch']);
  $_SESSION['role'] = 'Student';
}
error_reporting(0);
$user = $_SESSION["regno_of_user"];
$test12 = $_GET['test_id'];
$test1 = base64_decode($test12);
$path = "http://" . $_SERVER['SERVER_ADDR'] . "/new/";
function RandomizeArray($array) {
  $array = (!is_array($array)) ? array($array) : $array;
  $a = array();
  $max = count($array) + 10;
  while (count($array) > 0) {
    $e = array_shift($array);
    $r = rand(0, $max);
    while (isset ($a[$r])) {
      $r = rand(0, $max);
    }
    $a[$r] = $e;
  }
  ksort($a);
  $a = array_values($a);
  return $a;
}
include ("class.database.php");
$db = new Database();
$db->connect();
//echo "select * from test_setting where for_college='".$_SESSION['college']."' AND test_id='$test1'";
$qry = mysql_query("select * from `test_setting` where for_college='" . $_SESSION['college'] . "' AND test_id='$test1'");
$c = mysql_num_rows($qry);
if ($c == '0') {
  ?>
  <?php
  exit;
}
if ($sel = mysql_fetch_array($qry)) {
  $instance = $sel['instance'];
}
$db->select('student_result', 'reg_no,question_attend,status', "test_id ='$test1' AND reg_no='$user'", null, null, null);
$resg2 = $db->get_name();
if (sizeof($resg2) == '0') {
  $rs2 = "SELECT * from online_test where (test_id='" . $test1 . "' and  STATUS='ACTIVE')  order by id";
  $rs3 = mysql_query($rs2);
  $j = 1;
  while ($row = mysql_fetch_array($rs3)) {
    $dur = $row['TOTAL_NO_QUESTION'];
    $test = $row['test_id'];
    $sub = $row['CAT_NAME'];
    $cat_name = base64_encode($row['CATEGORY']);
    $db->select('test_question', 'question_id', "c_id='$sub' AND test_id='$test'", null, null, null);
    $res = $db->get_name();
    $data = $res['question_id'];
    $row = explode(",", $data);
    $l = sizeof($row);
    $tid = RandomizeArray($row);
    $comma = implode(",", $tid);
    $i = 1;
    $ans1 = '';
    foreach ($tid as $tids) {
      if ($tids != '') {
        $db->select('activetestquestions', 'id,question,subject_id,ans1,ans2,ans3,ans4,ans5,corans', "id='$tids'", null, null, null);
        $rows = $db->get_name();
        $ans1 .= $rows['corans'];
        if ($rows['corans']) {
          $ans1 .= ",";
        }
        $i++;
      }
      $ans = rtrim($ans1, ",");
    }
    if ($comma != '') {
      $db->insert('student_result', array($user, $comma, $ans, $sub, $test), 'reg_no,question_attend,correct_ans,cat_id,test_id');
      $res4 = $db->get_name();
    }
  }
}
?>
<!-- saved from url=(0088)http://www.digialm.com/EForms/Mock/167/CWE_Online_Assessment_Mock_Test/instructions.html -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

	<title>Instructions - Assessment </title>
  <link rel="shortcut icon" href="../../../../../images/favicon.ico" />
	<link rel="stylesheet" href="css1/mock_style.css">

	<!--<link rel="stylesheet" href="css1/number_style.css">
	<link rel="stylesheet" href="css1/keyboard.css">-->
	<!--<script type="text/javascript" src="js1/jquery.js"></script>
  <script src="js1/keyboard.js" type="text/javascript"></script>
	<script src="js1/document_iterator.js"></script>
	<script src="js1/find_proxy.js"></script><script src="js1/get_html_text.js"></script>
	<script src="js1/global_constants.js"></script>
	<script src="js1/name_injection_builder.js"></script>
	<script src="js1/number_injection_builder.js"></script>
	<script src="js1/string_finder.js"></script>-->
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
</style>
<script type="text/javascript">
function start(){
		var a= document.getElementById("disclaimer").checked;
		if(a){
		window.location.href="test2.php?test_id=<?php echo $test12;?>";
		return true;
		}else{
		alert("Please accept terms and conditions before proceeding.");
		return false;
		}
		}
function start1(){
		var a= document.getElementById("disclaimer").checked;
		if(a){
		window.location.href="test21.php?test_id=<?php echo $test12;?>";
		return true;
		}else{
		alert("Please accept terms and conditions before proceeding.");
		return false;
		}
		}
</script>
<body  onselectstart="return false;" ondrag="return false;" style="background:url('<?php echo $path;?>images/background1.png');">
<!--Container Started-->
<div id="header" style="background-color:rgb(55, 55, 255) !important;">
		<div style="background-color: #FFFF00;padding:2px;width:247px"><img src="images/77.gif" height="35"/></div>
        <div style="height:100%;float: right"> </div>
		</div>
		<div id="container">
	<?php
	$qrya = mysql_query("select distinct(instance) from `temp_test_result` where test_id='" . $test1 . "' AND candidate='" . $_SESSION['regno_of_user'] . "'");
	$ca = mysql_num_rows($qrya);
	$sqry = mysql_query("select * from `test_status` where test_id='" . $test1 . "' AND candidate='" . $_SESSION['regno_of_user'] . "' AND status='finish'");
	$count = mysql_num_rows($sqry);
	$instance;
	if ($count >= '1') {
	  if ($count == $instance) {
	    ?>

<script language="JavaScript">
//function refreshParent() {
//window.location="mod3.php?test_id=<?php ?>";
//}
    function refreshAndClose() {
        window.opener.location.reload(true);
       setTimeout("window.close()", 10);
    }
</script>

<h1 align="center" style="padding:100px 0px 0px 0px;"><font color="#000000">You have reached maximum instances.
	</font></h1>
	<p align="center"><a href="#" onClick='refreshAndClose();' class="btn4">Close Window</a></p>
	</div>
	<div id="header" style="height:30px;position: fixed;bottom: 0;"></div>

<?php exit;}}?>

		<div id="mainleft">
			<div style="clear:both;float:left;width:99%;margin-top:1%;height:96%">
				<div id="firstPage" style="height:100%;overflow:auto;border:1px #CCC solid;padding:2px">
				<br>
					<div id="instEnglish">

					<br />

			<table border="1" border-collapse="collapse" width="95%" align="center" id="dyna"><thead>

			<tr><th>Sections</th><th>Total Questions</th><th>Mark for each question</th><th>Mark(deduction) for each wrong Answer</th><th>Total Marks</th><th>Section Time</th></tr>	</thead>
<?php
$sqlquery = "select * from `online_test` where `test_id`='$test1' order by id";
$resultquery = mysql_query($sqlquery);
$countsection = mysql_num_rows($resultquery);
$tq = 0;
$tt = 0;
while ($rowquery = mysql_fetch_array($resultquery)) {
  $sqlnoofque = mysql_query("select * from `student_result` where `test_id`='$test1' AND cat_id='$rowquery[CATEGORY]'");
  if ($rowquery1 = mysql_fetch_array($sqlnoofque)) {
    $countque = sizeof(explode(",", $rowquery1['question_attend']));
  }
  $tm = $countque * $rowquery['EACH_QUE_MARK_CORRECT'];
  ?>

			<tbody><tr>
			<td><?php echo $rowquery['CATEGORY'];?></td>
			<td><?php echo $countque;?></td>
			<td><?php echo $rowquery['EACH_QUE_MARK_CORRECT'];?></td>

			<td><?php echo $rowquery['EACH_QUE_MARK_WRONG'];?></td>
			<td><?php echo $tm;?></td>
			<td><?php echo $rowquery['duration'];?> Minutes</td>
			</tr>


  <?php
  $tq += $countque;
  $tt += $rowquery['duration'];
}
?>
</tbody>
<tfoot><tr><td colspan="3"></td><td colspan="1"><strong>Overall Total Questions</strong> :<?php echo $tq;?></td><td colspan="2"><strong>Overall Total Time</strong> :<?php echo $tt;?> minutes</td></tr></tfoot>
</table>	<p>&nbsp;	</p>
<center><span><b>Please read the following instructions carefully</b></span></center>
<br />

					<b><u>General Instructions:</u></b>
					<br>
					<ol>

						<li>The clock has been set at the server and the countdown timer at the top right corner of your screen will display the time remaining for you to complete the exam. When the clock runs out the exam ends by default - you are not required to end or submit your exam. </li>
						<li>The question palette at the left of screen shows one of the following statuses of each of the questions numbered:
								<table id="abc"><tbody><tr><td valign="top"><span style="padding-top:5px" id="tooltip_not_visited"></span></td><td>You have not visited the question yet.</td><td valign="top"><span style="padding-top:5px" id="tooltip_not_answered"></span></td><td>You have not answered the question.</td></tr>
								<tr><td valign="top"><span style="padding-top:5px" id="tooltip_answered"></span></td><td>You have answered the question. </td><td valign="top"><span style="padding-top:5px" id="tooltip_review"></span></td><td>You have NOT answered the question but have marked the question for review.</td></tr>
								<tr><td valign="top"><span style="padding-top:12px" id="tooltip_reviewanswered">&nbsp;&nbsp;&nbsp;&nbsp;</span></td> <td>You have answered the question but marked it for review. </td><td></td></tr></tbody></table>
					  </li>
						<li style="list-style-type: none;">The Marked for Review status simply acts as a reminder that you have set to look at the question again. <font color="red"><i> If an answer is selected for a question that is Marked for Review, the answer will  be considered in the final evaluation.</i></font></li>
					</ol>
					<br><b><u>Navigating to a question : </u></b>
					<ol start="3">
						<li>To select a question to answer, you can do one of the following:
							<ol type="a">
								<li> Click on the question number on the question palette at the right of your screen to go to that numbered question directly. Note that using this option does NOT save your answer to the current question. </li>
								<li> Click on Save and Next to save answer to current question and to go to the next question in sequence.</li>
								<li> Click on  Mark for Review and Next to save answer to current question, mark it for review, and to go to the next question in sequence.</li>
							</ol>
						</li>

					</ol>
					<br><b><u>Answering questions : </u></b>
					<ol start="4">
						<li>For multiple choice type question :
							<ol type="a">
								<li>To select your answer, click on one of the option buttons</li>
								<li>To change your answer, click the another desired option button</li>
								<li>To save your answer, you MUST click on <b>Save &amp; Next</b> </li>
								<li>To deselect a chosen answer, click on the chosen option again or click on the <b>Clear </b> button.</li>
								<li>To mark a question for review click on <b>Mark for Review &amp; Next</b>. <font color="red"><i>If an answer is selected for a question that is Marked for Review, the answer will  be considered in the final evaluation. </i></font></li>
							</ol>
						</li>

						<li>To change an answer to a question, first select the question and then click on the new answer option followed by a click on the <b>Save &amp; Next</b> button.</li>
						<li>Questions that are saved  or marked for review after answering will ONLY be considered for evaluation.</li>
					</ol>
					<br><b><u>Navigating through sections : </u></b>
					<ol start="10">
						<li>Sections in this question paper are displayed on the top bar of the screen. Questions in a section can be viewed by clicking on the question pallete on the left of the screen. The section you are currently viewing is highlighted.</li>
						<li>After clicking the <b>Save &amp; Next</b>  button on the last question for a section, you will automatically be taken to the first question of the next section. </li>
						<li>You can move  over the section names to view the status of the questions for that section. </li>
						<li>You can shuffle between sections and questions anytime during the examination as per your convenience. </li>
					</ol>
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
				<?php
				$row = mysql_query("select * from `student_data` where REG_NO='" . $_SESSION['regno_of_user'] . "'") or die(mysql_error());
				if ($rs = mysql_fetch_array($row) or die(mysql_error())) {
				  $pic = $rs['PIC'];
				}
				?>
<img <?php if ($pic != '') {?>src="../uploads/<?php echo $pic;?>" <?php }else {?>src="../../example/profile.jpg" <?php }?> alt="User Photo" width="150" height="150" style="border:1px solid #ddd;border-radius:4px;margin-right:3px;padding:4px;"/>

				<p style="font-size:18px;color:#0000CC;font-weight:bold;"> <?php echo ucwords($_SESSION['name_of_user2']);?>  </p>
				<p>&nbsp;</p>
				<p style="font-size:16px;color:#000;font-weight:bold;">Welcome to Indus Education Online Test </p>
				</center>
				<!--<div align="center" style="bottom:110px;position:fixed;right:110px;"><a href="instruction.php" class="btn3" alt="">Next </a></div>
			     -->
				 <span class="highlightText">
				 <p>&nbsp;</p>
					<p align="justify" style="padding:4px;margin-top:15px !important; ">
					<input type="checkbox" id="disclaimer" value="ok" checked="checked">I have read and understood the instructions.All Computer Hardwares allotted to me are in proper working condition.I agree that in case of not adhering to the instructions, I will be disqualified from giving the exam.</input></p></span>
					</span>
					<?php
					$sql = mysql_query("select * from `test_setting` where test_id='" . $test1 . "' and for_college='" . $_SESSION['college'] . "'");
					if ($cnt = mysql_fetch_array($sql)) {
					  $rowdur = $cnt['duration'];
					}
					?>
<p align="center"> <a id="readylink" class="btn4" alt=""  <?php if ($rowdur == 'Combined Section Duration') {?> href="test2.php?test_id=<?php echo $test12;?>"  <?php }if ($rowdur == 'Each Section Duration') {?> href="test21.php?test_id=<?php echo $test12;?>"  <?php }?> style="background-color:#CC3300 !important;"><font size="5">I am ready to begin</font></a></p>
 </div>
		</div>

	</div>
	<!--<div id="footer"></div>-->
<div id="header" style="height:30px;position: fixed;bottom: 0;"></div>

</body><span id="skype_highlighting_settings" display="none" autoextractnumbers="1"></span><object id="skype_plugin_object" location.href="index1.php" location.hostname="" style="position: absolute; visibility: hidden; left: -100px; top: -100px; " width="0" height="0" type="application/x-vnd.skype.toolbars.npplugin.4.2.0"></object></html>
<?php
$db->disconnect();
?>