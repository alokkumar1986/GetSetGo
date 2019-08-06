<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

if(isset($_POST['submitted']))
{
   if($fgmembersite->Addfaculty())
   {
        $fgmembersite->RedirectToURL("?id=addedfaculty");
   }
}


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
<legend><font color="#330099" ><strong>Add Faculty</strong></font></legend>
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
<select name="typeinteviewer" style="width:206px; color:grey"><option value="">Interviewer Type</option><option value="PI">PI</option><option value="TI">TI</option><option value="BOTH">BOTH</option></select><br />
<br/><br/>
<input type="file" name="pic" placeholder="Photo" id="imgInp" />
<br />
    <input type='submit' class="btn btn-success" name='Submit' value='Submit' />
</fieldset>
</form>
</div>
 
