<!DOCTYPE HTML>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">

  
    <meta charset="utf-8">
    <title>Assessment Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
<!--<link href="css/jquery-ui.css" rel="stylesheet">-->
    <link rel="stylesheet" href="css/typica-login.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/style.css">
<!--<script language="javascript"> 
var base = 60;
var clocktimer,dateObj,dh,dm,ds,ms;
var readout='';
var h=1;
var m=1;
var tm=1;
var s=0;
var ts=0;
var ms=0;
var show=true;
var init=0;
var mPLUS=new Array(
'm0',
'm1',
'm2',
'm3',
'm4',
'm5',
'm6',
'm7',
'm8',
'm9');
var ii=0;

function clearALL() {
clearTimeout(clocktimer);
h=1;m=1;tm=1;s=0;ts=0;ms=0;
init=0;show=true;
readout='00:00:00.00';
document.clockform.clock.value=readout;
var CF = document.clockform;
for (ij=0;ij<=9;ij++) { CF[mPLUS[ij]].value = ''; }
ii = 0;}

function addMEM() {
if (init>0) {var CF = document.clockform;
CF[mPLUS[ii]].value = readout;
if (ii==9) { ii = 0; } else { ii++; }}}


function startTIME() { 
var cdateObj = new Date();
var t = (cdateObj.getTime() - dateObj.getTime())-(s*1000);

if (t>999) { s++; }

if (s>=(m*base)) {ts=0;
m++;} else {ts=parseInt((ms/100)+s);
if(ts>=base) { ts=ts-((m-1)*base); }}

if (m>(h*base)) {tm=1;
h++;} else {tm=parseInt((ms/100)+m);
if(tm>=base) { tm=tm-((h-1)*base); }}

ms = Math.round(t/10);
if (ms>99) {ms=0;}
if (ms==0) {ms='00';}
if (ms>0&&ms<=9) { ms = '0'+ms; }

if (ts>0) { ds = ts; if (ts<10) { ds = '0'+ts; }} else { ds = '00'; }
dm=tm-1;
if (dm>0) { if (dm<10) { dm = '0'+dm; }} else { dm = '00'; }
dh=h-1;
if (dh>0) { if (dh<10) { dh = '0'+dh; }} else { dh = '00'; }

readout = dh + ':' + dm + ':' + ds + '.' + ms;
if (show==true) { document.clockform.clock.value = readout; }

clocktimer = setTimeout("startTIME()",1);}

function findTIME() {
if (init==0) {dateObj = new Date();
startTIME();
init=1;} else {if(show==true) {show=false;} else {show=true;}}}
</script>
<script>
function startTime()
{
var today=new Date();
var h=today.getHours();
var m=today.getMinutes();
var s=today.getSeconds();
// add a zero in front of numbers<10
m=checkTime(m);
s=checkTime(s);
document.getElementById('txt').innerHTML=h+":"+m+":"+s;
t=setTimeout(function(){startTime()},500);
}

function checkTime(i)
{
if (i<10)
  {
  i="0" + i;
  }
return i;
}
</script>-->


    <link rel="shortcut icon" href="http://induseducation.in/favicon.ico" />
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/jquery-ui.js"></script>
    <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
	<script src="js/jquery-1.7.2.min.js"></script>
	<script src="js/jquery-ui-1.8.21.custom.min.js"></script>
 <script>
function myfunction()
{
document.getElementById("theform").reset();
}
</script>
  <script>
function goBack()
  {
  window.history.back();
  }
</script>
<link rel="stylesheet" href="css/jquery-ui.css">
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

  </head><body >
 
	 
	  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="navbar-inner">
        <div class="container">
		  <div class="navbar-header">
         
          <a class="brand" ><img src="image/77.gif" align="left" alt=""></a>
        
           <!--<font color="#CCCC00" margin-right="2px">Welcome</font>-->
        </div>
<br/> <span style="text-transform:uppercase;margin-left:120px;"> <font size="5" color="#33CCFF" > <strong>Careers & Employability Service </strong></font></span>
       <!--<li style="margin-left:90%;font-color:blue;">Welcome</li></ul>-->
        <span style="margin-left:80%;font-color:blue;margin-top:2px;">Welcome Sasmita&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="">Logout</a></span>
         <!--<a href="" style="margin-left:80%"><img src="image/logout1.png"></a>-->
         </div>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        
     
    </nav>


    <div class="container">

        <div >
         <div id="login-wraper4">
         <form action="" name='login' method="post">
         
          <table width="50%"><tr><td><strong>Name:</strong></td><td>Sasmita Mahapatra</td><td><strong>Reg.No</strong></td><td>123546</td><td><strong>Branch:</strong></td><td>Computer Science </td><td></td>        
               
         
          </tr></table>

          
         </form>
         <div align="right" class="side"> <img src="image/winter.jpg" height="30px"width="40px"></div>
        <!-- <form name="clockform" class="side" >
<input name="clock"; value="00:00:00:00"  style="width:50%;height:44px;font-align:center;font-size:32px;color:#003;background-color:#036;background-image:none;border:1px solid #660;border-radius:4px;-webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);box-shadow:inset 0 1px 1px rgba(0,0,0,.075);-webkit-transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s;"/></td>
<td><input name="starter" class="btn btn-success" onclick="findTIME()" style="font-weight: bold; width: 97px;" type="button" value="Start/Stop" ></td>
<td><input name="clearer" class="btn btn-custom2" onclick="clearALL()" type="button" value="Reset" >
</form>-->

         
         </div>
                <form class="" action="" name="" method="post">
               <div style=" margin-top:130px  ;">
           <div class="panel panel-primary"> <div class="panel-heading"><font size="3" color="#000066"><center><strong>Verbal Communication</strong></center></font> </div><table class="table" >
            
          
                <tr><td width="10%"><strong>Clarity  </strong></td><td width="80%" ><div id="slider-range-min"></div></td><td width="10%">
	
<input type="text" id="amount" name="clarity" style="border:0; width:30px; color:#f6931f; font-weight:bold;">  </td></tr>
           <tr><td><strong>Articulation</strong></td><td width="80%" ><div id="slider-range-min1"></div></td><td width="10%">
	
<input type="text" id="amount1" name="articulation" style="border:0; width:30px; color:#f6931f; font-weight:bold;">  </td></tr>
           <tr><td><strong>Usage</strong></td><td width="80%" ><div id="slider-range-min2"></div></td><td width="10%">
	
<input type="text" id="amount2" name="usage" style="border:0; width:30px; color:#f6931f; font-weight:bold;">  </td></tr>
            </table></div>
            <dl><dd></dd></dl>
          
             <div class="panel panel-primary1"> <div class="panel-heading"><font size="3" color="#000066"><center><strong>Non-Verbal Communication</strong></center></font> </div>
             <table class="table" >
           
            <tr><td><strong>Confidence</strong></td><td width="80%" ><div id="slider-range-min3"></div></td><td width="10%">
	
<input type="text" id="amount3" name="confidence" style="border:0; width:30px; color:#f6931f; font-weight:bold;">  </td></tr>
           <tr><td> <strong>Body lang.</strong> </td><td width="80%" ><div id="slider-range-min4"></div></td><td width="10%">
	
<input type="text" id="amount4" name="bodylang" style="border:0; width:30px; color:#f6931f; font-weight:bold;">  </td></tr>
           <tr><td> <strong>Listening</strong></td><td width="80%" ><div id="slider-range-min5"></div></td><td width="10%">
	
<input type="text" id="amount5" name="listening" style="border:0; width:30px; color:#f6931f; font-weight:bold;">  </td></tr>
            </table></div>
            <dl><dd></dd></dl>
             <div>
              <div class="panel panel-primary2"> <div class="panel-heading"><font size="3" color="#000066"><center><strong>Physical Appearance & Mannerisms</strong></center></font> </div>
             <table class="table">
           
            <tr><td><strong>Appearance</strong></td><td width="80%" ><div id="slider-range-min6"></div></td><td width="10%">
	
<input type="text" id="amount6" name="appearance" style="border:0; width:30px; color:#f6931f; font-weight:bold;">  </td></tr>
           <tr><td><strong>Manners </strong>
          </td><td width="80%" ><div id="slider-range-min7"></div></td><td width="10%">
	
<input type="text" id="amount7" name="manners" style="border:0; width:30px; color:#f6931f; font-weight:bold;">  </td></tr>
            </table></div>
        
            <div class="panel panel-primary3"> <div class="panel-heading"><font size="3" color="#000066"><center><strong>Other Feedback</strong></center></font> </div><table class="table" ><tr><td><textarea name="otherfeedback" cols="" rows="" ></textarea></td></tr></table></div>
            
            </div>
         <div id="login-wraper">
           <div class="panel panel-success"> <div class="panel-heading"><font size="3" color="#000066"><strong>Communication Feedback</strong></font> </div><table class="table" >
            
            <tr><td>
          
           <div class="input-group"> <span class="input-group-addon  "><input type="checkbox"  name="comm.feedback1" value="Lacks confidence. Needs to be more sure of the himself/herself."></span><span class="form-control" ><font size="2">Lacks confidence. Needs to be more sure of the himself/herself.</font></span> </div><br/>
          <div class="input-group"> <span class="input-group-addon  "><input type="checkbox" name="comm.feedback2" value="Lacks assertiveness. Be a little louder and put some more energy in your voice."></span><span class="form-control" ><font size="2">Lacks assertiveness. Be a little louder and put some more energy in your voice.</font></span></div><br/>
             <div class="input-group"> <span class="input-group-addon  "><input type="checkbox" name="comm.feedback3" value="Try to improve upon your verbal communication. Do not get nervous by taking unnecessary pressure."></span><span class="form-control" ><font size="2">Try to improve upon your verbal communication. Do not get nervous by taking unnecessary pressure.</font> </span></div><br/>
              <div class="input-group"> <span class="input-group-addon  "> <input type="checkbox" name="comm.feedback4" value="Sound nervous. Needs to be more confident."></span><span class="form-control" ><font size="2">Sound nervous. Needs to be more confident. </font></span></div><br/>
                <div class="input-group"> <span class="input-group-addon  "><input type="checkbox" name="comm.feedback5" value="Not able to put across ideas properly. Trying to recall answers from memory."></span><span class="form-control" ><font size="2">Not able to put across ideas properly. Trying to recall answers from memory.</font></span></div><br/>
                <div class="input-group"> <span class="input-group-addon  "> <input type="checkbox" name="comm.feedback6" value="Listening skills is poor. Interrupting the panelist."></span><span class="form-control" ><font size="2">Listening skills is poor. Interrupting the panelist.</font></span></div><br/>
                <div class="input-group"> <span class="input-group-addon  "><input type="checkbox" name="comm.feedback7" value="Eye contact is missing. Have a better eye contact. Look at both the panelists while answering"></span><span class="form-control" ><font size="2">Eye contact is missing. Have a better eye contact. Look at both the panelists while answering</font></span></div><br/>
                  <!--  <div class="input-group"> <span class="input-group-addon  "><input type="checkbox" name="keepyouranswer" value="keepyouranswer"></span><span class="form-control" ><font size="2">Sitting very stiff. Do a little hand movement while answering. Appear energetic.</font></span></div><br/>
             <div class="input-group"> <span class="input-group-addon  "><input type="checkbox" name="keepyouranswer" value="keepyouranswer"></span><span class="form-control" ><font size="2">Communication is good. Try to keep your answers to-the-point. Be brief and be effective, but do not give close-ended answers in Yes or No</font></span></div><br/>-->
                </td></tr>
            </table></div><div id="login-wraper1">
                  <div class="panel panel-success1"> <div class="panel-heading"><font size="3" color="#000066"><strong>Preparation Feedback</strong></font> </div><table class="table" >
           
            <tr><td> <div class="input-group"> <span class="input-group-addon  "><input type="checkbox" name="Prep.feedback1" value="Lack of preparation is apparent. answer the basic HR questions confidently."></span><span class="form-control" ><font size="2">Lack of preparation is apparent. answer the basic HR questions confidently.</font> </span></div><br>
           <div class="input-group"> <span class="input-group-addon  "><input type="checkbox" name="Prep.feedback2" value="Answers lack maturity and as a result give an impression of lack of seriousness in the candidate. Please work on the same."> </span><span class="form-control" ><font size="2">Answers lack maturity and as a result give an impression of lack of seriousness in the candidate. Please work on the same.</font> </span></div><br>
            <div class="input-group"> <span class="input-group-addon  "><input type="checkbox" name="Prep.feedback3" value="Please justify whatever you have written in CV or whatever you are answering for your Introduction. Create better evidences to support your answers."></span><span class="form-control" ><font size="2">Please justify whatever you have written in CV or whatever you are answering for your Introduction. Create better evidences to support your answers.</font></span></div> <br>
            <div class="input-group"> <span class="input-group-addon  "> <input type="checkbox" name="Prep.feedback4" value="Answers can be much better. In this interview it appeared as though answers were being created on the spot rather than as a result of thorough preparation."></span><span class="form-control" ><font size="2">Answers can be much better. In this interview it appeared as though answers were being created on the spot rather than as a result of thorough preparation.</font></span></div> <br>
             <div class="input-group"> <span class="input-group-addon  "> <input type="checkbox" name="Prep.feedback5" value="Improve on your Etiquettes and mannerisms."></span><span class="form-control" ><font size="2">Improve on your Etiquettes and mannerisms. </font> </span></div> <br>
              <div class="input-group"> <span class="input-group-addon  "> <input type="checkbox" name="Prep.feedback6" value="Be calm and composed while speaking. You are trying to answer very fast."></span><span class="form-control" ><font size="2">Be calm and composed while speaking. You are trying to answer very fast.</font></span></div> 
                </td></tr>
            </table></div></div>
           
            </div>
          </div>
          <div class="clear"></div>
            <div class="submits">
        <input type="button" class="btn btn-success"  value="Back" onclick="goBack()" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                   
         <input type="submit"  class=" btn btn-success" name="submit" value="Submit"  />
       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="button" class="btn btn-success" name="reset_form" value="Reset " onclick="myfunction()"></div>  
         
            </form></div>
             <!--<div id="login-wraper1">
             <form class="" action="" name='login' method="post">
           <div class="panel panel-warning"> <div class="panel-heading"><font size="3" color="#000066"><strong>Profile</strong></font> </div><table class="table" ><tr><td>Name:</td></tr>
           <tr><td>Reg.No:</td></tr>
           <tr><td>Branch:</td></tr><tr><td>College:</td></tr><tr><td>HR Interview:</td></tr>
           <tr><td>Technical Interview:</td></tr></table></div>
           </form>
           </div>-->
   </div>
  
         <!-- <div>
          <input type="button" value="Start stopwatch" onClick="timedCount()">
          </div>  -->
           

  <footer class="white navbar-fixed-bottom">
     <font color="grey">copyright@IndusEducation. All rights reserved.</font>
    </footer>
 
    <script src="jquery.js"></script>
    <script src="bootstrap.js"></script>
    <script src="backstretch.js"></script>
    <script src="typica-login.js"></script>
</body></html>