<?PHP 
require_once("../../include/membersite_config.php");
error_reporting(0);
if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}
$fgmembersite->DBLogin();

if(isset($_POST['submit'])){
//echo "alok";
$instance= implode(",",$_REQUEST['instance']);
$sql="delete from `temp_test_result` where (candidate='$_POST[s]' and test_id='$_POST[test]' and instance in ($instance))";
$rs=mysql_query($sql);
$sql1="delete from `test_status` where (candidate='$_POST[s]' and test_id='$_POST[test]' and instance in ($instance))";
$rs1=mysql_query($sql1);
$sql2="delete from `student_result` where (reg_no='$_POST[s]' and test_id='$_POST[test]')";
$rs2=mysql_query($sql2);
$sql3="delete from `test_timer` where (candidate='$_POST[s]' and test_id='$_POST[test]' and instance in ($instance))";
$rs3=mysql_query($sql3);
if($rs){
$_SESSION[msg]="Instance ".$instance." for test ".$_POST[test]." cleared";
}
}
$page=$_GET['id'];
?>
 <link href="../../css/bootstrap1.css" rel="stylesheet">
    <link href="../../css/bootstrap-responsive.css" rel="stylesheet">
<!--<link href="css/jquery-ui.css" rel="stylesheet">-->
    <link rel="stylesheet" href="../../css/typica-login.css">
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../../css/style.css">
<link rel="stylesheet" type="text/css" href="../../css/jquery.autocomplete.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

   
    <link rel="shortcut icon" href="http://induseducation.in/favicon.ico" />
 <script src="../../js/jquery-latest.js"></script>
    <script src="../../js/bootstrap.js"></script>
    <!--<script src="../../js/backstretch.js"></script>-->
    <!--<script src="../../js/typica-login.js"></script>-->
    <script src="../../js/jquery.autocomplete.js"></script>
    
    <script type="text/javascript">
$(document).ready(function(){
$("#s").autocomplete("../staff/data12.php");

$.ajaxSetup ({
		cache: false
	});
	var ajax_load = "Loading..";

//	load() functions
	$("#search").click(function(){
	var q1=document.getElementById('s').value;
	
  htmlobj=$.ajax({url:"data_load.php?q="+q1,async:false,cache:false});
  $("#result").html(htmlobj.responseText);
	});
});
</script>
<script>
function showinstance(p){
var test=document.getElementById("test").value;
var xmlhttp;
if (p=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  }
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","get.php?q="+p+"&test="+test,true);
xmlhttp.send();

}
</script>
<div>
<form id='changepwd' action='' method='post' enctype="multipart/form-data">

<fieldset style="float:center;" >
<legend><font color="#330099" ><strong>Clear Test Attempt</strong></font></legend>
<?php if($_SESSION['msg']!=''){ ?><div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <?php echo "Instance ".$instance." of ".$_POST['test']." Test Attempt for ".$_POST[s]." has been cleared."; ?> </div> <?php } ?>
<p><select name="test" id="test" style="color: grey;width:30% !important;" onchange="">
<option value="">-Select Test-</option>
<?php $sql=mysql_query("select * from `test_tests` t, `test_setting` t1 where t.`test_id`=t1.`test_id` AND t1.`for_college`='".$_SESSION['actingrole']."'")or die(mysql_error());
                   	while($rs=mysql_fetch_array($sql)){ ?>
					<option value="<?php echo $rs['test_id']; ?>"><?php echo $rs['test_name']; ?></option>
<?php } ?>
</select>
</p>
<p>
<input placeholder="Search Student by Registration Number" name='s' id='s' type="text" style="width:49%;line-height: 25px !important;margin-bottom: 0px !important"
onblur="showinstance(this.value)">
</p>
<p id="txtHint"></p>
<p>
  <input type='submit' name="submit" value='Clear' class="btn btn-success" id="search" style="" />
</p>
</fieldset>
</form>
</div>