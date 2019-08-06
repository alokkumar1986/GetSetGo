<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}

$fgmembersite->DBLogin();

?>
 <style type="text/css">
        	select {
				
				width:207px;
			}
			.input-group{
				width:97px;
			}
        </style>
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
<script>
    function submitForm(action)
    {
        document.getElementById('changepwd').action = action;
        document.getElementById('changepwd').submit();
    }
	function submitForm1(action)
    {
        document.getElementById('changepwd').action = action;
        document.getElementById('changepwd').submit();
    }
</script>
<div>
<form id='changepwd' action='?id=report' method='post'  enctype="multipart/form-data">

<fieldset>
<legend><font color="#330099" ><strong>Test Report</strong></font></legend>
 <p>
 <select name="college" id="college" style="color: grey;">
 <!--<option value="">-Select College-</option> -->
 <?php $qry=mysql_query("select DISTINCT(COLLEGE_FULLNAME) from student_data where COLLEGE='".$_SESSION['actingrole']."'"); 
 while($rs=mysql_fetch_array($qry)){ ?>
 	<option value="<?php echo $rs['COLLEGE_FULLNAME']; ?>"><?php echo $rs['COLLEGE_FULLNAME']; ?></option>
 <?php }  ?>
 </select> </p>
 <p><select name="shortname" id="shortname" style="color: grey;">
 <?php $qry=mysql_query("select DISTINCT(COLLEGE) from student_data where COLLEGE='".$_SESSION['actingrole']."'"); 
 while($rs=mysql_fetch_array($qry)){ ?>
 	<option value="<?php echo $rs['COLLEGE']; ?>"><?php echo $rs['COLLEGE']; ?></option>
 <?php }  ?>
 <!--<option value="">-Select College Shortname-</option> -->
 </select>
</p>
 <p> Select Year Of Passing Out </p>
<p> <select name="yop[]" style="color: grey;" id="example27" multiple="multiple">
 	<?php $sq="select distinct COURSE_YOP from student_data where COLLEGE='".$_SESSION['actingrole']."' ORDER BY COURSE_YOP asc ";
$r=mysql_query($sq);

while($result=mysql_fetch_array($r)){
	?>
	<option value="<?php echo $result['COURSE_YOP']; ?>" ><?php echo $result['COURSE_YOP']; ?></option>
	<?php }  ?>
 </select>
</p>
<p>

<select name="test" id="test" style="color: grey;width:30% !important;" onchange="">
<option value="">-Select Test-</option>
<?php $sql=mysql_query("select * from `test_tests` t, `test_setting` t1 where t.`test_id`=t1.`test_id` AND t1.`for_college`='".$_SESSION['actingrole']."' order by test_name asc")or die(mysql_error());
                   	while($rs=mysql_fetch_array($sql)){ 
										?>
					<option value="<?php echo $rs['test_id']; ?>"><?php echo $rs['test_name']; ?></option>
					
<?php } ?>
</select></p>
<br/>
    <input type='button' class="btn btn-success" id="button1" name='Submit' value='See Report Now' onclick="submitForm1('?id=report')" />&nbsp;&nbsp;<input type='button' class="btn btn-danger" id="button1" name='button' value='Download Report (Excel)' onclick="submitForm('word.php')" /> 

</fieldset>
</form>
</div>
<script type='text/javascript' src="../../../../javascript/bootstrap.min.js"></script>