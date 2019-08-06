<?php
require_once("../../include/membersite_config.php");
$fgmembersite->DBLogin();
if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

if(isset($_POST['submitted']))
{
        if(empty($_POST['college']))
        {
            $fgmembersite->HandleError("College is empty!");
            return false;
        }
        if(empty($_POST['name']))
        {
            $fgmembersite->HandleError("File Name is empty!");
            return false;
        }
        if(empty($_FILES['file']['name']))
        {
            $fgmembersite->HandleError("File is empty!");
            return false;
        }
        $pic=$_FILES['file']['name'];
        $pic_tmp=$_FILES['file']['tmp_name'];
        $qry="insert into materials (`id`, `name`, `college`, `file`, `addeddate`) VALUES (NULL, '$_POST[name]', '$_POST[college]', '$pic', CURDATE());";
           if(!mysql_query( $qry ,$fgmembersite->connection))
        {
            $fgmembersite->HandleDBError("Error inserting data into database \nquery:$qry");
            return false;
        }else{
			move_uploaded_file($pic_tmp,'materials/'.$pic);
		}
        $fgmembersite->RedirectToURL("?id=added material");
  
}
$fgmembersite->DBLogin();
?>
 <fieldset>
<legend><font color="#330099" ><strong>Add Materials </strong></font></legend>
		<form id='changepwd' action='' method='post' enctype="multipart/form-data">

<fieldset>
<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
<div>
<input type='hidden' name='submitted' id='submitted' value='1'/>
<p><select name="college" style="color: grey;">
<option value="">-Select College-</option>
<?php $sql="select distinct(COLLEGE),COLLEGE_FULLNAME from student_data ";
	$rs=mysql_query($sql);
	while($row=mysql_fetch_array($rs)){ ?>
<option value="<?php echo $row['COLLEGE']; ?>"><?php echo $row['COLLEGE_FULLNAME']; ?></option>
<?php } ?>
</select></p>
<p><input type="text" id="name" name="name" placeholder="Name Of The File" style="width:220px;"/><br />
<input type="file" id="file" name="file" placeholder="Choose File to Upload" /></p>

<p><input type="submit" name="submit" id="button" value="Save" class="btn btn-success"/></p>	
	
</div>
</fieldset>
</form>
<script type='text/javascript' src="../../../../javascript/bootstrap.min.js"></script>
       <script>
 
 $(document).ready(function(){
 $('#button').button();

 $('#button').click(function() {
 	var a=document.getElementById('name').value;
 	var b=document.getElementById('file').value;
 	
 	if(a!='' && b!='' ){
		$(this).button('loading');
	}
   
 });  
});
</script>