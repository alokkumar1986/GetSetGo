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
/*$sel=mysql_query("select * from `student_data` where COLLEGE='$_POST[shortname]'")or die(mysql_error());
while($res=mysql_fetch_array($sel)){   */
$sql="delete from `verbaltest_result` where (college='$_POST[shortname]')";
$rs=mysql_query($sql);
$sql1="delete from `verbaltest_eval` where (college='$_POST[shortname]')";
$rs1=mysql_query($sql1);
if($rs || $rs1){
$_SESSION['msg']="test cleared";
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
<legend><font color="#330099" ><strong>Clear Email Test Attempt(Bulk)</strong></font></legend>
<?php if($_SESSION['msg']!=''){ ?><div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <?php echo "Email Test Attempt for ".$_POST['college']." has been cleared."; ?> </div> <?php } ?>
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

 <p> Select Year Of Passing Out </p>
<p> <select name="yop[]" style="color: grey;" id="example27" multiple="multiple">
     <?php $sq="select distinct COURSE_YOP from student_data ORDER BY COURSE_YOP asc ";
$r=mysql_query($sq);

while($result=mysql_fetch_array($r)){ ?>
    <option value="<?php echo $result['COURSE_YOP']; ?>" ><?php echo $result['COURSE_YOP']; ?></option>
    <?php }  ?>
 </select>
</p>

<input type='submit' name="submit" value='Clear Now' class="btn btn-success" id="search" style="">
</fieldset>
</form>
</div>
<script type='text/javascript' src="../../../../javascript/bootstrap.min.js"></script>