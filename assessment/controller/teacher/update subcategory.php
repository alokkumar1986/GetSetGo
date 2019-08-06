<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../../login.php");
    exit;
}
$fgmembersite->DBLogin();
if(isset($_POST['submitted']))
{
   if(mysql_query("UPDATE  `test_category` SET  `name` =  '".$_POST['name']."', `parent_category_id`='".$_POST['category']."' WHERE  `category_id` ='".$_POST['id']."'; "))
   {
         $fgmembersite->HandleDBError("Sub-Category Updated Successfully");;
   }
}
if($_GET['action']='edit'){
//echo "select * from test_category where category_id='".$_GET['category']."'";
	$rs=mysql_query("select * from test_category where category_id='".$_GET['category']."'")or die(mysql_error());
}

?>

      <title>Update College</title>
      
     <!--<div id='fg_membersite'>--><div onload="readURL(input);">
<?php if($row=mysql_fetch_array($rs)){
	
	?> 
<form id='changepwd' action='' method='post' enctype="multipart/form-data">

<fieldset>
<legend><font color="#330099" ><strong>Update Sub-Category</strong></font></legend>
<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
<input type='hidden' name='submitted' id='submitted' value='1'/>
<input type='hidden' name='id' value='<?php echo $_GET['category']; ?>' />
<!--<img src="../../image/winter.jpg" width="100px"height="100px" id="blah" style="float:right;margin-top:10px;"/>-->
<br/>
<table style="width:68% !important;">
<tr><td>
    Sub-Category :</td><td> <input type="text" name="name" placeholder="Sub-Category Name" value="<?php echo $row['name']; ?>"/></td></tr>
  
<tr><td>Parent Category : </td><td><select name="category" class="validate[required] text-input" style="color: grey;width:98% !important;">
                   	
                   	<option value="" selected="selected">-Select Parent Category-</option>
                   	<?php $sql=mysql_query("select * from test_category where parent_category_id='0' order by name")or die(mysql_error());
                   	while($rs=mysql_fetch_array($sql)){ ?>
					<option value="<?php echo $rs['category_id']; ?>" <?php if($rs['category_id']==$row['parent_category_id']){ ?> selected="selected" <?php } ?>><?php echo $rs['name']; ?></option>
					<?php $sql1=mysql_query("select * from test_category where parent_category_id='".$rs['category_id']."'")or die(mysql_error());
                   	while($rs1=mysql_fetch_array($sql1)){ ?>
					<option value="<?php echo $rs1['category_id']; ?>" <?php if($rs1['category_id']==$row['parent_category_id']){ ?> selected="selected" <?php } ?>>&ndash;|<?php echo $rs['name']; ?>&rarr;<?php echo $rs1['name']; ?></option>	
					
					<?php $sql11=mysql_query("select * from test_category where parent_category_id='".$rs1['category_id']."'")or die(mysql_error());
                   	while($rs11=mysql_fetch_array($sql11)){ ?>
					<option value="<?php echo $rs11['category_id']; ?>" <?php if($rs11['category_id']==$row['parent_category_id']){ ?> selected="selected" <?php } ?>>&ndash;|&ndash;|<?php echo $rs['name']; ?>&rarr;<?php echo $rs1['name']; ?>&rarr;<?php echo $rs11['name']; ?></option>	
					
					<?php $sql111=mysql_query("select * from test_category where parent_category_id='".$rs11['category_id']."'")or die(mysql_error());
                   	while($rs111=mysql_fetch_array($sql111)){ ?>
					<option value="<?php echo $rs111['category_id']; ?>" <?php if($rs111['category_id']==$row['parent_category_id']){ ?> selected="selected" <?php } ?>>&ndash;|&ndash;|&ndash;|<?php echo $rs['name']; ?>&rarr;<?php echo $rs1['name']; ?>&rarr;<?php echo $rs11['name']; ?>&rarr;<?php echo $rs111['name']; ?></option>	
					<?php } } }
					 } ?>
                   </select></td></tr>
<tr><td colspan="2"><br />
</td></tr>
<tr><td colspan="2" >
    <input type='submit' class="btn btn-success" name='Submit' value='Submit' /></td></tr></table>
</fieldset>
</form>
<?php } ?>
</div>
 
