<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

if(isset($_POST['submitted']))
{
   if($fgmembersite->Adduniversity())
   {
        $fgmembersite->RedirectToURL("?id=addeduniversity");
   }
        
       
    }

$fgmembersite->DBLogin();

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
		<link rel="stylesheet" href="../../css/datepicker.css">
	  <!--<div id='fg_membersite'>--><div>
<form id='changepwd' action='' method='post' enctype="multipart/form-data">

<fieldset style="float:center;" >
<legend><font color="#330099" ><strong>Add University </strong></font></legend>
<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
<input type='hidden' name='submitted' id='submitted' value='1'/>
  
<p><select name="state" class="validate[required] text-input" style="color: grey;width:98% !important;">
                   	<option value="">-Select State-</option>
                   	<?php $sql=mysql_query("select * from state")or die(mysql_error());
                   	while($rs=mysql_fetch_array($sql)){ ?>
					<option value="<?php echo $rs['state']; ?>" <?php if($rs['state']=='Odisha'){ ?>selected="selected" <?php } ?>><?php echo $rs['state']; ?></option>	
					<?php } ?>
                   </select>
    </p>
<p>
                   <input type="text" name="university" class="validate[required] text-input" value="" />
    </p>
<br/>
    <input type='submit' class="btn btn-success" name='Submit' value='Submit' /> &nbsp;&nbsp;&nbsp;<a href="?id=upload college" class="btn btn-danger" style="float: right;margin-left:10px;margin-right:10px;">Upload College CSV</a>&nbsp;&nbsp;&nbsp;<a href="?id=view college" class="btn btn-info" style="float: right;">View College </a>
</fieldset>
</form>
<!-- client-side Form Validations:
Uses the excellent form validation script from JavaScript-coder.com-->





</div>
<!--
Form Code End (see html-form-guide.com for more info.)
-->
