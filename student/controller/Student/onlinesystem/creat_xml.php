<?php $user=$_SESSION["regno_of_user"];
$db->select('test_question','question_id',"c_id='$sub' AND test_id='$test_name'",'c_id',null,null);  
$res = $db->get_name();
$data=$res['question_id'];
$row=explode(",",$data);
//$tid=$row;
$l=sizeof($row);
$tid = RandomizeArray($row);
$comma = implode(",", $tid);
/*$sel=mysql_query("select * from review where (regno='$user' AND test_id='$test_name' AND category='$sub' AND instance='$c')");
$cntin=mysql_num_rows($sel);
if($cntin=='0'){
$db->insert('review',array($user,$test_name,$sub,$comma,$c),'regno,test_id,category,questions,instance'); 
$res4 = $db->get_name(); 
}else if($cntin=='1'){
$sqlquery=mysql_query("update review set questions='$comma' where (regno='$user' AND test_id='$test_name' AND category='$sub' AND instance='$c')")or die(mysql_error());
}*/
$i=1;
$ans='';
foreach($tid as $tids)
{ 
if($tids!='')
{
$db->select('activetestquestions','id,question,subject_id,ans1,ans2,ans3,ans4,ans5,corans',"id='$tids'",null,null,null);  
$rows = $db->get_name();
$ans.=$rows['corans'];
if($rows['corans']){
$ans.=",";
} ?>
<!--<p id='resultQ<?php //echo $a; ?><?php //echo $i?>' align="center" style="color:#FF0000;font-size:9px"></p>-->
<div class="Question" id='Q<?php echo $a; ?><?php echo $i?>' >
<div style="height:320px;overflow:auto;background-color:#fff;padding:6px;border: 1px solid #000;" ><b><font color=#306BCF>Question:<?php echo $i?>)</font></b>
<input type="hidden" id="H<?php echo $a; ?><?php echo $i?>"  value="<?php echo $rows['id']; ?>" />
<br /><font color=#000 size=2.0em>
<input name="Q<?php echo $a; ?><?php echo $i; ?>" id="Q<?php echo $a; ?><?php echo $i; ?>" type="hidden" value="<?php echo $rows['id']; ?>" /><?php echo $rows['question']; ?></font>
</div>
<!--<div id="countdown" style="display:none;"></div>-->
<?php 
 $ca=$c;
$findque=mysql_query("select * from `temp_test_result` where test_id='$test_name' AND candidate='$user' AND instance='$ca' AND question_id='$rows[id]'");
if($findres=mysql_fetch_array($findque)){
$ansresult=$findres['answer'];
}else{
$ansresult=0;
} ?>
<br />
<?php if(strip_tags($rows['ans1'])!='')
{ ?>
<input class='ans<?php echo $a; ?><?php echo $i?>'  type=radio name="<?php echo $a; ?><?php echo $i?>" id="<?php echo $a; ?><?php echo $i?>" value="1" onclick="check(this.name,this.value);ajaxsub2('<?php echo $a; ?>');anssave('<?php echo $rows['id']; ?>',this.value);"  <?php if($ansresult=='1'){ ?> checked="checked" <?php } ?> />&nbsp;<?php echo strip_tags($rows['ans1']); ?><br/> <?php } ?>
<?php if(strip_tags($rows['ans2'])!=''){ ?>
<input class='ans<?php echo $a; ?><?php echo $i?>' id="<?php echo $a; ?><?php echo $i?>" type=radio name="<?php echo $a; ?><?php echo $i?>" value=2 onclick="check(this.name,this.value);ajaxsub2('<?php echo $a; ?>');anssave(<?php echo $rows['id']; ?>,this.value);"  <?php if($ansresult=='2'){ ?> checked="checked" <?php } ?> />&nbsp;<?php echo strip_tags($rows['ans2']); ?><br/><?php } ?>
<?php if(strip_tags($rows['ans3'])!=''){ ?>
<input class='ans<?php echo $a; ?><?php echo $i?>' id="<?php echo $a; ?><?php echo $i?>" type=radio name="<?php echo $a; ?><?php echo $i?>" value=3 onclick="check(this.name,this.value);ajaxsub2('<?php echo $a; ?>');anssave(<?php echo $rows['id']; ?>,this.value);"  <?php if($ansresult=='3'){ ?> checked="checked" <?php } ?> />&nbsp;<?php echo strip_tags($rows['ans3']); ?><br/> <?php } ?>
<?php if(strip_tags($rows['ans4'])!=''){ ?>
<input class='ans<?php echo $a; ?><?php echo $i?>' id="<?php echo $a; ?><?php echo $i?>" type=radio name="<?php echo $a; ?><?php echo $i?>" value=4 onclick="check(this.name,this.value);ajaxsub2('<?php echo $a; ?>');anssave(<?php echo $rows['id']; ?>,this.value)"  <?php if($ansresult=='4'){ ?> checked="checked" <?php } ?> />&nbsp;<?php echo strip_tags($rows['ans4']); ?><br/> <?php } ?>
<?php if(strip_tags($rows['ans5'])!=''){ ?>
<input class='ans<?php echo $a; ?><?php echo $i?>' id="<?php echo $a; ?><?php echo $i?>" type=radio name="<?php echo $a; ?><?php echo $i?>" value=5 onclick="check(this.name,this.value);ajaxsub2('<?php echo $a; ?>');anssave(<?php echo $rows['id']; ?>,this.value)"  <?php if($ansresult=='5'){ ?> checked="checked" <?php } ?> />&nbsp;<?php echo strip_tags($rows['ans5']); ?><br/> <?php } ?>
<br/>
<span><input type='checkbox' onclick="mfreview('<?php echo $a; ?><?php echo $i?>')"  id='review<?php echo $a; ?><?php echo $i?>' name='review<?php echo $a; ?><?php echo $i?>'>  <b><font color=red>Mark For Review</font></b></span> &nbsp;&nbsp;&nbsp; 
<span><input type='button' value='Clear Response' id="clearres" onclick="clearcheck('<?php echo $a; ?><?php echo $i?>');ajaxsub2('<?php echo $a; ?>');clear1('<?php echo $rows['id']; ?>')" style="width:150px;background:#fff;cursor:pointer;font-weight:bold;color:#000;" /></span><br/>
</div>
<?php
$i++;
} } ?>
