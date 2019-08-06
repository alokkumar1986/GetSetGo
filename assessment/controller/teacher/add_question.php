<?php 
  $subject=$_REQUEST['subject'];
	$cat=$_REQUEST['cat'];
    //echo "the name of the subject is".$subject;
   require_once("../../include/membersite_config.php");
if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}
if(isset($_POST['submitted']))
{
   if($fgmembersite->Addquestion())
   {
   	 
     $fgmembersite->RedirectToURL("?id=add_question&subject=$_POST[subject]&cat=$_POST[cat]");
        //$fgmembersite->HandleDBError("Question Added Successfully");
		/*if(!$fgmembersite->HandleDBError()){
		$_SESSION['success']="Question Added Successfully";
		}*/
		$_SESSION['success']="Question Added Successfully";
   }
}
$fgmembersite->DBLogin();

?>

<title>Add Question</title>
<!--<script type='text/javascript' src="//cdnjs.cloudflare.com/ajax/libs/summernote/0.5.0/summernote.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/summernote/0.5.0/summernote.css">
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/summernote/0.5.0/summernote-bs3.css">
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.min.css"> -->

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
$('.summernote').summernote({height: 200});
$('#summernote1').summernote({height: 100});
$('#option_1').summernote({height: 50});
$('#option_2').summernote({height: 50});
$('#option_3').summernote({height: 50});
$('#option_4').summernote({height: 50});
$('#option_5').summernote({height: 50});
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
			
<?php if($subject=='Multiple-Option'){ ?>
<?php if($_SESSION['flag']!=''){ ?><div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <?php echo $_SESSION['success']; ?> </div> <?php } $_SESSION['success']=''; ?>
   <?php if($fgmembersite->GetErrorMessage()){ ?><div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <?php echo $fgmembersite->GetErrorMessage(); ?> </div> <?php } ?>
   <form id="entry_form" enctype="multipart/form-data" method="post">
<input type='hidden' name='submitted' id='submitted' value='1'/>
<table border="0" width="100%" id="table2" style="border-collapse: collapse"  bgcolor="#FFFFFF" cellspacing="5" cellpadding="5" align="center">
        <tr>
                <td align="left" width="50%">
				<div style="width:100px"><ul class="nav nav-pills nav-stacked">
  <li class="active">
    <a href="?id=add question">
      <span class="badge pull-right" style="padding:0px 0px !important;"><img src="img/back.png" border="0" width="16" height="16"></span>
      Back
    </a>
  </li>
  
</ul></div>
                   <!-- <a href="javascript:back()"><img src="img/goback.png" border="0" width="16" height="16"> Back</a> -->
                </td>
                <td align="right" width="50%">
				<div style="width:100px"><ul class="nav nav-pills nav-stacked">
  <li class="active">
    <a href="?id=add_question&subject=<?php echo $subject?>&cat=<?php echo $cat?>">
      <span class="badge pull-left" style="padding:0px 0px !important;"><img src="img/add.png" border="0" width="16" height="16"></span>
      More
    </a>
  </li>
  
</ul></div>
                   <!-- <a href="add_question.php?subject=<?php echo $subject?> &cat=<?php echo $cat?>"><img src="img/add_more.png" onClick="send();" border="0"> More</a> -->
                </td>
        </tr>
       <?php
      $sql_select="SELECT * FROM `test_category` where category_id='$cat'";
       $rs_select=mysql_query($sql_select);
       $row_select=mysql_fetch_array($rs_select);
     
           $catname=$row_select['name'];
           
      /*  $rs_selectcat=mysql_query("SELECT * FROM subcategory where ID='$cat' and CAT_ID='$subject'");
       $row_selectcat=mysql_fetch_array($rs_selectcat);
           $catname=$row_selectcat['SUB_CAT_NAME'];*/
  
       ?>
       <tr bgcolor="#99FFCC" >
       <td  align="center" style="padding:10px; border-radius:4px;"><font color="#800000" size="2">Question Type : &nbsp;<?php echo $subject; ?></font></td>
	   <td  align="center" style="padding:10px; border-radius:4px;"><font color="#800000" size="2">Category : &nbsp;<?php echo $catname; ?></font></td>
        </tr>
		<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
				<td colspan="2" bgcolor="#FFFFFF">
				<div class="panel panel-info">
  <div class="panel-heading">Question<font color="#B81900">*</font></div>
				<textarea cols="30" id="summernote" name="summernote" rows="5" style="width:880px;height:10px;"></textarea>
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
			<textarea cols="10"  name="option_1" id="option_1" rows="5" style="width:880px;height:10px;"></textarea></div>
			<div class="panel panel-primary">
  <div class="panel-heading">Answer Choice 2 <b><font color="#B81900">*</font></b></div>
			<textarea cols="10"  name="option_2" id="option_2" rows="5" style="width:880px;height:10px;"></textarea></div>
			<div class="panel panel-primary">
  <div class="panel-heading">Answer Choice 3 <b><font color="#B81900">*</font></b></div>
			<textarea cols="10"  name="option_3" id="option_3" rows="5" style="width:880px;height:10px;"></textarea></div>
			<div class="panel panel-primary">
  <div class="panel-heading">Answer Choice 4 <b><font color="#B81900">*</font></b></div>
			<textarea cols="10"  name="option_4" id="option_4" rows="5" style="width:880px;height:10px;"></textarea></div>
			<div class="panel panel-primary">
  <div class="panel-heading">Answer Choice 5 <b><font color="#B81900">*</font></b></div>
			<textarea cols="10"  name="option_5" id="option_5" rows="5" style="width:880px;height:10px;"></textarea></div>
			</td><tr><td>
           <div class="panel panel-danger">
  <div class="panel-heading">Difficulty Level<b><font color="#B81900">*</font></b> </div> <select  name="diff" id="answer1">
			<option value="">None selected</option>
			<option value="difficult">Difficult</option>
			<option value="modorate">Modorate</option>
			<option value="easy">Easy</option>
			</select>
			</div>
			</td>
			<td>
			<div class="panel panel-danger">
  <div class="panel-heading">Answer<b><font color="#B81900">*</font></b></div>
			<select name="answer[]" id="answer"  multiple="multiple">
            <option value="1">A</option>
            <option value="2">B</option>
            <option value="3">C</option>
            <option value="4">D</option>
            <option value="5">E</option>
            </select></div></td>
            </tr>   
            <tr>
            <td colspan="2"><div class="panel panel-warning">
  <div class="panel-heading">Explanation</div>
            				<textarea cols="50" id="summernote1" name="summernote1" rows="5" style="width:880px;height:20px"></textarea>
			</div>

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
		<?php } ?>
		<?php if($subject=='True/False'){ ?>
		<?php if($fgmembersite->GetErrorMessage()){ ?><div class="alert alert-info alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Success!</strong> <?php echo $fgmembersite->GetErrorMessage(); ?> </div> <?php } ?>
<form id="entry_form" enctype="multipart/form-data" method="post">
<input type='hidden' name='submitted' id='submitted' value='1'/>
<table border="0" width="100%" id="table2" style="border-collapse: collapse" bordercolor="#8FCBF8" bgcolor="#FFFFFF" cellspacing="5" cellpadding="5" align="center">
        <tr>
                <td align="left" width="50%">
				<div style="width:100px"><ul class="nav nav-pills nav-stacked">
  <li class="active">
    <a href="?id=add question">
      <span class="badge pull-right" style="padding:0px 0px !important;"><img src="img/back.png" border="0" width="16" height="16"></span>
      Back
    </a>
  </li>
  
</ul></div>
                   <!-- <a href="javascript:back()"><img src="img/goback.png" border="0" width="16" height="16"> Back</a> -->
                </td>
                <td align="right" width="50%">
				<div style="width:100px"><ul class="nav nav-pills nav-stacked">
  <li class="active">
    <a href="?id=add_question&subject=<?php echo $subject?>&cat=<?php echo $cat?>">
      <span class="badge pull-left" style="padding:0px 0px !important;"><img src="img/add.png" border="0" width="16" height="16"></span>
      More
    </a>
  </li>
  
</ul></div>
                   <!-- <a href="add_question.php?subject=<?php echo $subject?> &cat=<?php echo $cat?>"><img src="img/add_more.png" onClick="send();" border="0"> More</a> -->
                </td>
        </tr>
       <?php
      $sql_select="SELECT * FROM `test_category` where category_id='$cat'";
       $rs_select=mysql_query($sql_select);
       $row_select=mysql_fetch_array($rs_select);
     
           $catname=$row_select['name'];
           
      /*  $rs_selectcat=mysql_query("SELECT * FROM subcategory where ID='$cat' and CAT_ID='$subject'");
       $row_selectcat=mysql_fetch_array($rs_selectcat);
           $catname=$row_selectcat['SUB_CAT_NAME'];*/
  
       ?>
       <tr bgcolor="#99FFCC" >
       <td  align="center" style="padding:10px; border-radius:4px;"><font color="#800000" size="2">Question Type : &nbsp;<?php echo $subject; ?></font></td>
	   <td  align="center" style="padding:10px; border-radius:4px;"><font color="#800000" size="2">Category : &nbsp;<?php echo $catname; ?></font></td>
        </tr>
			<tr>
				<td colspan="2" bgcolor="#FFFFFF">
				<p>Question<b><font color="#B81900">*</font></b></p>
				<textarea cols="30" id="summernote" name="summernote" rows="5" style="width:880px;height:50px;"></textarea>
			
</td>
			</tr>
            <tr>
            <td colspan="2" align="left">
			
            </td>
            
            </tr>
            <tr>
            <td>
			<p>Answer Choice 1 <b><font color="#B81900">*</font></b></p>
			<div class="input-group">
  <span class="input-group-addon">A</span>
  <input type="text" name="option_1" id="option_11" class="form-control" value="True" />
</div>
</td><td>
			<p>Answer Choice 2 <b><font color="#B81900">*</font></b></p>
			<div class="input-group">
  <span class="input-group-addon">B</span>
  <input type="text" name="option_2" id="option_12"  class="form-control" value="False" />
</div>
			
			
			</td><tr><td>
            <p>Difficulty Level<b><font color="#B81900">*</font></b> </p> <select size="1" name="diff" id="answer1">
			<option value="">None selected</option>
			<option value="difficult">Difficult</option>
			<option value="modoret">Modorate</option>
			<option value="easy">Easy</option>
			</select>
			</td>
			<td>
			<p>Answer<b><font color="#B81900">*</font></b></p>
			<select name="answer[]" id="answer" size="1" multiple="multiple">
            
            <option value="1">A</option>
            <option value="2">B</option>
            
            </select></td>
            </tr>   
            <tr>
            <td colspan="2"><p>Explanation</p>
            				<textarea cols="50" id="summernote1" name="summernote1" rows="5" style="width:880px;height:20px"></textarea>
			

        </td>
		</tr>
		<tr>
		<td colspan="2" align="center">
            <p>
                <input type='submit' class="btn btn-success" name='Submit' value='Save &amp; Continue' />
				</p>
           
            </td>
            </tr>   
                  <input type="hidden" name="subject" id="subject" value="<?php echo $subject?>">
				  <input type="hidden" name="cat" id="cat" value="<?php echo $cat?>">
				  <input type="hidden" name="user" id="user" value="<?php echo $_SESSION['email_of_user']; ?>">
			</tr>
		</table>
		</form>
		<?php } ?>
		<?php if($subject=='Block-Level'){  ?>
<?php if($_SESSION['flag']!=''){ ?><div class="alert alert-success alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <?php echo $_SESSION['success']; ?> </div> <?php } $_SESSION['success']=''; ?>
   <?php if($fgmembersite->GetErrorMessage()){ ?><div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
   <?php echo $fgmembersite->GetErrorMessage(); ?> </div> <?php } ?>
   <form id="entry_form" enctype="multipart/form-data" method="post">
<input type='hidden' name='submitted' id='submitted' value='1'/>
<table border="0" width="100%" id="table2" style="border-collapse: collapse"  bgcolor="#FFFFFF" cellspacing="5" cellpadding="5" align="center">
        <tr>
                <td align="left" width="50%">
				<div style="width:100px"><ul class="nav nav-pills nav-stacked">
  <li class="active">
    <a href="?id=add question">
      <span class="badge pull-right" style="padding:0px 0px !important;"><img src="img/back.png" border="0" width="16" height="16"></span>
      Back    </a>  </li>
  
</ul></div>
                   <!-- <a href="javascript:back()"><img src="img/goback.png" border="0" width="16" height="16"> Back</a> -->                </td>
                <td align="right" width="50%">
				<div style="width:100px"><ul class="nav nav-pills nav-stacked">
  <li class="active">
    <a href="?id=add_question&subject=<?php echo $subject?>&cat=<?php echo $cat?>">
      <span class="badge pull-left" style="padding:0px 0px !important;"><img src="img/add.png" border="0" width="16" height="16"></span>
      More    </a>  </li>
  
</ul></div>
                   <!-- <a href="add_question.php?subject=<?php echo $subject?> &cat=<?php echo $cat?>"><img src="img/add_more.png" onClick="send();" border="0"> More</a> -->                </td>
        </tr>
       <?php
      $sql_select="SELECT * FROM `test_category` where category_id='$cat'";
       $rs_select=mysql_query($sql_select);
       $row_select=mysql_fetch_array($rs_select);
     
           $catname=$row_select['name'];
           
      /*  $rs_selectcat=mysql_query("SELECT * FROM subcategory where ID='$cat' and CAT_ID='$subject'");
       $row_selectcat=mysql_fetch_array($rs_selectcat);
           $catname=$row_selectcat['SUB_CAT_NAME'];*/
  
       ?>
       <tr bgcolor="#99FFCC" >
       <td  align="center" style="padding:10px; border-radius:4px;"><font color="#800000" size="2">Question Type : &nbsp;<?php echo $subject; ?></font></td>
	   <td  align="center" style="padding:10px; border-radius:4px;"><font color="#800000" size="2">Category : &nbsp;<?php echo $catname; ?></font></td>
        </tr>
		<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
				<td colspan="2" bgcolor="#FFFFFF">
				<div class="panel panel-info">
  <div class="panel-heading">Common Text<font color="#B81900">*</font></div>
				<textarea cols="30" class="summernote" name="cnote" rows="5" style="width:880px;height:50px;"></textarea>
				</div></td>
			</tr>
			</table>
			<div id="que">
			<table>
            <tr>
            <td colspan="2" align="left"> <div class="panel panel-warning"> <div class="panel-heading">Question<font color="#B81900">*</font></div>    <textarea cols="30" class="summernote" name="summernote" rows="5" style="width:880px;height:50px;" ></textarea></div>       </td>
            </tr>
			<tr>
            <td colspan="2" align="left"></td></tr>
            <tr>
            <td colspan="2">
			<div class="panel panel-primary">
  <div class="panel-heading">Answer Choice 1 <b><font color="#B81900">*</font></b></div>
			<textarea cols="10"  name="option_1" id="option_1" rows="2" style="width:880px;height:10px !important;"></textarea></div>
			<div class="panel panel-primary">
  <div class="panel-heading">Answer Choice 2 <b><font color="#B81900">*</font></b></div>
			<textarea cols="10"  name="option_2" id="option_2" rows="2" style="width:880px;height:10px !important;"></textarea></div>
			<div class="panel panel-primary">
  <div class="panel-heading">Answer Choice 3 <b><font color="#B81900">*</font></b></div>
			<textarea cols="10"  name="option_3" id="option_3" rows="2" style="width:880px;height:10px !important;"></textarea>
			</div>
			<div class="panel panel-primary">
  <div class="panel-heading">Answer Choice 4 <b><font color="#B81900">*</font></b></div>
			<textarea cols="10"  name="option_4" id="option_4" rows="2" style="width:880px;height:10px !important;"></textarea></div>
			<div class="panel panel-primary">
  <div class="panel-heading">Answer Choice 5 <b><font color="#B81900">*</font></b></div>
			<textarea cols="10"  name="option_5" id="option_5" rows="2" style="width:880px;height:10px !important;"></textarea></div>			</td><tr><td>
           <div class="panel panel-danger">
  <div class="panel-heading">Difficulty Level<b><font color="#B81900">*</font></b> </div> <select  name="diff" id="answer1">
			<option value="">None selected</option>
			<option value="difficult">Difficult</option>
			<option value="modorate">Modorate</option>
			<option value="easy">Easy</option>
			</select>
			</div>
			</td>
			<td>
			<div class="panel panel-danger">
  <div class="panel-heading">Answer<b><font color="#B81900">*</font></b></div>
			<select name="answer[]" id="answer"  multiple="multiple">
            <option value="1">A</option>
            <option value="2">B</option>
            <option value="3">C</option>
            <option value="4">D</option>
            <option value="5">E</option>
            </select></div></td>
            </tr>   
            <tr>
            <td colspan="2"><div class="panel panel-warning">
  <div class="panel-heading">Explanation</div>
            			<textarea cols="50" id="summernote1" name="summernote1" rows="5" style="width:880px;height:20px;"></textarea>	</div>        </td>
		</tr>
		
			</table>
		</div> 
		<table><tr>
		<tdalign="center">
            <p align="center">
                <input type='submit' class="btn btn-success" name='Submit' value='Save &amp; Continue'  />
				</p>            </td>
            </tr> </table> 
                  <input type="hidden" name="subject" id="subject" value="<?php echo $subject?>">
				  <input type="hidden" name="cat" id="cat" value="<?php echo $cat?>">
				  <input type="hidden" name="user" id="cat" value="<?php echo $_SESSION['email_of_user']; ?>">
			
		
</form>
		<?php } ?>
		<script type='text/javascript' src="../../../../javascript/bootstrap.min.js"></script>

</body>

</html>
