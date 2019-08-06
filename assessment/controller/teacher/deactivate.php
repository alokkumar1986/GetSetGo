<?PHP
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}
$fgmembersite->DBLogin();

if(isset($_POST['submitted']))
{
$formvars['test'] = $fgmembersite->Sanitize($_POST['test']);
		$formvars['college'] = $fgmembersite->Sanitize($_POST['college']);
		$formvars['shortname'] = $fgmembersite->Sanitize($_POST['shortname']);
        $formvars['yop'] = $fgmembersite->Sanitize($_POST['yop']);
		$yop=str_replace('multiselect-all,','', implode(",",$formvars['yop']));
        $formvars['sdate'] = $fgmembersite->Sanitize($_POST['sdate']);
        $formvars['edate'] = $fgmembersite->Sanitize($_POST['edate']);
        $formvars['sectionduration'] = $fgmembersite->Sanitize($_POST['sectionduration']);
		$formvars['calculator'] = $fgmembersite->Sanitize($_POST['calculator']);
		$formvars['instance'] = $fgmembersite->Sanitize($_POST['instance']);
		$formvars['result'] = $fgmembersite->Sanitize($_POST['result']);
		$formvars['review'] = $fgmembersite->Sanitize($_POST['review']);
   $qry="delete from `test_setting` where (test_id='".$formvars['test']."' and for_college='".$formvars['college']."' and `for_yop`='".$yop."')";
		if(!mysql_query( $qry ,$fgmembersite->connection))
        {
            $fgmembersite->HandleDBError("Error in Inserting Data.. \nquery:$qry2");
            return false;
        }
		$fgmembersite->RedirectToURL("?id=setting");
}


?>
