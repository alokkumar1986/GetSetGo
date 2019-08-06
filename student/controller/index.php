<?PHP
require_once("../include/membersite_config.php");

if($fgmembersite->CheckLogin())
{
	$fgmembersite->RedirectToURL("$_SESSION[role]");
    exit;
}

else{ 
 $fgmembersite->RedirectToURL("../login.php");
}

?>