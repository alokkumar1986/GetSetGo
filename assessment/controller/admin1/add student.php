<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}

if(isset($_POST['submitted']))
{
   if($fgmembersite->Addstudent())
   {
        $fgmembersite->RedirectToURL("?id=addedstudent");
   }
}

?>

      <title>Add Student</title>
      <!--<link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css" />-->
      <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
     <!-- <link rel="STYLESHEET" type="text/css" href="style/pwdwidget.css" />-->
      <script src="scripts/pwdwidget.js" type="text/javascript"></script>    
	  <script type= "text/javascript" src = "../../js/college.js"></script>
	  <script type="text/javascript" src="../../js/bootstrap-datepicker.js"></script>
	  
<script type="text/javascript">
            // When the document is ready
            $(document).ready(function () {
                
                $('#date2').datepicker({
                    format: "yyyy/mm/dd"
                });  
            
            });
        </script>
        <style type="text/css">
        	select {
				
				width:207px;
			}
			.input-group{
				width:97px;
			}
        </style>
		<link rel="stylesheet" href="../../css/datepicker.css">
	  <!--<div id='fg_membersite'>--><div>
<form id='changepwd' action='' method='post' enctype="multipart/form-data">

<fieldset style="float:center;" >
<legend><font color="#330099" ><strong>Add Student</strong></font></legend>
<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
<p>Email-Id and Reg No. Will be treated as username and password respectvely.</p>
<input type='hidden' name='submitted' id='submitted' value='1'/>
   <input type="text" name="name" placeholder="Name"/>&nbsp;&nbsp;&nbsp;
<input type="text" name="bputreg" placeholder="BPUT Regd."/><br/>
<input type="text" name="email" placeholder="Email"/>&nbsp;&nbsp;&nbsp;
<input type="text" name="mobileno" placeholder="MobileNo"/>
<div class="row">
<div class="col-lg-4" style="padding-left:15px;">
<input type="text" name="date" id="date2" placeholder="Date Of Birth">
</div>
<div class="col-lg-2" style="margin-left: 0px;">
<div class="input-group">
      <span class="input-group-addon">
        <input type="radio" name="gender" value="Male">
      </span>
      <span class="form-control">Male</span>
    </div></div>
	<div class="col-lg-3" style="margin-left: -17px;">
	<div class="input-group">
      <span class="input-group-addon">
        <input type="radio" name="gender" value="Male">
      </span>
      <span class="form-control">Female</span></div></div>
    </div>
<select style="color:#808080" onchange="print_college('college',this.selectedIndex);" id="university" name = "university"></select>&nbsp;&nbsp;&nbsp;
<select style="color:#808080" name="college" id="college" placeholder="Enter College"></select>
<script language="javascript">print_university("university");</script><br/>

<br/>
<select name="stream" style="color:#808080" ><option value="">-Select Branch-</option><option value="COMPUTER SCIENCE ENGG">COMPUTER SCIENCE ENGG</option></option>
<option value="ELECTRONICS AND TELECOMMUNICATION ENGG">ELECTRONICS AND TELECOMMUNICATION ENGG</option>
<option value="ELECTRICAL AND ELECTRONICS ENGG">ELECTRICAL AND ELECTRONICS ENGG</option>
<option value="ELECTRICAL ENGG">ELECTRICAL ENGG</option>
<option value="INFORMATION TECHNOLOGY">INFORMATION TECHNOLOGY</option>
<option value="MECHANICAL ENGG">MECHANICAL ENGG</option>
<option value="CIVIL ENGG">CIVIL ENGG</option>
<option value="AUTOMOBILE ENGG">AUTOMOBILE ENGG</option>
<option value="APPLIED ELECTRONICS & INSTRUMENTATION ENGG">APPLIED ELECTRONICS & INSTRUMENTATION ENGG</option>
</select>&nbsp;&nbsp;&nbsp;
<select size="1" name="batch" style="color:#808080"  id="">
						<option value="">-Select Passing Out Year-</option>
						<?php for($i=2014;$i<=2017;$i++){ ?>
							
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php } ?>
                            </select><br/>
<br/>
<!--<input type="text" name="branch" placeholder="Branch"/><br/>-->
 <input type="file" name="pic" placeholder="Choose Image"/><br/>
<br/>
    <input type='submit' class="btn btn-success" name='Submit' value='Submit' />
</fieldset>
</form>
<!-- client-side Form Validations:
Uses the excellent form validation script from JavaScript-coder.com-->

<script type='text/javascript'>
// <![CDATA[
    var pwdwidget = new PasswordWidget('oldpwddiv','oldpwd');
    pwdwidget.enableGenerate = false;
    pwdwidget.enableShowStrength=false;
    pwdwidget.enableShowStrengthStr =false;
    pwdwidget.MakePWDWidget();
    
    var pwdwidget = new PasswordWidget('newpwddiv','newpwd');
    pwdwidget.MakePWDWidget();
    
    
    var frmvalidator  = new Validator("changepwd");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();

    frmvalidator.addValidation("oldpwd","req","Please provide your old password");
    
    frmvalidator.addValidation("newpwd","req","Please provide your new password");

// ]]>
</script>



</div>
<!--
Form Code End (see html-form-guide.com for more info.)
-->
