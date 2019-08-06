<?PHP
$path="http://localhost/new/";
//error_reporting(0);
require_once("./include/membersite_config.php");
if($fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("controller");
    exit;
}

if(isset($_POST['submitted']))
{
   if($fgmembersite->RegisterUser())
   {
        $fgmembersite->RedirectToURL("success.php");
   }
}
$fgmembersite->DBLogin();
?>


<!DOCTYPE HTML>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
   <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta charset="utf-8">
    <title>Assessment Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    
<link rel="stylesheet" href="<?php echo $path; ?>validate/css/validationEngine.jquery.css" type="text/css"/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js">
	</script>
	<script src="<?php echo $path; ?>validate/js/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8">
	</script>
	<script src="<?php echo $path; ?>validate/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8">
	</script>
	<script type="text/javascript" src="<?php echo $path; ?>javascript/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $path; ?>javascript/bootstrap-datepicker.js"></script>
	  
<script type="text/javascript">
            // When the document is ready
            $(document).ready(function () {
                
                $('#dob').datepicker({
                    format: "yyyy-mm-dd"
                });  
            
            });
        </script>
	<style>
		p{
			height:34px;
		}
		
	</style>
	<script>
	jQuery(document).ready(function(){
	$("#collegeother").hide();
	$("#universityother").hide();
	$("#courseother").hide();
	$("#branchother").hide();
	});
		function validate() {
			
		}
		function formSuccess() {
			alert('Success!');
		}
		
		function formFailure() {
			alert('Failure!');
		}
		jQuery(document).ready(function(){
			// binds form submission and fields to the validation engine
			jQuery("#formID").validationEngine({
				onFormSuccess:formSuccess,
				onFormFailure:formFailure
			});
		});

		/**
		*
		* @param {jqObject} the field where the validation applies
		* @param {Array[String]} validation rules for this field
		* @param {int} rule index
		* @param {Map} form options
		* @return an error string if validation failed
		*/
		function checkHELLO(field, rules, i, options){
			if (field.val() != "HELLO") {
				// this allows to use i18 for the error msgs
				return options.allrules.validate2fields.alertText;
			}
		}
	</script> 
    
   </head>
<body style="background:url('<?php echo $path; ?>images/background1.png');">
<div class="row-fluid" id="header-pane" style="background-color: #306bcf;padding-top:6px;padding-bottom:6px;border-top:2px solid #000;box-shadow:0px 2px 2px 2px #888888;">
            <div id="top_home" class="clear">
                <header class="clear">
                    
                    <a href="index.php"><img src="<?php echo $path; ?>images/77.gif" ></a>
                    
                   
                </header>
            </div>
        </div>
<link rel="STYLESHEET" type="text/css" href="<?php echo $path; ?>css/style.css" />
    <script type='text/javascript' src='<?php echo $path; ?>javascript/gen_validatorv31.js'></script>
    <link rel="STYLESHEET" type="text/css" href="<?php echo $path; ?>css/bootstrap.min.css" />
 <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
      
	<div class="row-fluid container" id="showcase-pane">
	<h2 style="color: #000;text-align: center;text-shadow:0px 2px 2px 2px #888;padding-top: 4px;">Create An Account</h2>
        <div id="login-signup-container" class="container">
             <div id="login-Signup-box" style="padding-top: 0px;">
             
             <div style="text-align: center !important;"><!--<p align="center" style="font-size: 80px;color:#ff0013;font-weight: bold;">Login </p>--></div>

    <div style="margin: auto;border-radius:7px;">
	
        <div style="padding:20px;margin: auto;">
            <form id="FormID" class="form login-form" action='<?php echo $fgmembersite->GetSelfScript(); ?>' name='login' method="post" autocomplete="off" style="width:100%;margin: auto;" onSubmit="return jQuery(this).validationEngine('validate');">
             
                <span align="center">                
                 <font color="#000"><?php echo $fgmembersite->GetErrorMessage(); ?></font></span>	
                
    <div class="container-fluid">
  <div class="row-fluid" style="padding-left: 56px;padding-right: 56px;">
  
    <div class="span6">
     <div class="body">
                <div class="panel panel-primary">
  <div class="panel-heading"><font size="4">Academic Details</font></div>
  <div class="panel-body">
				<input type='hidden' name='submitted' id='submitted' value='1'/>
				
                   <p>
                   <select name="state" id="state" class="validate[required] text-input" style="color: grey;width:98% !important;">
                   	<option value="">-Select State-</option>
                   	<?php $sql=mysql_query("select * from state")or die(mysql_error());
                   	while($rs=mysql_fetch_array($sql)){ ?>
					<option value="<?php echo $rs['state']; ?>" <?php if($rs['state']=='Odisha'){ ?>selected="selected" <?php } ?>><?php echo $rs['state']; ?></option>	
					<?php } ?>
                   </select>
                    </p>
                    <p id="university1">
                   <select name="university" id="university" class="validate[required] text-input" style="color: grey;width:98% !important;">
                   	<option value="">-Select University-</option>
                   	<?php $sql=mysql_query("select * from university ORDER BY university asc")or die(mysql_error());
                   	while($rs=mysql_fetch_array($sql)){ ?>
					<option value="<?php echo $rs['university']; ?>" <?php if($rs['university']=='Biju Patnaik University of Technology Rourkela'){ ?>selected="selected" <?php } ?>><?php echo $rs['university']; ?></option>	
					<?php } ?>
                   </select>
				  
                   </p>
				   <p id="universityother"> <input type="text" name="university1"  placeholder="Please Specify University" style="color: grey;width:98% !important;height:30px !important;"></p>
				   
                    <p id="college1">
                   <select name="college" id="college" class="validate[required] text-input" style="color: grey;width:98% !important;">
                   	<option value="">-Select College-</option>
                   	<?php $sql=mysql_query("select * from college where university='Biju Patnaik University of Technology Rourkela' ORDER BY name asc")or die(mysql_error());
                   	while($rs=mysql_fetch_array($sql)){ ?>
					<option value="<?php echo $rs['name']; ?>-<?php echo $rs['short_name']; ?>" ><?php echo $rs['name']; ?></option>	
					<?php } ?>
                   </select>
                    </p>
					  <p id="collegeother"> <input type="text" name="college1"  placeholder="Please Specify College" style="color: grey;width:98% !important;height:30px !important;"></p>
					<p id="course1">
                   <select name="course" id="course" class="validate[required] text-input" style="color: grey;width:98% !important;">
                   	<option value="">-Select Course-</option>
                   </select>
                    </p>
					<p id="courseother"> <select name="course1" id="course" class="validate[required] text-input" style="color: grey;width:98% !important;">
                   	<option value="">-Select Course-</option>
					<option value="B.Tech">B.Tech</option>
                   </select></p>
                    <p id="branch1">
                   <select name="branch" id="branch" class="validate[required] text-input" style="color: grey;width:98% !important;">
                   	<option value="">-Select Branch-</option>
                   </select>
                    </p>
					<p id="branchother">  <select name="branch1" id="branch" class="validate[required] text-input" style="color: grey;width:98% !important;">
                   	<option value="">-Select Branch-</option>
					<option value="Computer Science &amp; Engineering">Computer Science &amp; Engineering</option>	
										<option value="Electronics &amp; Communication Engineering">Electronics &amp; Communication Engineering</option>	
										<option value="Mechanical Engineering">Mechanical Engineering</option>	
										<option value="Civil Engineering ">Civil Engineering </option>	
										<option value="Electrical">Electrical</option>
                   </select></p>
					<p>
                    <input placeholder="Enter University Registration No." name="reg" type="text" style="width:98% !important;height:30px !important;" class="validate[required] text-input" >
                </p>
                
                   <select name="yop" class="validate[required] text-input" style="color: grey;width:98% !important;">
                   	<option value="">-Select Year Of Passing Out-</option>
                   	<?php for($i=2014;$i<=2018;$i++){ ?>
						<option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
				   <?php }?>
                   </select>
                   
                </div>
                </div>
               
    </div></div>
    <!--<div class="span1">
  </div>-->
  <div class="span6">
      <div class="body">
                
				<div class="panel panel-primary">
  <div class="panel-heading"><font size="4">Login Details</font></div>
  <div class="panel-body">
				
                   
                    <input placeholder="Enter Username" name="username" type="text" value='' style="width:99% !important;height:30px !important;" class="validate[required] text-input" >
                    
                    
                    <input placeholder="Enter Password"  name="password" type="password" style="width:49% !important;height:30px !important;" class="validate[required] text-input" >
                   <input placeholder="Re-Enter Password"  name="repassword" type="password" style="width:49% !important;height:30px !important;" class="validate[required] text-input" >
                   </div></div>
                   <div class="panel panel-primary" style="margin-top: -3px;">
  <div class="panel-heading"><font size="4">Personal Details</font></div>
  <div class="panel-body">
                 <input placeholder="Enter First Name" name="fname" type="text" style="width:49% !important;height:30px !important;" class="validate[required] text-input" >
                 <input placeholder="Enter Last Name" name="lname" type="text" style="width:49% !important;height:30px !important;" class="validate[required] text-input" >
                <input placeholder="Enter Email" name="email" type="email" style="width:49% !important;height:30px !important;" class="validate[required,custom[email]] text-input" >
                <input placeholder="Enter Mobile Number" name="mobile" maxlength="10" type="text" style="width:49% !important;height:30px !important;" class="validate[required,custom[phone]] text-input" >
                &nbsp;<input placeholder="Enter Date Of Birth" name="dob" id="dob" type="text" style="width:49% !important;height:30px !important;" class="validate[required,custom[date]] text-input" >
               
             
        <div class="input-group" style="width:96px !important;height:30px !important;float:left;margin-right: 7px;">
      <span class="input-group-addon">
        <input type="radio" name="gender" value="Male" checked="checked" >
      </span>
      <span class="form-control" style="height:31px; padding: 5px 12px !important;">Male</span>
    </div>
    <div class="input-group" style="width:103px !important;height:30px !important;float:left;">
      <span class="input-group-addon">
        <input type="radio" name="gender" value="Female" >
      </span>
      <span class="form-control" style="height:31px; padding: 5px 12px !important;">Female</span>
    </div>
   

                  
                </div>
                </div>
    </div>
  </div>
  
    
</div>
            
               
            
            </form>
            <div class="footer" style="margin:10px auto;">
                    
  
                    <p align='center'> <span align="center"><button type="submit" class="btn btn-success" name="submit" ><strong>Create An Account Now</strong></button></span>
			
               
                       <br /> <br />Already have an account? <a href="login.php"  style="text-align:center;color:red"><strong>LogIn Now</strong></a></p>
</div>
        </div></div>
		
</div>
                    </div>
                </div>
			</div>
	    </div> 
	    

<div id="wrapper" style="height:24px;position: fixed;bottom: 0;background-color: #306bcf;border-top:2px solid #000;box-shadow:0px 2px 2px 2px #888888;">
 <div id="footer1"> 
		<p align='center' style="padding:3px;">copy right &copy; 2013 Indus Education. All rights reserved.</p>
		     </div>
     </div>
<script type="text/javascript">
$(document).ready(function(){
$("#college").change(function()
{
var id=$(this).val();
var dataString = 'id='+ id;
$.ajax
({
type: "POST",
url: "course.php",
data: dataString,
cache: false,
success: function(html)
{
$("#course").html(html);
} 
});

});
});
$(document).ready(function(){
$("#course").change(function()
{
var id=$(this).val();
var id1=$('#college').val();
var dataString = 'id='+ id +'&id1='+ id1;

$.ajax
({
type: "GET",
url: "branch.php",
data: dataString,
cache: false,
success: function(html)
{
$("#branch").html(html);
} 
});

});
});
$(document).ready(function(){
$("#state").change(function()
{
var id=$(this).val();
var id1=$('#state').val();
var dataString = 'id='+ id +'&id1='+ id1;

$.ajax
({
type: "GET",
url: "university.php",
data: dataString,
cache: false,
success: function(html)
{
$("#university").html(html);
} 
});

});
});
$(document).ready(function(){
$("#university").change(function()
{

var id=$(this).val();
if(id=='Others'){
$("#universityother").show();
$("#college1").hide();
$("#collegeother").show();
$("#course1").hide();
$("#courseother").show();
$("#branch1").hide();
$("#branchother").show();
}else{
$("#universityother").hide();
$("#college1").show();
$("#collegeother").hide();
$("#course1").show();
$("#courseother").hide();
$("#branch1").show();
$("#branchother").hide();

}
var id1=$('#state').val();
var dataString = 'id='+ id +'&id1='+ id1;

$.ajax
({
type: "GET",
url: "college.php",
data: dataString,
cache: false,
success: function(html)
{
$("#college").html(html);
} 
});

});
});

</script>