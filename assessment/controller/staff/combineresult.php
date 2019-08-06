<?PHP session_start();
error_reporting(0);
require_once("../../include/membersite_config.php");
if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}
if(isset($_POST['submitted']))
{
$var = $_POST['prepfeedback'];
$prepfeedback=implode(",",$var);
$var1 = $_POST['communifeedback'];
$communifeedback=implode(",",$var1);
$var2 = $_POST['techfeedback'];
$techfeedback=implode(",",$var2);
if(!$fgmembersite->DBLogin()) {
$_SESSION['data']="Database login failed!";
header("location: search.php");
exit;
}?>
<div style="background:#000;">
<?php
ob_end_flush();
$sql=mysql_query("select * from `student_data` where `REG_NO`='".$_POST['reg_no']."'")or die(mysql_error());
if($ros=mysql_fetch_array($sql)){
require '../PHPMailer/PHPMailerAutoload.php';
$count=1;
$feedback='<ul>';
$choice=explode(",", $communifeedback);
foreach($choice as $a) {
if($a!='')
$feedback.= "<li> ".$a."</li>";
$count++; } 							
$count=1;
$choice=explode(",", $row1['PREP_FEEDBACK']);
foreach($choice as $a) {
if($a!='')
$feedback."<li> ".$a."</li>"; 
$count++; } 
$feedback.="<li>".$_POST['otherhrfeedback']."</li></ul>";
// '".$techfeedback."', '".$_POST['othertechfeedback'].
$feedback1='<ul>';    
$choice1=explode(",", $techfeedback);
foreach($choice1 as $a) {
if($a!='')
$feedback1.="<li> ".$a."</li>";
$count++; } 
$feedback1.="<li>". $_POST['othertechfeedback']."</li></ul>";

$clarity=$_POST['clarity']*74;



$mail = new PHPMailer;
 
$mail->isSMTP();                                      
$mail->Host = 'smtp.gmail.com';                       
$mail->SMTPAuth = true;                               
$mail->Username = 'gradindusm3d@gmail.com';                   
$mail->Password = 'mahamegamockdrive';              
$mail->SMTPSecure = 'ssl'; 
$mail->SMTPDebug = 1;                           
$mail->Port = 465;                                    
$mail->From = 'gradindusm3d@gmail.com';
$mail->FromName = 'Assessment Review';
$mail->addAddress($ros[EMAIL_ID], $ros[NAME]);
$mail->addReplyTo('gradindusm3d@gmail.com', 'Assessment Review');
$mail->WordWrap = 50;
$mail->isHTML(true);
$mail->Subject = 'Interview Report';
$mail->Body = 
"<table cellspacing='0' cellpadding='0' width='100%'>
<tr><td>
				<table cellspacing='0' cellpadding='0' width='100%'>
				<tr>
        
        <td colspan='2'>
						
				<b>Dear ".$ros[NAME]."</b> <br/> Regd No: ".$ros[REG_NO]."<br /> Branch: ".$ros['BRANCH']."
				<p align='justify'>The following result has been generated based on your performance during <b><em>'Employability Assessment Program'</em></b> conducted on <b>".date('dS M Y')."</b>. Please understand the importance of it and take care of the areas where your score is less than 3.5. </p> </td>
      </tr>
			</table>
			<br />
			<h4>HR Score</h4>
			<table cellspacing='0' cellpadding='0' id='tab' style='background-repeat:repeat-x;background-position:left top;width: 33em;border  :1px solid #e5e5e5;'>
      <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Clarity- </td>
        <td class='value last' style='width:50%;'><img src=\'http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png\' style='vertical-align: middle;margin: 3px 3px 3px 0;' alt='' width=".$clarity." height='16' />".$_POST[clarity]."
				</td>
      </tr>
      <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Articulation- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST['articulation']." height='16' />".$_POST[articulation]."</td>
      </tr>
			<tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Usage- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST[usage]." height='16' />".$_POST[usage]."</td>
      </tr>
			<tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Confidence- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST['confidence']." height='16' />".$_POST[confidence]."</td>
      </tr>
			<tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Body Language- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST[bodylang]." height='16' />".$_POST[bodylang]."</td>
      </tr>
			<tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Listening- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST[listening]." height='16' />".$_POST[listening]."</td>
      </tr>
			<tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Appearance- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST[appearance]." height='16' />".$_POST[appearance]."</td>
      </tr>
			<tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Manners- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST[manners]." height='16' />".$_POST[manners]."</td>
      </tr>
			</table>
			
			<p></p>
			<h5>&nbsp;&nbsp;&nbsp;&nbsp;1-Very Poor	&nbsp;&nbsp;&nbsp;&nbsp; 2-Poor	 &nbsp;&nbsp;&nbsp;&nbsp;    3- Average	 &nbsp;&nbsp;&nbsp;&nbsp;   4-Good  &nbsp;&nbsp;&nbsp;&nbsp;  	5-Very Good </h5>     


		<table cellspacing='0' cellpadding='0' width='100%'>
		<tr><td>
		<h4>HR FeedBack</h4>
    ".$feedback."
		
		<h4>Tech Score</h4>
			<table cellspacing='0' cellpadding='0' id='tab' style='background-repeat:repeat-x;background-position:left top;width: 33em;border  :1px solid #e5e5e5;'>
      <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>IT Skills- </td>
        <td class='value last' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' style='vertical-align: middle;margin: 3px 3px 3px 0;' alt='' width=".$_POST[itskill]." height='16' />".$_POST[itskill]."
				</td>
      </tr>
      <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Domain Knowledge- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST[domainknow]." height='16' />".$_POST[domainknow]."</td>
      </tr>
			<tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Sectorial Knowledge- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST[sectorialknow]." height='16' />".$_POST[sectorialknow]."</td>
      </tr>
			<tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Project- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST[project]." height='16' />".$_POST[project]."</td>
      </tr>
			
			</table>
			
			<p></p>
			<p></p>
			<h5>&nbsp;&nbsp;&nbsp;&nbsp;1-Very Poor	&nbsp;&nbsp;&nbsp;&nbsp; 2-Poor	 &nbsp;&nbsp;&nbsp;&nbsp;    3- Average	 &nbsp;&nbsp;&nbsp;&nbsp;   4-Good  &nbsp;&nbsp;&nbsp;&nbsp;  	5-Very Good </h5>     


		<table cellspacing='0' cellpadding='0' width='100%'>
		<tr><td>
		<h4>Tech FeedBack</h4>
    ".$feedback1."
		
		</td></tr>
		</table>
		<p>A good <b><em>overall score</em></b> for any student would be <b><em>4 and above</em></b>.</P 

<p>The overall score is calculated based on giving different weightage to different parameters and then finally calculating the overall score. 
</p>
		<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
		<hr/>
                <span align='center'><i>Disclaimer: This is a computer generated email. Please don't reply back. </i></span>
</td></tr></table>";
//$mail->Body    = $msg;
if(!$mail->send()) {
   echo 'Message could not be sent.';
  // echo 'Mailer Error: ' . $mail->ErrorInfo;
   exit;
}
}
$qry="INSERT INTO `tipi` (`REGD_NO`, `INTERVIEWER`, `CLARITY`, `ARTICULATION`, `USAGES`, `CONFIDENCE`, `BODY_LANG`, `LISTENING`, `APPEARANCE`, `MANNERS`,`COMM_FEEDBACK`, `PREP_FEEDBACK`, `OTHER_HR_FEEDBACK`,`IT_SKILLS`, `SECT_KNOW`, `DOMAIN_KNOW`, `PROJECT`, `TECH_FEEDBACK`, `OTHER_TECH_FEEDBACK`, `TIME_START`, `TIME_END`, `TIME_TAKEN`, `DATE`) VALUES ( $_POST[reg_no],'".$_POST[interviewer]."', $_POST[clarity], $_POST[articulation], $_POST[usage], $_POST[confidence], $_POST[bodylang], $_POST[listening], $_POST[appearance], $_POST[manners], '".$communifeedback."', '".$prepfeedback."', '".$_POST[otherhrfeedback]."', $_POST[itskill], $_POST[sectorialknow], $_POST[domainknow], $_POST[project], '".$techfeedback."', '".$_POST[othertechfeedback]."', '".$_POST[timestarted]."', CURTIME(), TIMEDIFF(CURTIME(),'$_POST[timestarted]'), CURDATE())";
if(!mysql_query( $qry))
{
$_SESSION['data']="Error in Saving the result.. \nquery:$qry";
?>
<script>
window.location.href="search.php";
</script>
<?php
 header("location: search.php");
 exit;
} 
$_SESSION['data']="Combine Interview(TI+PI) Of Regd No".$_POST[reg_no]." has been saved successfully";
?>
<script>
window.location.href="search.php";
</script>
<?php
header("location: search.php");
}		
?>

</div>