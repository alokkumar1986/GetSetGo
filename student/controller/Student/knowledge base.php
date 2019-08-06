</style>
<style>
.material{
list-style: none;
}
.material li{
height:120px;
display: inline-block;zoom:1;*display:inline;text-align: center;padding: 10px;background: #ddd;	
width:100px;margin:0px 2px 10px 2px;border-radius:4px;
}
.material li:hover{
background: #fff;border:1px solid #ddd;border-radius:4px;
}
</style> 
<div class="con_right"><!--content right --> 
        <h1 class="heading">Knowledge Base </h1>
		<br/>
		<div style="">
		<h2>Materials</h2>
		<ul class="material">
		<?php 
		$sql1="select * from student_data where EMAIL_ID='".$_SESSION['email_of_user']."'";
		$res=mysql_query($sql1);
		if($rows=mysql_fetch_array($res)){
	    $coll=$rows['COLLEGE'];
		}
		$sql12="select * from `materials` where college='".$coll."'"; 
		$sql=mysql_query($sql12);
		$count=mysql_num_rows($sql);
		if($count){
		while($rs=mysql_fetch_array($sql)){
			?><li><a href="../../../assessment/controller/admin/materials/<?php echo $rs['file']; ?>"  target="_blank" ><img src="../../../../newimg/download.png" height="" width="50"/><br /><br /><?php echo substr( $rs['name'],0,10)."..."; ?></a></li>
			
			<?php } 	
		}?>
		
		</div>
		</div>