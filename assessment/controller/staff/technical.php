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
if($_GET['id']){
	$rs=$fgmembersite->Getstudent($_GET['id']);
	if($fgmembersite->ThatDate($_GET['id'])){
		$fgmembersite->RedirectToURL("index1.php?id=warning&regno=$_GET[id]");
	}
}

$row=mysql_fetch_array($rs);
$count=mysql_num_rows($rs);
if($count<1){
	$fgmembersite->RedirectToURL("index.php");
}
?>
<!DOCTYPE HTML>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">

  
     <meta charset="utf-8">
    <title>Assessment Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="../../css/bootstrap.css" rel="stylesheet">
    <link href="../../css/bootstrap-responsive.css" rel="stylesheet">

    <link rel="stylesheet" href="../../css/typica-login.css">
	<link href="../../css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../../css/style.css">

    <link rel="shortcut icon" href="http://induseducation.in/favicon.ico" />
    <script type="text/javascript" src="../../js/bootstrap.js"></script>
    <script type="text/javascript" src="../../js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="../../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../js/jquery-ui.js"></script>
	<script src="../../js/jquery-ui-1.8.21.custom.min.js"></script>

	<link rel="stylesheet" href="../../css/jquery-ui.css"> 
<!--Scripting for Sliderbar Start-->
<script> 
	$(function() {
		$( "#slider-range-min" ).slider({
			range: "min",
			value: 0,
			min:0,
			max: 5,
			step: 0.5,
			slide: function( event, ui ) {
				$( "#amount" ).val( ui.value );
			}
		});
		$( "#amount" ).val( $( "#slider-range-min" ).slider( "value" ) );
	});
	$(function() {
		$( "#slider-range-min1" ).slider({
			range: "min",
			value: 0,
			min: 0,
			max: 5,
			step: 0.5,
			slide: function( event, ui ) {
				$( "#amount1" ).val( ui.value );
			}
		});
		$( "#amount1" ).val( $( "#slider-range-min1" ).slider( "value" ) );
	});
	$(function() {
		$( "#slider-range-min2" ).slider({
			range: "min",
			value: 0,
			min: 0,
			max: 5,
			step: 0.5,
			slide: function( event, ui ) {
				$( "#amount2" ).val( ui.value );
			}
		});
		$( "#amount2" ).val( $( "#slider-range-min2" ).slider( "value" ) );
	});
	$(function() {
		$( "#slider-range-min3" ).slider({
			range: "min",
			value: 0,
			min: 0,
			max: 5,
			step: 0.5,
			slide: function( event, ui ) {
				$( "#amount3" ).val( ui.value );
			}
		});
		$( "#amount3" ).val( $( "#slider-range-min3" ).slider( "value" ) );
	});
	$(function() {
		$( "#slider-range-min4" ).slider({
			range: "min",
			value: 0,
			min: 0,
			max:5,
			step: 0.5,
			slide: function( event, ui ) {
				$( "#amount4" ).val( ui.value );
			}
		});
		$( "#amount4" ).val( $( "#slider-range-min4" ).slider( "value" ) );
	});
	$(function() {
		$( "#slider-range-min5" ).slider({
			range: "min",
			value: 0,
			min: 0,
			max: 5,
			step: 0.5,
			slide: function( event, ui ) {
				$( "#amount5" ).val( ui.value );
			}
		});
		$( "#amount5" ).val( $( "#slider-range-min5" ).slider( "value" ) );
	});
	$(function() {
		$( "#slider-range-min6" ).slider({
			range: "min",
			value: 0,
			min: 0,
			max: 5,
			step: 0.5,
			slide: function( event, ui ) {
				$( "#amount6" ).val( ui.value );
			}
		});
		$( "#amount6" ).val( $( "#slider-range-min6" ).slider( "value" ) );
	});
	$(function() {
		$( "#slider-range-min7" ).slider({
			range: "min",
			value: 0,
			min: 0,
			max: 5,
			step: 0.5,
			slide: function( event, ui ) {
				$( "#amount7" ).val( ui.value );
			}
		});
		$( "#amount7" ).val( $( "#slider-range-min7" ).slider( "value" ) );
	});
	</script>
    <!--Scripting for Sliderbar End--> 
    <!--Script for Stopwatch start---> 
     <script type="text/javascript" src="../../js/mootools-core-1.4.5-compat.js"></script>
     <script>
countdown('countdown', 0, 0,1);
//countdown("countdown2",0 , 50, 0);
function countdown(element, hours, minutes, seconds) {
    var time = hours*3600 + minutes*60 + seconds;
    var interval = setInterval(function() {
        var el = document.getElementById(element);
        //var el1 = document.getElementById(countdown1);
        if(time == 0) {
            el.innerHTML = "countdown's over!";    
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
        el.innerHTML = text;
        //el1.innerHTML = text;
        time++;
    }, 1000);
}

</script>
   <style>
	.input-group{
		margin-bottom:8px;
	}
	
</style>
<!--Script Stopwatch End-->

  </head><body style="background:url('<?php echo $path; ?>images/background1.png');padding-top:0px !important;">
 
	 <!--Start Header-->
	 	  
      <div class="row-fluid" id="header-pane" style="background-color: #B20EFF;padding-top:6px;padding-bottom:6px;border-top:2px solid #000;box-shadow:0px 5px 5px 5px #888888;">
      
       <div id="top_home" class="clear">

      <div class="col-md-2" style="padding-left:10px;">
      <img src="../../image/77.gif" alt="" >  
      </div>

      <div class="col-md-6" style="padding:20px;text-align: right;" >
         <span style="text-transform:uppercase;"> <font size="5" color="#33CCFF" > <strong><!--Careers & Employability Service--> </strong></font></span>
            </div>
             <div class="col-md-4" style="padding-top:5px;padding-left: 100px;font-weight: bold;" >
               <?php
               $row1=mysql_query("select * from staff where Email='".$_SESSION['email_of_user']."'")or die(mysql_error());
if($rs1=mysql_fetch_array($row1)or die(mysql_error())){ $photo=$rs1['Photo'];  ?>

               <img <?php if($photo!=''){ ?>src="../admin/uploads1/<?php echo $photo; ?>" <?php }else { ?>src="../example/profile.jpg" <?php } ?> alt="User Photo" width="43" height="43" style="border:2px solid #ddd;border-radius:4px;float:left;margin-right:3px;">  Hello, <?php echo ucwords($_SESSION['name_of_user']); ?> <br/>
        <a href="index1.php?id=profile&sid=<?php echo $_SESSION['email_of_user']; ?>">Profile</a> | <a href="index1.php?id=change password">Change Password</a> | <a href="../../logout.php">Logout</a>
        <?php } ?>
            </div>
         </div>
      </div>
     <div class="clear" style="height:20px;"></div>

<!--Header End-->
<!--Start User Data Header-->
    <div class="container" id="login-wraper4" style="float: none !important;
margin: auto !important;">
 
 <div class="row" style="margin-left: 30px;margin-right:3px;">

     <form action="" name='login' method="post">
         
         <div class="col-md-3" style="text-align: left;"><table><tr><td><strong>Name   </strong></td><td>:</td> <td><font size="1"><?php echo $row['NAME']; ?></font></td></tr>
        <tr><td> <strong>Reg.No  </strong></td><td>:</td> <td> <font size="1"><?php echo $row['REG_NO']; ?></font></td></tr>
        <tr><td> <strong>Branch  </strong></td><td>:</td> <td> <font size="1"><?php echo $row['BRANCH']; ?></font> </td></tr></table></div>   
        <div class="col-md-6" style="text-align: left;">
		<table>
        <?php $qry1 = "Select * from `ti` where REGD_NO ='".$row['REG_NO']."' ";
        		$rs1=mysql_query($qry1);
        		$counter=mysql_num_rows($rs1);
        		if($counter>0){
					?>
        	<tr><td><strong>TI Instances </strong></td><td> :  </td><td> 
        		<?php
        		$count=1;
        		while($row1=mysql_fetch_array($rs1)){
        			?>
        			<a class="ajax btn btn-danger" href="report1.php?id=<?php echo $row1['ID']; ?>&instance=<?php echo $count; ?>&reg=<?php echo $row['REG_NO']; ?>" style="color: #fff;padding:3px !important;margin-bottom:3px;"> <?php echo $count; ?></a>  
					
                   <?php $count++; }
        		?>
        	</td></tr>
        	
        	<?php } ?>
        	
        	<?php $qry1 = "Select * from `pi` where REGD_NO ='".$row['REG_NO']."'";
        		$rs1=mysql_query($qry1);
        		$counter=mysql_num_rows($rs1);
        		if($counter>0){
					?>
        	<tr><td><strong>PI Instances  </strong></td><td> :  </td><td> 
        		<?php
        		$count=1;
        		while($row1=mysql_fetch_array($rs1)){
        			?>
        			<a class="ajax btn btn-primary" href="report.php?id=<?php echo $row1['ID']; ?>&instance=<?php echo $count; ?>&reg=<?php echo $row['REG_NO']; ?>" style="color: #fff;padding:3px !important;margin-top:3px;"> <?php echo $count; ?></a>  
					
                   <?php $count++; }
        		?>
        	</td></tr>
        	<?php } ?>
        	</table>
        </div>      
           <div class="col-md-3" id="countdown" style="width:20%; float:right;margin-right:20px;font-align:center;font-size:32px;color:#FFF;background-color:#036;background-image:none;border:1px solid #660;border-radius:4px;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);box-shadow:inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s;"></div>      
         </form>
      </div>
        
   </div>
  <!--End User Data Header-->
  <!--Technical Interview assessment Start-->  
  <form id="uguu" class="" action="index1.php?id=technicalresult" name="form1" method="post">
  <input type="hidden" name="student" value="<?php echo $row['NAME']; ?>" />
  <input type="hidden" name="reg_no" value="<?php echo $row['REG_NO']; ?>" />
  <input type="hidden" name="timestarted" value="<?php echo date("H:i:s"); ?>" id="countdown1" /> 
  <div class="container" >
  <div class="clear" style="height:20px;"></div>
  <div class="row">
   <form action="" name='login' method="post">
    <div class="col-md-5">
    
    <div class="panel panel-primary4"> <div class="panel-heading"><font size="3" color="#000066"><center><strong>Tech Interview Assessment</strong></center></font> </div><table class="table" >
           
                <tr><td><strong>Personal Disposition</strong> </td><td width="80%" ><div id="slider-range-min"></div></td><td width="10%">
	
<input type="text" id="amount" name="personaldisposition" style="border:1; width:30px; color:#f6931f; font-weight:bold;">  </td></tr>
           <tr><td><strong>Career </strong></td><td width="80%" ><div id="slider-range-min1"></div></td><td width="10%">
	
<input type="text" id="amount1" name="career" style="border:1; width:30px; color:#f6931f; font-weight:bold;">  </td></tr>
           <tr><td><strong>Communication</strong></td><td width="80%" ><div id="slider-range-min2"></div></td><td width="10%">
	
<input type="text" id="amount2" name="communication" style="border:1; width:30px; color:#f6931f; font-weight:bold;">  </td></tr>
           <tr><td><strong>Knowledge in own area</strong></td><td width="80%" ><div id="slider-range-min3"></div></td><td width="10%">
	
<input type="text" id="amount3" name="knowledge" style="border:1; width:30px; color:#f6931f; font-weight:bold;">  </td></tr>
           <tr><td><strong>IT Awareness</strong> 
</td><td width="80%" ><div id="slider-range-min4"></div></td><td width="10%">
	
<input type="text" id="amount4" name="itawareness" style="border:1; width:30px; color:#f6931f; font-weight:bold;">  </td></tr>
           <tr><td><strong>Confidence</strong></td><td width="80%" ><div id="slider-range-min5"></div></td><td width="10%">
	
<input type="text" id="amount5" name="confidence" style="border:1; width:30px; color:#f6931f; font-weight:bold;">  </td></tr>
          
            </table></div>
           
             <div class="panel panel-primary3"> <div class="panel-heading"><font size="3" color="#000066"><center><strong>Other Feedback</strong></center></font> </div><table class="table" ><tr><td style="padding-left:54px;"><textarea name="otherfeedback" cols="" rows="4" style="width:400px !important;padding-bottom:12px; " ></textarea></td></tr></table></div>
             
            </div>
         <!--Technical Interview assessment End-->  
          <!--Technical Feedback Start-->
    <div class="col-md-7">
     <div class="panel panel-success"> <div class="panel-heading"><font size="3" color="#000066"><center><strong>Technical Feedback</strong></center></font> </div><table class="table" >
            
            <tr><td>
          
           <div class="input-group"> <span class="input-group-addon  "><input type="checkbox"  name="techfeedback[]" value="Need to brush up Technical basics slightly."></span><span class="form-control" ><font size="2">Need to brush up Technical basics slightly. </font></span> </div>
          <div class="input-group"> <span class="input-group-addon  "><input type="checkbox" name="techfeedback[]" value="Technical is average. Need to brush up technical urgently and ensure that at least the most expected and obvious questions are answered from your branch. "></span><span class="form-control" ><font size="2">Technical is average. Need to brush up technical urgently and ensure that at least the most expected and obvious questions are answered from your branch. </font></span></div>
             <div class="input-group"> <span class="input-group-addon  "><input type="checkbox" name="techfeedback[]" value="Technical is good. Try to sound more confident while answering Technical questions. Answers are correct but sounding as if not sure."></span><span class="form-control" ><font size="2">Technical is good. Try to sound more confident while answering Technical questions. Answers are correct but sounding as if not sure. </font> </span></div>
              <div class="input-group"> <span class="input-group-addon  "> <input type="checkbox" name="techfeedback[]" value="Technically very poor. Work on fundamentals of your core areas."></span><span class="form-control" ><font size="2">Technically very poor. Work on fundamentals of your core areas. </font></span></div>
                <div class="input-group"> <span class="input-group-addon  "><input type="checkbox" name="techfeedback[]" value="Project thoroughly unprepared. Work on project so that you can speak on the same for at least 2-3 minutes effectively. "></span><span class="form-control" ><font size="2">Project thoroughly unprepared. Work on project so that you can speak on the same for at least 2-3 minutes effectively. </font></span></div>
                <div class="input-group"> <span class="input-group-addon  "> <input type="checkbox" name="techfeedback[]" value="Work on basic IT Technical Skills. What is written in resume you must be able to answer. There is no excuse for not doing the same."></span><span class="form-control" ><font size="2">Work on basic IT Technical Skills. What is written in resume you must be able to answer. There is no excuse for not doing the same. </font></span></div>
                <div class="input-group"> <span class="input-group-addon  "><input type="checkbox" name="techfeedback[]" value="Technically Knowledge is good. Learn some practical application and contemporary things of your field"></span><span class="form-control" ><font size="2">Technically Knowledge is good. Learn some practical application and contemporary things of your field</font></span></div>
                 <!--<div class="input-group"> <span class="input-group-addon  "><input type="checkbox" name="keepyouranswer" value="Knows the answers but not able to articulate the concepts well."></span><span class="form-control" ><font size="2">Knows the answers but not able to articulate the concepts well. </font></span></div><br/>-->
                <div class="input-group"> <span class="input-group-addon  "><input type="checkbox" name="techfeedback[]" value="Knows the concepts but not able to relate it to practical application."></span><span class="form-control" ><font size="2">Knows the concepts but not able to relate it to practical application. </font></span></div>
                </td></tr>
            </table></div>
    </div>
   <!--Technical Feedback End-->
   <!--Submit button Start-->
   <div class="container">
   <div class="row">
   
   <div class="col-md-12">
   <div class="submits" style="margin:auto;padding-bottom:50px;">
              
         <p align="center"><input type="submit"  class=" btn btn-success" name="submit" value="Save Result"  /></p>
     </div> 
   </div>
   </div>
   </div>
   <!--Submit button End-->
   </form>
  </div>  
  </div>
  </form>
  
   <!--Technical Interview assessment End-->         
<!--Footer Start-->
    <div id="wrapper" style="width:100%; height:25px;background-color: #B20EFF;position: fixed;bottom: 0;border-top:2px solid #000;box-shadow:0px 2px 2px 2px #888888;">
 <div id="footer1"> 
		<p align='center' style="padding:3px;">Copyright &copy; 2013 Indus Education. All Rights Reserved.</p>
		     </div>
     </div>
 <!--Footer End-->
   
   <!-- ColorBox -->
 <link rel="stylesheet" href="../../css/colorbox.css" />
		<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
		<script src="../../js/jquery.colorbox.js"></script>
		<script>
			$(document).ready(function(){
				//Examples of how to assign the Colorbox event to elements
				
				$(".ajax").colorbox();
				
			});
		</script>  
		<!-- End Color Box -->
 </body></html>