<?PHP session_start(); 
require_once("../../include/membersite_config.php");
error_reporting(0);
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
       $fgmembersite->RedirectToURL("reply.php");
   }
}
?>
<link rel="stylesheet" href="../../../../css/bootstrap.min.css">
<div>
			<h2 style="padding-left:30px;border-bottom:1px dotted #0000CC;">All Messages</h2>
			<ul class="comments" style="list-style:none;">
			<?php 
			$sql1="select * from student_data where `EMAIL_ID`='".$_SESSION['email_of_user']."'";
			$rs1=mysql_query($sql1);
			while($row1=mysql_fetch_array($rs1)){
			$yop=$row1['COURSE_YOP'];
			$college=$row1['COLLEGE'];
			$course=$row1['COURSE'];
			$branch=$row1['BRANCH'];
			}
	$sql="select * from `message` where ((`to` ='".$_SESSION['regno_of_user']."') or (`college` LIKE '%".$college."%' AND `branch` LIKE '%".$branch."%' AND `to` LIKE '%".$yop."%') or (`to`='Administrator' and `sentfrom`='".$_SESSION['regno_of_user']."')) order by `date` desc";
	//echo $sql;
	$rs=mysql_query($sql);
	$count=mysql_num_rows($rs);
	if($count!='0'){
	while($row=mysql_fetch_array($rs)){
		?>
					<li>
						<div class="comment-body clearfix">
							<img class="comment-avatar" src="design/dummy.gif" style="float: left;margin-right: 12px;">
							<a href="#"><?php echo ucwords($row['sentfrom']); ?></a> :
							<div><?php echo ucwords($row['message']); ?></div>
						</div>
						<div class="links">
							<!--<span class="date"><?php echo date('d/m/Y',strtotime($row['date'])); ?></span>
							<a href="reply.php?id=<?php echo $row['id']; ?>" class="example5 reply">Reply</a>
							<a href="?id=messages&action=delete&id1=<?php echo $row['id']; ?>" class="delete" onclick="return confirm('Are You Sure to delete this entry?')">Delete</a>-->
						</div> 
						<br />
						<br />
					</li>
					<?php } }else{ ?>
					
					<h1>No Messages</h2>
					<?php } ?>
					
					
				</ul>
			</div>
			<form action="" method="post">
			<h3>Write Your Message</h3>
			<input type='hidden' name='submitted' id='submitted' value='1'/>
<input type='hidden' name='from' id='from' value='<?php echo $_SESSION['email_of_user']; ?>'/>
<input type='hidden' name='to' id='to' value='Adminstrator'/>

<input type="hidden" name="college" id="college" class="validate[required] text-input" value="<?php echo $college; ?>" />
                   	
<input type="hidden" name="course" id="course" class="validate[required] text-input" value="<?php echo $course; ?>" />
<input type="hidden" name="branch" id="branch" class="validate[required] text-input" value="<?php echo $branch; ?>" />
<input type="hidden" name="yop" class="validate[required] text-input" value="<?php echo $yop; ?>" />
<textarea name="message" rows="10" cols="103" style="width:876px;"></textarea>
<input type='submit' class="btn btn-success" name='Submit' value='Send'  />
</form>
