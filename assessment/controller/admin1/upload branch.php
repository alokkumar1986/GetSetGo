<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

if(isset($_POST['submitted']))
{
   if($fgmembersite->Uploadbranch())
   {
        //$fgmembersite->RedirectToURL("?id=uploadedfaculty");
   }
}

?>

      <title>Upload Branch(csv format)</title>
      
<div>
<form id='changepwd' action='' method='post' enctype="multipart/form-data">

<fieldset>
<legend><font color="#330099" ><strong>Upload Branch(.csv file)</strong></font></legend>
<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
<input type='hidden' name='submitted' id='submitted' value='1'/>
<p>
<input type="file" name="pic" placeholder="Choose CSV File" id="imgInp" accept=".csv" /></span></p>

    <input type='submit' class="btn btn-success" id="button" name='Submit' value='Submit' />
</fieldset>
</form>
</div>
 
<script type='text/javascript' src="../../../../javascript/bootstrap.min.js"></script>
       <script>
 
 $(document).ready(function(){
 $('#button').button();

 $('#button').click(function() {
 	
		$(this).button('loading');
	
   
 });  
});
</script>