<?PHP //session_start(); 
require_once("../../include/membersite_config.php");
//error_reporting(0);
$id=$_GET['id1'];
if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}
$fgmembersite->DBLogin();
/*if($_GET['action']=='delete'){
	//$fgmembersite->Deletenotice($_GET['id1']);
	
	$rs=mysql_query("delete from `message` where id='$_GET[id1]'");
}*/
if(isset($_POST['submitted']))
{
   if($fgmembersite->compose1())
   {
       $fgmembersite->RedirectToURL("?id=reply&id1=$id");
   }
}
?>
<div>
			<h3 style="border-bottom:1px dotted #0000CC;">All Messages</h3>
			<ul class="comments" style="list-style:none;">
			<?php 
			$sql1="select * from message where `id`='".$id."'";
			$rs1=mysql_query($sql1);
			while($row1=mysql_fetch_array($rs1)){
			$to=$row1['to'];
			$to=$row1['to'];
			$from=$row1['sentfrom'];
			$college=$row1['college'];
			$course=$row1['course'];
			$branch=$row1['branch'];
			$yop=$row1['yop'];
			}
	$sql="select * from `message` where ((`to` ='".$to."' AND `sentfrom` ='".$from."') or (`to` ='".$from."' AND `sentfrom` ='".$to."')) order by `id` asc";
	$rs=mysql_query($sql);
	$count=mysql_num_rows($rs);
	if($count!='0'){
	while($row=mysql_fetch_array($rs)){
		?>
					<li>
						<div class="comment-body clearfix">
							<img class="comment-avatar" src="../../../../images/profile.jpg" height="60" width="20" style="float: left;margin-right: 12px;border:1px solid #ddd;"> 
							<a href="#" style="color:#0000FF;font-weight:bold;"><?php echo ucwords($row['sentfrom']); ?></a> :
							<div style="padding-left:30px;"><?php echo ucwords($row['message']); ?></div>
						</div>
						<div class="links">
							<!--<span class="date"><?php echo date('d/m/Y',strtotime($row['date'])); ?></span>
							<a href="reply.php?id=<?php echo $row['id']; ?>" class="example5 reply">Reply</a>
							<a href="?id=messages&action=delete&id1=<?php echo $row['id']; ?>" class="delete" onclick="return confirm('Are You Sure to delete this entry?')">Delete</a>-->
						</div> 
						
						
					</li>
					<?php } }else{ ?>
					
					<h5>No Messages</h5>
					<?php } ?>
					
					
				</ul>
			
			<form action="" method="post">
			<h5>Write Your Message</h5>
			<input type='hidden' name='submitted' id='submitted' value='1'/>
			<?php if($fgmembersite->GetErrorMessage()){ ?><div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Warning!</strong> <?php echo $fgmembersite->GetErrorMessage(); ?> </div> <?php } ?>
<input type='hidden' name='from' id='from' value='Adminstrator'/>
<input type='hidden' name='to' id='to' value='<?php echo $from; ?>'/>

<input type="hidden" name="college" id="college" class="validate[required] text-input" value="<?php echo $college; ?>" />
                   	
<input type="hidden" name="course" id="course" class="validate[required] text-input" value="<?php echo $course; ?>" />
<input type="hidden" name="branch" id="branch" class="validate[required] text-input" value="<?php echo $branch; ?>" />
<input type="hidden" name="yop" class="validate[required] text-input" value="<?php echo $yop; ?>" />
<p><textarea name="message" rows="10" cols="103" style="width:576px;"></textarea></p>
<p><input type='submit' class="btn btn-success" name='Submit' value='Send'  /></p>
</form>
</div>