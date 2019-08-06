<?PHP //session_start();
//error_reporting(0);

?>
<?php
/* If you refresh the page
   or
   leave the page to browse and come back
   then the timer will continue to count down until finished. */

// $minutes and $seconds are added together to get total time.
$minutes = 10; // Enter minutes
$seconds = 0; // Enter seconds
$time_limit = ($minutes * 60) + $seconds + 1; // Convert total time into seconds
if(!isset($_SESSION["start_time"])){$_SESSION["start_time"] = mktime(date(G),date(i),date(s),date(m),date(d),date(Y)) + $time_limit;} // Add $time_limit (total time) to start time. And store into session variable.
?>

<!doctype html>
<html lang="en-US">
	<meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	<title>Verbal/Email Writting Test</title>
<!--
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Varela+Round">-->
	    
    <!-- <link href="../css/bootstrap.css" rel="stylesheet"> -->
      <link href="../css/bootstrap.min.css" rel="stylesheet">
      <link href="../css/onlinestyle.css" rel="stylesheet">
     <link href="../css/api.css" rel="stylesheet">
     <link href="../css/reset.css" rel="stylesheet">
     <link rel="shortcut icon" href="http://induseducation.in/favicon.ico" />
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
width:70px;
text-align:center;
color:#000000;
 }
 </style>
  <style>
    .btn,pre{
    margin:10px;
}
 </style>
   <script src="../js/jquery.min.js" type="text/javascript"></script>     
   <script src="../js/bootstrap.min.js"></script>
		<script src="../js/jquery.textareaCounter.plugin.js" type="text/javascript"></script>
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

</head>

<body >
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
	<div class="panel panel-primary"> <div class="panel-heading"><font size="5" color="#000066"><center><strong>Verbal Ability Test</strong></center></font> </div>
	<table class="table" >
	<tr><td>
    <input id="txt" readonly>
    
<br/>
<?php $sql = 'SELECT * FROM verbalquestion';
$result = mysql_query($sql);
$count=mysql_num_rows($result);
$id=rand(1,$count);
$sql1 = 'SELECT * FROM verbalquestion where ID="'.$id.'"';
$result1 = mysql_query($sql1)or die(mysql_error());
if($row=mysql_fetch_array($result1))
{
	echo $row['VERBAL_QUESTION'];
} 
?>
<form  action='result.php' method='post' enctype="multipart/form-data">
<input type='hidden' name='submitted' id='submitted' value='1'/>
<input type='hidden' name='queid'  value='<?php echo $id; ?>'/>
<input type='hidden' name='REG_NO'  value='<?php echo  $_SESSION['REG_NO']; ?>'/>
    <br/>
    <textarea id="testTextarea" name="answer" cols="100" rows="10"></textarea>
    <p><input type="button" name="submit" class="btn btn-success" value="Submit" onClick="show_confirm()" ></p>
     
    <pre id="output"></pre> 
 
 <div id="confirmModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
  <div class="modal-header"> 
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
   <!-- <h3 id="myModalLabel">Delete?</h3>  -->
  </div> 
  <div class="modal-body"> 
    <p>Are you sure you want to submit the answer?</p> 
  </div> 
  <div class="modal-footer"> 
    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Cancel</button> 
    <button onClick="ok_hit()" class="btn btn-success">OK</button> 
  </div> 
</div> 
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
      

<script>
var ct = setInterval("calculate_time()",100); // Start clock.
function calculate_time()
{

 var end_time = "<?php echo $_SESSION["start_time"]; ?>"; // Get end time from session variable (total time in seconds).
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
   alert("The time is up.");
   }
  }
 }
</script>

   
</body>	
</html>