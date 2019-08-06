<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}




?>

<title>Dashboard</title>
<link href="../../css/bootstrap1.css" rel="stylesheet">
<link href="../../css/bootstrap-responsive.css" rel="stylesheet">
<!--<link href="css/jquery-ui.css" rel="stylesheet">-->
<link rel="stylesheet" href="../../css/typica-login.css">
<link href="../../css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../../css/style.css">
<link rel="stylesheet" type="text/css" href="../../css/jquery.autocomplete.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

   
<link rel="shortcut icon" href="http://induseducation.in/favicon.ico" />
<script src="../../js/jquery-latest.js"></script>
<script src="../../js/bootstrap.js"></script>
<!--<script src="../../js/backstretch.js"></script>-->
<!--<script src="../../js/typica-login.js"></script>-->
<script src="../../js/jquery.autocomplete.js"></script>
    
<script type="text/javascript">
$(document).ready(function(){
$("#s").autocomplete("data.php");

$.ajaxSetup ({
		cache: false
	});
	var ajax_load = "Loading..";

//	load() functions
	$("#search").click(function(){
	var q1=document.getElementById('s').value;
	
  htmlobj=$.ajax({url:"data_load.php?q="+q1,async:false,cache:false});
  $("#result").html(htmlobj.responseText);
	});
});
</script>
<link rel="stylesheet" type="text/css" href="../../css/bootstrap.icon-large.min.css">
<!--<div id='fg_membersite'>--><div onload="readURL(input);">
<form id='changepwd' action='' method='post' enctype="multipart/form-data">

<fieldset style="margin: 0 0 0 17px !important;">
<!--<legend><font color="#330099" ><strong>Dashboard</strong></font></legend>-->

                       <!-- Dashboard icons --> 
             <div id="login-wraperb" style="margin:0px auto;">
      
            <form class="form login-form" action="" name='login' method="post">
                    
                <div class="body">
               
                    <input placeholder="Search Student by Name Or Registration Number" name='s' id='s' type="text" style="width:49%;line-height: 25px !important;margin-bottom: 0px !important">
                    
                    <input type=button value='Search' class="btn btn-success" id="search" style="">
                    
                                  </div>            
            </form>
        </div>
                <div id="result" style="padding:10px;"></div> 
				
       </div>       

</form>
</fieldset>
<div style="clear:both;"></div>   

 
