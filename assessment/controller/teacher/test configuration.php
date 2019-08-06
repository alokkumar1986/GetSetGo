
<script type="text/javascript">
function checkall(id)
{
$("."+id).attr("checked", "true");
var a=$('.'+id).attr('checked','checked');
if(a){
$("."+id).attr("checked", "false");
}
}
</script>
<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}
if(!$_POST['test']){
$fgmembersite->RedirectToURL("?id=configure test");
    exit;
}

if(isset($_POST['submitted'])){
if($fgmembersite->Addsectioncat())
   {         
   	    $fgmembersite->RedirectToURL("?id=configure test");
		exit;
   }
}
$fgmembersite->DBLogin();
$sql="select * from test_section_category where test_id='".$_POST['test']."'";
$rs=mysql_query($sql);
$cnt=mysql_num_rows($rs);
if($cnt>=1){
$fgmembersite->RedirectToURL("?id=testconfiguration&test=$_POST[test]");
exit;
}
?>
<div>
<form id='changepwd' action='?id=test configuration' method='post' enctype="multipart/form-data">
<fieldset style="float:center;" >
<legend><font color="#330099" ><strong>Test Configuration (Test : <?php echo $_POST['test']; ?>)</strong></font></legend>
<?php if($fgmembersite->GetErrorMessage()){ ?><div class="alert alert-danger alert-dismissable">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<?php echo $fgmembersite->GetErrorMessage();  ?> </div> <?php }  ?>
<h5>Choose the category from which you want to select questions.</h5>
<input type='hidden' name='submitted' id='submitted' value='1' />
<input type='hidden' name='test' value='<?php echo $_POST['test']; ?>'>


<?php $sql="select * from test_tests where test_id='".$_POST['test']."'";
$rs=mysql_query($sql)or die(mysql_error());
if($row=mysql_fetch_array($rs)){ 

//------ Sections -----------------------------------------//
$section=explode(',',$row['sections']); 
if(in_array('multiselect-all',$section)){
$count=(count($section)-1);
}else{
$count=count($section);
}
?>
<input name="count" type="hidden" value="<?php echo $count; ?>">
<?php for($i=1;$i<=$count;$i++){ 
if(in_array('multiselect-all',$section)){
$sql="select * from test_section where section_id='".$section[$i]."'";
}else{
$sql="select * from test_section where section_id='".$section[($i-1)]."'";
}
//echo $sql;
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
 echo "<h4>".$row['section_name']."</h4>"; 
echo "<input type='hidden' name='section".$i."' value='".$row['section_name']."'>";
	$category=$row['category'];
	/*$sql=mysql_query("select * from test_category where category_id in ($category) order by category_id")or die(mysql_error());
    while($rs=mysql_fetch_array($sql)){ 
echo "<input type='checkbox' name='cat".$i."[]'>". $rs['name'] ."&nbsp;&nbsp;&nbsp;&nbsp;";
}*/
 
 $sql1=mysql_query("select * from test_category where parent_category_id not in ($category) and category_id in ($category)")or die(mysql_error());
                   	while($rs1=mysql_fetch_array($sql1)){ 
					if($rs1['parent_category_id']!='0'){
					?>
					<input type="checkbox" name="cat<?php echo $i; ?>[]" id="<?php echo $rs1['category_id']; ?>" class="0<?php echo $i; ?>" onclick="checkall('0<?php echo $i; ?>')" value="<?php echo $rs1['name']; ?>"> <?php echo $rs1['name']; ?><br />
					<?php }
$sql11=mysql_query("select * from test_category where parent_category_id='".$rs1['category_id']."'")or die(mysql_error());
                   	while($rs11=mysql_fetch_array($sql11)){
					if($rs1['parent_category_id']!='0'){
					echo "&nbsp;&nbsp;&nbsp;&nbsp;";
					}
					?>
					<input type='checkbox' name='cat<?php echo $i; ?>[]' id='<?php echo $rs11['category_id']; ?>' class='0<?php echo $i; ?> 1<?php echo $i; ?>' onclick="checkall('1<?php echo $i; ?>')" value='<?php echo $rs11['name']; ?>'><?php echo $rs11['name']; ?><br /> 
					<?php
$sql111=mysql_query("select * from test_category where parent_category_id='".$rs11['category_id']."'")or die(mysql_error());
                   	while($rs111=mysql_fetch_array($sql111)){ 
					if($rs111['parent_category_id']!='0'){
					echo "&nbsp;&nbsp;&nbsp;&nbsp;";
					} ?>
					<input type='checkbox'  name='cat<?php echo $i; ?>[]' id='<?php echo $rs111['category_id']; ?>' class='0<?php echo $i; ?> 1<?php echo $i; ?> 2<?php echo $i; ?>' onclick="checkall('2<?php echo $i; ?>')" value='<?php echo $rs111['name']; ?>'><?php echo $rs111['name']; ?><br />
					
				<?php	$sql1111=mysql_query("select * from test_category where parent_category_id='".$rs111['category_id']."'")or die(mysql_error());
                   	while($rs1111=mysql_fetch_array($sql1111)){ 
					if($rs1111['parent_category_id']!='0'){
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					} ?>
					<input type='checkbox'  name='cat<?php echo $i; ?>[]' id='<?php echo $rs1111['category_id']; ?>' class='0<?php echo $i; ?> 1<?php echo $i; ?> 2<?php echo $i; ?> 3<?php echo $i; ?>' onclick="checkall('3<?php echo $i; ?>')" value='<?php echo $rs1111['name']; ?>'><?php echo $rs1111['name']; ?><br />
					<?php } } }}



}} ?>
<p></p>
<p> <input type='submit' class="btn btn-success" id="button1" name='Submit' value='Submit' /></p>
</fieldset>
</form>
</div>

