<?php //session_start();
//error_reporting(0);
include("onlinesystem/class.database.php");
$db = new Database();
$db->connect(); 

$user=$_SESSION["regno_of_user"];
$test=$_GET['test'];
$result=mysql_query("select * from `test_tests` where test_id='".$test."'");
if($rows=mysql_fetch_array($result)){
$testname=$rows['test_name'];
}

?>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title>Online Test Result</title>
<link class="include" rel="stylesheet" type="text/css" href="onlinesystem/jquery.jqplot.min.css" />
<div style="margin:auto;width:1000px;">
<h1 align="center"><?php echo $testname; ?>, Instance - <?php echo $_GET['instance']; ?></h1>

<?php  
$i=1;
$c=0;
//$db->select('online_test','*',"STATUS='active'",null,null,null);  
//echo "select * from online_test where (test_name='".$test."' and  STATUS='ACTIVE') group by test_name";
$rs=mysql_query("select * from online_test where (test_id='".$test."' and  STATUS='ACTIVE') order by id");
$count=mysql_num_rows($rs);
while($row=mysql_fetch_array($rs)){ ?>
	<div class=pic1  style="float:left;width:92%; border:2px solid #0033CC;padding:20px;margin:20px;">
	<table style="border:none;border-collapse: collapse" width="100%"><tr><td width="50%">
	<div id="pie<?php echo $i; ?>" align=center style="margin-top:20px; margin-left:20px; width:350px; height:350px;"></div>
<?php 
$mark=$row['EACH_QUE_MARK_CORRECT'];
$minus=$row['EACH_QUE_MARK_WRONG'];
//echo "select * from student_result where cat_id=$row[CATEGORY] AND reg_no='$user'"; 
$rs1=mysql_query("select * from student_result where test_id='".$row['test_id']."' and cat_id='".$row['CATEGORY']."' AND reg_no='$user'");  
while($row1=mysql_fetch_array($rs1)){
?>
	</td><td>
	
			<div align="center">
				<table style="border-collapse: collapse" class=pic bgcolor="#FFFFA8" cellspacing="6" cellpadding="6" width="234" border="1" >
	<tr>
	<td align="right" width="99"><font size="2" color="#800000">Total Question		</font>		</td>
	<td align="center"><font size="2"><?php echo $ia=count(explode(",",$row1['question_attend'])); ?></font></td></tr><tr>
	<?php 
	$queid=explode(",",$row1['question_attend'])	;
	//$ans=explode(",",$row1['correct_ans']);
	$un=0;
	$cor=0;
	for($j=0;$j<$ia;$j++){
	//echo $queid[$j].",";
	$quest=mysql_query("select * from `questions` where id='".$queid[$j]."'");
if($rowquest=mysql_fetch_array($quest)){
$ans=$rowquest['corans'];
}
	$rs2=mysql_query("select * from `temp_test_result` where test_id='".$row['test_id']."' and question_id='$queid[$j]' AND candidate='$user' AND instance='".$_GET['instance']."'");  
	if($row2=mysql_fetch_array($rs2)){
	//echo $row2['question_id'];
	if($row2[question_id]==$queid[$j]){
	if($row2[answer]){
	$un++;
	}
	}
	if($row2[answer]==$ans){
	$cor++;
	}
	}
	}
	
	
	

	?>
	
		<td height="23" align="right" width="99" >
		<font size="2" color="#800000">Incorrect</font></td>
	<td align="center" width="63" height="23"><font size="2"><?php echo $un-$cor; ?></font></td></tr><tr>

		<td align="right" width="99" >	<font size="2" color="#800000">Un-Attempted	</font>	</td>
	<td align="center"><font size="2"><?php echo ($ia-$un); ?></font></td></tr><tr>

	<td align="right" width="99" ><font size="2" color="#800000">Correct</font></td>
		<td align="center">
		
		<font size="2">
		
		<?php echo $cor; 
		$c=((($mark*$cor)-($minus*($un-$cor)))/$ia)*100;
		?>
		</font>
		</td>
	<h4 align="center">Overall Score : <?php echo round($c,2); ?>%</h4>

	
	</tr>
</table>
			</div>
</td></tr></table>
</div>
<!--<h4 align="center">Overall Score : <?php //echo $c; ?>%</h4>
 -->
<script src="onlinesystem/js/jquery.min.js"> </script>
<script type="text/javascript" src="onlinesystem/js/jquery.countdown.js"></script>     
 <link rel='stylesheet' type='text/css' href='onlinesystem/css/style.css' />
 <script class="include" type="text/javascript" src="onlinesystem/jquery.jqplot.min.js"></script>
<script class="include" type="text/javascript" src="onlinesystem/plugins/jqplot.pieRenderer.min.js"></script>
<script class="code" type="text/javascript">
$(document).ready(function(){ 

    var s<?php echo $i; ?>= [['Correct',<?php echo $cor; ?>], ['Incorrect',<?php echo $ia-($ia-$un)-$cor;; ?>], ['Un-Attempted',<?php echo $ia-$un; ?>]];
         
    var plot<?php echo $i; ?> = $.jqplot('pie<?php echo $i; ?>', [s<?php echo $i; ?>],
          {
          textColor:"#FFFFFF",
    title: {
        text: '<?php echo  $row['CATEGORY'];//$row[CATEGORY]; ?>',   // title for the plot,
        show: true
},
        grid: {
            drawBorder: false, 
            drawGridlines: false,
            background: '#ffffff',
            shadow:false
        },
       
        axesDefaults: {
             
        },
        seriesDefaults:{
            renderer:$.jqplot.PieRenderer,
            rendererOptions: {
                showDataLabels: true
            }
        },
        legend: {
            show: true,
            rendererOptions: {
                numberRows: 1
            },
            location: 's'
        }
             
    }); 

});
</script>
<?php
$i++;
	}
	?>
	 
<?php } ?> 
</div>    
