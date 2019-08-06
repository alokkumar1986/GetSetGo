<?php session_start();
error_reporting(0);
$test_name=base64_decode($_GET['test_id']);

include("class.database.php");

$using_ie6 = (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.')!==FALSE );
if($using_ie6!='')
{
header('location: error.php');
}
$db = new Database();  
$db->connect();  

$rs1= "SELECT * from online_test where (test_id='".$test_name."' and  STATUS='ACTIVE') order by id"; 
$rs11=mysql_query($rs1);
$count=mysql_num_rows($rs11);
$test1='';
$al=1;
while($row=mysql_fetch_array($rs11)){
$test1.=$row['test_id'];
if($al<$count){
$test1.=',';
}
$testname=$row['test_name'];
$al++;
}
$qry=mysql_query("select * from test_setting where for_college='".$_SESSION['college']."' AND test_id='$test_name'");

if($sel=mysql_fetch_array($qry)){
$instance=$sel['instance'];
$calculator=$sel['calculator'];
}

$sqlll="select * from test_status where (test_id='".$test_name."' AND candidate='".$_SESSION['regno_of_user']."' AND status='finish' AND instance='$instance')";
$rs111=mysql_query($sqlll);
$count11=mysql_num_rows($rs111);
if($count11=='1'){
header("location: x.php?cat_id=$sub&test_id=$test_name");
exit();
}
//echo $test;
//exit;
//$dur1=$_GET['dur1'];
//$v2=$_GET['dur'];
//$v1=$v2-1;
//$dur=$_GET['dur'];
//$test=$_GET['test'];
//$sub=$_GET['sub'];
//for($i=0;$i<$v2;$i++)
//{
//$dataa=$dataa.",0";
//}
function RandomizeArray($array){
// error check:
$array = (!is_array($array)) ? array($array) : $array;
$a = array();
$max = count($array) + 10;
while(count($array) > 0){        
$e = array_shift($array);
$r = rand(0, $max);
// find a empty key:
while (isset($a[$r])){
$r = rand(0, $max);
}        
$a[$r] = $e;
}
ksort($a);
$a = array_values($a);
return $a;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title>Online test <?php echo $dur1; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="js/jquery.min.js"> </script>
<script type='text/javascript' src='js/footer.js'></script>
<link rel='stylesheet' type='text/css' href='css/style.css' />
<script type="text/javascript" src="js/jquery.countdown.js"></script>
<!--<script type="text/javascript" src="js/jquery.timers-1.2.js"></script> -->
<link href="css/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css"/>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-ui-1.8.16.custom.min.js"></script> 
<script type="text/javascript" src="js/script.js"></script>
<script src="js/jquery.ui.draggable.js" type="text/javascript"></script>
<script src="js/jquery.alerts.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/number_style.css" />
<link href="css/jquery.alerts.css" rel="stylesheet" type="text/css" media="screen" />
<link rel="stylesheet" href="css/jquery-ui.css" />
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>
<script type="text/javascript">
$(function() {
$( "#tabs" ).tabs();
});
</script>
<!--<script type="text/javascript">
$(document).everyTime(1000000, function() {
$.ajax({
   /* your other params here*/
   url: "text1.php",
   error: function (req, status, error) {
   if(status == "timeout")
   $('#con').html("Internet Connection Ok");      
else
$('#con').html("<font color=red size=4>Please Check Internet Connection!</font>");
},
timeout: 2000 //2 seconds
});
});
</script> -->
<script type="text/javascript">
$(document).ready(function(){
for(var i=1;i<=4;i++){
$("#submit"+i).click(function(){
//alert("Test to submit");
//ajaxsub(Q);
jConfirm('Are You Sure you want to submit the test?', '<?php echo $test_name; ?>', function(r) {
if( r ) {
$("#formx").submit();
}				     
});
});
function sat()	{
//jAlert('Thank You');
}
}	

});
/*function subm()
{
alert('You moved out of the test area so your test module is going to be submited')
$("#formx").submit();
}*/
</script>
<script type="text/javascript">
$(window).load(function() {
	$(".loader").fadeOut("slow");
})
</script>
<script type="text/javascript">
function popUpClosed() {
    window.location.reload();
}
</script>
<script type="text/javascript" src="close.js"></script> 
<style>
	.section
	{
	float:left;
	background-color:#336699;
	color:#FFFFFF;
	font-weight:bold;
	border:1px solid #000;
	padding:4px;
	margin:4px;
	cursor:pointer;
	}
	.loader {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url('images/loading.gif') 50% 50% no-repeat rgb(249,249,249);
}
#container {
            bottom: 0px ;
            display: none ;
            right: 10px;
            position: fixed ;
            width: 20% ;
            }
 
        #inner {
            background-color: #F0F0F0 ;
            border: 1px solid #666666 ;
            border-bottom-width: 0px ;
            padding: 20px 20px 100px 20px ;
            }
 .calculator{
 			bottom: 10px ;
           	background:#000066;
		   	border-radius:5px;
			color:#CCFF33 !important;
			font-weight:bold; 
			padding:10px;
			text-align:center;
          	left: 10px;
            position: fixed ;
            width: 10% ;
 			}
.ui-tabs-active,.ui-state-active{
			background:#eee !important;
			}
.ui-tabs-active,.ui-state-active a{
			color:#3737FF !important;
			}
	</style>
	
<script language="JavaScript"> 

var version = navigator.appVersion; 

function showKeyCode(e) { 
var keycode = (window.event) ? event.keyCode : e.keyCode; 

if ((version.indexOf('MSIE') != -1)) { 
if (keycode) { 
event.keyCode = 0; 
event.returnValue = false; 
return false; 
} 
} 
else { 
if (keycode ) { 
return false; 
} 
} 
} 

</script> 
<script language=JavaScript>



//Disable right mouse click Script
//By Maximus (maximus@nsimail.com) w/ mods by DynamicDrive
//For full source code, visit http://www.dynamicdrive.com

var message="Function Disabled!";

///////////////////////////////////
function clickIE4(){
if (event.button==2){
alert(message);
return false;
}
}

function clickNS4(e){
if (document.layers||document.getElementById&&!document.all){
if (e.which==2||e.which==3){
alert(message);
return false;
}
}
}

if (document.layers){
document.captureEvents(Event.MOUSEDOWN);
document.onmousedown=clickNS4;
}
else if (document.all&&!document.getElementById){
document.onmousedown=clickIE4;
}

document.oncontextmenu=new Function("alert(message);return false")

 
</script>

<script type="text/javascript">
function ajaxsub(id){
    //alert(id);
    var i = (document.getElementById("Qut").value)-1;
	//alert(i);
	var aa="Q"+id+i;
	//alert(aa);
	var aaa=id+i;
	var aaaa="T"+id+i;
	var test = document.getElementById("test").value;
	var candidate = document.getElementById("candidate").value;
	var question = $('input[name='+aa+']').val();
	//alert(question);
	var ans = $('input[name='+aaa+']:checked').val();
	
	var tim= document.getElementById("countdown").value;
	var prvstim = document.getElementById("timer").value;
	$('#timer').val(tim);
	var instance= document.getElementById("instance").value;
	//alert(tim);
	//alert(prvstim);
	if(!ans){
	ans=0;
	}
	$.ajax
    ({ 
        url: 'savetest.php',
        data: {"test_id": test,
		       "candidate": candidate,
			   "question_id": question,
			   "answer":  ans,
			   "etime": tim,
			   "stime": prvstim,
			   "instance" : instance },
        type: 'post',
        cache: false,
		success: function(html)
			{
			$("#result"+aa).html(html);
			} 
    });
	setTimeout(function() { $("#result"+aa).fadeOut(10000); }, 1000);	
}
function ajaxsub1(id){
    var i = document.getElementById("Qut").value;
	//alert(i);
	var aa="Q"+id+i;
	alert(aa);
	var aaa=id+i;
	var aaaa="T"+id+i;
	var test = document.getElementById("test").value;
	var candidate = document.getElementById("candidate").value;
	var question = $('input[name='+aa+']').val();
	//alert(question);
	var ans = $('input[name='+aaa+']:checked').val();
	
	var tim= document.getElementById("countdown").value;
	var prvstim = document.getElementById("timer").value;
	$('#timer').val(tim);
	var instance= document.getElementById("instance").value;
	//alert(tim);
	//alert(prvstim);
	//alert(instance);
	if(!ans){
	ans=0;
	}
	$.ajax
    ({ 
        url: 'savetest.php',
        data: {"test_id": test,
		       "candidate": candidate,
			   "question_id": question,
			   "answer":  ans,
			   "etime": tim,
			   "stime": prvstim,
			   "instance" : instance },
        type: 'post',
        cache: false,
		success: function(html)
			{
			$("#result"+aa).html(html);
			}
    });
	setTimeout(function() { $("#result"+aa).fadeOut(10000); }, 1000);	
}
function ajaxsub2(id){
    //alert(id);
    var i = (document.getElementById("Qut").value);
	//alert(i);
	var aa="Q"+id+i;
	//alert(aa);
	var aaa=id+i;
	var aaaa="T"+id+i;
	var test = document.getElementById("test").value;
	var candidate = document.getElementById("candidate").value;
	var question = $('input[name='+aa+']').val();
	//alert(question);
	var ans = $('input[name='+aaa+']:checked').val();
	
	var tim= document.getElementById("countdown").value;
	var prvstim = document.getElementById("timer").value;
	$('#timer').val(tim);
	var instance= document.getElementById("instance").value;
	//alert(tim);
	//alert(prvstim);
	if(!ans){
	ans=0;
	}
	$.ajax
    ({ 
        url: 'savetest.php',
        data: {"test_id": test,
		       "candidate": candidate,
			   "question_id": question,
			   "answer":  ans,
			   "etime": tim,
			   "stime": prvstim,
			   "instance" : instance },
        type: 'post',
        cache: false,
		success: function(html)
			{
			$("#result").html(html);
			}
    });
	setTimeout(function() { $("#result"+aa).fadeOut(10000); }, 1000);	
}
function move(id){
	var selected = $("#tabs").tabs("option", "active");
	$("#tabs").tabs("option", "active", selected + 1);
	//alert(id);
	var id1=parseInt(id)+1;
	//alert(id1);
	var value=id1;
	//alert(value);
	
	//start();
	var totalque=document.getElementById("total"+id1).value;
	//alert(totalque);
	start1(totalque);
	var value=0;
	var value1=document.getElementById("Q").value;
	var value2=document.getElementById("R").value;
	var value3=document.getElementById("S").value;
	var value4=document.getElementById("T").value;
	$("#Q"+value1+1).show();
	$("#Q"+value2+1).show();
	$("#Q"+value3+1).show();
	$("#Q"+value4+1).show();
	$(".nt1").hide();
  	$(".nt").show();
}

function move1(id){
//alert(id);
	var id1=parseInt(id)-1;
	var value=document.getElementById("Qut1").value;
	//alert(value);
	var selected = $("#tabs").tabs("option", "active");
	$("#tabs").tabs("option", "active", selected - 1);
	//start();
	var totalque=document.getElementById("total"+id1).value;
	//alert(totalque);
	start1(totalque);
	var value1=document.getElementById("Q").value;
	var value2=document.getElementById("R").value;
	var value3=document.getElementById("S").value;
	var value4=document.getElementById("T").value;
	$("#Q"+value1+1).show();
	$("#Q"+value2+1).show();
	$("#Q"+value3+1).show();
	$("#Q"+value4+1).show();
	$(".nt1").hide();
  	$(".nt").show();
}

</script>
<script type="text/javascript" src="../../../../assessment/js/mootools-core-1.4.5-compat.js"></script>
     <script>
countdown('countdown', 0, 0,1);
//countdown("countdown2",0 , 50, 0);
function countdown(element, hours, minutes, seconds) {
    var time = hours*3600 + minutes*60 + seconds;
    var interval = setInterval(function() {
        var el = document.getElementById(element);
        //var el1 = document.getElementById(countdown1);
        if(time == 0) {
            el.value = "countdown's over!";    
            clearInterval(interval);
            return;
        }
        var hours = Number.floor( time / 3600 );
        if (hours < 10) hours = "0" + hours;
        var minutes = Number.floor( time / 60 );
        if(minutes >= 60){
			minutes = minutes - 60;
		}
        if (minutes < 10) minutes = "0" + minutes;
        var seconds = time % 60;
        if (seconds < 10) seconds = "0" + seconds; 
        var text = hours + ':' + minutes + ':' + seconds;
        el.value = text;
        //el1.value = text;
        time++;
    }, 1000);
}

function clearcheck(qid){
	//alert(qid);
	$("#"+qid).attr("class","tooltip_not_answered");
	
    $(".ans"+qid).attr('checked', false);
  
}


/*window.onbeforeunload = bunload;

function bunload(){
dontleave="Before Leaving this page, Please submit the test. Otherwise your test result won't come properly.";
return dontleave;
}*/

</script>

</head>
<body  onload="start();" onkeydown="return showKeyCode(event)" id="body" >
<div class="loader"><p style="padding-top:350px;font-size:44px;color:red" align="center">All The Best</p></div>
<input type="hidden" name="count" id="count" value="<?php echo $count; ?>" />
<input type="hidden" name="countrand2" id="countrand2" value="0" />
<form action="x.php?cat_id=<?php echo $sub; ?>&test_name=<?php echo $test_name; ?>" method=post id=formx name="formx">
<input name="test" id="test" type="hidden" value="<?php echo $test_name; ?>" />
<input name="candidate" id="candidate" type="hidden" value="<?php echo $_SESSION['regno_of_user']; ?>" />
<?php $qry=mysql_query("select distinct(instance) from `temp_test_result` where test_id='".$test_name."' AND candidate='".$_SESSION['regno_of_user']."'");
$c=mysql_num_rows($qry);

if($c=="0")
{
$c=1;
}else{
$sqry=mysql_query("select * from test_status where test_id='".$test_name."' AND candidate='".$_SESSION['regno_of_user']."' AND instance='$c' AND status='finish'");
$count=mysql_num_rows($sqry);
if($count=='1'){
$c+=1; 
}
} ?>
<input name="instance" id="instance" type="hidden" value="<?php echo $c; ?>" />

<input type="hidden" name="countdown" id="countdown" value="" />
<div id="tabs">
<div style="background-color: #FFFF00;padding:2px;width:247px"><img src="images/77.gif" height="35"/></div>
<ul style="margin-bottom:16px;background-color: #3737FF;margin-left:255px;margin-top:-38px;">
<?php $db = new Database();  
$db->connect();  
$rs= "SELECT * from online_test where (test_name='".$test_name."' and  STATUS='ACTIVE') order by id"; 
$rs1=mysql_query($rs);
$i=1;
$dur1=0;
while($row=mysql_fetch_array($rs1)){
$dur1=$dur1+$row['duration'];
?>
<li style="background: #54F017;font-weight:bold;color:#FFFFFF;"><a href="#tabs-<?php echo $i; ?>" onclick="start1(<?php echo $row['TOTAL_NO_QUESTION']; ?>);"><?php echo $row['CATEGORY']; ?></a></li>
<?php $i++; } 
$v2=$dur1;
$v1=$v2-1;
for($i=0;$i<$v2;$i++)
{
$dataa=$dataa.",0";
}
?>
</ul>

<?php
$rs2= "SELECT * from online_test where (test_id='".$test_name."' and  STATUS='ACTIVE')  order by id"; 
$rs3=mysql_query($rs2);
$j=1;
$counta=mysql_num_rows($rs1);
while($row=mysql_fetch_array($rs3)){ 
$dur=$row['TOTAL_NO_QUESTION'];
$test=$row['test_id'];
$sub=$row['CAT_NAME'];
$cat_name=base64_encode($row['CATEGORY']);
?>
<div id="countdown-1" style="float:right"></div>
<div style="width:63%;float:right;">
<div id="progress2">
<div class="pbar"></div>
<span class="percent" style="float:left"></span>
</div>
</div>
<div class="clear"> </div>

<div id="tabs-<?php echo $j; ?>">

<div style="float:left;width:247px;margin-top:-55px;padding:2px; background-color:#E4EDF7;"><p> <img src="images/NewCandidateImage.jpg" height="47px;" style="float:left; "/> <strong><?php echo ucwords($_SESSION['name_of_user2']); ?></strong><br /><font size="1" color="#0033CC"><?php echo ucwords($_SESSION['branch']); ?>, <?php echo ucwords($_SESSION['college']); ?></font></p> </div>
<div class="clear"> </div>
<div id="home1" style="width:78%;float:right;margin-top:2px;">


<input type=hidden name="xx" id=xx size="111" value="<?php echo $dataa; ?>" >
<input type="hidden" name="timer" id="timer" value="00:00:00" />			  
    </div>
<div align="center">
				<table class=option style="border-collapse: collapse;" id=cont width="100%" align="left">
				<tr>
				<td  rowspan="2"  valign="top" style="background:#E4EDF7;width:247px;">
				
				<div style="padding:5px;border:0px solid #999999; height:100%;overflow:auto;background-color:#E4EDF7">
				<div style="margin:auto;">
				<center>
				
				</center>
				 <div></div>
				 </div>
				 <p></p>
				 <p align="center">You Are In Section 
				<b><?php echo base64_decode($cat_name); ?></b> </p>
									<div style="margin:auto;width:100%;padding:0px;border:0px solid #999999; height:310px;overflow:auto;background-color:#E4EDF7" align="center">									
									<?php include("review.php"); ?>
									
									</div>
									
									<div style="clear:both"></div>
									
									
									<div><table width="100%" align="center" style="font-size:11px;">
							        <tbody><tr>
								    <td colspan="4"><b>Legend : </b></td>
							        </tr>
									<tr>
								    <td><span id=natt class="natt"><?php echo $dur; ?></span>
				  <input type="hidden" id="totalq" value="<?php echo $dur; ?>" />
				  <input type="hidden" id="total<?php echo $j; ?>" value="<?php echo $dur; ?>" /></td> <td> Total Question</td>
				   <td><span class="rev<?php echo $j; ?> review"><!-- <?php //echo $dur-1; ?> --> </span></td> <td> Not Visited</td>
				  
							        </tr>
							        <tr>
								    <td><span  class="att<?php echo $j; ?> tooltip_answered" style="text-align:center"><!-- 0 --></span></td> <td> Answered</td>
								    <td><span class="uatt<?php echo $j; ?> tooltip_not_answered" style="color:#000000"><!-- 1 --></span></td> <td>Unanswered</td>
							        </tr>
							        <tr>
								    <td><span class="ratt<?php echo $j; ?> tooltip_reviewanswered"><!-- 0 --></span></td> <td> Marked & Answered</td>
									
								    <td><span class="natt<?php echo $j; ?> tooltip_review"><!-- 0 --></span></td> <td>Marked & Unanswered</td>
								   
							        </tr>
						            </tbody></table></div>
									 <div style="margin:0px auto;position:fixed;bottom:13px;">
									 <center>
									 
									</center>
		<a href="<?php if($calculator=="Yes"){ ?>calculator.php<?php }if($calculator=="No"){ ?>#<?php } ?>" <?php if($calculator=="Yes"){ ?>class="example5"<?php } ?> <?php if($calculator=="No"){ ?>onclick="alert('This feature is disabled by the adminstrator!!!');"<?php } ?>><input type="button" value="Calculator" style="cursor:pointer;width:234px;background-color:#B1D2ED;font-weight:bold;" /></a>							 
</div>									 
</div>									 
									 
									 								</td>
				<td valign="top"><span id=ch></span>
				<!--<div id="page-wrap" ></div>-->
				    
							         
							        <?php include("creat_xml.php"); ?>
									<input type=hidden value='0' id="Qut">
									 <input type=hidden value='0' id="Qut2">
									<input type=hidden value='0' id="Qut1">
									
									<table border="0" cellpadding="2" width="99%">
    <tr>
	<!--<td width="244" align="right">	</td> -->
	<td width="152"><input type="button" id=pt class="pt"  align=center  onclick="prev('<?php echo $a; ?>'); ajaxsub('<?php echo $a; ?>');" value="Previous" style="width:150px;background-color:#DF6853;font-weight:bold;color:#FFFFFF;" /></td>
	<td align="right" width="847"><input type="button" id=nt class="nt" align=center name="<?php echo $a; ?>"  onclick="next('<?php echo $a; ?>'); ajaxsub('<?php echo $a; ?>')" value="Save & Next" style="width:150px;background-color:#4D7BCA;float:left;font-weight:bold;color:#FFFFFF;" />
	<?php if($counta!=$j){ ?><input type="button" id=nt class="nt1" align=center name="<?php echo $a; ?>"  onclick="ajaxsub('<?php echo $a; ?>'); move('<?php echo $j; ?>')" value="Save & Move to Next Section" style="width:230px;background-color:#4D7BCA;float:left;font-weight:bold;color:#FFFFFF;display:none;" />
	<?php }
	if($j!='1'){
	 if($counta==$j){ ?><input type="button" id=nt class="nt1" align=center name="<?php echo $a; ?>"  onclick="ajaxsub('<?php echo $a; ?>'); move1('<?php echo $j; ?>')" value="Save & Move to Previous Section" style="width:250px;background-color:#DF6853;float:left;font-weight:bold;color:#FFFFFF;display:none;" />
	<?php } }  ?>
	
	<div align=right style="width:150px;" class=options> <input type="button" id="submit<?php echo $j; ?>" style="width:150px;background:#99FF33;cursor:pointer;font-weight:bold;color:#000;" value="Submit the Test" "/> </div>
	</td >
	</tr>
	</table>
				  </td>
	              </tr>
						            
      </table>
</div>
			                        
									
			
	
  
	</form>
	</div>
   <?php 
   $j++; 
   }
    ?>
</div>
</div>
</div>

<script type=text/javascript>
	var time3=<?php echo $dur1; ?>; 
	var v1=<?php echo $v1; ?>; 
	var v2=<?php echo $v2; ?>; 
	
</script>
<link rel="stylesheet" href="../../../../../css/colorbox.css" />
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script> -->
<script src="../../../../../javascript/jquery.colorbox.js"></script>
<script>
$(document).ready(function(){
//Examples of how to assign the Colorbox event to elements
				
$(".example5").colorbox({iframe:true, innerWidth:705, innerHeight:405,
onCleanup:function(){ //window.location="calculator.php";
}});
				
});
</script>
<link href="timeTo.css" type="text/css" rel="stylesheet"/>
<script src="jquery.timeTo.min.js"></script>
    <script>
        /**
         * Set timer countdown in seconds with callback
         */
        $('#countdown-1').timeTo((time3*60), function(){
            alert('Your Test Time is finished');
			
        });

        

        function getRelativeDate(days, hours, minutes){
            var date = new Date((new Date()).getTime() + 60000 /* milisec */ * 60 /* minutes */ * 24 /* hours */ * days /* days */);

            date.setHours(hours || 0);
            date.setMinutes(minutes || 0);
            date.setSeconds(0);

            return date;
        }
    </script>
</body>
</html>

