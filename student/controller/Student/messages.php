<?PHP 
if($_GET['action']=='delete'){
	$rs=mysqli_query($fgmembersite->connection, "delete from `message` where id='$_GET[id1]'");
}
?>
<link rel="stylesheet" href="../../../../css/colorbox.css" />
<script src="../../../../javascript/jquery.min.js"></script>
<script src="../../../../javascript/jquery.colorbox.js"></script>
<script>
$(document).ready(function(){
$(".example5").colorbox({iframe:true, innerWidth:900, innerHeight:600,
onCleanup:function(){ //window.location="calculator.php";
}});
				
});
</script>
<div>
			<h2>All Messages</h2>
			<ul class="comments">
			<?php 
			$yop=$student_data['COURSE_YOP'];
			$college=$student_data['COLLEGE'];
			$course=$student_data['COURSE'];
			$branch=$student_data['BRANCH'];
			//}
			$arrConditions = array('yop' => $yop, 'college' => $college, 'course' => $course, 'branch'=>$branch, 'email'=>$_SESSION['email_of_user']);
			$message = $fgmembersite->getWhereCustomActionValues("USP_STUDENT_DATA", "MSG", $arrConditions);
			if(!empty($message['result'])){
			   $messages  = $message['result'];
			}
	
			$count=count($messages);
			if($count!='0'){
			foreach($messages as $row){
		?>
					<li>
						<div class="comment-body clearfix">
							<img class="comment-avatar" src="design/dummy.gif" style="float: left;margin-right: 12px;">
							<a href="#"><?php echo ucwords($row['sentfrom']); ?></a> :
							<div><?php echo ucwords($row['message']); ?></div>
						</div>
						<div class="links">
							<span class="date"><?php echo date('d/m/Y',strtotime($row['date'])); ?></span>
							<a href="reply.php?id=<?php echo $row['id']; ?>" class="example5 reply">Reply</a>
							<a href="?id=messages&action=delete&id1=<?php echo $row['id']; ?>" class="delete" onclick="return confirm('Are You Sure to delete this entry?')">Delete</a>
						</div>
					</li>
					<?php } }else{ ?>					
					<h1>No Messages</h2>
					<?php } ?>		
					
				</ul>
			</div>