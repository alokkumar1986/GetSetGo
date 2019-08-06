<?php
require_once("../../include/membersite_config.php");
$fgmembersite->DBLogin();
$id=$_POST['id'];
$qry=mysql_query("select course from course where college='$id'");

?>
<select name="course" id="course" style="color: grey;">
 <option value="">-Select Course-</option>
 
 <?php 
 while($rs=mysql_fetch_array($qry)){ ?>
 	<option value="<?php echo $rs['course']; ?>"><?php echo $rs['course']; ?></option>
 <?php } ?>
 </select>