<?php require_once("../../include/membersite_config.php");
if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}
if(isset($_POST['submitted']))
{
   if($fgmembersite->Updatequestion())
   {
     	 $fgmembersite->RedirectToURL("view_questions.php?question=$_POST[subject1]&category=$_POST[cat1]&user=$_POST[user]");
       //$fgmembersite->HandleDBError("Question Updated Successfully view_questions.php?question=$_POST[subject1]&category=$_POST[cat1]&user=$_POST[user]");
   }
}
$fgmembersite->DBLogin();
$id=$_REQUEST['qid'];
       $sql_select="SELECT * FROM `test_question_multiple_choice` where question_id='$id'";
       $rs_select=mysql_query($sql_select);
       while($row_select=mysql_fetch_array($rs_select))
       {
?>

<html>

<head>
<meta http-equiv="Content-Language" content="en-us">

<title>Placement</title>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script src="ckeditor/_sample/sample.js" type="text/javascript"></script>
<script type="text/javascript">
function update_question()
{
    document.getElementById("entry_form").action="upd_question.php?reg=yes";
    document.getElementById("entry_form").submit();
}
</Script>
<link type="text/css" href="date/themes/ui-lightness/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
   <script type="text/javascript" src="date/jquery-1.3.2.js"></script>
   <script type="text/javascript" src="date/ui/ui.core.js"></script>
   <script type="text/javascript" src="date/ui/ui.datepicker.js"></script>
   
   <script type="text/javascript" src="date/form_validate.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$(function() 
       {
           $('#date').datepicker({dateFormat:'yy-mm-dd',yearRange: '2010:2010'});
       }
   );
   });
   
</script>

</head>

<body style="font-size:65%;margin:0px"><br />
<title>Add Question</title>
<script type='text/javascript' src="//cdnjs.cloudflare.com/ajax/libs/summernote/0.5.0/summernote.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/summernote/0.5.0/summernote.css">
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/summernote/0.5.0/summernote-bs3.css">
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.min.css">

<style type="text/css">
input[type=checkbox],input[type=radio] {
 margin: -5px 0 0; 
 }
 .radio, .checkbox{
 margin-top: 0px !important;
margin-bottom: 0px !important;
}
.alert{
padding: 18px 35px 13px 34px !important;
}
</style>
<script language="javascript">
/*function send()
{
    var subject=document.getElementById("subject").value;
	var subject=document.getElementById("cat").value;
    document.getElementById("entry_form").action="add_question.php?subject="+subject+"&cat="+cat;
   document.getElementById("entry_form").submit(); 
}

function back()
{
    window.location='?id=add question';
}*/
</script>
<script type="text/javascript" src="../../../../javascript/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
  theme : "advanced",
  theme_advanced_toolbar_location : "top",
  theme_advanced_buttons1 : "bold,italic,underline,cut,copy,paste,link,unlink,anchor,image,justifyleft,justifycenter,justifyright,justifyfull,tablecontrols,,forecolor,backcolor",
  theme_advanced_buttons2 : "",
  theme_advanced_buttons3 : "",
  theme_advanced_toolbar_location : "top",
  theme_advanced_toolbar_align : "left",
  theme_advanced_statusbar_location : "bottom",
  theme_advanced_resizing : true,
	});
</script>
<!--<script type='text/javascript'>//<![CDATA[ 
$(function(){
$('#summernote').summernote({height: 200});
$('#summernote1').summernote({height: 100});
$('#option_1').summernote({height: 100});
$('#option_2').summernote({height: 100});
$('#option_3').summernote({height: 100});
$('#option_4').summernote({height: 100});
$('#option_5').summernote({height: 100});
});//]]>  

</script> -->
<style>
.input-group-addon {
background-color: #fff !important;
font-size: 13px !important; 
}
.input-group{
/*width: 250px !important;*/
/*float:left;*/
margin-right:20px;
/*margin-left:20px;*/
padding:2px;
}
input{
margin-bottom: 0px !important;
height:30px;
}
table p{
font-weight:bold;
color:#1B4AAB;
padding-top:10px;
}

.modal{
margin:auto !important;
width: 630px;
height:auto;
background: none;
overflow:hidden !imporatnt;
}
</style>
<!--<script type="text/javascript" src="../../../../javascript/jquery-2.0.1.min.js"></script> -->
<script type="text/javascript" src="../../../../javascript/bootstrap-2.3.2.min.js"></script>
<link rel="stylesheet" href="../../../../css/bootstrap-multiselect.css" type="text/css">
<script type="text/javascript" src="../../../../javascript/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="../../../../css/prettify.css" type="text/css">
<script type="text/javascript" src="../../../../javascript/prettify.js"></script>
<script>
$('.dropdown input, .dropdown label').click(function (event) {
 event.stopPropagation();
 });
</script>
<script type="text/javascript">
			    $(document).ready(function() {
			        window.prettyPrint() && prettyPrint();
					
			        $('#answer').multiselect({
			        	includeSelectAllOption: true
			        });
                     $('#answer1').multiselect({
			        	includeSelectAllOption: true
			        });

					
			        });
			</script>

<?php if($fgmembersite->GetErrorMessage()){ ?><div class="alert alert-info alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <?php echo $fgmembersite->GetErrorMessage(); ?> </div> <?php } ?>
   <form id="entry_form" enctype="multipart/form-data" method="post">
<input type='hidden' name='submitted' id='submitted' value='1'/>
<input type='hidden' name='question_id' id='question_id' value='<?php echo $_REQUEST['qid']; ?>' />
<table border="0" width="100%" id="table2" style="border-collapse: collapse" bordercolor="#8FCBF8" bgcolor="#FFFFFF" cellspacing="5" cellpadding="5" align="center">
        <tr>
                <td align="left" width="50%">
				<!--<div style="width:100px"><ul class="nav nav-pills nav-stacked">
  <li class="active">
    <a href="?id=add question">
      <span class="badge pull-right" style="padding:0px 0px !important;"><img src="img/back.png" border="0" width="16" height="16"></span>
      Back
    </a>
  </li>
  
</ul></div> -->
                   <!-- <a href="javascript:back()"><img src="img/goback.png" border="0" width="16" height="16"> Back</a> -->
                </td>
                <td align="right" width="50%">
				<!--<div style="width:100px"><ul class="nav nav-pills nav-stacked">
  <li class="active">
    <a href="?id=add_question&subject=<?php echo $subject?>&cat=<?php echo $cat?>">
      <span class="badge pull-left" style="padding:0px 0px !important;"><img src="img/add.png" border="0" width="16" height="16"></span>
      More
    </a>
  </li>
  
</ul></div> -->
                   <!-- <a href="add_question.php?subject=<?php echo $subject?> &cat=<?php echo $cat?>"><img src="img/add_more.png" onClick="send();" border="0"> More</a> -->
                </td>
        </tr>
       <?php
       $sql_select1="SELECT * FROM `test_category` where category_id='".$row_select['category']."'";
       $rs_select1=mysql_query($sql_select1);
       $row_select1=mysql_fetch_array($rs_select1);
       $catname=$row_select1['name'];
           
      /*  $rs_selectcat=mysql_query("SELECT * FROM subcategory where ID='$cat' and CAT_ID='$subject'");
       $row_selectcat=mysql_fetch_array($rs_selectcat);
           $catname=$row_selectcat['SUB_CAT_NAME'];*/
  
       ?>
       <tr bgcolor="#99FFCC" >
       <td  align="center" style="padding:10px; border-radius:4px;"><font color="#800000" size="2">Question Type : &nbsp;<?php echo $row_select['question_type']; ?>
	   <input type='hidden' name='subject1' id='subject' value='<?php echo $row_select['question_type']; ?>' />
	   <input type='hidden' name='cat1' id='cat' value='<?php echo $row_select['category']; ?>' />
	   <input type='hidden' name='user' id='user' value='<?php echo $_SESSION['email_of_user']; ?>' /></font></td>
	   <td  align="center" style="padding:10px; border-radius:4px;"><font color="#800000" size="2">Category : &nbsp;<?php echo $catname; ?></font></td>
        </tr>
		<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
				<td colspan="2" bgcolor="#FFFFFF">
				<div class="panel panel-info">
  <div class="panel-heading">Question<font color="#B81900">*</font></div>
				<textarea cols="30" id="summernote" name="summernote" rows="5" style="width:680px;height:10px;"><?php echo $row_select['question']; ?></textarea>
			</div>
</td>
			</tr>
            <tr>
            <td colspan="2" align="left">
			
            </td>
            
            </tr>
            <tr>
            <td colspan="2">
			<div class="panel panel-primary">
  <div class="panel-heading">Answer Choice 1 <b><font color="#B81900">*</font></b></div>
			<textarea cols="10"  name="option_1" id="option_1" rows="5" style="width:680px;height:10px;"><?php echo $row_select['choice1']; ?></textarea></div>
	<div class="panel panel-primary">
  <div class="panel-heading">Answer Choice 2 <b><font color="#B81900">*</font></b></div>
			<textarea cols="10"  name="option_2" id="option_2" rows="5" style="width:680px;height:10px;"><?php echo $row_select['choice2']; ?></textarea></div>
<div class="panel panel-primary">
  <div class="panel-heading">Answer Choice 3 <b><font color="#B81900">*</font></b></div>
			<textarea cols="10"  name="option_3" id="option_3" rows="5" style="width:680px;height:10px;"><?php echo $row_select['choice3']; ?></textarea></div>
			<div class="panel panel-primary">
  <div class="panel-heading">Answer Choice 4 <b><font color="#B81900">*</font></b></div>
			<textarea cols="10"  name="option_4" id="option_4" rows="5" style="width:680px;height:10px;"><?php echo $row_select['choice4']; ?></textarea></div>
			<div class="panel panel-primary">
  <div class="panel-heading">Answer Choice 5 <b><font color="#B81900">*</font></b></div>
			<textarea cols="10"  name="option_5" id="option_5" rows="5" style="width:680px;height:10px;"><?php echo $row_select['choice5']; ?></textarea></div>
			</td><tr><td>
             <div class="panel panel-danger">
  <div class="panel-heading">Difficulty Level<b><font color="#B81900">*</font></b> </div> <select  name="diff" id="answer1">
			<option value="">None selected</option>
			<option value="difficult" <?php if($row_select['difficulty_level']=='Difficult'){ ?> selected="selected" <?php } ?>>Difficult</option>
			<option value="modorate" <?php if($row_select['difficulty_level']=='modorate'){ ?> selected="selected" <?php } ?>>Modorate</option>
			<option value="easy" <?php if($row_select['difficulty_level']=='easy'){ ?> selected="selected" <?php } ?>>Easy</option>
			</select>
			</td>
			<td>
			<div class="panel panel-danger">
  <div class="panel-heading">Answer<b><font color="#B81900">*</font></b></div>
  <?php $answer=explode(",",$row_select['answer']); ?>
			<select name="answer[]" id="answer"  multiple="multiple">
            <option value="1" <?php if(in_array(1,$answer)){ ?> selected="selected" <?php } ?> >A</option>
            <option value="2" <?php if(in_array(2,$answer)){ ?> selected="selected" <?php } ?>>B</option>
            <option value="3" <?php if(in_array(3,$answer)){ ?> selected="selected" <?php } ?>>C</option>
            <option value="4" <?php if(in_array(4,$answer)){ ?> selected="selected" <?php } ?>>D</option>
            <option value="5" <?php if(in_array(5,$answer)){ ?> selected="selected" <?php } ?>>E</option>
            </select></div></td>
            </tr>   
            <tr>
            <td colspan="2"><div class="panel panel-danger">
  <div class="panel panel-warning">
  <div class="panel-heading">Explanation</div>
            				<textarea cols="50" id="summernote1" name="summernote1" rows="5" style="width:680px;height:10px;"><?php echo $row_select['explanation']; ?></textarea></div>
			

        </td>
		</tr>
		<tr>
		<td colspan="2" align="center">
            <p>
                <input type='submit' class="btn btn-success" name='Submit' value='Save &amp; Continue'  />
				</p>
           
            </td>
            </tr>   
                  <input type="hidden" name="subject" id="subject" value="<?php echo $subject?>">
				  <input type="hidden" name="cat" id="cat" value="<?php echo $cat?>">
				  <input type="hidden" name="user" id="cat" value="<?php echo $_SESSION['email_of_user']; ?>">
			</tr>
		</table>
		</form>
		
		<script type='text/javascript' src="../../../../javascript/bootstrap.min.js"></script>
		</body>
		</html>
<?php } ?>