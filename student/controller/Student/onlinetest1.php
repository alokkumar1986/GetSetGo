<script>
		 function openerNew(page_name){
            var params =  'top=0, left=0';
            params += ', width='+screen.width+', height='+screen.height+',statusbar=no,toolbar=no,location=no,directories=no,menubar=no,resizable=no';
            params += ', scrollbars=auto, status=no, fullscreen=yes, minimizable=no, titlebar=0, channelmode=1';
            //newwin=window.open("start.html?idmsg=<?php echo md5(time()); ?>&test_id="+page_name,"_blank",params);
			newwin=window.open("onlinesystem/index.php?idmsg=<?php echo md5(time()); ?>&test_id="+page_name,"_blank",params);
            if (window.focus) {newwin.focus()}
	            return false;
        }
</script>
		<style>
.style1
{
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
<div align="center">

<?php 
$arrConditionss = array('regdno' => $_SESSION['regno_of_user'], 'college' => $_SESSION['college']);
$result_data = $fgmembersite->getWhereCustomActionValues("USP_TEST", "TST", $arrConditionss);
//echo "<pre>";print_r($result_data);
$rows = $result_data['result'];
if(empty($rows)){ ?>
 	<h2><font color="#000000">Sorry, No test is activate for <?php echo $_SESSION['college']; ?>	</font></h2>
 <?php exit;
}
else{

    foreach ($rows as $row) { ?>

    <div style="padding:5px;margin:5px">
    <div class="style1" title="<?php echo $row['test_name']; ?>"  >
    <div style="float:left;width:70%;">
      <h2><font color="#000000"><?php echo $row['test_name']; ?>
    </font></h2>        
      </div>
      
   <?php  
   if($row['completedInstance']==$row['instance']){ ?>

   <div style="float:right;background-color:#FF0000;color:#fff;padding:6px;font-weight:bold;margin:4px;" onClick="openerNew('<?php echo base64_encode($row['test_id']); ?>')">Maximum Instance Reached<br /><img style="padding:3px;" src="img/start.png" width="40" height="40" alt="dashboard" align="absmiddle" /></div>

<?php }else{

$rowsel = $row['instance'];
$start  = $row['start_date'];
$end    = $row['end_date'];
date_default_timezone_set("Asia/Kolkata");
$date   = date("Y-m-d h:i:s");
if($date<$start){
?>
<div style="float:right;background-color:<?php if($count11==$rowsel){ ?>#FF0000; <?php }else{ ?> yellow;<?php } ?>color:#fff;padding:6px;font-weight:bold;float:right;margin:4px;">Test Yet to Start<br /><img style="padding:3px;" src="img/start.png" width="40" height="40" alt="dashboard" align="absmiddle"  /></div>
<?php
}
else if($date>$end){
?>
<div style="float:right;background-color:<?php if($count11==$rowsel){ ?>#FF0000; <?php }else{ ?> pink;<?php } ?>color:#fff;padding:6px;font-weight:bold;float:right;margin:4px;" onClick="alert('The test is expired. Please contact Adminstrator.');">Test Expired<br /><img style="padding:3px;" src="img/start.png" width="40" height="40" alt="dashboard" align="absmiddle"  /></div>
<?php
}

} ?>
<div style="clear:both"></div>      
</div>

<div class="style3" title="<?php echo $row['test_name']; ?>"  >
<div style="width:98%;">
      Number of Module :<span class="style2"><?php echo $row['n']; ?></span>,
        Duration : <span class="style2"><?php echo $row['d']; ?></span> Minutes ,
        Total Questions : <span class="style2"><?php echo $row['q']; ?></span>,
        Instance Allowed : <span class="style2"><?php echo $row['instance']; ?></span>,
        Start Date : <span class="style2"><?php echo date('dS M y h:m:s',strtotime($row['start_date'])); ?></span>,
        End Date : <span class="style2"><?php echo date('dS M y h:m:s',strtotime($row['end_date'])); ?></span>
      </div>
      </div>
</div>

<?php }
?>

</div>
<?php }
?>
</div>
