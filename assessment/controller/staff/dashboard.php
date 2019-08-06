<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}




?>

      <title>Dashboard</title>
     
      <script type="javascript">
	  	function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInp").change(function(){
        readURL(this);
    });
	  	
	  </script>
	  <link rel="stylesheet" type="text/css" href="../../css/bootstrap.icon-large.min.css">
<!--<div id='fg_membersite'>--><div onload="readURL(input);">
<form id='changepwd' action='' method='post' enctype="multipart/form-data">

<fieldset style="margin: 0 0 0 17px !important;">
<!--<legend><font color="#330099" ><strong>Dashboard</strong></font></legend>-->

                       <!-- Dashboard icons --> 
            <div > 
            	
               
                
               <!-- <a href="?id=add faculty" class="dashboard-module"> 
                	<img src="../../image/Crystal_Clear_user.gif"  width="64" height="64" alt="edit" />
                	<span>Add Faculty</span> 
                </a> 
                  <a href="?id=upload faculty" class="dashboard-module"> 
                	<img src="../../image/user_up.png"  width="64" height="64" alt="edit" /> 
                	<span>Upload Faculty</span> 
                </a> 
                  <a href="?id=view faculty" class="dashboard-module"> 
                	<img src="../../image/photo_edit.png"  width="64" height="64" alt="edit" /> 
                	<span>View Faculty</span> 
                </a> 
                 
                <a href="?id=add student" class="dashboard-module"> 
                	<img src="../../image/Crystal_Clear_user.gif"  width="64" height="64" alt="edit" /> 
                	<span>Add Student</span> 
                </a> 
                  <a href="?id=upload student" class="dashboard-module"> 
                	<img src="../../image/user_up.png"  width="64" height="64" alt="edit" /> 
                	<span>Upload Student</span> 
                </a> 
                  <a href="?id=view student" class="dashboard-module"> 
                	<img src="../../image/photo_edit.png"  width="64" height="64" alt="edit" /> 
                	<span>View Student</span> 
                </a> -->
               
                <a href="search.php" class="dashboard-module"> 
                	<img src="../../image/chart_down.png"  width="64" height="64" alt="edit" /> 
 
                	<span>Interview</span> 
                </a> 
				<a href="?id=interview report" class="dashboard-module"> 
                	<img src="../../image/chart_up.png"  width="64" height="64" alt="edit" /> 
 
                	<span>Report</span> 
                </a> 
				<!--<a href="?id=attendance report" class="dashboard-module"> 
                	<img src="../../image/chart.png"  width="64" height="64" alt="edit" /> 
 
                	<span>Attendance Report</span> 
                </a> -->
				
                <!--<a href="?id=add college" class="dashboard-module"> 
                	<img src="../../image/home_add.png"  width="64" height="64" alt="edit" /> 
                	<span>Add College</span> 
                </a> 
                <a href="?id=add branch" class="dashboard-module"> 
                	<img src="../../image/image_add.png"  width="64" height="64" alt="edit" /> 
                	<span>Add Branch</span> 
                </a> 
                <a href="?id=add notice" class="dashboard-module"> 
                	<img src="../../image/notes_add.png"  width="64" height="64" alt="edit" /> 
                	<span>Add Notice</span> 
                </a> 
                <a href="?id=view notice" class="dashboard-module"> 
                	<img src="../../image/notes_lock.png"  width="64" height="64" alt="edit" /> 
                	<span>View Notice</span> 
                </a>
                <a href="?id=interview setting" class="dashboard-module"> 
                	<img src="../../image/Crystal_Clear_settings.gif"  width="64" height="64" alt="edit" /> 
                	<span>Interview Settings</span> 
                </a>
                <a href="#" class="dashboard-module"> 
                	<img src="../../image/page_process.png"  width="64" height="64" alt="edit" /> 
                	<span>XXXX</span> 
                </a>-->
                <div style="clear: both"></div> </div> 
                    
              
</fieldset>
</form>
</div>
 
