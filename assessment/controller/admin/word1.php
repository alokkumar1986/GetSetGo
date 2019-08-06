
<link rel="stylesheet" href="../../css/colorbox.css" />
		
		<script src="../../js/jquery.colorbox.js"></script>
		
		<script>
		
			$(document).ready(function(){
				//Examples of how to assign the Colorbox event to elements
				
				$(".ajax").colorbox();
				
			});
		</script> 
		<style type="text/css" title="currentStyle">
			
			@import "../../css/jquery.dataTables.css";
		</style>
		
		<script type="text/javascript" language="javascript" src="../../js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf-8">
		
			$(document).ready(function() {
				
				$('#example').dataTable();
			} );
		</script> 
		<style>
			#example_length select {
				width:53px !important;
			}
			#example_filter input{
				/*float:right;*/
			}
		</style>
<?php require_once("../../include/membersite_config.php");
error_reporting(0);
if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
if(!$fgmembersite->DBLogin())
        {
            $fgmembersite->HandleError("Database login failed!");
            return false;
        } 
$college=$_POST['college'];
$branch=$_POST['stream'];
$dateofinterview=$_POST['date'];
$interviewtype=$_POST['interviewtype'];
$regno=$_POST['regno'];
//header("Content-type: application/vnd.ms-excel");
//header("Content-Disposition: attachment;Filename=$college$dateofinterview.xls");
//$interviewtype=$_POST['interviewtype'];
if($regno==''){
if($college!='' and $branch==''){
	$qry = "select * from student_data where COLLEGE='$college'";
}
if($college=='' and $branch!=''){
	$qry = "select * from student_data where BRANCH='$branch'";
}
if($college!='' and $branch!=''){
$qry = "select * from student_data where COLLEGE='$college' and BRANCH='$branch'";	
}
if($college=='' and $branch==''){
$qry = "select * from student_data ";	
}
}else{
	$qry = "select * from student_data where REG_NO='$regno' ";
}
$rs=mysql_query($qry);

?>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
<thead><tr style="border-bottom: 1px solid #000;><th align="center" ><h4>Personalised Interview Report(<?php echo $interviewtype; ?>) (Date : <?php echo $dateofinterview; ?>)<br/><?php if($college!=''){ ?>College : <?php echo $college; ?>,<?php } ?> <?php if($branch!=''){ ?>Branch : <?php echo $branch; ?><?php } ?></h4></th></tr>
<tr valign="top"><th>REGD NO</th><th>Instances</th></tr></thead>
<tbody>
<?php
while($row=mysql_fetch_array($rs)){
	if($interviewtype=='PI'){
		$qry1="select * from pi where (REGD_NO='$row[REG_NO]' and DATE='$dateofinterview')";
	}
	if($interviewtype=='TI'){
		$qry1="select * from ti where (REGD_NO='$row[REG_NO]' and DATE='$dateofinterview')";
	}
	//$qry1="select * from pi where (REGD_NO='$row[REG_NO]' and DATE='$dateofinterview')";
	$rs1=mysql_query($qry1);
	$count=mysql_num_rows($rs1);
	if($count){
		
			?>
		<tr valign="top" ><td ><?php echo $row['REG_NO']; ?></td><td >
		<?php $counter=1;
		while($row1=mysql_fetch_array($rs1)){ ?>
			<a <?php if($interviewtype=='PI'){ ?>class="ajax btn btn-primary"<?php }else { ?>class="ajax btn btn-danger"<?php } ?> href="<?php if($interviewtype=='PI'){ ?>report.php<?php }else { ?>report1.php<?php } ?>?id=<?php echo $row1['ID']; ?>&instance=<?php echo $counter; ?>&reg=<?php echo $row['REG_NO']; ?>" style="color: #fff;padding:3px !important;margin-top:3px;"> <?php echo $counter; ?></a>
		<?php $counter++; }	?>	
		</td>
		</tr>

		<?php
		
	}}

		
?></tbody></table>
<p></p><p></p>