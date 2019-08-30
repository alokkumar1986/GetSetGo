<?PHP session_start();
ob_start();
error_reporting(1);
$path=$_SERVER['DOCUMENT_ROOT']."/GetSetGo/";
include($path."assessment/include/membersite_config.php");
//echo $path."assessment/include/membersite_config.php";
$fgmembersite->DBLogin();
if(!$fgmembersite->CheckLogin())
{
  $fgmembersite->RedirectToURL("../../login.php");
  exit;
}

//print_r($_REQUEST);

$method = $_REQUEST['method'];
switch($method){
 
 case 'getSubcategory':
 	$parentId = $_REQUEST['parentId'];
 	getSubcategory($parentId);
 break;
}


/*=========================  Function Call Here ******************* */

function getSubcategory($catId){
	include($path."assessment/include/fgmembersite.php");
	$fgmembersite = new FGMembersite();
	$fgmembersite->InitDB(/*hostname*/'localhost',
                      /*username*/'root',
                      /*password*/'',
                      /*database name*/'indusedu_webcms',
                      /*table name*/'staff');

//For better security. Get a random string from this link: http://tinyurl.com/randstr
// and put it here
  $fgmembersite->SetRandomKey('11111qSRcVS6DrTzrPvr');
	$arrConditions = array('parentId' => $catId);
	$data = $fgmembersite->getWhereCustomActionValues("USP_ADMIN_TEST", "TCT", $arrConditions);
	//print_r($data['result']);exit;
	if(!empty($data['result'])){
	  $dataRes  = $data['result'];
    $count    = count($dataRes);
    $i = 0;
	   $selField = '<option value="" selected="selected">-Select Sub Category-</option>';
      while ($i < $count){
      if($dataRes[$i]['category_id']!=''){
          $selField  .=	'<option value="'.$dataRes[$i]['category_id'].'">'.$dataRes[$i]['name'].'<option>';
       }
       $i++;
      }
      $selField  .=	'';
	  echo $selField;
	}
}
