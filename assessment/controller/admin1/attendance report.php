<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
    exit;
}
$fgmembersite->DBLogin();
?>

      <title>Report For Non-attendace</title>
      <!--<link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css" />-->
      <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
     <!-- <link rel="STYLESHEET" type="text/css" href="style/pwdwidget.css" />-->
      <script src="scripts/pwdwidget.js" type="text/javascript"></script>    
	  <script type= "text/javascript" src = "../../js/college.js"></script>
	  <script type="text/javascript" src="../../js/bootstrap-datepicker.js"></script>
	  <script>
    function submitForm(action)
    {
        document.getElementById('changepwd').action = action;
        document.getElementById('changepwd').submit();
    }
</script>
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
<legend><font color="#330099" ><strong>Interview Attendance Report Generation</strong></font></legend>
<div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
<input type='hidden' name='submitted' id='submitted' value='1'/>
   <select style="color:#808080" onchange="print_college('college',this.selectedIndex);" id="university" name = "university"></select>&nbsp;&nbsp;&nbsp;
<select style="color:#808080" name="college" id="college" placeholder="Enter College"></select>
<script language="javascript">print_university("university");</script><br/>

<br/>
<select name="stream" style="color:#808080" ><option value="">-Select Branch-</option><option value="COMPUTER SCIENCE ENGG</option><option>ELECTRONICS AND TELECOMMUNICATION ENGG">COMPUTER SCIENCE ENGG</option><option value="ELECTRONICS AND TELECOMMUNICATION ENGG">ELECTRONICS AND TELECOMMUNICATION ENGG</option>
<option value="ELECTRICAL AND ELECTRONICS ENGG">ELECTRICAL AND ELECTRONICS ENGG</option>
<option value="ELECTRICAL ENGG">ELECTRICAL ENGG</option>
<option value="INFORMATION TECHNOLOGY">INFORMATION TECHNOLOGY</option>
<option value="MECHANICAL ENGG">MECHANICAL ENGG</option>
<option value="CIVIL ENGG">CIVIL ENGG</option>
<option value="AUTOMOBILE ENGG">AUTOMOBILE ENGG</option>
<option value="APPLIED ELECTRONICS & INSTRUMENTATION ENGG">APPLIED ELECTRONICS & INSTRUMENTATION ENGG</option>
</select> &nbsp;&nbsp;&nbsp;<input type="text" name="date"  id="date2" placeholder="Date Of Interview" style="margin-top: 7px;"/>
<br/><br/>
<select style="color:#808080" name="interviewer"><option value="">-Select Interviewer-</option>
<?php $sql=mysql_query("select Distinct(INTERVIEWER) from pi");
while($rs=mysql_fetch_array($sql)){ ?>
<option value="<?php echo $rs['INTERVIEWER']; ?>"><?php echo $rs['INTERVIEWER']; ?></option>
<?php	
} ?>
</select>&nbsp;&nbsp;&nbsp;
<select style="color:#808080" name="interviewtype">

<option value="PI" selected="selected">Personal Interview</option>
<option value="TI">Technical Interview</option>
</select>
   <br />
<br/>
 <p align="left">   <input type='button' class="btn btn-danger" name='Submit' value='Generate EXCEL' onclick="submitForm('notattainexcel.php')" />  <input type='button' class="btn btn-success" name='Submit' value='Generate PDF' onclick="submitForm('notattainpdf.php')" /> </p>
</fieldset>
</form>
</div>
