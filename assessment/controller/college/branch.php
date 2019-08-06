<?php require_once("./../../include/membersite_config.php");
$fgmembersite->DBLogin();
echo $id=$_GET['id'];
echo $id1=trim($_GET['id1']);
echo "select * from branch where (course='$id' and college='$id1')";
?>
 <select name="branch" id="branch" class="validate[required] text-input" style="color: grey;width:98% !important;">
                   	<option value="">-Select Branch-</option>
                   	<?php $sql=mysql_query("select * from branch where (course='$id' and college='$id1')")or die(mysql_error());
                   	while($rs=mysql_fetch_array($sql)){ ?>
					<option value="<?php echo $rs['branch']; ?>" ><?php echo $rs['branch']; ?></option>	
					<?php } ?>
                   </select>