<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

if(isset($_POST['submitted']))
{
   if($fgmembersite->Searchsetting())
   {
        $fgmembersite->RedirectToURL("?id=profie search setting");
   }
}
$fgmembersite->DBLogin();

?>
<script type="text/javascript" src="../../../../javascript/jquery-2.0.1.min.js"></script>
<script type="text/javascript" src="../../../../javascript/bootstrap-2.3.2.min.js"></script>
<link rel="stylesheet" href="../../../../css/bootstrap-multiselect.css" type="text/css">
<script type="text/javascript" src="../../../../javascript/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="../../../../css/prettify.css" type="text/css">
<script type="text/javascript" src="../../../../javascript/prettify.js"></script>
<script>
	            $('.dropdown input, .dropdown label').click(function (event) {
	                event.stopPropagation();
	            });
        	</script>
<script type="text/javascript">
			    $(document).ready(function() {
			        window.prettyPrint() && prettyPrint();
					
			         $('#example27').multiselect({
			        	includeSelectAllOption: true
			        });
			        $('#state').multiselect({
			        	includeSelectAllOption: true
			        });

					
			        });
			</script>
<div>
<form id='changepwd' action='' method='post' enctype="multipart/form-data">

<fieldset>
<legend><font color="#330099" ><strong>Profile Search Setting </strong></font></legend>
<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
<p><strong>Select Year Of Passing Out</strong></p>
<p>
 <select name="yop[]" style="color: grey;" id="example27" multiple="multiple">
 	<?php $sq="select distinct COURSE_YOP from student_data ORDER BY COURSE_YOP asc ";
$r=mysql_query($sq);
$r1=mysql_query("select * from search where id='1'");
if($rw1=mysql_fetch_array($r1)){
	$yop=explode(",",$rw1['yop']);
while($result=mysql_fetch_array($r)){
	?>
	<option value="<?php echo $result['COURSE_YOP']; ?>" <?php if(in_array($result['COURSE_YOP'],$yop)){ ?> selected="selected" <?php } ?>><?php echo $result['COURSE_YOP']; ?></option>
	<?php } } ?>
 </select>
</p>
<p><span><strong>Check Your Prefered College</strong></span>   <span style="float: right;"><strong>Sort By State</strong> : <select name="state[]" id="state" style="color: grey;"  multiple="multiple">
 	<?php $sq2="select distinct state from state ORDER BY state asc ";
$r2=mysql_query($sq2);

while($result2=mysql_fetch_array($r2)){
	?>
	<option value="<?php echo $result2['state']; ?>" ><?php echo $result2['state']; ?></option>
	<?php } ?>
 </select></span></p>
<input type='hidden' name='submitted' id='submitted' value='1'/>
<div class="row" id="row" style="padding-left:20px;padding-top: 10px;">
<?php $sql="select distinct COLLEGE from student_data";
$rs=mysql_query($sql);
$rs1=mysql_query("select * from search where id='1'");
if($row1=mysql_fetch_array($rs1)){
	$college=explode(",",$row1['college']);
while($row=mysql_fetch_array($rs)){
	$mysql=mysql_query("select name from college where short_name='".$row['COLLEGE']."'");
	if($resultset=mysql_fetch_array($mysql)){
	$collgefullname=$resultset['name'];	
	}
	?>
	
  <div class="col-lg-9" style="margin-bottom: 3px;">
	<div class="input-group">
      <span class="input-group-addon"><input type="checkbox" class="case" name="college[]" <?php if(in_array($row['COLLEGE'],$college)){ ?> checked="checked" <?php } ?> value="<?php echo $row['COLLEGE']; ?>"/></span>  <input type="text" class="form-control" value="<?php echo $collgefullname; ?>(<?php echo $row['COLLEGE']; ?>)" /></div></div>
	<?php
} 
} 
 ?> 
 </div>
<br />
   <p> <input type='submit'  id="button" class="btn btn-success" name='Submit' value='Update' />  <span style="float: right;"><a id="check-all" class="btn btn-default" href="javascript:void(0);">Select All</a>
<a id="uncheck-all" class="btn btn-default" href="javascript:void(0);">Deselect All</a></span></p>
</fieldset>
</form>
</div>
<script type='text/javascript' src="../../../../javascript/bootstrap.min.js"></script>
       <script>
       $('#check-all').click(function(){
    $(".case").attr('checked', true);
  });
  $('#uncheck-all').click(function(){
    $(".case").attr('checked', false);
  });
 
 $(document).ready(function(){
 $('#button').button();

 $('#button').click(function() {
 	
		$(this).button('loading');
	
   
 });
 
$("#state").change(function()
{
var id=$(this).val();
var dataString = 'id='+ id;

$.ajax
({
type: "POST",
url: "college122.php",
data: dataString,
cache: false,
success: function(html)
{
$("#row").html(html);
} 
});

});

});  

</script>
 