<title>PI TI Combine Report</title>
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
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=\"{$college}-{$dateofinterview}.doc\"");

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
@{
font-family: "Times New Roman", Georgia, Serif;
}
 #tab td.value {
	background: url(http://localhost/new/GetSetGo/assessment/controller/admin/gridline58.gif);
	background-repeat: repeat-x;
	background-position: left top;
	
	padding:0;
	background-color:transparent;
}
 #tab td {
	padding: 2px 3px;
	
	background-color:#fff;
}
 #tab1 td.value {
	background: url(http://localhost/new/GetSetGo/assessment/controller/admin/gridline58.gif);
	background-repeat: repeat-x;
	background-position: left top;
	
	padding:0;
	background-color:transparent;
}
 #tab1 td {
	padding: 2px 3px;
	
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
 
}
 #tab1 td.last {
 width:50%;
 
}
 #tab td.first {
 width:27%;
 text-align:right;
 border-right: 1px solid #e5e5e5;
}
#tab1 td.first {
 width:27%;
 text-align:right;
 border-right: 1px solid #e5e5e5;
}
.auraltext
{
   position: absolute;
   font-size: 0;
   left: -1000px;
}
table #tab{
	background:url(http://localhost/new/GetSetGo/assessment/controller/admin/bg_fade.png);
	background-repeat:repeat-x;
	background-position:left top;
	width: 33em;
	border  :1px solid #e5e5e5;
}
table #tab1{
	background:url(http://localhost/new/GetSetGo/assessment/controller/admin/bg_fade.png);
	background-repeat:repeat-x;
	background-position:left top;
	width: 33em;
	border  :1px solid #e5e5e5;
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
		$qry1="select * from tipi where (REGD_NO='$row[REG_NO]' and DATE='$dateofinterview' and INTERVIEWER='$interviewer')";
	}
	if($interviewer==''){
		$qry1="select * from tipi where (REGD_NO='$row[REG_NO]' and DATE='$dateofinterview' )";
	}
	//$qry1="select * from tipi where (REGD_NO='$row[REG_NO]' and DATE='$dateofinterview')";
	//echo $qry1;
	$rs1=mysql_query($qry1);
	$count=mysql_num_rows($rs1);
	if($count==1){
		$row1=mysql_fetch_array($rs1);
		?>
		<!--<table cellspacing="0" cellpadding="0" width="100%">
		<tr>
		<td width="5%" style="border-left:5px solid #000;border-top:5px solid #000;border-bottom:5px solid #000;"> <img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/77.gif" height="" width="" alt=""></td><td style="border:5px solid #000;" align="center" valign="middle"><font size="5">INDUS EDUCATION PI REPORT</font></td>
		</tr>
		</table>
		<br />-->
		<table cellspacing="0" cellpadding="0" width="100%">
				<tr>
        
        <td colspan='2'>
						
				<b>Dear <?php echo $row['NAME']; ?></b> <br />Regd No: <?php echo $row['REG_NO']; ?> <br /> Branch: <?php echo $row['BRANCH']; ?>
				<p align="justify">The following result has been generated based on your performance during <b><em>"Employability Assessment Program"</em></b> conducted on <b><?php echo date('dS M Y',strtotime($dateofinterview)); ?></b>. Please understand the importance of it and take care of the areas where your score is less than 3.5. </p> </td>
      </tr>
			</table>
			<br />
			<h4>HR Score</h4>
			<table cellspacing="0" cellpadding="0" id="tab">
      <tr>
        <td class="first">Clarity- </td>
        <td class="value">
				<?php if($row1['CLARITY']>='4') { ?>
				<img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar1.png" alt="" width="<?php echo $row1['CLARITY']*74; ?>" height="16" />
				<?php }else{ ?> 
				<img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar.png" alt="" width="<?php echo $row1['CLARITY']*74; ?>" height="16" />
				<?php } echo (float)$row1['CLARITY']; ?>
				</td>
      </tr>
      <tr>
        <td class="first">Articulation- </td>
        <td class="value last">
				<?php if($row1['ARTICULATION']>='4') { ?>
				<img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar1.png" alt="" width="<?php echo $row1['ARTICULATION']*74; ?>" height="16" />
				<?php }else{ ?> <img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar.png" alt="" width="<?php echo $row1['ARTICULATION']*74; ?>" height="16" />
				<?php }  echo (float)$row1['ARTICULATION']; ?></td>
      </tr>
      <tr>
        <td class="first">Usage- </td>
        <td class="value">
				<?php if($row1['USAGES']>='4') { ?>
				<img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar1.png" alt="" width="<?php echo $row1['USAGES']*74; ?>" height="16" />
				<?php }else{ ?> <img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar.png" alt="" width="<?php echo $row1['USAGES']*74; ?>" height="16" />
				<?php } echo (float)$row1['USAGES']; ?></td>
      </tr>
      <tr>
        <td class="first">Confidence- </td>
				
        <td class="value">
				<?php if($row1['CONFIDENCE']>='4') { ?>
				<img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar1.png" alt="" width="<?php echo $row1['CONFIDENCE']*74; ?>" height="16" />
				<?php }else{ ?> 
				<img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar.png" alt="" width="<?php echo $row1['CONFIDENCE']*74; ?>" height="16" />
				<?php } echo (float)$row1['CONFIDENCE']; ?></td>
      </tr>
		<tr>
        <td class="first">Body Language- </td>
        <td class="value">
				<?php if($row1['BODY_LANG']>='4') { ?>
				<img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar1.png" alt="" width="<?php echo $row1['BODY_LANG']*74; ?>" height="16" />
				<?php }else{ ?> 
				<img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar.png" alt="" width="<?php echo $row1['BODY_LANG']*74; ?>" height="16" />
				<?php } echo (float)$row1['BODY_LANG']; ?></td>
      </tr>
			<tr>
        <td class="first">Listening- </td>
        <td class="value">
				<?php if($row1['LISTENING']>='4') { ?>
				<img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar1.png" alt="" width="<?php echo $row1['LISTENING']*74; ?>" height="16" />
				<?php }else{ ?>
				 <img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar.png" alt="" width="<?php echo $row1['LISTENING']*74; ?>" height="16" />
				<?php } echo (float)$row1['LISTENING']; ?></td>
      </tr>
			<tr>
        <td class="first">Appearance- </td>
        <td class="value">
				<?php if($row1['APPEARANCE']>='4') { ?>
				<img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar1.png" alt="" width="<?php echo $row1['APPEARANCE']*74; ?>" height="16" />
				<?php }else{ ?> 
				<img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar.png" alt="" width="<?php echo $row1['APPEARANCE']*74; ?>" height="16" />
				<?php }  echo $row1['APPEARANCE']; ?></td>
      </tr>
			<tr>
        <td class="first">Mannerism- </td>
        <td class="value">
				<?php if($row1['MANNERS']>='4') { ?>
				<img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar1.png" alt="" width="<?php echo $row1['MANNERS']*74; ?>" height="16" />
				<?php }else{ ?> 
				<img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar.png" alt="" width="<?php echo $row1['MANNERS']*74; ?>" height="16" />
				<?php }  echo $row1['MANNERS']; ?></td>
      </tr>
				
			</table>
			<h5>&nbsp;&nbsp;&nbsp;&nbsp;1-Very Poor	&nbsp;&nbsp;&nbsp;&nbsp; 2-Poor	 &nbsp;&nbsp;&nbsp;&nbsp;    3- Average	 &nbsp;&nbsp;&nbsp;&nbsp;   4-Good  &nbsp;&nbsp;&nbsp;&nbsp;  	5-Very Good </h5>     

			<table cellspacing="0" cellpadding="0" width="100%">
		<tr><td>
		<h4>HR FeedBack</h4>
    <ul>    
		<?php $count=1;
						 $choice=explode(",", $row1['COMM_FEEDBACK']);
						foreach($choice as $a) {
							if($a!='')
							echo "<li> ".$a."</li>";
						$count++; } 							
						$count=1;
						 $choice=explode(",", $row1['PREP_FEEDBACK']);
						foreach($choice as $a) {
							if($a!='')
							echo "<li> ".$a."</li>"; 
						$count++; } ?>
						<li><?php echo $row1['OTHER_HR_FEEDBACK']; ?> </li>
						</ul>
		
		</td></tr>
		</table>
	
			<p></p>
			<h4>TECH Score</h4>
			<table cellspacing="0" cellpadding="0" id="tab1">
      <tr>
        <td class="first">IT Skills-</td>
        <td class="value last">
				<?php if($row1['IT_SKILLS']>='4') { ?>
				<img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar1.png" alt="" width="<?php echo $row1['IT_SKILLS']*74; ?>" height="16" />
				<?php }else{ ?> <img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar.png" alt="" width="<?php echo $row1['IT_SKILLS']*74; ?>" height="16" />
				<?php } echo (float)$row1['IT_SKILLS']; ?>
				
				</td>
      </tr>
			<tr>
        <td class="first">Sector Knowledge-</td>
        <td class="value">
				<?php if($row1['SECT_KNOW']>='4') { ?>
				<img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar1.png" alt="" width="<?php echo $row1['SECT_KNOW']*74; ?>" height="16" />
				<?php }else{ ?> <img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar.png" alt="" width="<?php echo $row1['SECT_KNOW']*74; ?>" height="16" />
				<?php } echo (float)$row1['SECT_KNOW']; ?></td>
      </tr>
      <tr>
        <td class="first">Domain Knowledge-</td>
        <td class="value">
				<?php if($row1['DOMAIN_KNOW']>='4') { ?>
				<img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar1.png" alt="" width="<?php echo $row1['DOMAIN_KNOW']*74; ?>" height="16" />
				<?php }else{ ?> <img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar.png" alt="" width="<?php echo $row1['DOMAIN_KNOW']*74; ?>" height="16" />
				<?php } echo (float)$row1['DOMAIN_KNOW']; ?></td>
      </tr>
      <tr>
        <td class="first">Project-</td>
        <td class="value">
				<?php if($row1['PROJECT']>='4') { ?>
				<img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar1.png" alt="" width="<?php echo $row1['PROJECT']*74; ?>" height="16" />
				<?php }else{ ?> <img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/new/GetSetGo/assessment/controller/admin/bar.png" alt="" width="<?php echo $row1['PROJECT']*74; ?>" height="16" />
				<?php }  echo (float)$row1['PROJECT']; ?></td>
      </tr>
      			
			</table>
			<h5>&nbsp;&nbsp;&nbsp;&nbsp;1-Very Poor	&nbsp;&nbsp;&nbsp;&nbsp; 2-Poor	 &nbsp;&nbsp;&nbsp;&nbsp;    3- Average	 &nbsp;&nbsp;&nbsp;&nbsp;   4-Good  &nbsp;&nbsp;&nbsp;&nbsp;  	5-Very Good </h5>     

			<table cellspacing="0" cellpadding="0" width="100%">
		<tr><td>
		<h4>TECH FeedBack</h4>
    <ul>    
		<?php  $choice=explode(",", $row1['TECH_FEEDBACK']);
						foreach($choice as $a) {
							if($a!='')
							echo "<li> ".$a."</li>";
						$count++; } ?><li><?php echo $row1['OTHER_TECH_FEEDBACK']; ?> </li>
						</ul>
		
		</td></tr>
		</table>
			<p></p>
			

<p>A good <b><em>overall score</em></b> for any student would be <b><em>4 and above</em></b>.</P 

<p>The overall score is calculated based on giving different weightage to different parameters and then finally calculating the overall score. 
</p>
		
			<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
		<?php
	}
}
		
?>
<hr/>
                <span align="center"><i>This is a computer generated copy.</i></span>
</td></tr></table>