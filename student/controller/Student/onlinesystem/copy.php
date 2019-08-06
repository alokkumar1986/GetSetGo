<p align="right" style="margin-right:100px;"><b><a href="#" id="printpdf" onclick="printpdf();" style="background:#99FF33;cursor:pointer;font-weight:bold;color:#000;">Save as PDF</a></b> &nbsp;&nbsp; <b><!--<a href="#" id="cancel1" style="background:#0000FF;cursor:pointer;font-weight:bold;color:#fff;">Cancel</a> --></b></p>
<?php 
$test_name=base64_decode($_GET['test_id']);
$rs4= "SELECT * from `online_test` where (test_id='".$test_name."' and  STATUS='ACTIVE')  order by id"; 
$rs5=mysql_query($rs4)or die(mysql_error());
$z=1;
$countb=mysql_num_rows($rs5);
while($z<=$countb){
while($row=mysql_fetch_array($rs5)){ 
$dur=$row['TOTAL_NO_QUESTION'];
$test=$row['test_id'];
$sub=$row['CAT_NAME'];
$cat_name=base64_encode($row['CATEGORY']);
echo "<div><h1 align='center' style='border-bottom:1px solid #ddd;'>".$sub."</h1>";
$user=$_SESSION["regno_of_user"];

$dbqry="select `question_id` from `test_question` where (c_id='$sub' AND test_id='$test_name')";  
$dat= mysql_query($dbqry)or die(mysql_error());
while($res=mysql_fetch_array($dat)){
if($z=='1'){
$b="Q";
?>
<input type=hidden value='<?php echo $b; ?>' id="Q">
<input type=hidden value='1' id="QA">

<?php
}else if($z=='2'){

$b="R";
?>
<input type=hidden value='<?php echo $b; ?>' id="R">
<input type=hidden value='1' id="RA">

<?php

}else if($z=='3'){
$b="S";
?>
<input type=hidden value='<?php echo $b; ?>' id="S">
<input type=hidden value='1' id="SA">

<?php

}else if($z=='4'){
$b="T";
?>
<input type=hidden value='<?php echo $b; ?>' id="T">
<input type=hidden value='1' id="TA">

<?php

}
//echo $z;
//echo $b;
$data=$res['question_id'];
$row=explode(",",$data);
$l=sizeof($row);
$tid=$row;
$comma = implode(",", $tid);
$i=1;
$ans='';
foreach($tid as $tids)
{ 
if($tids!='')
{
//echo "select id,question,subject_id,ans1,ans2,ans3,ans4,ans5,corans from `questions` where id='$tids'";
$dbqry1=mysql_query("select id,question,subject_id,ans1,ans2,ans3,ans4,ans5,corans from `questions` where id='$tids'")or die(mysql_error());  
if($rows = mysql_fetch_array($dbqry1)){
$ans.=$rows['corans'];
if($rows['corans']){
$ans.=",";
}

echo "<div style='width:90%;float:left;margin:0px auto;padding-left:30px;' id='".$rows['id']."'>
<b><font color=#306BCF> "; ?>
Question:<?php echo $i.") &nbsp;</font></b>";
echo strip_tags($rows['question']); ?>
<input type="hidden" id="<?php echo $i?>"  value="<?php echo $rows['id']; ?>" />
<?php 
$sqry=mysql_query("select distinct(instance) from `test_status` where (test_id='".$test_name."' AND candidate='".$_SESSION['regno_of_user']."' AND status='finish')");
$cab=mysql_num_rows($sqry)+1;  
$findque=mysql_query("select * from `temp_test_result` where test_id='$test_name' AND candidate='$user' AND instance='$cab' AND question_id='$rows[id]'");
if($findres=mysql_fetch_array($findque)){
$ansresult=$findres['answer'];
}else{
$ansresult=0;
}
?>
&nbsp; &nbsp;
<br />
<?php if(strip_tags($rows['ans1'])!='' ){ ?>
<input class='ans<?php echo $b; ?><?php echo $i?>'  type=radio name="<?php echo $b; ?><?php echo $i?>" id="copy<?php echo $b; ?><?php echo $i?>" value="1"   <?php if($ansresult=='1'){ ?> checked="checked" <?php } ?> />&nbsp;<?php echo strip_tags($rows['ans1']); ?><br/> <?php } ?>
<?php if(strip_tags($rows['ans2'])!=''){ ?>
<input class='ans<?php echo $b; ?><?php echo $i?>' id="copy<?php echo $b; ?><?php echo $i?>" type=radio name="<?php echo $b; ?><?php echo $i?>" value=2  <?php if($ansresult=='2'){ ?> checked="checked" <?php } ?> />&nbsp;<?php echo strip_tags($rows['ans2']); ?><br/><?php } ?>
<?php if(strip_tags($rows['ans3'])!=''){ ?>
<input class='ans<?php echo $b; ?><?php echo $i?>' id="copy<?php echo $b; ?><?php echo $i?>" type=radio name="<?php echo $b; ?><?php echo $i?>" value=3  <?php if($ansresult=='3'){ ?> checked="checked" <?php } ?> />&nbsp;<?php echo strip_tags($rows['ans3']); ?><br/> <?php } ?>
<?php if(strip_tags($rows['ans4'])!=''){ ?>
<input class='ans<?php echo $b; ?><?php echo $i?>' id="copy<?php echo $a; ?><?php echo $i?>" type=radio name="<?php echo $b; ?><?php echo $i?>" value=4  <?php if($ansresult=='4'){ ?> checked="checked" <?php } ?> />&nbsp;<?php echo strip_tags($rows['ans4']); ?><br/> <?php } ?>
<?php if(strip_tags($rows['ans5'])!=''){ ?>
<input class='ans<?php echo $b; ?><?php echo $i?>' id="copy<?php echo $b; ?><?php echo $i?>" type=radio name="<?php echo $b; ?><?php echo $i?>" value=5   <?php if($ansresult=='5'){ ?> checked="checked" <?php } ?> />&nbsp;<?php echo strip_tags($rows['ans5']); ?><br/> <?php } ?>
<br/><br />
</div>
<?php
$i++;
} } } }
$z++;
echo "<div style='clear:both;'></div></div>";
}
echo "<div style='clear:both;'></div></div>";
}
echo "<div style='clear:both;'></div></div>";
?>
