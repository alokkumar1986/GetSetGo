<?PHP 
require_once("./include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("login.php");
	
    exit;
}
else{
$fgmembersite->RedirectToURL("controller/index.php");
}


?>