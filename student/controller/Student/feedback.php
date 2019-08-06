<?PHP session_start(); 
require_once("../../include/membersite_config.php");
error_reporting(0);
if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}
$fgmembersite->DBLogin();
$sql=mysql_query("select * from feedback where college='".$_SESSION['college']."' and CURDATE() between startdate and enddate")or die(mysql_error()); 
$count=mysql_num_rows($sql);
$row=mysql_fetch_array($sql);
if($count>=1){
$qry=mysql_query("select count(*) from feedbackans where regno='".$_SESSION['regno_of_user']."'") or die(mysql_error());
$row1=mysql_fetch_array($qry);
if($row1['count(*)']<$row['attempt']){
?>
<link rel="stylesheet" href="../../../assessment/css/bootstrap.min.css">
<link href="../../../assessment/css/bootstrap-responsive.css" rel="stylesheet">

    <link rel="stylesheet" href="../../../assessment/css/typica-login.css">
	<link href="../../../assessment/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../../../assessment/css/style.css">
    
  <script type="text/javascript" src="../../../assessment/js/bootstrap-modal.js"></script>
    <script type="text/javascript" src="../../../assessment/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="../../../assessment/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../../assessment/js/jquery-ui.js"></script>
	<script src="../../../assessment/js/jquery-ui-1.8.21.custom.min.js"></script>
 
	<link rel="stylesheet" href="../../../assessment/css/jquery-ui.css"> 
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
	$(function() {
		$( "#slider-range-min8" ).slider({
			range: "min",
			value: 0,
			min: 0,
			max: 5,
			step: 0.5,
			slide: function( event, ui ) {
				$( "#amount8" ).val( ui.value );
			}
		});
		$( "#amount7" ).val( $( "#slider-range-min8" ).slider( "value" ) );
	});
	</script>
<div>
			
			<form action="savefeedback.php" method="post" >
<div class="panel panel-success"> <div class="panel-heading"><font size="3" color="#000066"><center><strong>Feeedback</strong></center></font> </div>
<div style="margin: 10px 0px 0px 36px">
<p style="text-align:right"><?php echo $row1['count(*)']; ?> of <?php echo $row['attempt']; ?> Attempts</p>
<p>Feedback parameters :&nbsp; &nbsp; &nbsp; &nbsp; 
<b>1- Poor &nbsp; &nbsp; &nbsp; &nbsp; 
2- Average &nbsp; &nbsp; &nbsp; &nbsp; 
3- Good    &nbsp; &nbsp; &nbsp; &nbsp;                     
4- Very Good &nbsp; &nbsp; &nbsp; &nbsp; 
5- Excellent 
</b>
</p>
</div>


             <table class="table" style="width:94%;padding:10px;" align="center">
           
            <tr><td width="90%" colspan="2">
            <strong>1) &nbsp;Do you like to attend more of these kind of Program?  (Yes/NO)</strong>
           <br /> 
            <br />
	        <input type="radio" name="1" value='Yes' checked/> &nbsp; &nbsp; <b>Yes</b> 
            &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; <input type="radio" name="1" value='No' /> &nbsp; &nbsp; <b>No</b> 
           </td></tr>
           <tr><td width="90%"> 
           <strong>2) &nbsp; Quality of classes conducted (Scale)? </strong><br /> <br /><div id="slider-range-min4"></div><br /></td>
           <td width="10%">
	<input type="text" id="amount4" name="2" style="border:1; width:30px; color:#f6931f; font-weight:bold;" readonly="readonly" required="required">  
           </td></tr>
           <tr><td width="90%"> 
           <strong>3) &nbsp;How do you find the  trainers who have conducted Training (Scale)?</strong><br /><br /><div id="slider-range-min5"></div><br /></td>
           <td width="10%">
	
<input type="text" id="amount5" name="3" style="border:1; width:30px; color:#f6931f; font-weight:bold;" readonly="readonly" required="required">  
		   </td></tr>
           <tr><td width="90%"> 
           <strong>4) &nbsp; Overall Assessment of the training Program (Scale)?</strong><br /><br /><div id="slider-range-min3"></div><br /></td>
           <td width="10%">
	
<input type="text" id="amount3" name="4"  style="border:1; width:30px; color:#f6931f; font-weight:bold;" readonly="readonly" required="required">  
		   </td></tr>
           
           <tr><td width="90%" colspan="2"> 
           <strong>5) &nbsp;Please write a few lines about the training program. Your feedback could be negative or positive but please ensure it is constructive:   (Subjective Section)</strong><br /><br />
	
<textarea name="5" cols='107' rows="6" required></textarea>
		   </td></tr>
            </table></div>
            
            <center><input type="submit" class="btn btn-danger" value='Submit Feedback'/></center>
            </form>
            
 <?php }else{
	 
	 ?>
	 <h1 align="center" style="margin: 10px 0px 0px 36px">You have attempted the maximum number of feedback system. No more attempt is allowed.</h1>
  <?php }  }else { ?>
	 <h1 align="center" style="margin: 10px 0px 0px 36px">No feedback setting found for your college <?php echo $_SESSION['college']; ?> college. No feedback is activated.</h1>
  <?php } ?>
            
