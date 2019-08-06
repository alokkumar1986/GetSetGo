<?php //session_start(); 
//error_reporting(0);
$arrConditions = array('college' => $_SESSION['college']);
$student_data = $fgmembersite->getWhereCustomActionValues("USP_STUDENT_DATA", "EMAL", $arrConditions);
?>
<h1>Email Writting/Verbal Test</h1>
<script>
function openerNew(page_name){
	var params =  'top=0, left=0';
	params += ', width='+screen.width+', height='+screen.height+',statusbar=no,toolbar=no,location=no,directories=no,menubar=no,resizable=no';
	params += ', scrollbars=auto, status=no, fullscreen=yes, minimizable=no, titlebar=0, channelmode=1';
            //newwin=window.open("start.html?idmsg=<?php echo md5(time()); ?>&test_id="+page_name,"_blank",params);
            newwin=window.open("verbaltest/index.php?idmsg=<?php echo md5(time()); ?>&college="+page_name,"_blank",params);
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
        <div>
        	<?php 
        	if(empty($student_data['result'])){ ?>

        	<h4 align="center"><font color="#000000">No Email Writting/Verbal Test is activate for Regd No: <?php echo $_SESSION['regno_of_user']; ?>.
        	</font></h2>

        	<?php }else{

        		$sel = $student_data['result'];
        		$i=0;

        		do{

        			$arrConditionss = array('regdno' => $_SESSION['regno_of_user'], 'college' => $_SESSION['college']);
        			$result_data = $fgmembersite->getWhereCustomActionValues("USP_STUDENT_DATA", "REML", $arrConditionss);
        			$rs = $result_data['result'];
    //print_r($rs); exit;
        			do{
        				?>
        				<div style="padding:5px;margin:5px">
        					<div class="style1" title="<?php echo $sel['college']; ?>"  >
        						<div style="float:left;width:70%;">
        							<h2 align='center'><font color="#000000">Email Writting/Verbal Test</font></h2>
        						</div>		
        						<?php


        						if($sel['id']==$rs['test_id'] and $rs['status']=='finish'){ ?>
        						<div style="float:right;background-color:#FF0000;color:#fff;padding:6px;font-weight:bold;margin:4px;">Closed<br /><img style="padding:3px;" src="img/start.png" width="40" height="40" alt="dashboard" align="absmiddle" /></div>
        						<?php }else if($sel['id']==$rs['test_id'] and $rs['status']==''){
        							$start=($rs['start_date'])?$rs['start_date']:'00:00';
        							$end=$sel['end_date'];
        							date_default_timezone_set("Asia/Kolkata");
        							$date=date("Y-m-d h:i:s");
		//if($date>$start){ ?>
		
		<div align='center' style="float:right;background-color: #663399;color:#fff;padding:6px;font-weight:bold;float:right;margin:4px;"  
		onClick="openerNew('<?php echo base64_encode($sel['college']); ?>')">Test On Progress <br /><img style="padding:3px;" src="img/start.png" width="40" height="40" alt="dashboard" align="absmiddle" /></div>
	<?php //}
}else{ ?>
<div align='center' style="float:right;background-color: #663399;color:#fff;padding:6px;font-weight:bold;float:right;margin:4px;"  
onClick="openerNew('<?php echo base64_encode($sel['college']); ?>')">Start Test <br /><img style="padding:3px;" src="img/start.png" width="40" height="40" alt="dashboard" align="absmiddle" /></div>

<?php }
} while(next($rs['id'])!='');
?>

<div style="clear:both"></div>
</div>
<div class="style3" title="<?php echo $sel['test_name']; ?>"  >
	<div style="width:98%;text-align:center">

		Duration : <span class="style2"><?php echo $sel['duration']; ?></span> Minutes ,
		
		Start Date : <span class="style2"><?php echo date('dS M y h:m:s',strtotime($sel['start_date'])); ?></span>,
		End Date : <span class="style2"><?php echo date('dS M y h:m:s',strtotime($sel['end_date'])); ?></span>
	</div>
</div>
</div>

<?php 
}while(next($sel['id'])!='');
}?>