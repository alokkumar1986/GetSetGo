<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}
if(!$_GET['test']){
$fgmembersite->RedirectToURL("?id=configure test");
    exit;
}
if(isset($_POST['submitted'])){
if($fgmembersite->Addquestionset())
   {         
   	    $fgmembersite->RedirectToURL("?id=testconfiguration&test=$_POST[test]");
		exit;
   }
}
$fgmembersite->DBLogin();

?>
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
 $('#subject').multiselect({
	includeSelectAllOption: true
	});
  $('.text-input').multiselect({
	includeSelectAllOption: true
	}); 
});
</script>
<script type="text/javascript">
function checkque(id,id1){
var val= parseInt(document.getElementById(id).value);
var val1= parseInt(document.getElementById(id1).value);
if(val1 > val){
alert("This value cann't be greater than "+val);
$('#'+id1).val(val);
}
}
function totalq(p,q){
var mdiff1=document.getElementById(p+"diff"+q+q).value;
var measy1=document.getElementById(p+"easy"+q+q).value;
var mmod1=document.getElementById(p+"mod"+q+q).value;
var mdiff=document.getElementById(p+"diff"+q).value;
var measy=document.getElementById(p+"easy"+q).value;
var mmod=document.getElementById(p+"mod"+q).value;
val=parseInt(mdiff)+parseInt(measy)+parseInt(mmod);
if(mdiff1==''){
$('#tq'+q).val(val);
}else{
$('#tq'+q).val(0);
}

if(mdiff1==''){
var mdiff=document.getElementById(p+"diff"+q).value;
$('#'+p+"diff"+q+q).val(mdiff);
}else{
$('#'+p+"diff"+q+q).val("");
}

if(measy1==''){
var measy=document.getElementById(p+"easy"+q).value;
$('#'+p+"easy"+q+q).val(measy);
}else{
$('#'+p+"easy"+q+q).val("");
}

if(mmod1==''){
var mmod=document.getElementById(p+"mod"+q).value;
$('#'+p+"mod"+q+q).val(mmod);
}else{
$('#'+p+"mod"+q+q).val("");
}

}
function tq(m,n){
var val=parseInt(document.getElementById(n).value);
var val1=parseInt(document.getElementById("tq"+m).value);
//alert(val);
//alert(val1);
var p=val+val1;
//alert(p);
$('#tq'+m).val(p);
}
</script>
<script type='text/javascript' src="../../../../javascript/bootstrap.min.js"></script>
<link type="text/css" href="../../../../css/bootstrap-timepicker.min.css" />
<script type="text/javascript" src="../../../../javascript/bootstrap-timepicker.min.js"></script>
<div>
<fieldset style="float:center;" >
<legend><font color="#330099" ><strong>Test Configuration (Test : <?php echo $_GET['test']; ?>)</strong></font></legend>

<?php if($fgmembersite->GetErrorMessage()){ ?><div class="alert alert-danger alert-dismissable">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<?php echo $fgmembersite->GetErrorMessage();  ?> </div> <?php }  ?>
<?php $sql="select * from test_section_category where test_id='".$_GET['test']."'";
$rs=mysql_query($sql)or die(mysql_error());
$coun=mysql_num_rows($rs);
$i=1;
$sqlqry=mysql_query("select * from `test_questionset` where (test_id='".$_GET['test']."' )");
$counrow=mysql_num_rows($sqlqry);
if($counrow==(2*$coun)){
	?>
	<div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <?php echo "Questions added successfully... Now you need to activate this test under test setting menu."; ?> </div> 
  <?php	}
while($row=mysql_fetch_array($rs)){ ?>
<form action="" method="post" enctype="multipart/form-data">
<input type='hidden' name='submitted' id='submitted' value='<?php echo $i; ?>' />
<input type='hidden' name='test'  value='<?php echo $_GET['test']; ?>' />
<?php $sqlqry=mysql_query("select * from `test_questionset` where (test_id='".$_GET['test']."' AND section='".$row['section_name']."')");
	$counrow=mysql_num_rows($sqlqry);
	
	if($counrow=='0'){  ?>
<div class="accordion" id="accordion<?php echo $i; ?>">
  <div class="accordion-group" style="background:#003399;color:#FFFFFF;">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion<?php echo $i; ?>" href="#collapse<?php echo $i; ?>">
        <?php echo $row['section_name']; ?>
      </a>
    </div>
 </div>
<div id="collapse<?php echo $i; ?>" class="accordion-body collapse in">
      <div class="accordion-inner">
<input name="section<?php echo $i; ?>" type="hidden" value="<?php echo $row['section_name']; ?>">
<table width="100%" border="1" style="border:border-collapse;" class="table table-bordered">
	<tr><th width="11%">Category</th>
	<th width="19%">Question Type</th>
  	<th width="10%">Total No. Of Questions</th>
   	<th width="10%">No. Of Difficult Questions</th>
   	<th width="10%">No. Of Easy Questions</th>
   	<th width="10%">No. Of Moderate Questions</th>
   	
   	<th width="10%">Difficult</th>
   	<th width="10%">Easy</th>
   	<th width="10%">Moderate</th>
	<th>Check For All Questions</th>
   	</tr>
	<?php 
	$cat=$row['category'];
	$cat1=explode(',',$cat);
	$length=count($cat1);
	$category='';
	for($k=0;$k<$length;$k++){
	$category.= "'".$cat1[$k]."'";
	if($k!=($length-1)){
	$category.=",";
	}
	}
	//echo $category;
	
	//$sqlqry="select * from `test_questionset` where test_id='".$_GET['test']."'";
	$sql1=mysql_query("select * from test_category where name in ($category) order by name")or die(mysql_error());
	$l=1;
	$countcat=mysql_num_rows($sql1);
	?>
	<input type="hidden" name="catcount" value="<?php echo $countcat; ?>"  />
    <?php while($rs1=mysql_fetch_array($sql1)){
	 $que=mysql_query("SELECT  count(*) FROM test_question_multiple_choice 
WHERE (category =".$rs1['category_id']." )"); 
$rss=mysql_fetch_array($que); 
$que1=mysql_query("SELECT  count(*) FROM test_question_true_false
WHERE (category =".$rs1['category_id']." )"); 
$qss=mysql_fetch_array($que1); 
// ----- Difficulty Level -----////
$diff=mysql_query("select count(*) from test_question_multiple_choice 
WHERE ((category =".$rs1['category_id']." ) AND (difficulty_level='difficult'))");
$rsss=mysql_fetch_array($diff);
$diff1=mysql_query("select count(*) from test_question_multiple_choice
WHERE ((category =".$rs1['category_id']." ) AND (difficulty_level='easy'))");
$rsss1=mysql_fetch_array($diff1);
$diff11=mysql_query("select count(*) from test_question_multiple_choice
WHERE ((category =".$rs1['category_id']." ) AND (difficulty_level='modorate'))");
$rsss11=mysql_fetch_array($diff11);

// ----- End Of Difficulty Level ---//

// ----- Easy Level -----////
$easy=mysql_query("select count(*) from test_question_true_false 
WHERE ((category =".$rs1['category_id']." ) AND (difficulty_level='difficult'))");
$rssss=mysql_fetch_array($easy);
$easy1=mysql_query("select count(*) from test_question_true_false
WHERE ((category =".$rs1['category_id']." ) AND (difficulty_level='easy'))");
$rssss1=mysql_fetch_array($easy1);
$easy11=mysql_query("select count(*) from test_question_true_false
WHERE ((category =".$rs1['category_id']." ) AND (difficulty_level='modorate'))");
$rssss11=mysql_fetch_array($easy11);

// ----- End Of Easy Level ---//
?>
	
	<tr><td width="10%" style="padding:10px;">
	<input name="category<?php echo $l; ?>" type="hidden" value="<?php echo $rs1['name']; ?>" />
	<?php echo $rs1['name']; ?></td>
	<td style="padding:0px !important;"><table style="padding:0px !important;margin-bottom:0px !important;width:100%;"><tr><td>Multiple Choice</td></tr><?php if($qss['count(*)']>'0'){ ?> <tr><td>True/False</td></tr><?php } ?><!--<tr><td>Block Level</td></tr> --></table></td>
	<td style="padding:0px !important;"><table class="table table-bordered" style="padding:0px !important;margin-bottom:0px !important;"><tr><td>
	
<input type="text" class="form-control" value="<?php echo $rss['count(*)']; ?>" style="margin-bottom:0px !important;"></td></tr><?php if($qss['count(*)']>'0'){ ?><tr><td><input type="text" class="form-control" value="<?php echo $qss['count(*)']; ?>" style="margin-bottom:0px !important;"></td></tr> <?php } ?>
<!--<tr><td><input type="text" class="form-control" value="<?php echo $qss['count(*)']; ?>" style="margin-bottom:0px !important;"></td></tr> --></table></td>
	<td style="padding:0px !important;"><table class="table table-bordered" style="padding:0px !important;margin-bottom:0px !important;"><tr><td>
	<input type="text" class="form-control" value="<?php echo $rsss['count(*)']; ?>" style="margin-bottom:0px !important;" id="mdiff<?php echo $i; ?>"></td></tr><?php if($qss['count(*)']>'0'){ ?><tr><td><input type="text" class="form-control" value="<?php echo $rssss['count(*)']; ?>" id="tdiff<?php echo $i; ?>" style="margin-bottom:0px !important;"></td></tr><?php } ?>
	<!--<tr><td><input type="text" class="form-control" value="<?php echo $rssss['count(*)']; ?>" style="margin-bottom:0px !important;"></td></tr> --></table></td>
	<td style="padding:0px !important;"><table class="table table-bordered" style="padding:0px !important;margin-bottom:0px !important;"><tr><td>
	<input type="text" class="form-control" value="<?php echo $rsss1['count(*)']; ?>" id="measy<?php echo $i; ?>" style="margin-bottom:0px !important;"></td></tr><?php if($qss['count(*)']>'0'){ ?><tr>
	  <td><input name="text" type="text" class="form-control" id="teasy<?php echo $i; ?>" style="margin-bottom:0px !important;" value="<?php echo $rssss1['count(*)']; ?>" /></td>
	</tr><?php } ?>
	<!--<tr><td><input type="text" class="form-control" value="<?php echo $rssss1['count(*)']; ?>" style="margin-bottom:0px !important;"></td></tr> --></table></td>
	<td style="padding:0px !important;"><table class="table table-bordered" style="padding:0px !important;margin-bottom:0px !important;"><tr><td>
	<input type="text" class="form-control" value="<?php echo $rsss11['count(*)']; ?>" id="mmod<?php echo $i; ?>" style="margin-bottom:0px !important;"></td></tr><?php if($qss['count(*)']>'0'){ ?><tr><td><input type="text" class="form-control" value="<?php echo $rssss11['count(*)']; ?>" id="tmod<?php echo $i; ?>" style="margin-bottom:0px !important;"></td></tr><?php } ?><!--<tr><td><input type="text" class="form-control" value="<?php echo $rssss11['count(*)']; ?>" style="margin-bottom:0px !important;"></td></tr> --></table></td>
	<td style="padding:0px !important;"><table class="table table-bordered" style="padding:0px !important;margin-bottom:0px !important;"><tr><td>
	<input type="text" class="form-control" name="mdiff<?php echo $l; ?>" value="" style="margin-bottom:0px !important;" id='mdiff<?php echo $i; ?><?php echo $i; ?>' onblur="checkque('mdiff<?php echo $i; ?>','mdiff<?php echo $i; ?><?php echo $i; ?>'); tq('<?php echo $i; ?>','mdiff<?php echo $i; ?><?php echo $i; ?>')"></td></tr><?php if($qss['count(*)']>'0'){ ?><tr><td><input type="text" class="form-control" name="tdiff<?php echo $l; ?>" value="" style="margin-bottom:0px !important;" id='tdiff<?php echo $i; ?><?php echo $i; ?>' onblur="checkque('tdiff<?php echo $i; ?>','tdiff<?php echo $i; ?><?php echo $i; ?>'); tq('<?php echo $i; ?>','tdiff<?php echo $i; ?><?php echo $i; ?>')"></td></tr><?php } ?><!--<tr><td><input type="text" class="form-control" value="" style="margin-bottom:0px !important;"></td></tr> --></table></td>
	<td style="padding:0px !important;"><table class="table table-bordered" style="padding:0px !important;margin-bottom:0px !important;"><tr><td>
	<input type="text" class="form-control" name="measy<?php echo $l; ?>" value="" style="margin-bottom:0px !important;" id='measy<?php echo $i; ?><?php echo $i; ?>' onblur="checkque('measy<?php echo $i; ?>','measy<?php echo $i; ?><?php echo $i; ?>'); tq('<?php echo $i; ?>','measy<?php echo $i; ?><?php echo $i; ?>')"></td></tr><?php if($qss['count(*)']>'0'){ ?><tr><td><input type="text" class="form-control" name="teasy<?php echo $l; ?>" value="" style="margin-bottom:0px !important;" id='teasy<?php echo $i; ?><?php echo $i; ?>' onblur="checkque('teasy<?php echo $i; ?>','teasy<?php echo $i; ?><?php echo $i; ?>'); tq('<?php echo $i; ?>','teasy<?php echo $i; ?><?php echo $i; ?>')"></td></tr><?php } ?><!--<tr><td><input type="text" class="form-control" value="" style="margin-bottom:0px !important;"></td></tr> --></table></td>
	<td style="padding:0px !important;"><table class="table table-bordered" style="padding:0px !important;margin-bottom:0px !important;"><tr><td>
	<input type="text" class="form-control" name="mmod<?php echo $l; ?>" value="" style="margin-bottom:0px !important;" id='mmod<?php echo $i; ?><?php echo $i; ?>' onblur="checkque('mmod<?php echo $i; ?>','mmod<?php echo $i; ?><?php echo $i; ?>'); tq('<?php echo $i; ?>','mmod<?php echo $i; ?><?php echo $i; ?>')">
	
	</td></tr><?php if($qss['count(*)']>'0'){ ?><tr><td><input type="text" class="form-control" name="tmod<?php echo $l; ?>" value="" style="margin-bottom:0px !important;" id='tmod<?php echo $i; ?><?php echo $i; ?>' onblur="checkque('tmod<?php echo $i; ?>','tmod<?php echo $i; ?><?php echo $i; ?>'); tq('<?php echo $i; ?>','tmod<?php echo $i; ?><?php echo $i; ?>')"></td></tr><?php } ?><!--<tr><td><input type="text" class="form-control" value="" style="margin-bottom:0px !important;"></td></tr> --></table></td>
	<td><table> <tr><td> <input type="checkbox" onchange="totalq('m','<?php echo $i; ?>')" /></td></tr><?php if($qss['count(*)']>'0'){ ?> <tr><td> <input type="checkbox" onchange="totalq('t','<?php echo $i; ?>')" /></td></tr><?php } ?></table> </td>
	</tr>
	<?php $l++; }?>
   <tr>
   </tr>
</table>
 <p> <label style="width:180px;">Mark Of Each Question </label><select name="mark_of_each_question<?php echo $i; ?>">
 <?php for($j=1;$j<=10;$j++){ ?>
 <option value="<?php echo $j; ?>"><?php echo $j; ?></option>
 <?php } ?>
 </select> </p>
 <div style="float:right;"><label style="width:120px;">Total Questions</label><input name="tq<?php echo $i; ?>" id="tq<?php echo $i; ?>" type="text" value="0"/></div>
			    <p> <label style="width:180px;">Negative Marking </label><select name="negative_marking_of_each_wrong_answer<?php echo $i; ?>">
 <?php for($j=0;$j<=5;$j+=.05){ ?>
 <option value="<?php echo $j; ?>"><?php echo $j; ?></option>
 <?php } ?>
 </select> </p>
				
				<div class="input-append bootstrap-timepicker">
				<label style="width:180px;">Duration </label>
            <input name="duration<?php echo $i; ?>" id="timepicker1" type="text" class="input-medium time" placeholder="Only Number (ie. 15)">
            <span class="add-on" style="padding:3px;height:30px"><i class="icon-time"></i></span>
        </div>
		<!--<script type="text/javascript">
            $('.time').timepicker();
        </script> -->
		<input type="hidden" name="cnt" value="<?php echo $i; ?>"  />
<input type='submit' class="btn btn-success" id="button1" name='Submit' value='Save' />
</div>
</div>
</div>
</form>
<?php  $i++; }  
}
?>

</fieldset>


</div>
