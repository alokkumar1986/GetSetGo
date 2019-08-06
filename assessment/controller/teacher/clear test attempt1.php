<?PHP 
require_once("../../include/membersite_config.php");
//error_reporting(0);
if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}
$fgmembersite->DBLogin();

if(isset($_POST['submit'])){
//echo "alok";
$yop=str_replace("multiselect-all,"," ",implode(",",$_POST['yop']));
//echo "select * from student_data where COLLEGE='$_POST[shortname]' AND BRANCH='$_POST[branch]' AND COURSE_YOP in ($yop)";
$sel=mysql_query("select * from `student_data` where COLLEGE='$_POST[shortname]' AND BRANCH='$_POST[branch]' AND COURSE_YOP in ($yop)")or die(mysql_error());
while($res=mysql_fetch_array($sel)){
$sql="delete from `temp_test_result` where (candidate='$res[REG_NO]' and test_id='$_POST[test]')";
$rs=mysql_query($sql) or die(mysql_error());
$sql1="delete from `test_status` where (candidate='$res[REG_NO]' and test_id='$_POST[test]')";
$rs1=mysql_query($sql1) or die(mysql_error());
$sql2="delete from `student_result` where (reg_no='$res[REG_NO]' and test_id='$_POST[test]')";
$rs2=mysql_query($sql2);
$sql3="delete from `test_timer` where (candidate='$res[REG_NO]' and test_id='$_POST[test]')";
$rs3=mysql_query($sql3);
$sql4="delete from `test_timer2` where (candidate='$res[REG_NO]' and test_id='$_POST[test]')";
$rs4=mysql_query($sql4);
if($rs || $rs1){
$_SESSION['msg']="test cleared";
}
}
}
$page=$_GET['id'];
?>
 <script type="text/javascript">
	  $(document).ready(function(){
	 $("#college").change(function()
{
var id=$(this).val();
var dataString = 'id='+ id;

$.ajax
({
type: "POST",
url: "../admin/college11.php",
data: dataString,
cache: false,
success: function(html)
{
$("#shortname").html(html);
} 
});

});
$("#college").change(function()
{
var id=$(this).val();
var dataString = 'id='+ id;
$.ajax
({
type: "POST",
url: "course.php",
data: dataString,
cache: false,
success: function(html)
{
$("#course").html(html);
} 
});

});


$("#course").change(function()
{
var id=$(this).val();
var id1=$('#college').val();
var dataString = 'id='+ id +'&id1='+ id1;

$.ajax
({
type: "GET",
url: "branch.php",
data: dataString,
cache: false,
success: function(html)
{
$("#branch").html(html);
} 
});
});

});
</script>
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

<fieldset style="float:center;" >
<legend><font color="#330099" ><strong>Clear Test Attempt</strong></font></legend>
<?php if($_SESSION['msg']!=''){ ?><div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <?php echo $_POST['test']." Test Attempt for ".$_POST['college']."(".$_POST['branch'].") has been cleared."; ?> </div> <?php } ?>
   <p>
 <select name="college" id="college" style="color: grey;">
 <option value="">-Select College-</option>
 <?php $qry=mysql_query("select DISTINCT(COLLEGE_FULLNAME) from student_data"); 
 while($rs=mysql_fetch_array($qry)){ ?>
 	<option value="<?php echo $rs['COLLEGE_FULLNAME']; ?>"><?php echo $rs['COLLEGE_FULLNAME']; ?></option>
 <?php }  ?>
 </select> </p>
 <p><select name="shortname" id="shortname" style="color: grey;">
 <option value="">-Select College Shortname-</option>
 </select>
</p>
<p>
                   <select name="course" id="course" class="validate[required] text-input" style="color: grey;">
                   	<option value="">-Select Course-</option>
                   </select>
                    </p>
					
                    <p >
                   <select name="branch" id="branch" class="validate[required] text-input"  style="color: grey;">
                   	<option value="">-Select Branch-</option>
                   </select>
                    </p>
 <p> Select Year Of Passing Out </p>
<p> <select name="yop[]" style="color: grey;" id="example27" multiple="multiple">
 	<?php $sq="select distinct COURSE_YOP from student_data ORDER BY COURSE_YOP asc ";
$r=mysql_query($sq);

while($result=mysql_fetch_array($r)){
	?>
	<option value="<?php echo $result['COURSE_YOP']; ?>" ><?php echo $result['COURSE_YOP']; ?></option>
	<?php }  ?>
 </select>
</p>
<p><select name="test" id="test" style="color: grey;width:30% !important;" onchange="">
<option value="">-Select Test-</option>
<?php $sql=mysql_query("select * from `test_tests`")or die(mysql_error());
                   	while($rs=mysql_fetch_array($sql)){ ?>
					<option value="<?php echo $rs['test_id']; ?>"><?php echo $rs['test_name']; ?></option>
<?php } ?>
</select></p>

<input type='submit' name="submit" value='Clear Now' class="btn btn-success" id="search" style="">
</fieldset>
</form>
</div>
<script type='text/javascript' src="../../../../javascript/bootstrap.min.js"></script>