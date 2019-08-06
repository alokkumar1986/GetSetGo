<?PHP
require_once("../../include/membersite_config.php");
if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}
if(isset($_POST['submitted']))
{
   if($fgmembersite->Addcategory())
   {
   	    
        $fgmembersite->HandleDBError("Sub-Category Added Successfully");
   }
}
$fgmembersite->DBLogin();

?>

      <title>Add Sub-Category</title>
      
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
<legend><font color="#330099" ><strong>Add Sub-Category</strong></font></legend>

<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
<input type='hidden' name='submitted' id='submitted' value='1' />
<p><select name="category" class="validate[required] text-input" style="color: grey;width:98% !important;">
                   	
                   	<option value="" selected="selected">-Select Parent Category-</option>
                   	<?php $sql=mysql_query("select * from test_category where parent_category_id='0' order by name")or die(mysql_error());
                   	while($rs=mysql_fetch_array($sql)){ ?>
					<optgroup label="<?php echo $rs['name']; ?>">
					<option value="<?php echo $rs['category_id']; ?>"><?php echo $rs['name']; ?></option>
					<?php $sql1=mysql_query("select * from test_category where parent_category_id='".$rs['category_id']."'")or die(mysql_error());
                   	while($rs1=mysql_fetch_array($sql1)){ ?>
					<option value="<?php echo $rs1['category_id']; ?>"><?php echo $rs['name']; ?>&rarr;<?php echo $rs1['name']; ?></option>	
					
					<?php $sql11=mysql_query("select * from test_category where parent_category_id='".$rs1['category_id']."'")or die(mysql_error());
                   	while($rs11=mysql_fetch_array($sql11)){ ?>
					<option value="<?php echo $rs11['category_id']; ?>"><?php echo $rs['name']; ?>&rarr;<?php echo $rs1['name']; ?>&rarr;<?php echo $rs11['name']; ?></option>	
					
					
					<?php $sql111=mysql_query("select * from test_category where parent_category_id='".$rs11['category_id']."'")or die(mysql_error());
                   	while($rs111=mysql_fetch_array($sql111)){ ?>
					<option value="<?php echo $rs111['category_id']; ?>"><?php echo $rs['name']; ?>&rarr;<?php echo $rs1['name']; ?>&rarr;<?php echo $rs11['name']; ?>&rarr;<?php echo $rs111['name']; ?></option>	
					<?php } } }
					 } ?>
					 </optgroup>
                   </select>
                   </p>
<input type="text" name="name" placeholder="Sub-Category Name" />



<br/>
    <input type='submit' class="btn btn-success" id="button1" name='Submit' value='Submit' /> &nbsp;&nbsp;&nbsp;<!--<a href="?id=upload category" class="btn btn-danger" style="float: right;margin-left:10px;margin-right:10px;">Upload Subject/Category CSV</a>-->&nbsp;&nbsp;&nbsp;<a href="?id=view sub-Category" class="btn btn-info" style="float: right;">View Sub-Category </a>
</fieldset>
</form>
<!-- client-side Form Validations:
Uses the excellent form validation script from JavaScript-coder.com-->





</div>
<!--
Form Code End (see html-form-guide.com for more info.)
-->
<script type='text/javascript' src="../../../../javascript/bootstrap.min.js"></script>
<script> 
 $(document).ready(function(){
 $('#button1').button();

 $('#button1').click(function() {
 	
		$(this).button('loading');
	
   
 });
</script>