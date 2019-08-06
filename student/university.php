<?php require_once("./include/membersite_config.php");
$fgmembersite->DBLogin();
$id=$_GET['id'];
//$id1=$_GET['id1'];
//$coll=explode('-',$id1);
		$college=$coll[0];
?>
 <select name="university" id="university" class="validate[required] text-input" style="color: grey;width:280px !important;">
                   	<option value="">-Select University-</option>
                   	<?php $sql=mysql_query("select * from university where state='$id'")or die(mysql_error());
                   	while($rs=mysql_fetch_array($sql)){ ?>
					<option value="<?php echo $rs['university']; ?>" ><?php echo $rs['university']; ?></option>	
					<?php } ?>
                   </select>