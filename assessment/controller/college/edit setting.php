<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}
if(isset($_POST['submitted']))
{
$formvars['test'] = $fgmembersite->Sanitize($_POST['test']);
		$formvars['college'] = $fgmembersite->Sanitize($_POST['college']);
		$formvars['shortname'] = $fgmembersite->Sanitize($_POST['shortname']);
        $formvars['yop'] = $fgmembersite->Sanitize($_POST['yop']);
		$yop=str_replace('multiselect-all,','', implode(",",$formvars['yop']));
        $formvars['sdate'] = $fgmembersite->Sanitize($_POST['sdate']);
        $formvars['edate'] = $fgmembersite->Sanitize($_POST['edate']);
        $formvars['sectionduration'] = $fgmembersite->Sanitize($_POST['sectionduration']);
		$formvars['calculator'] = $fgmembersite->Sanitize($_POST['calculator']);
		$formvars['instance'] = $fgmembersite->Sanitize($_POST['instance']);
		$formvars['result'] = $fgmembersite->Sanitize($_POST['result']);
		$formvars['review'] = $fgmembersite->Sanitize($_POST['review']);
   $qry="update  `test_setting` set `test_id`='".$formvars['test']."', `start_date`='".$formvars['sdate']."', `end_date`='".$formvars['edate']."', `for_college`='".$formvars['college']."', `for_yop`='".$yop."', `duration`='".$formvars['sectionduration']."', `calculator`='".$formvars['calculator']."',`instance`='".$formvars['instance']."',`result`='".$formvars['result']."',`review`='".$formvars['review']."'  where (test_id='".$formvars['test']."' and for_college='".$formvars['college']."')";
		if(!mysql_query( $qry ,$fgmembersite->connection))
        {
            $fgmembersite->HandleDBError("Error in Inserting Data.. \nquery:$qry2");
            return false;
        }
		$fgmembersite->RedirectToURL("?id=edit setting&test=$formvars[test]&college=$formvars[college]&updated=yes");
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
<?php $sql=mysql_query("select * from test_setting where test_id='$_GET[test]' and for_college='$_GET[college]'");
while($row=mysql_fetch_array($sql)){ 
$yop=explode(",",$row['for_yop']);
?>
<form id='changepwd' action='' method='post' enctype="multipart/form-data">

<fieldset style="float:center;" >
<legend><font color="#330099" ><strong>Edit Test (<?php echo $_GET['test']; ?>) Setting </strong></font></legend>
<?php if($_GET['updated']!=""){ ?><div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <?php echo "Test ".$_GET['test']." is updated successfully..."; ?> </div> <?php 
   exit;
   } ?>
   
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
 	<option value="<?php echo $rs['COLLEGE']; ?>" <?php if($row['for_college']==$rs['COLLEGE']){ ?> selected="selected" <?php } ?>><?php echo $rs['COLLEGE_FULLNAME']; ?></option>
 <?php }  ?>
 </select> </p>
 <p><select name="shortname" id="shortname" style="color: grey;">
 <option value="">-Select College Shortname-</option>
 <option value="<?php echo $row['for_college']; ?>" selected="selected"><?php echo $row['for_college']; ?></option>
 </select>
</p>

<p> <select name="yop[]" style="color: grey;" id="example27" multiple="multiple">
 	<?php $sq="select distinct COURSE_YOP from student_data ORDER BY COURSE_YOP asc ";
$r=mysql_query($sq);

while($result=mysql_fetch_array($r)){
	?>
	<option value="<?php echo $result['COURSE_YOP']; ?>" <?php if(in_array($result['COURSE_YOP'],$yop)){ ?> selected="selected" <?php } ?>><?php echo $result['COURSE_YOP']; ?></option>
	<?php }  ?>
 </select> Select YOP
</p>
<p><select name="test" id="test" style="color: grey;" >
<?php $sql=mysql_query("select distinct(test_id),test_name from test_tests where test_id='$row[test_id]'")or die(mysql_error());
                   	while($rs=mysql_fetch_array($sql)){ ?>
					<option value="<?php echo $rs['test_id']; ?>" <?php if($row['test_id']==$rs['test_id']){ ?> selected="selected" <?php } ?>><?php echo $rs['test_name']; ?></option>
<?php } ?>
</select>
<span id="msg"></span>
</p>
<p><select name="result">
<option value="Yes" <?php if($row['result']=='Yes'){ ?> selected="selected" <?php } ?>>Yes, it is to be shown.</option>
<option value="No" <?php if($row['result']=='No'){ ?> selected="selected" <?php } ?> >No, it is n't to be shown.</option>
</select>  Result </p>
<p><select name="review">
<option value="No" <?php if($row['review']=='No'){ ?> selected="selected" <?php } ?> >No, Never.</option>
<option value="Yes" <?php if($row['review']=='Yes'){ ?> selected="selected" <?php } ?>>Yes, After the test.</option>
<option value="YesR" <?php if($row['review']=='YesR'){ ?> selected="selected" <?php } ?>>Yes, After the test time elapsed.</option>
</select>  Review </p>
 <input type='submit' class="btn btn-success" id="button1" name='Submit' value='Update Setting' /> <input type='button' class="btn btn-danger" id="button1" name='Submit' value='Deactivate' onclick="submitForm('?id=deactivate')" />

</td>
<td width="46%" valign="top">

  <div id="datetimepicker1" class="input-append date">
   <input data-format="dd/MM/yyyy hh:mm:ss" type="text" name="sdate" Placeholder="Start Date" value="<?php echo $row['start_date']; ?>"/>
    <span class="add-on"  style="padding:3px;height:30px">
      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
      </i>
    </span>
  </div>

<p>			
  <div id="datetimepicker1" class="input-append date">
  End Date  <input data-format="dd/MM/yyyy hh:mm:ss" type="text" name="edate" Placeholder="End Date" value="<?php echo $row['end_date']; ?>" />
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
        <input type="radio" name="sectionduration" value="Combined Section Duration" <?php if($row['duration']=='Combined Section Duration'){ ?> checked="checked" <?php } ?>>
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
        <input type="radio" name="sectionduration" value="Each Section Duration" <?php if($row['duration']=='Each Section Duration'){ ?> checked="checked" <?php } ?>>
      </span>
      <input type="text" class="form-control" value="Each Section Duration">
    </div><!-- /input-group -->
  </div><!-- /.col-lg-6 -->
</div><!-- /.row -->
</p>
<p></p>
<p><select name="calculator">
<option value="Yes" <?php if($row['calculator']=='Yes'){ ?> selected="selected" <?php } ?>>Yes, it is shown.</option>
<option value="No" <?php if($row['calculator']=='No'){ ?> selected="selected" <?php } ?>>No, it is n't shown.</option>
</select>  Calculator </p>
<p>   <select name="instance">
<option value="1" selected="selected">1</option>
<?php for($v=2;$v<=10;$v++){ ?>
<option value="<?php echo $v; ?>" <?php if($row['instance']==$v){ ?> selected="selected" <?php } ?>><?php echo $v; ?></option>
<?php } ?>
</select>  Test Instance </p>
</td></tr></table>
    <!--&nbsp;&nbsp;&nbsp;<a href="?id=view sections" class="btn btn-danger" style="float: right;margin-left:10px;margin-right:10px;">View All Secions</a>&nbsp;&nbsp;&nbsp;<a href="?id=create test" class="btn btn-info" style="float: right;">Create Test</a> -->
</fieldset>
</form>
<?php } ?>
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
  $(function() {
    $('.date').datetimepicker({
      language: 'en',
	  format: "yyyy-MM-dd HH:mm:00"
    });
  });
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



</div>