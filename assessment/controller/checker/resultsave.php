<?php session_start(); 
//error_reporting(0);
$regd_no=$_GET["regd_no"]; 
$path="http://".$_SERVER['SERVER_ADDR']."/new/";
include("../class.database.php");
$db = new Database();  
$db->connect(); 
?>

<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	
	<title>Evaluation Verbal Test </title>
  <link rel="shortcut icon" href="../../../../images/favicon.ico" />
	<link rel="stylesheet" href="mock_style.css">
	<script language="JavaScript">
//function refreshParent() {
//window.location="mod3.php?test_id=<?php //echo $test_id; ?>";
//}
    function refreshAndClose() {
        window.opener.location.reload(true);
       setTimeout("window.close()", 1);
    }
</script>
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

<body ondrag="return false;" style="background:url('<?php echo $path; ?>images/background1.png');">
<!--Container Started-->
<div id="header" style="background-color:rgb(55, 55, 255) !important;">
		<div style="background-color: #FFFF00;padding:2px;width:247px"><img src="../../../../images/77.gif" height="35"/></div>
        <div style="height:100%;float: right"> </div>
		</div>
		<div id="container">
		<form  action='x.php' method='post' enctype="multipart/form-data" style="margin-left:14px;" id="formd">
<input type='hidden' name='submitted' id='submitted' value='1'/>
<input type='hidden' name='regd_no'  value='<?php echo $regd_no; ?>'/>
	<?php	
$sqry=mysql_query("select * from `verbaltest_result` where candidate='".$regd_no."' AND status='finish'");
//$count=mysql_num_rows($sqry);
//if($count>='1'){ } ?>
				
				<div id="mainleft">
			  <div style="clear:both;float:left;width:99%;margin-top:1%;height:96%">
				<div id="firstPage" style="height:100%;overflow:auto;border:1px #CCC solid;padding:2px">
				<div id="instEnglish">
				<?php	
$sqry=mysql_query("select * from `verbaltest_result` where regd_no='".$regd_no."' AND status='finish'");
if($row=mysql_fetch_array($sqry)){
echo "<div style='margin-left:10px;font-size:17px;font-weight:normal;'><font color='black'> Que) </font><font color='#ff3333'>".$row['commonarea']."</font></div>";
echo "<div style='margin-left:10px;font-size:19px;font-weight:normal;'><font color='black'> ".$row['question'].".</font></div>";
echo "<br /><div style='margin-left:10px;font-size:17px;font-weight:normal;'><font color='black'> Ans) </font><textarea id='testTextarea' name='answer' cols='115' rows='14' spellcheck='true' readonly='readonly'>".$row['answer']."</textarea></div>";

?>
<br />
<input type='hidden' name='college' value='<?php echo $row['college']; ?>' />
<div style="width:30%;float:left;">
<div style='margin-left:10px;font-size:17px;font-weight:normal;'>No Of Words : <?php echo str_word_count($row['answer']); ?>
<input type='hidden' name='no_words' value='<?php echo str_word_count($row['answer']); ?>' />
</div>
<br />
<?php 
$arr1 = explode('-', $row['question']);
$length=sizeof($arr1);
$count=0;
for($i=0;$i<$length;$i++){
/*if (stripos(strtolower($row['answer']), $arr1[$i]) !== false) {
    $count++;
}*/
if (strchr(str_replace(array("?","!",",",";","."), " ", strtolower($row['answer'])), "$arr1[$i]")) {
    $count++;
		//echo $arr1[$i];
		//echo strtolower($row['answer']);
}
}
 ?>
<div style='margin-left:10px;font-size:17px;font-weight:normal;'>Matched Phrases : <?php echo  $count; ?>
<input type='hidden' name='match_phrase' value='<?php echo $count; ?>' />
</div>
<br />
<div style='margin-left:10px;font-size:17px;font-weight:normal;'>Pass :<input type="radio" name="status" value="Pass" required>  Fail :<input type="radio" name="status" value="Fail" required>  </div>
</div>
<div style="width:30%;float:left;">
<div style='margin-left:10px;font-size:17px;font-weight:normal;'>% No Of Words : <?php $perword=(int)((str_word_count($row['answer'])/70)*100); if($perword<100){ echo $perword; ?>%<?php }else{ echo 100; ?>% <?php } ?>
<input type='hidden' name='per_word' value='<?php if($perword<100){ echo $perword; ?>%<?php }else{ echo 100; ?>% <?php } ?>' />
</div>
<br />
<div style='margin-left:10px;font-size:17px;font-weight:normal;'>% Matched Phrases : <?php $perphrase=(int)(($count/$length)*100); if($perphrase<100){ echo $perphrase; ?>%<?php }else{ echo 100; ?>% <?php } ?>
<input type='hidden' name='per_phrase' value='<?php if($perphrase<100){ echo $perphrase; ?>%<?php }else{ echo 100; ?>% <?php } ?>' />
</div>
<br />
<div style='margin-left:10px;font-size:17px;font-weight:normal;'><input type="submit" name="submit" class="btn btn-success" value="Submit" onClick="show_confirm()" ></div>
</div>
<div style="width:30%;float:left;">
<div style='margin-left:10px;font-size:17px;font-weight:normal;'>Total Time : <?php $sqlqry=mysql_query("select `duration` from `verbaltest` where `college`='".$row['college']."'")or die(mysql_error()); 
$rs=mysql_fetch_array($sqlqry);
echo $rs['duration'];
?> Minutes
<input type='hidden' name='total_time' value='<?php echo $rs['duration']; ?>' />
</div>
<br />
<div style='margin-left:10px;font-size:17px;font-weight:normal;'>
Time Taken : <?php $all = round((strtotime($row['finished_time']) - strtotime($row['started_time'])) / 60);
$all1 = round((strtotime($row['finished_time']) - strtotime($row['started_time'])) / 60,2);
$d = floor ($all / 1440);
$d1= floor ($all1 / 1440);
$m1 = $all1 - ($d1 * 1440);
$h = floor (($all - $d * 1440) / 60);
echo $m = $all - ($d * 1440);  ?>:<?php echo (int)(($m1-$m)*60); ?> Minutes
<input type='hidden' name='time_taken' value='<?php echo (int)(($m1-$m)*60); ?>' />
</div>
<br />
</div>
<?php }  ?>
</div>
</div>
</div>
</div>
		<div id="mainright" style="height:100%;border-left:1px #000 solid">
		  <div style="top:5%;position:relative">
				<center>
				<?php $row=mysql_query("select * from `student_data` where REG_NO='".$regd_no."'")or die(mysql_error());
if($rs=mysql_fetch_array($row)or die(mysql_error())){ 
$pic=$rs['PIC'];
$name=$rs['NAME'];
}
?><img <?php if($pic!=''){ ?>src="../../../student/controller/Student/uploads/<?php echo $pic; ?>" <?php }else { ?>src="img/profile.jpg" <?php } ?> alt="User Photo" width="150" height="150" style="border:1px solid #ddd;border-radius:4px;margin-right:3px;padding:4px;"/>
				
				<p style="font-size:18px;color:#0000CC;font-weight:bold;"> <?php echo ucwords($name); ?>  </p> 
				<p>&nbsp;</p>
				<p style="font-size:16px;color:#000;font-weight:bold;">Welcome to Indus Education Verbal Test/Email Writting Test Evaluation </p>
				</center>
				<!--<div align="center" style="bottom:110px;position:fixed;right:110px;"><a href="instruction.php" class="btn3" alt="">Next </a></div>
			     -->
				 <span class="highlightText">
				 <p>&nbsp;</p>
					 </div>
		</div>
		</form>
	</div>
	<!--<div id="footer"></div>-->
<div id="header" style="height:30px;position: fixed;bottom: 0;text-align:center;padding:10px 0 0 0;">Copyright &copy; 2014 Indus Education</div>


</body><span id="skype_highlighting_settings" display="none" autoextractnumbers="1"></span><object id="skype_plugin_object" location.href="index1.php" location.hostname="" style="position: absolute; visibility: hidden; left: -100px; top: -100px; " width="0" height="0" type="application/x-vnd.skype.toolbars.npplugin.4.2.0"></object></html>
<?php
$db->disconnect();
?>