<?php //session_start();
require_once("../../include/membersite_config.php");
error_reporting(0);
if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}
$fgmembersite->DBLogin();
if($_POST['submitted']){
$sel=mysql_query("select * from `verbaltest` where college='".$_POST['college']."'");
$count=mysql_num_rows($sel);
if($count>=1){
$_SESSION['unsuccess']='One email test is active for this college.. First delete it and try again';

}else{
$yop=implode(",",$_POST['yop']);
$query="INSERT INTO `verbaltest` (`id`, `college`, `college_shortname`, `yop`, `start_date`, `end_date`, `duration`) VALUES (NULL, '".$_POST['college']."', '".$_POST['shortname']."', '$yop', '".$_POST['sdate']."', '".$_POST['edate']."', '".$_POST['duration']."');";
mysql_query($query);
$fgmembersite->RedirectToURL("index.php?id=view email tests&id1=success");
exit;
}
}
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
<script type="text/javascript">
	  $(document).ready(function(){
	 $("#college").change(function()
{
var id=$(this).val();
var dataString = 'id='+ id;

$.ajax
({
type: "POST",
url: "../admin/college1.php",
data: dataString,
cache: false,
success: function(html)
{
$("#shortname").html(html);
} 
});

});
});
</script>
<div>
<form id='changepwd' action='' method='post' enctype="multipart/form-data">

<fieldset>
<legend><font color="#330099" ><strong>Email Writting/Verbal Test Setting</strong></font></legend>
<?php if($_SESSION['unsuccess']!=""){ ?><div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <?php echo $_SESSION['unsuccess']; ?> </div> <?php } unset($_SESSION['unsuccess']); ?>
   
<?php if($fgmembersite->GetErrorMessage()){ ?><div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <?php echo $fgmembersite->GetErrorMessage(); ?> </div> <?php } ?>
<input type='hidden' name='submitted' id='submitted' value='1' />

<p>
 <select name="college" id="college" style="color: grey;">
 <option value="">-Select College-</option>
 <?php $qry=mysql_query("select DISTINCT(COLLEGE),COLLEGE_FULLNAME from student_data"); 
 while($rs=mysql_fetch_array($qry)){ ?>
 	<option value="<?php echo $rs['COLLEGE']; ?>"><?php echo $rs['COLLEGE_FULLNAME']; ?></option>
 <?php }  ?>
 </select> </p>
 <p><select name="shortname" id="shortname" style="color: grey;">
 <option value="">-Select College Shortname-</option>
 </select>
</p>
<p> <select name="yop[]" style="color: grey;" id="example27" multiple="multiple">
 	<?php $sq="select distinct COURSE_YOP from student_data ORDER BY COURSE_YOP asc ";
$r=mysql_query($sq);

while($result=mysql_fetch_array($r)){
	?>
	<option value="<?php echo $result['COURSE_YOP']; ?>" ><?php echo $result['COURSE_YOP']; ?></option>
	<?php }  ?>
 </select> Select YOP
</p>
<div id="datetimepicker1" class="input-append date">
   <input data-format="dd/MM/yyyy hh:mm:ss" type="text" name="sdate" Placeholder="Start Date"/>
    <span class="add-on"  style="padding:3px;height:30px">
      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
      </i>
    </span>
  </div>

<p>			
  <div id="datetimepicker1" class="input-append date">
  End Date  <input data-format="dd/MM/yyyy hh:mm:ss" type="text" name="edate" Placeholder="End Date" />
    <span class="add-on"  style="padding:3px;height:30px">
      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
      </i>
    </span>
  </div>
  </p>
	<p><input name="duration" id="timepicker1" type="text" class="input-medium time" placeholder="Duration(Only Number (ie. 15))"></p>
	<p><input type='submit' class="btn btn-success" id="button1" name='Submit' value='Save' />&nbsp;&nbsp;&nbsp;<a href="?id=view email tests" class="btn btn-danger" style="float: right;margin-left:10px;margin-right:10px;">View All Tests</a></p>
</fieldset>
</form>
</div>
<script type='text/javascript' src="../../../../javascript/bootstrap.min.js"></script>
<!--<link rel="stylesheet" type="text/css" media="screen" href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
<script type="text/javascript" src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.pt-BR.js"></script>->