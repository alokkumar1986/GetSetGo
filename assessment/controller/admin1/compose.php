<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}
if(isset($_POST['submitted']))
{
   if($fgmembersite->compose())
   {
        $fgmembersite->RedirectToURL("?id=compose&send=y");
   }
}
$fgmembersite->DBLogin();
?>
<script type="text/javascript" src="../../../../javascript/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
  theme : "advanced",
  theme_advanced_toolbar_location : "top",
  theme_advanced_buttons1 : "bold,italic,underline,cut,copy,paste,link,unlink,anchor,image,justifyleft,justifycenter,justifyright,justifyfull,tablecontrols,,forecolor,backcolor",
  theme_advanced_buttons2 : "",
  theme_advanced_buttons3 : "",
  theme_advanced_toolbar_location : "top",
  theme_advanced_toolbar_align : "left",
  theme_advanced_statusbar_location : "bottom",
  theme_advanced_resizing : true,
	});
</script>
<script type="text/javascript" src="../../../../javascript/jquery-2.0.1.min.js"></script>
<script type="text/javascript" src="../../../../javascript/bootstrap-2.3.2.min.js"></script>
<link rel="stylesheet" href="../../../../css/bootstrap-multiselect.css" type="text/css">
<script type="text/javascript" src="../../../../javascript/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="../../../../css/prettify.css" type="text/css">
<script type="text/javascript" src="../../../../javascript/prettify.js"></script>
<script>
	            $('.dropdown input, .dropdown label').click(function (event) {
	                event.stopPropagation();
	            });
        	</script>
<script type="text/javascript">
			    $(document).ready(function() {
			        window.prettyPrint() && prettyPrint();
					
			         $('#course1').multiselect({
			        	includeSelectAllOption: true
			        });
			        $('#branch1').multiselect({
			        	includeSelectAllOption: true
			        });
					$('#yop1').multiselect({
			        	includeSelectAllOption: true
			        });
					
			        });
			</script>
			<script type='text/javascript' src="../../../../javascript/bootstrap.min.js"></script>
<div>
<form id='changepwd' action='' method='post' enctype="multipart/form-data">
<fieldset style="float:center;" >
<legend><font color="#330099" ><strong>Compose Message</strong></font></legend>
<?php if($fgmembersite->GetErrorMessage()){ ?><div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Warning!</strong> <?php echo $fgmembersite->GetErrorMessage(); ?> </div> <?php } ?>
  <?php if($_GET['send']=='y'){ ?><div class="alert alert-info alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Success!</strong> <?php echo "Your message is sent successfully."; ?> </div> <?php } ?>
<input type='hidden' name='submitted' id='submitted' value='1'/>
<input type='hidden' name='from' id='from' value='<?php echo $_SESSION['name_of_user']; ?>'/>

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
					<p>
					<?php $cyear=date(Y); ?>
					Select Year Of Passing Out 
					<select name="yop[]" class="validate[required] text-input" id="yop" style="color: grey;width:98% !important;" multiple="multiple">
                   	
                   	<?php
					
					 for($i=$cyear;$i<=($cyear+4);$i++){ ?>
						<option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
				   <?php }?>
                   </select> 
					</p>
					<p>
					<textarea name="message" placeholder="Write Your Message." style="width:675px;">Write Your Message.</textarea>
					</p>
					<p>
                <input type='submit' class="btn btn-success" name='Submit' value='Send'  />
				</p>
           

</fieldset>
</form>
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