<?php require_once("./include/membersite_config.php");
$fgmembersite->DBLogin();
$id=$_POST['id'];
$coll=explode('-',$id);
		$college=$coll[0];
		//$formvars['college2']=$coll[1];
?>
 <select name="course" id="course" class="validate[required] text-input" style="color: grey;width:98% !important;">
                   	<option value="">-Select Course-</option>
                   	<?php $sql=mysql_query("select * from course where college LIKE '$college%'")or die(mysql_error());
                   	if($rs=mysql_fetch_array($sql)){ ?>
					<option value="<?php echo $rs['course']; ?>" ><?php echo $rs['course']; ?></option>	
					<?php } ?>
                   </select>