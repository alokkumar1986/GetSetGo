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

<style type="text/css">

#el01 
{
color:#00f;
font-weight: bold;
}
* { font-family: arial;
}
</style>

<script language="javascript">
   function chk_subject()
   {
       var subobj=document.getElementById('subject');
       var subject=subobj.options[subobj.selectedIndex].value;
	   
	  var catobj=document.getElementById('cat');
      var cat=catobj.options[catobj.selectedIndex].value;
	  
       if(subject!=0) 
       {
           window.location.href="?id=add_question&subject="+subject+"&cat="+cat;
       }
       else
       {
           alert("Error : Please Select the Question Type");
           return false;
       }
   } 
</script>
<!--<script src="js/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
$.ajaxSetup ({
		cache: false
	});
	var ajax_load = "Loading..";

//	load() functions
	$("#subject").change(function(){
	var q1=document.getElementById('subject').value;
	
  htmlobj=$.ajax({url:"data_load.php?q="+q1,async:false,cache:false});
  $("#result").html(htmlobj.responseText);
	});
});
</script> -->
<div>
    <form method="POST" id="add_question_form" name="add_question_form" onSubmit="return chk_subject()">
	<fieldset>
<legend><font color="#330099" ><strong>Add Questions</strong></font></legend>
<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
       <table align="left" cellpadding="5" border="0" width="100%">
            <tr>
              <td >Question Type </td>
              <td align="left">
			  <select name="question" id="subject" class="validate[required] text-input" style="color: grey;width:98% !important;">
			  <option value="">-Select Type-</option>
			  <option value="Multiple-Option">Multiple Option</option>
			  <option value="True/False">True/False</option>
			   <option value="Block-Level">Block Level</option>
			  </select>
			  </td>
			  </tr>
			  <tr><td colspan="2"><br /></td></tr>
           <tr>
              <td >Category </td>
              <td align="left">
                   <select name="category" id="cat" class="validate[required] text-input" style="color: grey;width:98% !important;">
                   	
                   	<option value="" selected="selected">-Select Parent Category-</option>
                   	<?php $sql=mysql_query("select * from test_category where parent_category_id='0' order by name")or die(mysql_error());
                   	while($rs=mysql_fetch_array($sql)){ ?>
					<option value="<?php echo $rs['category_id']; ?>"><?php echo $rs['name']; ?></option>
					<?php $sql1=mysql_query("select * from test_category where parent_category_id='".$rs['category_id']."'")or die(mysql_error());
                   	while($rs1=mysql_fetch_array($sql1)){ ?>
					<option value="<?php echo $rs1['category_id']; ?>">&nbsp;&nbsp;<?php echo $rs['name']; ?>&rarr;<?php echo $rs1['name']; ?></option>	
					
					<?php $sql11=mysql_query("select * from test_category where parent_category_id='".$rs1['category_id']."'")or die(mysql_error());
                   	while($rs11=mysql_fetch_array($sql11)){ ?>
					<option value="<?php echo $rs11['category_id']; ?>">&nbsp;&nbsp;<?php echo $rs['name']; ?>&rarr;<?php echo $rs1['name']; ?>&rarr;<?php echo $rs11['name']; ?></option>	
					
					<?php $sql111=mysql_query("select * from test_category where parent_category_id='".$rs11['category_id']."'")or die(mysql_error());
                   	while($rs111=mysql_fetch_array($sql111)){ ?>
					<option value="<?php echo $rs111['category_id']; ?>">&nbsp;&nbsp;<?php echo $rs['name']; ?>&rarr;<?php echo $rs1['name']; ?>&rarr;<?php echo $rs11['name']; ?>&rarr;<?php echo $rs111['name']; ?></option>	
					<?php } } }
					 } ?>
                   </select>
              </td>
			  
           </tr>
		   <tr><td colspan="2"><br /></td></tr>
		      
		   <tr>
                <td colspan="2">
                    <input type='button' class="btn btn-success" name='Submit' value='Submit'  onClick="chk_subject()" />
                </td>
           </tr>
        </table>
    </form>
	</fieldset>
</div>