<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}
if(isset($_POST['submitted']))
{
   if($fgmembersite->testsetting())
   {
     $fgmembersite->RedirectToURL("?id=setting&test_id=$_POST[test]&college=$_POST[college]");
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

<fieldset style="float:center;" >
<legend><font color="#330099" ><strong> Test Setting </strong></font></legend>
<?php if($_GET['test_id']!=""){ ?><div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <?php echo "Test ".$_GET['test_id']." is activated successfully for ".$_GET['college']." ..."; ?> </div> <?php } ?>
   
<?php if($fgmembersite->GetErrorMessage()){ ?><div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <?php echo $fgmembersite->GetErrorMessage(); ?> </div> <?php } ?>
<input type='hidden' name='submitted' id='submitted' value='1' />
<table width="100%"><tr valign="top"><td width="54%" valign="top">
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
<p><select name="test" id="test" style="color: grey;">
<option value="">-Select Test-</option>
<?php $sql=mysql_query("select distinct(test_id),test_name from test_tests")or die(mysql_error());
                   	while($rs=mysql_fetch_array($sql)){ ?>
					<option value="<?php echo $rs['test_id']; ?>"><?php echo $rs['test_name']; ?></option>
<?php } ?>
</select>
<span id="msg"></span>
</p>
<p><select name="result">
<option value="Yes">Yes, it is to be shown.</option>
<option value="No" selected="selected">No, it is n't to be shown.</option>
</select>  Result </p>
<p><select name="review">
<option value="No" <?php if($row['review']=='No'){ ?> selected="selected" <?php } ?> >No, Never.</option>
<option value="Yes" <?php if($row['review']=='Yes'){ ?> selected="selected" <?php } ?>>Yes, After the test.</option>
<option value="YesR" <?php if($row['review']=='YesR'){ ?> selected="selected" <?php } ?>>Yes, After the test time elapsed.</option>

</select>  Review </p>
 <input type='submit' class="btn btn-success" id="button1" name='Submit' value='Activate Test Now' />
</td>
<td width="46%" valign="top">

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
<div class="row" style="margin-left:0px !important;">
 <p> <div class="col-lg-9">
    <div class="input-group">
      <span class="input-group-addon">
        <input type="radio" name="sectionduration" value="Combined Section Duration" checked="checked">
      </span>
      <input type="text" class="form-control" value="Combined Section Duration" />
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
  </p>
  </div>
  <div class="row" style="margin-left:0px !important;">
  <p>
  <div class="col-lg-9">
    <div class="input-group">
      <span class="input-group-addon">
        <input type="radio" name="sectionduration" value="Each Section Duration">
      </span>
      <input type="text" class="form-control" value="Each Section Duration">
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
</div><!-- /.row -->
</p>
<p></p>
<p><select name="calculator">
<option value="Yes">Yes, it is shown.</option>
<option value="No">No, it is n't shown.</option>
</select>  Calculator </p>
<p>   <select name="instance">
<option value="1" selected="selected">1</option>
<?php for($v=2;$v<=10;$v++){ ?>
<option value="<?php echo $v; ?>" ><?php echo $v; ?></option>
<?php } ?>
</select>  Test Instance </p>
</td></tr></table>
    <!--&nbsp;&nbsp;&nbsp;<a href="?id=view sections" class="btn btn-danger" style="float: right;margin-left:10px;margin-right:10px;">View All Secions</a>&nbsp;&nbsp;&nbsp;<a href="?id=create test" class="btn btn-info" style="float: right;">Create Test</a> -->
</fieldset>
</form>
<!-- client-side Form Validations:
Uses the excellent form validation script from JavaScript-coder.com-->
<script type='text/javascript' src="../../../../javascript/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" media="screen"
     href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
<script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js">
    </script>
    <script type="text/javascript"
     src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.pt-BR.js">
    </script>

<script type="text/javascript">
$(document).ready(function(){	   
$("#test").change(function()
{
$("#msg").html("Please wait...");
var id=$(this).val();
var college=document.getElementById("college").value;
var yop=document.getElementById("example27").value;
var dataString = 'id='+ id +'&college='+ college +'&yop='+yop;

$.ajax
({
type: "POST",
url: "ajax_test.php",
data: dataString,
cache: false,
success: function(html)
{
$("#msg").html(html);
} 
});
});
});	
</script>
<script type="text/javascript">
  $(function() {
    $('.date').datetimepicker({
      language: 'en',
	  format: "yyyy-MM-dd HH:mm:00"
    });
  });
</script>



</div>