<?PHP
error_reporting(0);
require_once("../../include/membersite_config.php");

if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}

$fgmembersite->DBLogin();
//require("db.php");
$action = mysql_real_escape_string($_POST['action']); 
print_r($updateRecordsArray 	= $_POST['recordsArray']);
$sql="Select max(id) as maxid from `online_test`";
$rs=mysql_query($sql)or die(mysql_error());
if($res=mysql_fetch_array($rs)){
$maxid=$res['maxid'];
}
//echo $maxid ."<br />";
$count=count($updateRecordsArray);
if ($action == "updateRecordsListings"){
	
  $listingCounter = $maxid+1;
	foreach ($updateRecordsArray as $recordIDValue) {
		
		$query = "UPDATE `online_test` SET id = " . $listingCounter . " WHERE id = " . $recordIDValue;
		mysql_query($query) or die('Error, insert query failed');
		$listingCounter = $listingCounter + 1;	
	}
	echo '<pre>';
	print_r($updateRecordsArray);
	echo '</pre>';
	echo 'If you refresh the page, you will see that records will stay just as you modified.';
}
?>