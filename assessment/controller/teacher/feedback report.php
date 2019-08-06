<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}
if(isset($_POST['submitted']))
{
   //if($fgmembersite->Hallticketsetting())
   //{   
         $sql1=mysql_query("select * from feedback where college='".$_POST['shortname']."'") or die(mysql_error());
		 $count=mysql_num_rows($sql1);
		 $row=mysql_fetch_array($sql1);
		 if($count==0){
	     $sql=mysql_query("insert into feedback values(NULL, '".$_POST['shortname']."', 
		 '".$_POST['sdate']."', '".$_POST['edate']."', '".$_POST['attempt']."', now()
		 )")or die(mysql_error());
		 $_POST=NULL;
         $_SESSION['successsection']="Setting Added Successfully";
		 }else{ ?>
         <script>
		 alert("The feedback setting for <?php echo $_POST['shortname']; ?> college is already in our database. Overriding the previous setting.")
		  </script> 
		 <?php 
		 $sql=mysql_query("update feedback set startdate='".$_POST['sdate']."', enddate='".$_POST['edate']."', 
		 attempt='".$_POST['attempt']."', addeddate=now() where id='".$row['id']."' ")or die(mysql_error());
		 $_POST=NULL;
		 $_SESSION['successsection']="Setting updated Successfully";
       	//$fgmembersite->HandleDBError("Section Added Successfully");
		}
   //}
} 
$fgmembersite->DBLogin();

?>
<script type="text/javascript" src="../../../../javascript/bootstrap-2.3.2.min.js"></script>
<!--<link rel="stylesheet" href="../../../../css/bootstrap-multiselect.css" type="text/css">
<script type="text/javascript" src="../../../../javascript/bootstrap-multiselect.js"></script> -->
<link rel="stylesheet" href="../../../../css/prettify.css" type="text/css">
<script type="text/javascript" src="../../../../javascript/prettify.js"></script>


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
<form id='changepwd' action='feedbackrpt.php' method='post' enctype="multipart/form-data">

<fieldset style="float:center;" >
<legend><font color="#330099" ><strong>Feedback Report</strong></font></legend>
<?php if($_SESSION['successsection']!=''){ ?><div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <?php echo $_SESSION['successsection']; ?> </div> <?php } $_SESSION['successsection']=''; ?>
<?php if($fgmembersite->GetErrorMessage()){ ?><div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <?php echo $fgmembersite->GetErrorMessage(); ?> </div> <?php } ?>
<input type='hidden' name='submitted' id='submitted' value='1' />
<table><tr><td width="54%" valign="top">
<p>
 <select name="college" id="college" style="color: grey;" required>
 <option value="">-Select College-</option>
 <?php $qry=mysql_query("select DISTINCT(COLLEGE),COLLEGE_FULLNAME from student_data"); 
 while($rs=mysql_fetch_array($qry)){ ?>
     <option value="<?php echo $rs['COLLEGE']; ?>"><?php echo $rs['COLLEGE_FULLNAME']; ?></option>
 <?php }  ?>
 </select> </p>
 <p><select name="shortname" id="shortname" style="color: grey;" required>
 <option value="">-Select College Shortname-</option>
 </select>
</p>
<p>
<div id="datetimepicker1" class="input-append date">
   <input data-format="dd/MM/yyyy hh:mm:ss" type="text" name="sdate"  class="input-large" Placeholder="Start Date" required/>
    <span class="add-on"  style="padding:3px;height:30px">
      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
      </i>
    </span>
  </div>
</p>
<p>            
  <div id="datetimepicker1" class="input-append date">
  End Date  <input data-format="dd/MM/yyyy hh:mm:ss" type="text" name="edate" class="input-large" Placeholder="End Date" required/>
    <span class="add-on"  style="padding:3px;height:30px">
      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
      </i>
    </span>
  </div>
  </p>
  </td>
  <td width="46%" valign="top">
  <p><select name='attempt' style="color: grey;" required>
  <option value="">&ndash;Select Attempt&ndash;</option>
  <option value="1">One Attempt</option>
  <option value="2">Two Attempt</option>
  <option value="3">Three Attempt</option>
  
  </select></p>
 <!-- <p><input name="venue" id="venue" type="text" placeholder="Venue Details" class="input-large" required /></p> 
  <p><input name="company" id="company" type="text" placeholder="Company Details" class="input-large" required/></p> -->  
  </td>
  </tr>
  </table>
    <input type='submit' class="btn btn-success" id="button1" name='Submit' value='Download Excel' /> &nbsp;&nbsp;&nbsp;<!--<a href="?id=view feedback setting" class="btn btn-danger" style="float: right;margin-left:10px;margin-right:10px;">View All Feedback  Setting</a>&nbsp;&nbsp;&nbsp;<!--<a href="?id=create test" class="btn btn-info" style="float: right;">Create Test</a> -->
</fieldset>
</form>
</div>
<script type='text/javascript' src="../../../../javascript/bootstrap.min.js"></script>
<script type='text/javascript' src="../../../../javascript/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../../../../css/bootstrap-datetimepicker.min.css">
<script type="text/javascript" src="../../../../javascript/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="../../../../javascript/bootstrap-datetimepicker.pt-BR.js"></script>


<script type="text/javascript">
  $(function() {
    $('.date').datetimepicker({
      language: 'en',
      format: "yyyy-MM-dd"
    });
  });
</script>
<link type="text/css" href="../../../../css/bootstrap.min.css" />
<link type="text/css" href="../../../../css/bootstrap-timepicker.min.css" />
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script> -->
<script type="text/javascript" src="../../../../javascript/bootstrap-2.2.2.min.js"></script> 
<script type="text/javascript" src="../../../../javascript/bootstrap-timepicker.min.js"></script>
<script type="text/javascript">
$('#timepicker1').timepicker();
</script>


        