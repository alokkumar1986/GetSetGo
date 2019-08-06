<?PHP
require_once("../../include/membersite_config.php");
$fgmembersite->DBLogin();
if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

if(isset($_POST['submitted']))
{
   if($fgmembersite->Addbranch())
   {
        $fgmembersite->RedirectToURL("?id=addedbranch");
   }
}

?>

      <title>Add Student</title>
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
url: "college.php",
data: dataString,
cache: false,
success: function(html)
{
$("#code").html(html);
} 
});

});
$("#college").change(function()
{
var id=$(this).val();
var dataString = 'id='+ id;

$.ajax
({
type: "POST",
url: "college12.php",
data: dataString,
cache: false,
success: function(html)
{
$("#course").html(html);
} 
});

});
});
</script>
		<link rel="stylesheet" href="../../css/datepicker.css">
	  <!--<div id='fg_membersite'>--><div>
<form id='changepwd' action='' method='post' enctype="multipart/form-data">

<fieldset style="float:center;" >
<legend><font color="#330099" ><strong>Add Branch</strong></font></legend>
<p>Write your branch (e.g - Computer Science Engg, Automobile Engg etc.)</p>
<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
<input type='hidden' name='submitted' id='submitted' value='1'/>
 <select name="college" id="college" style="color: grey;">
 <option value="">-Select College-</option>
 <?php $qry=mysql_query("select DISTINCT(name) from college"); 
 while($rs=mysql_fetch_array($qry)){ ?>
 	<option value="<?php echo $rs['name']; ?>"><?php echo $rs['name']; ?></option>
 <?php }  ?>
 </select>  <br /><br /><select name="code" id="code" style="color: grey;">
 <option value="">-Select College Code-</option>
 </select><br /><br />
 <select name="course" id="course" style="color: grey;">
 <option value="">-Select Course-</option>
 </select>
 <br /><br />
<input type="text" name="branch" placeholder="Branch (eg. Computer Science Engg)"/>

<br/>
    <input type='submit' class="btn btn-success" name='Submit' value='Submit' />&nbsp;&nbsp;&nbsp;<a href="?id=upload branch" class="btn btn-danger" style="float: right;margin-left:10px;margin-right:10px;">Upload Branch CSV</a>&nbsp;&nbsp;&nbsp;<a href="?id=view branch" class="btn btn-info" style="float: right;">View Branch </a>
</fieldset>
</form>
<!-- client-side Form Validations:
Uses the excellent form validation script from JavaScript-coder.com-->





</div>
<!--
Form Code End (see html-form-guide.com for more info.)
-->
