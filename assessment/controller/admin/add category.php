<?PHP
require_once("../../include/membersite_config.php");
if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}
if(isset($_POST['submitted']))
{
   if($fgmembersite->Addcategory1())
   {
   	    
        $fgmembersite->HandleDBError("Category Added Successfully");
   }
}
$fgmembersite->DBLogin();

?>

      <title>Add Student</title>
      
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
<legend><font color="#330099" ><strong>Add Test Category(Parent)</strong></font></legend>

<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
<input type='hidden' name='submitted' id='submitted' value='1' />
<input type="text" name="name" placeholder="Main Category Name" />



<br/>
    <input type='submit' class="btn btn-success" id="button1" name='Submit' value='Submit' /> &nbsp;&nbsp;&nbsp;<!--<a href="?id=upload category" class="btn btn-danger" style="float: right;margin-left:10px;margin-right:10px;">Upload Subject/Category CSV</a>-->&nbsp;&nbsp;&nbsp;<a href="?id=view Category" class="btn btn-info" style="float: right;">View all Category </a>
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