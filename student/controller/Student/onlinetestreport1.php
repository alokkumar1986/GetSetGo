<?php session_start(); ?>
<style>
.style1
{
text-align:center;
padding:2px;
margin:0px;
border:1px solid #999999;
background-color:#F7F7F7;
cursor: pointer;
}
.style1:hover
{
background-color:#D2D2D2;
}
.style3
{
padding:2px;
margin:0px;
border-left:1px solid #999999;
border-right:1px solid #999999;
border-bottom:1px solid #999999;
color:#FFFFFF;
background-color:rgb(0, 133, 204);
cursor: pointer;
}
.style3:hover
{
background-color:#D2D2D2;
color:#000;
}
.style2 
{
color: #FFFF00;
font-weight: bold;
}
</style>
<div>
<?php 
//include("onlinesystem/class.database.php");
//$db = new Database();  
//$db->connect();
$qry=mysql_query("select * from `test_setting` where for_college='".$_SESSION['college']."' order by start_date desc");
$c=mysql_num_rows($qry);
if($c=='0' ){ 
if($_SESSION['college']!=''){
?>
<h2><font color="#000000">No test is activated for <?php echo $_SESSION['college']; ?>.
	</font></h2>
<?php } exit;}
while($sel=mysql_fetch_array($qry)){
$date=date('Y-m-d');
$enddate=date('Y-m-d',strtotime($sel['end_date']));
$rs= "SELECT test_name,COUNT(test_name) as n ,test_id ,sum(duration) as d ,sum(TOTAL_NO_QUESTION) as q from online_test where (test_id='".$sel['test_id']."' AND STATUS='ACTIVE') order by id desc"; 
$rs1=mysql_query($rs)or die(mysql_error());
while($row=mysql_fetch_array($rs1)){ 
$res1=mysql_query("select * from test_tests where test_id='".$row['test_id']."'");
while($ros=mysql_fetch_array($res1)){ 
?>
	<div style="padding:5px;margin:5px">
	<div class="style1" title="<?php echo $ros['test_name']; ?>"  >
	<div style="float:left;width:40%;">
	  <h2><font color="#000000"><?php echo $ros['test_name']; ?>
	</font></h2>
		
	  </div>
	<?php
	$qrya=mysql_query("select * from `test_status` where test_id='".$row['test_name']."' AND candidate='".$_SESSION['regno_of_user']."' AND status='finish'")or die(mysql_error());
	 $count=mysql_num_rows($qrya);
	if($count=='0'){
?>
		<div style="float:right;background-color:#663399;color:#fff;padding:6px;font-weight:bold;float:right;margin:4px;">Test Yet To Appear<br /><img style="padding:3px;" src="img/start.png" width="40" height="40" alt="dashboard" align="absmiddle" onClick="alert('To appear test, go to online test menu.')" /></div>
		<?php }

	
	while($res=mysql_fetch_array($qrya)){
 $sqlll="select * from test_status where (test_id='".$row['test_name']."' AND candidate='".$_SESSION['regno_of_user']."' AND status='finish' AND instance='".$res['instance']."')";
$rs111=mysql_query($sqlll);
$count11=mysql_num_rows($rs111);
if($count11>='1'){
?>
<div style="float:right;background-color:#FF0000;color:#fff;padding:5px;font-weight:bold;margin:4px;">
<a href="<?php if($sel['result']=='No'){ ?> # <?php }if($sel['result']=='Yes'){ ?> ?id=<?php echo base64_encode('report'); ?>&test=<?php echo $row['test_name']; ?>&instance=<?php echo $res['instance']; ?> <?php } ?>" style="color:#fff;" 
<?php if($sel['result']=='No'){ ?> onClick="alert('Test Result for this test is deactivated by the Administrator!');" <?php } ?>
>Instance <?php echo $res['instance']; ?><br /><img style="padding:3px;" src="img/start.png" width="30" height="30" alt="dashboard" align="absmiddle" /></a></div>

<?php } } ?>
<div style="clear:both"></div>
</div>
<div style="clear:both"></div>
<div class="style3" title="<?php echo $ros['test_name']; ?>"  >
<div style="width:58%;">
Number of Module :<span class="style2"><?php echo $row['n']; ?></span>,
		Duration : <span class="style2"><?php echo $row['d']; ?></span> Minutes ,
		Total Question : <span class="style2"><?php echo $row['q']; ?></span>
</div>
<?php $qrya=mysql_query("select * from `test_status` where test_id='".$row['test_name']."' AND candidate='".$_SESSION['regno_of_user']."' AND status='finish'")or die(mysql_error()); 
while($res=mysql_fetch_array($qrya)){ 
$sqlll="select * from test_status where (test_id='".$row['test_name']."' AND candidate='".$_SESSION['regno_of_user']."' AND status='finish' AND instance='".$res['instance']."')";
$rs111=mysql_query($sqlll);
$count11=mysql_num_rows($rs111);

if($count11>='1'){ ?>
<div style="float:right;background-color:#FF0000;color:#fff;padding:2px;font-weight:bold;margin-right:6px;margin-top:-21px;padding-left:8px;padding-right:8px;">
<a href="<?php if($sel['review']=='Yes'){ ?>?id=<?php echo base64_encode('review'); ?>&test=<?php echo $row['test_name']; ?>&instance=<?php echo $res['instance']; ?> <?php } if(($sel['review']=='YesR') AND ($date>=$enddate)){ ?> ?id=<?php echo base64_encode('review'); ?>&test=<?php echo $row['test_name']; ?>&instance=<?php echo $res['instance']; ?> <?php } if($sel['review']=='No'){ ?># <?php } ?>" style="color:#fff;font-weight:bold;" <?php if($sel['review']=='No'){ ?> onClick="alert('Test result is not set to be viewed. Please Contact Administrator!!');" <?php } ?> >Review <?php echo $res['instance']; ?></a> 
</div>
<?php }} ?> </div></div><?php 
		
	}	}	}
	//$db->disconnect();
	?>
