<?php 
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}

$fgmembersite->DBLogin();
$user=$_REQUEST['q'];
$test=$_REQUEST['test'];
$sql="select distinct(instance) from `test_status` where candidate='$user' AND test_id='$test' AND status='finish'";
$rs=mysql_query($sql)or die(mysql_error());
while($row=mysql_fetch_array($rs)){
?>
<p><input type="checkbox" name="instance[]" value="<?php echo $row['instance']; ?>">  <b>Instance <?php echo $row['instance']; ?></b></p>
<?php
}
?>