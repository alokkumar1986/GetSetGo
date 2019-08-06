<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

if(isset($_POST['submitted']))
{
   if($fgmembersite->Adduser())
   {
        $fgmembersite->RedirectToURL("?id=addeduser");
   }
}
$fgmembersite->DBLogin();

?>

      <title>Add Faculty</title>
      
      <script type="javascript">
	 
	  	function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInp").change(function(){
        readURL(this);
    });
	  	
	  </script>
<!--<div id='fg_membersite'>--><div onload="readURL(input);">
<form id='changepwd' action='' method='post' enctype="multipart/form-data">

<fieldset>
<legend><font color="#330099" ><strong>Add User</strong></font></legend>
<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
<input type='hidden' name='submitted' id='submitted' value='1'/>
<img src="../../image/winter.jpg" width="100px"height="100px" id="blah" style="float:right;margin-top:10px;"/>
<br/>
   <input type="text" name="username" placeholder="Username"/>
    <input type="password" name="password" placeholder="Password"/><br />
<input type="text" name="fname" placeholder="Firstname"/>
<input type="text" name="lname" placeholder="Lastname"/><br />
<input type="text" name="email" placeholder="Email"/>
<input type="text" name="mobileno" placeholder="Mobileno"/><br />
<select name="typeinteviewer" id="more" style="width:206px; color:grey" ><option value="">User Type</option>
<option value="staff">Staff</option>
<option value="checker">Checker</option><option value="teacher">Teacher</option><option value="college">College</option><option value="admin">Administrator</option></select>

<select name="staff" id='staff' style="width:206px; color:grey;"><option value="" selected="selected">Interviewer Type</option><option value="COMBINE">COMBINE</option><option value="PI">PI</option><option value="TI">TI</option><option value="BOTH">BOTH</option></select>
<select name="college" id="college" class="validate[required] text-input" style="width:206px; color:grey;">
                   	<option value="" selected="selected">-Select College-</option>
                   	<?php $sql=mysql_query("select distinct(COLLEGE),COLLEGE_FULLNAME  from `student_data` ORDER BY COLLEGE asc")or die(mysql_error());
                   	while($rs=mysql_fetch_array($sql)){ ?>
					<option value="<?php echo $rs['COLLEGE']; ?>" ><?php echo $rs['COLLEGE_FULLNAME']; ?></option>	
					<?php }  ?>
                   </select>
				   <select name="teacher" id='teacher' style="width:206px; color:grey;">
				   <option value="">-Select-</option><option value="Not Set" selected="selected">Not to be set</option></select>
                   <select name="checker" id='checker' style="width:206px; color:grey;">
                   <option value="">-Select-</option><option value="checker" selected="selected">Checker</option></select>
				   <select name="admin" id='admin' style="width:206px; color:grey;"><option value="" selected="selected">-Select-</option><option value="Not Set">Not to be set</option></select>
<br/><br/>
<input type="file" name="pic" placeholder="Photo" id="imgInp" />
<br />
    <input type='submit' class="btn btn-success" name='Submit' value='Submit' />
</fieldset>
</form>
</div>
 <script type="text/javascript">
 $(document).ready(function() {
 $("#staff").hide();
 $("#college").hide();
 $("#teacher").hide();
 $("#admin").hide();
 $("#checker").hide();

  $("#more").change(function () { 

   var a=$("#more").val();
   if(a=='staff'){
   $("#staff").show();
   
 $("#college").hide();
 $("#teacher").hide();
$("#admin").hide();
$("#checker").hide(); 
   }
   if(a=='college'){
   $("#college").show();
   $("#staff").hide();
   $("#checker").hide(); 
 $("#teacher").hide();
$("#admin").hide();
   }
   if(a=='teacher'){
   $("#teacher").show();
   $("#staff").hide();
 $("#college").hide();
$("#admin").hide();
$("#checker").hide(); 
   }
   if(a=='admin'){
   $("#admin").show();
   $("#staff").hide();
 $("#college").hide();
 $("#teacher").hide();
 $("#checker").hide(); 
   }
   if(a=='checker'){
   $("#checker").show();
   $("#staff").hide();
 $("#college").hide();
 $("#teacher").hide();
 $("#admin").hide(); 
   }
  });

});
 </script>
