<?php
require_once("../../include/membersite_config.php");
$fgmembersite->DBLogin();
 //$state=implode($_POST['id']);
$state1=explode(",",$_POST['id']);
	 $count=count($state1);
	 //exit;
	 $state="";
	 for($i=0;$i<$count;$i++){
	 	$state.= "'$state1[$i]'";
	 	if($i<($count-1)){
			$state.=",";
		}
	 }
//echo "select s.COLLEGE,distinct(p.name) from college as p, student_data as s where ((s.COLLEGE=p.short_name) AND p.state IN ($state))";
 $qry=mysql_query("select distinct(p.name),p.short_name from college as p, student_data as s where ((s.COLLEGE=p.short_name) AND p.state IN ($state))")or die(mysql_error());
 $rs1=mysql_query("select * from search where id='1'");
if($row1=mysql_fetch_array($rs1)){
	$college=explode(",",$row1['college']);
	}
 while($rs=mysql_fetch_array($qry)){ ?>
 	 <div class="col-lg-9" style="margin-bottom: 3px;">
	<div class="input-group">
      <span class="input-group-addon">
      <input type="checkbox" name="college[]" class="case" <?php if(in_array($rs['short_name'],$college)){ ?> checked="checked" <?php } ?> value="<?php echo $rs['short_name']; ?>" />
      </span>  
      <input type="text" class="form-control" value="<?php echo $rs['name']; ?>(<?php echo $rs['short_name']; ?>)" />
      </div>
      </div>
 <?php } ?>
 