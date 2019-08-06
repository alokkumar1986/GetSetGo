<?php
require_once("../../include/membersite_config.php");
$fgmembersite->DBLogin();
$id=$_POST['id'];
$qry=mysql_query("select college_code from college where name='$id'");

?>
<select name="code" id="code" style="color: grey;">
 
 <?php 
 while($rs=mysql_fetch_array($qry)){ ?>
 	<option value="<?php echo $rs['college_code']; ?>"><?php echo $rs['college_code']; ?></option>
 <?php } ?>
 </select>