<?PHP ob_start();
ob_end_flush();
// require_once("../../include/membersite_config.php");

// if(!$fgmembersite->CheckLogin())
// {
//     $fgmembersite->RedirectToURL("../../login.php");
//     exit;
// }

if(isset($_POST['submitted']))
{        
        $pic= time().$_FILES['filePhoto']['name'];

        $arrConditions = array('regdno' => $_SESSION['regno_of_user'], 'pic' => $pic);
        $student_data = $fgmembersite->getWhereCustomActionValues("USP_STUDENT_DATA", "UPIC", $arrConditions);
        if(!empty($student_data['result'])){
           move_uploaded_file($_FILES['filePhoto']['tmp_name'],'uploads/'.$pic);
           $url=base64_encode('changedphoto');
           include("changedphoto.php");exit;
           //$fgmembersite->RedirectToURL("?id=$url");
        }else{

          $fgmembersite->HandleDBError("Error inserting data into database \nquery:$qry");
          //return false;
        }
  }
// if(isset($_GET['student'])){
// 	$rs=mysql_query("select * from `student_data` where REG_NO='$_GET[student]'");
// }

?>

      <title>Profile Photo Change</title>
      
      <style>
	   table,tr, td{
	 border:none !important;
	 }
	 .btn2 {
  background: #1aad41;
  background-image: -webkit-linear-gradient(top, #1aad41, #198a4e);
  background-image: -moz-linear-gradient(top, #1aad41, #198a4e);
  background-image: -ms-linear-gradient(top, #1aad41, #198a4e);
  background-image: -o-linear-gradient(top, #1aad41, #198a4e);
  background-image: linear-gradient(to bottom, #1aad41, #198a4e);
  -webkit-border-radius: 5;
  -moz-border-radius: 5;
  border-radius: 5px;
  font-family: Georgia;
  color: #ffffff;
  font-size: 18px;
  padding: 4px 8px 4px 8px;
  text-decoration: none;
    color:#FFFFFF !important;

}

.btn2:hover {
  background: #249113;
  background-image: -webkit-linear-gradient(top, #249113, #0d8f16);
  background-image: -moz-linear-gradient(top, #249113, #0d8f16);
  background-image: -ms-linear-gradient(top, #249113, #0d8f16);
  background-image: -o-linear-gradient(top, #249113, #0d8f16);
  background-image: linear-gradient(to bottom, #249113, #0d8f16);
  text-decoration: none;
}
	  </style>
	 
<!--<div id='fg_membersite'>--><div>
<?php
  $row= $student_data;
  //print_r($row);exit;
	$name=explode(" ",$row['Staff_Name']);
	$fname=$name[0];
	$lname=$name[1];
	?> 
<form id='changepwd' action='' method='post' enctype="multipart/form-data" >

<fieldset>
<legend><font color="#330099" ><strong>Change Your Profile Photo</strong></font></legend>
<div onload="readURL();"><span class='error'><?php //echo $fgmembersite->GetErrorMessage(); ?></span></div>
<?php if(!empty($fgmembersite->GetErrorMessage())){ ?>
<div class="alert alert-danger alert-dismissible fade in">
<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
</strong> <?php echo $fgmembersite->GetErrorMessage(); ?>
</div>
<?php } ?>
<input type='hidden' name='submitted' id='submitted' value='1'/>
<input type='hidden' name='user' value='<?php echo $_GET['student']; ?>' />
<!--<img src="../../image/winter.jpg" width="100px"height="100px" id="blah" style="float:right;margin-top:10px;"/>-->
<?php //echo dirname(__FILE__).'/uploads/'.$row['PIC']; ?>
<br/>
<div style="float:right;margin-left:20px;margin-right:50px;width:105px;"> <img <?php if($row['PIC']!='' && file_exists(dirname(__FILE__).'/uploads/'.$row['PIC'])){ ?>src="uploads/<?php echo $row['PIC']; ?>" <?php }else { ?>src="../example/profile.jpg" <?php } ?> width="100px"height="100px" style="margin-top:10px;border:2px solid #ccc;" id="previewHolder" alt="Uploaded Image Preview Holder"/>
</div>
<table style="width:68% !important;">
<tr><td>
<input type="file" name="filePhoto" required value="" id="filePhoto" class="required borrowerImageFile" data-errormsg="PhotoUploadErrorMsg" onclick="readURL(input);">
   </td></tr>
<tr><td>
<p>
</p></td></tr>
<tr><td>
    <input type='submit' class="btn2 btn-success" name='Submit' value='Submit' /></td></tr></table>
</fieldset>
</form>

</div>
<script type="javascript">
	  	function readURL(input) {
           if (input.files && input.files[0]) {
               var reader = new FileReader();
               reader.onload = function(e) {
                   $('#previewHolder').attr('src', e.target.result);
               }

               reader.readAsDataURL(input.files[0]);
           }
       }
       $("#filePhoto").change(function() {
           readURL(this);
       });
	  </script>
 