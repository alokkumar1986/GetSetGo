<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
$fgmembersite->DBLogin();
?>

      <title>Personal Interview Report</title>
      <!--<link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css" />-->
      <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
     <!-- <link rel="STYLESHEET" type="text/css" href="style/pwdwidget.css" />-->
      <script src="scripts/pwdwidget.js" type="text/javascript"></script>    
	  <script type= "text/javascript" src = "../../js/college.js"></script>
	  <script type="text/javascript" src="../../js/bootstrap-datepicker.js"></script>
	  
<script type="text/javascript">
            // When the document is ready
            $(document).ready(function () {
                
                $('#date2').datepicker({
                    format: "yyyy/mm/dd"
                });  
            
            });
        </script>
		<script type="text/javascript">
$(document).ready(function(){
$("#college").change(function()
{
var id=$(this).val();
var dataString = 'id='+ id;

$.ajax
({
type: "POST",
url: "../../../student/course.php",
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
url: "../../../student/branch.php",
data: dataString,
cache: false,
success: function(html)
{
$("#branch").html(html);
} 
});

});
});
</script>

        <style type="text/css">
        	select {
				
				width:207px;
			}
			.input-group{
				width:97px;
			}
        </style>
		<link rel="stylesheet" href="../../css/datepicker.css">
	  <!--<div id='fg_membersite'>--><div>
<form id='changepwd' action='?id=result' method='post' enctype="multipart/form-data">

<fieldset style="float:center;" >
<legend><font color="#330099" ><strong>Interview Report Generation</strong></font></legend>
<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
<input type='hidden' name='submitted' id='submitted' value='1'/>
<p><select name="college" id="college" class="validate[required] text-input" style="color: grey;width:98% !important;">
                   	<option value="">-Select College-</option>
                   	<?php $sql=mysql_query("select distinct(COLLEGE),COLLEGE_FULLNAME  from `student_data` ORDER BY COLLEGE asc")or die(mysql_error());
                   	while($rs=mysql_fetch_array($sql)){ ?>
					<option value="<?php echo $rs['COLLEGE_FULLNAME']; ?>-<?php echo $rs['COLLEGE']; ?>" ><?php echo $rs['COLLEGE_FULLNAME']; ?></option>	
					<?php } ?>
                   </select></p>
				   <p> Select Course 
                   <select name="course" id="course" class="validate[required] text-input" style="color: grey;width:98% !important;">
                   	
                   
                   </select> 
				   </p>
                    <p> Select Branch
                   <select name="branch[]" id="branch" class="validate[required] text-input" style="color: grey;width:98% !important;" multiple="multiple">
                   	
                   </select> 
                    </p>
					
					<input type="text" name="date"  id="date2" placeholder="Date Of Interview" style="margin-top: 7px;"/>

<br/><br/>

<select style="color:#808080" name="interviewtype">
<?php if($_SESSION['actingrole']=='PI'){?>
	<option value="PI" selected="selected">Personal Interview</option>
<?php } ?>
<?php if($_SESSION['actingrole']=='TI'){?>
	<option value="TI" selected="selected">Technical Interview</option>
<?php } ?>
<?php if($_SESSION['actingrole']=='BOTH'){?>
	<option value="PI" selected="selected">Personal Interview</option>
<option value="TI">Technical Interview</option>
<?php } ?>

</select>&nbsp;&nbsp;&nbsp;<input type="text" name="interviewer" value="<?php echo $_SESSION['name_of_user']; ?>" readonly="readonly" style="margin-top: 7px;"> 
   <br />
<br/>
 <p align="left">   <input type='submit' class="btn btn-danger" name='Submit' value='Find Result'  />   </p>
</fieldset>
</form>
</div>
