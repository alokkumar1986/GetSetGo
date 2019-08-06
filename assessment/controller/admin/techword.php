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
$college2=$_POST['college'];
$college1=explode('-',$college2);
$college=$college1['0'];
$branch1= $_POST['branch'];
$l=sizeof($branch1);
$branch='';
for($i=0;$i<$l;$i++){
$branch.="'".$branch1[$i]."'";
if($i<($l-1)){
$branch.=",";
}
}
$dateofinterview=$_POST['date'];
$interviewer=$_POST['interviewer'];
//header("Content-type: application/vnd.ms-word");
//header("Content-Disposition: attachment;Filename=\"{$college}-{$dateofinterview}.doc\"");

if($college!='' and $branch==''){
	$qry = "select * from student_data where COLLEGE_FULLNAME='$college'";
}
if($college=='' and $branch!=''){
	$qry = "select * from student_data where BRANCH in ($branch)";
}
if($college!='' and $branch!=''){
$qry = "select * from student_data where COLLEGE_FULLNAME='$college' and BRANCH in ($branch)";	
}
if($college=='' and $branch==''){
$qry = "select * from student_data ";	
}

$rs=mysql_query($qry);

?>
<style type="text/css">
<!--
 #tab td.value {
	background-image: url(http://localhost/new/GetSetGo/assessment/controller/admin/gridline58.gif);
	background-repeat: repeat-x;
	background-position: left top;
	border: 1px solid #e5e5e5;
	padding:0;
	background-color:transparent;
}
 #tab td {
	padding: 2px 3px;
	border-bottom:1px solid #e5e5e5;
	border-left:1px solid #e5e5e5;
	background-color:#fff;
}
body {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 80%;
}
td.value img {
  background:#f0f0f0;
	vertical-align: middle;
	margin: 3px 3px 3px 0;
}
th {
	text-align: left;
	vertical-align:top;
}
 #tab td.last {
 width:50%;
	border-bottom:1px solid #e5e5e5;
}
 #tab td.first {
 width:27%;
	border-top:1px solid #e5e5e5;
}
.auraltext
{
   position: absolute;
   font-size: 0;
   left: -1000px;
}
table #tab{
	background-image:url(http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bg_fade.png);
	background-repeat:repeat-x;
	background-position:left top;
	width: 33em;
}
caption {
	font-size:90%;
	font-style:italic;
}
-->
</style>
<table cellspacing="0" cellpadding="0" width="100%">
<tr><td>

<?php
while($row=mysql_fetch_array($rs)){
	if($interviewer!=''){
		$qry1="select * from ti where (REGD_NO='$row[REG_NO]' and DATE='$dateofinterview' and INTERVIEWER='$interviewer')";
	}
	if($interviewer==''){
		$qry1="select * from ti where (REGD_NO='$row[REG_NO]' and DATE='$dateofinterview' )";
	}
	$rs1=mysql_query($qry1);
	$count=mysql_num_rows($rs1);
	if($count==1){
		$row1=mysql_fetch_array($rs1);
		?>
		<table cellspacing="0" cellpadding="0" width="100%">
		<tr>
		<td width="5%" style="border-left:5px solid #000;border-top:5px solid #000;border-bottom:5px solid #000;"> <img src="http://localhost/new/GetSetGo/77.gif" height="" width="" alt=""></td><td style="border:5px solid #000;" align="center" valign="middle"><font size="5">INDUS EDUCATION TI REPORT</font></td>
		</tr>
		</table>
		<br />
		<table cellspacing="0" cellpadding="0" width="100%">
				<tr>
        
        <th scope="col" colspan='2'>
				<h4><?php echo $row['NAME']; ?> (<?php echo $row['REG_NO']; ?>), <?php echo $row['BRANCH']; ?></h4>
				
				<span>Dear <?php echo $row['NAME']; ?>,</span><p align="justify"><span>The following result has been generated based on your performance during "Employability Assessment Program" conducted on <?php echo date('dS M Y',strtotime($dateofinterview)); ?>. Please understand the importance of it and take care of the areas where your score is less than 3.5. </span></p> </th>
      </tr>
			</table>
			<br />
			<table cellspacing="0" cellpadding="0" id="tab">
      <tr>
        <td class="first">Disposiotion</td>
        <td class="value first"><img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar.png" alt="" width="<?php echo $row1['PER_DISPOSITION']*58; ?>" height="16" /><?php echo (float)$row1['PER_DISPOSITION']; ?>
				<br /><img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar1.png" alt="" width="<?php echo 4*58; ?>" height="16" /><?php echo "4"; ?>

				</td>
      </tr>
			<tr>
        <td>Career</td>
        <td class="value"><img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar.png" alt="" width="<?php echo $row1['CAREER']*58; ?>" height="16" /><?php echo (float)$row1['CAREER']; ?></td>
      </tr>
      <tr>
        <td>Communication</td>
        <td class="value"><img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar.png" alt="" width="<?php echo $row1['COMMUNICATION']*58; ?>" height="16" /><?php echo (float)$row1['COMMUNICATION']; ?></td>
      </tr>
      <tr>
        <td>Knowledge in own area</td>
        <td class="value"><img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar.png" alt="" width="<?php echo $row1['KNOWLEDGE_AREA']*58; ?>" height="16" /><?php echo (float)$row1['KNOWLEDGE_AREA']; ?></td>
      </tr>
      <tr>
        <td>IT Awareness</td>
        <td class="value"><img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar.png" alt="" width="<?php echo $row1['IT_AWARNESS']*58; ?>" height="16" /><?php echo (float)$row1['IT_AWARNESS']; ?></td>
      </tr>
		
			<tr>
        <td>Confidence</td>
        <td class="value"><img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar.png" alt="" width="<?php echo $row1['CONFIDENCE']*58; ?>" height="16" /><?php echo (float)$row1['CONFIDENCE']; ?></td>
      </tr>
			
			<tr>
        <td>Overall Rating</td>
        <td class="value"><img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar.png" alt="" width="<?php echo $row1['RATING']*58; ?>" height="16" /><?php echo $row1['RATING']; ?></td>
      </tr>
			
			</table>
			
			<p></p>
			
<h5>&nbsp;&nbsp;&nbsp;&nbsp;1-Very Poor	&nbsp;&nbsp;&nbsp;&nbsp; 2-Poor	 &nbsp;&nbsp;&nbsp;&nbsp;    3- Average	 &nbsp;&nbsp;&nbsp;&nbsp;   4-Good  &nbsp;&nbsp;&nbsp;&nbsp;  	5-Very Good </h5>     

<p>A good overall score for any student would be 4 and above. 

The overall score is calculated based on giving different weightage to different parameters and then finally calculating the overall score. 
</p>
		
		<table cellspacing="0" cellpadding="0" width="100%">
		<tr><td>
		<h4>FeedBack</h4>
    <ul>    
		<?php  $choice=explode(",", $row1['TECH_FEEDBACK']);
						foreach($choice as $a) {
							if($a!='')
							echo "<li> ".$a."</li>";
						$count++; } ?><li><?php echo $row1['OTHER_FEEDBACK']; ?> </li>
						</ul>
		<h5>Interviewer : <?php echo $row1['INTERVIEWER']; ?> </h5> <h5>Time Taken: <?php echo $row1['TIME_TAKEN']; ?> minutes</h5>
		</td></tr>
		</table>
		<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>

		<?php
	}
}
		
?></td></tr></table>