<?php
require_once("../../include/membersite_config.php");
$fgmembersite->DBLogin();
$id=$_POST['id'];
$qry=mysql_query("select distinct(COLLEGE) from student_data where COLLEGE='$id'");

?>
<select name="code" id="code" style="color: grey;">
 
 <?php 
 while($rs=mysql_fetch_array($qry)){ ?>
 	<option value="<?php echo $rs['COLLEGE']; ?>"><?php echo $rs['COLLEGE']; ?></option>
 <?php } ?>
 </select>