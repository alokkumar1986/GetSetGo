<?php require_once("../../include/membersite_config.php");
error_reporting(0);
if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
if(!$fgmembersite->DBLogin())
        {
            $fgmembersite->HandleError("Database login failed!");
            return false;
        } 
$college=$_POST['college'];
$branch=$_POST['stream'];
$dateofinterview=$_POST['date'];
$interviewtype=$_POST['interviewtype'];
$regno=$_POST['regno'];
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=$college$dateofinterview.doc");
if($regno==''){
if($college!='' and $branch==''){
	$qry = "select * from student_data where COLLEGE='$college'";
}
if($college=='' and $branch!=''){
	$qry = "select * from student_data where BRANCH='$branch'";
}
if($college!='' and $branch!=''){
$qry = "select * from student_data where COLLEGE='$college' and BRANCH='$branch'";	
}
if($college=='' and $branch==''){
$qry = "select * from student_data ";	
}
}else{
	$qry = "select * from student_data where REG_NO='$regno' ";
}
$rs=mysql_query($qry);
while($row=mysql_fetch_array($rs)){
	if($interviewtype=='PI'){
		$qry1="select * from pi where (REGD_NO='$row[REG_NO]' and DATE='$dateofinterview')";
	}
	if($interviewtype=='TI'){
		$qry1="select * from ti where (REGD_NO='$row[REG_NO]' and DATE='$dateofinterview')";
	}
	$rs1=mysql_query($qry1);
	$count=mysql_num_rows($rs1);
	if($count>=1){
		while($row1=mysql_fetch_array($rs1)){
			
?>

<style>
	p{
		padding: 4px 0px 4px 20px;
	}
	
</style>
<?php if($interviewtype=='PI'){
	 ?>

<div style="border:6px solid #000;width:600px;margin: auto;padding:20px;">
    <table width="100%"><tr><td style="border:2px solid #000;" width='20%'><img width="172" height="53" src="http://localhost/assessmentres/image/77.gif"/></td><td style="border:2px solid #000;" valign="middle"><h2 align="center" style="padding-top: 14px;">Diagnostics Evaluation – <?php echo $interviewtype; ?> Report</h2></td></tr></table>
    <p>&nbsp;</p> 
       
                    <table cellpadding="0" cellspacing="0" width="100%" style="margin:auto;border:2px solid #000;">
                        <tbody>
                            <tr>
                                <td width="20%">
                                    <div>
                                        <p>
                                            <strong>Date  </strong>
                                        </p>
                                    </div>
                                  </td><td><strong>:</strong></td><td><?php echo date('dS M Y',strtotime($dateofinterview)); ?> </td>
                             
                                 <td width="20%">
                                    <div>
                                        <p>
                                            <strong>College Name </strong>
                                        </p> </div>
                                        </td><td><strong>:</strong></td><td><?php echo $row['COLLEGE']; ?></td></tr>
                              <tr>
                                <td width="20%">
                                    <div>  
                                         <p>
                                            <strong>Candidate Name  </strong>
                                        </p></div>
                                        </td><td><strong>:</strong></td><td><?php echo $row['NAME']; ?></td>
                                <td width="20%">
                                    <div>  
                                          <p>
                                            <strong>Regd No. </strong>
                                        </p>
                                        </div>
                                        </td><td><strong>:</strong></td><td><?php echo $row1['REGD_NO']; ?></td></tr>
                          </table>
                                        <p align="center">
                                            <strong>GRADES</strong>
                                        </p>
                                        
                                        <table cellpadding="0" cellspacing="0" width="100%" style="margin:auto;border:1px solid #000;">
                                            <tbody>
                                                <tr >
                                                    <td valign="middle" style="border:1px solid #000;" width="50%">
                                                        
                                                        <p align="center">
                                                            <strong>Verbal Communication</strong>
                                                        </p>
                                                        </td>
                                                        <td valign="middle" style="border:1px solid #000;" width="50%">
                                                        
                                                        <p align="center">
                                                            <strong>Non Verbal Communication</strong>
                                                        </p>
                                                        </td></tr>
                                                        <tr>
                                                    <td valign="top" style="border:1px solid #000;">
                                                        <p>
                                                            <strong>Clarity :</strong><?php echo $row1['CLARITY']; ?>
                                                            <br />
                                                        
                                                            <strong>Articulation :</strong><?php echo $row1['ARTICULATION']; ?><br />
                                                        
                                                            <strong>Usage :</strong><?php echo $row1['USAGES']; ?>
                                                        </p>
                                                   </td>
                                                        <td valign="top" style="border:1px solid #000;">
                                                        <p>
                                                            <strong>Confidence :</strong><?php echo $row1['CONFIDENCE']; ?><br />
                                                        
                                                            <strong>Body Language :</strong><?php echo $row1['BODY_LANG']; ?><br />
                                                        
                                                            <strong>Listening :</strong><?php echo $row1['LISTENING']; ?>
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="middle" style="border:1px solid #000;">
                                                        
                                                        
                                                        <p align="center">
                                                            <strong>Etiquettes</strong>
                                                        </p>
                                                        </td>
                                                        <td valign="middle" style="border:1px solid #000;">
                                                       
                                                        <p align="center">
                                                            <strong>Total Over All Rating</strong>
                                                        </p>
                                                    </td></tr>
                                                      <tr>
                                                    <td valign="top" style="border:1px solid #000;">   <p>
                                                            <strong>Appearance :</strong><?php echo $row1['APPEARANCE']; ?><br />
                                                        
                                                            <strong>Manners :</strong><?php echo $row1['MANNERS']; ?>
                                                        </p>
                                                    </td>
                                                    <td valign="top" style="border:1px solid #000;">  
                                                            
                                                        <p>
                                                            <strong>Marks :</strong><?php echo $row1['RATING']; ?>
                                                        </p>
                                                    </td>
                                                    
                                                </tr>
                                            </tbody>
                                        </table>
                                        <p>
                                            <strong>&nbsp;</strong>
                                        </p>
                                        <table cellpadding="0" cellspacing="0" width="100%" style="margin:auto;">
                                            <tbody>
                                                <tr >
                                                    <td valign="middle" width="50%">
                                                        
                                                        <p align="left">
                                            <strong><u>Preparation Feedback</u></strong>
                                        </p>
                                                        </td>
                                                        </tr>
                                                        <tr>
                                                        	<td><?php if($row1['PREP_FEEDBACK']!='') { $count=1;
						 $choice=explode(",", $row1['PREP_FEEDBACK']);
						foreach($choice as $a) {
							if($a!='')
							echo $count." - ".$a."<br />"; 
						$count++; } }else { echo "No feedback given"; }?></td>
                                                        </tr>
                                        <tr >
                                                    <td width="50%">
                                        <p align="left">
                                            <strong><u>Communication Feedback</u></strong>
                                        </p>
                                        </td>
                                                        </tr>
                                                        <tr>
                                                        	<td><?php if($row1['COMM_FEEDBACK']!='') { $count=1;
						 $choice=explode(",", $row1['COMM_FEEDBACK']);
						foreach($choice as $a) {
							if($a!='')
							echo $count." - ".$a."<br />";
						$count++; }}else { echo "No feedback given."; } ?></td>
                                                        </tr>
                                        <tr >
                                                    <td width="50%"> 
                                        <p align="left">
                                            <strong><u>Other Feedback</ul></strong>
                                        </p></td>
                                                        </tr>
                                                        <tr>
                                                        	<td><?php if($row1['OTHER_FEEDBACK']!='') { echo $row1['OTHER_FEEDBACK']; } else{ echo "No feedback given."; } ?></td>
                                                        </tr>
                                       
                        </tbody>
                    </table>
                    <hr/>
                <span align="center"><i>This is a computer generated copy.</i></span>
</div>
		
<?php echo "<br /><br /><br /><br />";  }

if($interviewtype=='TI'){ ?>


<div style="border:6px solid #000;width:600px;margin: auto;padding:20px;">
    <table width="100%"><tr><td style="border:2px solid #000;" width='20%'><img width="172" height="53" src="http://localhost/assessmentres/image/77.gif"/></td><td style="border:2px solid #000;" valign="middle"><h2 align="center" style="padding-top: 14px;">Diagnostics Evaluation – <?php echo $interviewtype; ?> Report</h2></td></tr></table>
    <p>&nbsp;</p> 
       
                    <table cellpadding="0" cellspacing="0" width="100%" style="margin:auto;border:2px solid #000;">
                        <tbody>
                            <tr>
                                <td width="20%">
                                    <div>
                                        <p>
                                            <strong>Date  </strong>
                                        </p>
                                    </div>
                                  </td><td><strong>:</strong></td><td><?php echo date('dS M Y',strtotime($dateofinterview)); ?> </td>
                             
                                 <td width="20%">
                                    <div>
                                        <p>
                                            <strong>College Name </strong>
                                        </p> </div>
                                        </td><td><strong>:</strong></td><td><?php echo $row['COLLEGE']; ?></td></tr>
                              <tr>
                                <td width="20%">
                                    <div>  
                                         <p>
                                            <strong>Candidate Name  </strong>
                                        </p></div>
                                        </td><td><strong>:</strong></td><td><?php echo $row['NAME']; ?></td>
                                <td width="20%">
                                    <div>  
                                          <p>
                                            <strong>Regd No. </strong>
                                        </p>
                                        </div>
                                        </td><td><strong>:</strong></td><td><?php echo $row1['REGD_NO']; ?></td></tr>
                          </table>
                                        <p align="center">
                                            <strong>GRADES</strong>
                                        </p>
                                        
                                        <table cellpadding="0" cellspacing="0" width="100%" style="margin:auto;border:1px solid #000;">
                                            <tbody>
                                                <tr >
                                                    <td valign="middle" style="border:1px solid #000;" width="50%">
                                                        
                                                        <p align="center">
                                                            <strong>Tech Interview Assessment</strong>
                                                        </p>
                                                        </td>
                                                        
                                                       </tr>
                                                        <tr>
                                                    <td valign="top" style="border:1px solid #000;">
                                                        <p>
                                                            <strong>Personal Disposition :</strong><?php echo $row1['PER_DISPOSITION']; ?>
                                                            <br />
                                                        
                                                            <strong>Career :</strong><?php echo $row1['CAREER']; ?><br />
                                                        
                                                            <strong>Communication :</strong><?php echo $row1['COMMUNICATION']; ?><br />
                                                        
                                                            <strong>Knowledge in own area :</strong><?php echo $row1['KNOWLEDGE_AREA']; ?><br />
                                                        
                                                            <strong>IT Awareness :</strong><?php echo $row1['IT_AWARNESS']; ?><br />
                                                        
                                                            <strong>Confidence :</strong><?php echo $row1['CONFIDENCE']; ?>
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr >
                                                    <td valign="middle" style="border:1px solid #000;" width="50%">
                                                        
                                                        <p align="center">
                                                            <strong>Overall Rating</strong>
                                                        </p>
                                                        </td>
                                                        
                                                       </tr>
                                                <tr>
                                                 <td valign="top" style="border:1px solid #000;">  
                                                            
                                                        <p>
                                                            <strong>Marks :</strong><?php echo $row1['RATING']; ?>
                                                        </p>
                                                    </td></tr>
                                            </tbody>
                                        </table>
                                        <p>
                                            <strong>&nbsp;</strong>
                                        </p>
                                        <table cellpadding="0" cellspacing="0" width="100%" style="margin:auto;">
                                            <tbody>
                                                <tr >
                                                    <td valign="middle" width="50%">
                                                        
                                                        <p align="left">
                                            <strong><u>Technical  Feedback</u></strong>
                                        </p>
                                                        </td>
                                                        </tr>
                                                        <tr>
                                                        	<td><?php if($row1['TECH_FEEDBACK']!='') { $count=1;
						 $choice=explode(",", $row1['TECH_FEEDBACK']);
						foreach($choice as $a) {
							if($a!='')
							echo $count." - ".$a."<br />"; 
						$count++; } }else { echo "No feedback given"; }?></td>
                                                        </tr>
                                       
                                        <tr >
                                                    <td width="50%"> 
                                        <p align="left">
                                            <strong><u>Other Feedback</ul></strong>
                                        </p></td>
                                                        </tr>
                                                        <tr>
                                                        	<td><?php if($row1['OTHER_FEEDBACK']!='') { echo $row1['OTHER_FEEDBACK']; } else{ echo "No feedback given."; } ?></td>
                                                        </tr>
                                       
                        </tbody>
                    </table>
                    <hr/>
                <span align="center"><i>This is a computer generated copy.</i></span>
</div>
	
<?php  echo "<br /><br /><br /><br />"; }






  echo "<br /><br /><br /><br />"; 
 }} } ?>