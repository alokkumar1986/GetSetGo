<link rel="stylesheet" href="../../../../css/colorbox.css" />
<script src="../../../../javascript/jquery.colorbox.js"></script>
<script>
		
			$(document).ready(function(){
				//Examples of how to assign the Colorbox event to elements
				
				$(".ajax").colorbox();
				
			});
		</script> 
		
		<style>
			#example_length select {
				width:53px !important;
			}
			#example_filter input{
				/*float:right;*/
			}
		</style>
<table cellpadding="0" cellspacing="0" border="0" class="display" id="example" width="100%">
<thead><tr style="border-bottom: 1px solid #000;><th align="center" ><h4>Personal Interview Report</h4></th></tr>
<tr valign="top"><th>Date</th><th>Instances</th></tr></thead>
<tbody>
<?php $sql="select * from student_data where `EMAIL_ID`='".$_SESSION['email_of_user']."'";
			$rs=mysql_query($sql);
			while($row1=mysql_fetch_array($rs)){
			$REG_NO=$row1['REG_NO'];
			}
	$qry1="select distinct(DATE) from pi where (REGD_NO='$REG_NO')";
	$rs1=mysql_query($qry1);
	$count=mysql_num_rows($rs1);
	if($count=='0'){
			?>
			<tr><td colspan=2 align='left'> No records found.</td></tr>
			<?php } 
	while($rw=mysql_fetch_array($rs1)){
	$qry="select * from pi where (REGD_NO='$REG_NO' AND DATE='".$rw['DATE']."')";
	$rs=mysql_query($qry);
	?>
		<tr valign="top" ><td ><?php echo date("dS M Y",strtotime($rw['DATE'])); ?></td><td >
		<?php $counter=1;
		while($row1=mysql_fetch_array($rs)){ ?>
			<a class="ajax btn btn-primary" href="../../../assessment/controller/staff/report.php?id=<?php echo $row1['ID']; ?>&instance=<?php echo $counter; ?>&reg=<?php echo $_SESSION['regno_of_user']; ?>" style="color: red;padding:3px !important;margin-top:3px;"> <?php echo $counter; ?></a>
		<?php $counter++; }	?>	
		</td>
		</tr>
		<?php		
	}
		
?></tbody></table>

