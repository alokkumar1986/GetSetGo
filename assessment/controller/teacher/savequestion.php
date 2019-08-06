<?php 
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
   	    
        $fgmembersite->HandleDBError("Question Added Successfully");
   }
}
?>