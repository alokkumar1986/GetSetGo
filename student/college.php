<?php require_once("./include/membersite_config.php");
$fgmembersite->DBLogin();
$id=$_GET['id'];
$id1=$_GET['id1'];
$coll=explode('-',$id1);
$college=$coll[0];
?>
 <select name="college" id="college" class="validate[required] text-input" style="color: grey;width:98% !important;">
                   	<option value="">-Select College-</option>
                   	<?php $sql=mysql_query("select * from college where (university='$id')")or die(mysql_error());
                   	while($rs=mysql_fetch_array($sql)){ ?>
					<option value="<?php echo $rs['name']; ?>-<?php echo $rs['short_name']; ?>" ><?php echo $rs['name']; ?></option>
					<?php } ?>
                   </select>