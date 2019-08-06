<style>
	th{
		border: 1px solid #ddd;
		background:green;
		color: white;
	}
	</style>
<?php require_once("../../include/membersite_config.php");
require_once("../../include/student_config.php");
$fgmembersite->DBLogin();
$id=$_GET['id'];
$id1=$_GET['reg'];
$instance=$_GET['instance'];
$rs1=mysql_query("select * from student_data where REG_NO='$id1'");
$row1=mysql_fetch_array($rs1);
//$date=$_GET['date'];
$sql="select * from pi where ID='$id'";
$rs=mysql_query($sql);
while($row=mysql_fetch_array($rs)){
	?>
	<h1 align="center" style="color: #108bef;border-bottom: 1px solid #ddd;padding-left: 30px;padding-right: 30px;"><font color="red">PI Report Instance </font> - <?php echo $instance; ?> (Date : <?php echo date("dS M Y",strtotime($row['DATE'])); ?>)</h1>
	<table width="70%" style="margin: auto;background: red;color: #fffdfd;padding:5px;"><tr><td>&nbsp;&nbsp;&nbsp;<strong>Name   </strong></td><td>:</td> <td><?php echo $row1['NAME']; ?>&nbsp;&nbsp;&nbsp;</td>
        <td> <strong>Reg.No  </strong></td><td>:</td> <td> <?php echo $row1['REG_NO']; ?>&nbsp;&nbsp;&nbsp;</td>
       <td> <strong>Branch  </strong></td><td>:</td> <td> <?php echo $row1['BRANCH']; ?> &nbsp;</td></table>
       
       <tr><td colspan="9">&nbsp;</td></tr>
       
       <tr><td colspan="9"><table > 
       <tr><th colspan="2">Verbal Communication</th></tr>
       <tr valign="top" style="height:100%"><td><strong>CLARITY :</strong><?php echo $row['CLARITY']; ?></td></tr>
     <tr valign="top" style="height:100%"><td> <strong>ARTICULATION : </strong><?php echo $row['ARTICULATION']; ?></td></tr>
     <tr valign="top" style="height:100%"><td><strong>USAGES : </strong><?php echo $row['USAGES']; ?></td></tr>
     <tr><th colspan="2">Non-Verbal Communication</th></tr>
		 <tr valign="top" style="height:100%"><td> <strong>CONFIDENCE : </strong><?php echo $row['CONFIDENCE']; ?></td></tr>
		<tr valign="top" style="height:100%"> <td><strong>BODY LANGUAGE :</strong> <?php echo $row['BODY_LANG']; ?></td></tr>
		<tr valign="top" style="height:100%"><td><strong>LISTENING : </strong><?php echo $row['LISTENING']; ?></td></tr><tr><th colspan="2">Physical Appearance and Mannerism</th></tr>
		<tr valign="top" style="height:100%"><td> <strong>APPEARANCE : </strong><?php echo $row['APPEARANCE']; ?></td></tr>
		<tr valign="top" style="height:100%"><td> <strong>MANNERS : </strong><?php echo $row['MANNERS']; ?></td></tr>
		<tr><th colspan="2">Feedback</th></tr>
		<tr valign="top" style="height:100%"><td> <strong>COMMUNICATION FEEDBACK : </strong><br />
		<?php $count=1;
						 $choice=explode(",", $row['COMM_FEEDBACK']);
						foreach($choice as $a) {
							if($a!='')
							echo $count." - ".$a."<br />";
						$count++; } ?>
							
						</td></tr>
						<tr valign="top" style="height:100%"><td><strong>PREPARATION FEEDBACK : </strong><br /><?php $count=1;
						 $choice=explode(",", $row['PREP_FEEDBACK']);
						foreach($choice as $a) {
							if($a!='')
							echo $count." - ".$a."<br />"; 
						$count++; } ?></td></tr>
						<tr valign="top" style="height:100%">
						<td><strong>OTHER FEEDBACK : </strong><?php echo $row['OTHER_FEEDBACK']; ?> </td></tr>
						
						<tr><th colspan="2">Others</th></tr><tr valign="top" style="height:100%">
		<td><strong>OVERALL RATING : </strong><?php echo $row['RATING']; ?> </td>
		</tr>
						<tr valign="top" style="height:100%"><td><strong>INTERVIEWER :</strong> <?php echo $row['INTERVIEWER']; ?> </td>
						</tr>
						<tr valign="top" style="height:100%"><td><strong>TIME TAKEN : </strong><?php echo $row['TIME_TAKEN']; ?> </td></tr></table></td></tr></<table>
<?php }
?>