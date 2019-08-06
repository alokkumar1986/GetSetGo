<?php
require_once("checklogin.php");
$fgmembersite->DBLogin();
if(isset($_POST['submitted']))
{
   if($fgmembersite->Addinstance())
   {
        $fgmembersite->RedirectToURL("?id=instances");
   }
}
?>
 <style type="text/css">
        	select {
				
				width:207px;
			}
			.input-group{
				width:97px;
			}
        </style>
       <script type="text/javascript">
	  $(document).ready(function(){
	 $("#college").change(function()
{
var id=$(this).val();
var dataString = 'id='+ id;

$.ajax
({
type: "POST",
url: "../admin/college1.php",
data: dataString,
cache: false,
success: function(html)
{
$("#shortname").html(html);
} 
});

});
});
</script>
<fieldset>
<legend><font color="#330099" ><strong>Interview Instance Setting</strong></font></legend>
		<form id='changepwd' action='' method='post' enctype="multipart/form-data">
		<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
<input type='hidden' name='submitted' id='submitted' value='1'/>
 <p>
 <select name="college" id="college" style="color: grey;">
 <option value="">-Select College-</option>
 <?php $qry=mysql_query("select DISTINCT(COLLEGE),COLLEGE_FULLNAME from student_data"); 
 while($rs=mysql_fetch_array($qry)){ ?>
 	<option value="<?php echo $rs['COLLEGE']; ?>"><?php echo $rs['COLLEGE_FULLNAME']; ?></option>
 <?php }  ?>
 </select> </p>
 <p><select name="shortname" id="shortname" style="color: grey;">
 <option value="">-Select College Shortname-</option>
 </select>
</p>
<p><select name='email' id='email' style='color: grey'>
<option value="">-Select Email-</option>
<option value="yes">Yes</option><option value="no">No</option>
</select>
</p>
<input type="number" name="instance" placeholder="Instance Number "/>

<br/>
    <input type='submit' class="btn btn-success" name='Submit' value='Submit' />&nbsp;&nbsp; &nbsp;&nbsp;<a href="?id=instances" style="color: #000; " > See All Instances</a>
   
		</form>
<fieldset>