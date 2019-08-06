<?PHP session_start();
$path="http://".$_SERVER['SERVER_NAME']."/GetSetGo/";
ob_start();
error_reporting(1);
require_once("../../include/membersite_config.php");
$fgmembersite->DBLogin();
if(!$fgmembersite->CheckLogin())
{
  $fgmembersite->RedirectToURL("../../login.php");
  exit;
}
$arrConditions = array('email' => $_SESSION['email_of_user']);

$student_data = $fgmembersite->getWhereCustomActionValues("USP_ADMIN_DATA", "A", $arrConditions);
if(!empty($student_data['result'])){
  $student_data  = $student_data['result'];
}
$page = $_GET['id'];
$rs   = $student_data;
//($rs); exit;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> -->
  <link href="../../css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../../css/style2.css">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

  <script src="../../js/jquery.min.js"></script>
  <script src="../../js/bootstrap.min.js"></script>
  <script src="../../js/chart.js"></script>
  <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
  <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script> -->
  <style>
  /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
  .row.content {min-height: 550px;}

  /* Set gray background color and 100% height */
  .sidenav {
    background-color: #f1f1f1;
    height: 100%;
  }

  /* Set black background color, white text and some padding */
  footer {
    background-color: #306bcf;
    color: white;
    padding: 4px;
  }

  /* On small screens, set height to 'auto' for sidenav and grid */
  @media screen and (max-width: 767px) {
    .sidenav {
      height: auto;
      padding: 15px;
    }
    .row.content {height: auto;} 
  }
  div.subitem a.list-group-item {
    padding-left: 30px;
  }
  .loader {
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url(../../../student/controller/Student/onlinesystem/images/loading.gif) 50% 50% no-repeat rgb(249,249,249);
  }
  .sidebarmenu{
    margin:0px 0;
    padding:0;
    width:195px;
  }
  .sidebarmenu a.menuitem{background:url(../../image/sidebar_menu_top.gif) no-repeat center top;
    color: #fff;display: block;position: relative;width:100%;height:31px;margin:0 0 5px 8px;line-height:31px;padding:0px 0 0 10px;text-decoration: none;
  }
  .sidebarmenu a.menuitem_green{background:url(../../image/green_bt.gif) no-repeat center top;
    color: #fff;display: block;position: relative;width:100%;height:31px;margin:0 0 5px 8px;line-height:31px;padding:0px 0 0 10px;text-decoration: none;
  }
  .sidebarmenu a.menuitem_red{background:url(../../image/red_bt.gif) no-repeat center top;
    color: #fff;display: block;position: relative;width:100%;height:31px;margin:0 0 5px 8px;line-height:31px;padding:0px 0 0 10px;text-decoration: none;
  }
  .sidebarmenu a.menuitem:hover{background:url(../../image/sidebar_menu_top_a.gif) no-repeat center top;}
  .sidebarmenu a.menuitem_green:hover{background:url(../../image/green_bt_a.gif) no-repeat center top;}
  .sidebarmenu a.menuitem_red:hover{background:url(../../image/red_bt_a.gif) no-repeat center top;}

  .sidebarmenu a.menuitem:visited, .sidebarmenu .menuitem:active{
    color: white;
  }
  .sidebarmenu a.menuitem .statusicon{
    position: absolute;
    top:11px;
    right:7px;
    border: none;
  }

  .sidebarmenu div.submenu{
    background: white;
  }
  .sidebarmenu div.submenu ul{ 
    list-style-type: none;
    margin: 0;
    padding: 0 0 5px 0;
  }
  .sidebarmenu div.submenu ul li{
    border-bottom: 1px dotted #bfd1d9;
  }
  .sidebarmenu div.submenu ul li a{
    display: block;
    color: black;
    text-decoration: none;
    padding:5px 0;
    padding-left: 10px;
  }
  .sidebarmenu div.submenu ul li a:hover{
    background: #e2f0ff;
    color: #0e4354;
  }

  .sidebar_search{
    background:url(../../image/sidebar_menu_top.gif) no-repeat center;
    width:195px;
    height:31px;
    margin:0 0 5px 0;
  }
  </style> 
  <script type="text/javascript" src="../../js/ddaccordion.js"></script>

  <script type="text/javascript">
  ddaccordion.init({
headerclass: "submenuheader", //Shared CSS class name of headers group
contentclass: "submenu", //Shared CSS class name of contents group
revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
animatedefault: false, //Should contents open by default be animated into view?
persiststate: true, //persist state of opened contents within browser session?
toggleclass: ["", ""], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
togglehtml: ["suffix", "<img src='../../image/plus.gif' class='statusicon' />", "<img src='../../image/minus.gif' class='statusicon' />"], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
//do nothing
},
onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
//do nothing
}
})
</script>
<script type="text/javascript">
$(window).load(function(){
  $(".loader").fadeOut("slow");
})
</script></script> 
</head>
<body>
  <div class="loader">
    <p style="padding-top:350px;font-size:24px;color:red" align="center">Please Wait.</p>
  </div>
  <nav class = "navbar navbar-default" role = "navigation">

   <div class = "navbar-header">
    <a class = "navbar-brand" href = "index.php"><img src="<?php echo $path; ?>img/77.gif" width="120" alt="logo"></a>
  </div>

  <div class="pull-right">
    <ul class = "nav navbar-nav">
      <?php $photo=$rs['Photo'];  ?>

      <li class = "active">
        <img <?php if($photo!='' && file_exists(dirname(__FILE__)."../admin/uploads1/<?php echo $photo; ?>")){ ?>src="../admin/uploads1/<?php echo $photo; ?>" <?php }else { ?>src="../example/profile.jpg" <?php } ?> alt="User Photo" width="43" height="" style="border:2px solid #ddd;border-radius:50%;float:left;margin-right:0px;    margin-top: 2px;">  
      </li>


      
      <li class = "dropdown">
        <a href = "#" class = "dropdown-toggle" data-toggle = "dropdown">
         Hello, <?php echo ucwords($_SESSION['name_of_user']); ?>
         <b class = "caret"></b>
       </a>

       <ul class = "dropdown-menu">
         <li><a href = "index.php?id=profile&amp;sid=<?php echo $_SESSION['email_of_user']; ?>"><i class="fa fa-user-circle" aria-hidden="true"></i> Profile</a></li>
         <li><a href = "index.php?id=change password"><i class="fa fa-cog" aria-hidden="true"></i> Change Password</a></li>
         <li><a href = "../../logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></l>
       </ul>

     </li>

   </ul>
 </div>

</nav>

<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-2 sidenav">
      <div class="row">
        <?php include("leftMenu.php"); ?>
      </div>
    </div>


    <div class="col-sm-10">


     <div class="row">
      <div class="col-sm-3 p0">
        <div class="card text-white bg-secondary mb-3">
          <div class="card-body">
           <h4 class="card-title">Special title treatment</h4>
           <p class="card-text text-white">55555</p>
           <div class="icon">
            <i class=" fa fa-address-book-o"></i>
          </div>  
        </div>
      </div>
    </div>
    <div class="col-sm-3 p0">
      <div class="card text-white bg-success mb-3">
        <div class="card-body">
         <h4 class="card-title">Special title treatment</h4>
         <p class="card-text text-white">55555</p>
         <div class="icon">
          <i class="  fa fa-file-o"></i>
        </div>  
      </div>
    </div>
  </div>
  <div class="col-sm-3 p0">
    <div class="card text-white bg-warning mb-3">
      <div class="card-body">
        <h4 class="card-title">Special title treatment</h4>
        <p class="card-text text-white">55555</p>
        <div class="icon">
          <i class="fa fa-file-video-o"></i>
        </div>  
      </div>
    </div>
  </div>
  <div class="col-sm-3 p0">
    <div class="card text-white bg-info mb-3">
      <div class="card-body">
        <h4 class="card-title">Special title treatment</h4>
        <p class="card-text text-white">55555</p>
        <div class="icon">
          <i class="  fa fa-plus-square-o"></i>
        </div>  
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <div id="chartContainer" style="height: 300px; width: 100%;"></div>
      </div>
    </div>
  </div>

  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
       <div id="chartContainer1" style="height: 300px; width: 100%;"></div>
     </div>
   </div>
 </div>
</div>



</div>
</div>
</div>

<footer class="container-fluid">
  <div class="row">
    <div class="col-sm-12">  
      <center><span class="text-center">Copyright &copy; <?php echo date("Y"); ?> Indus Education. All Rights Reserved.</span></center>
    </div>
  </div>
</footer>

</body>
</html>
