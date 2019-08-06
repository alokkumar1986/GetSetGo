<?php require_once("../../include/membersite_config.php");
error_reporting(0);
if(!$fgmembersite->CheckLogin())
{
    $fgmembersite->RedirectToURL("../../login.php");
    exit;
}
$fgmembersite->DBLogin(); 
$category_id=$_REQUEST['category'];

$user=$_REQUEST['user'];
$type=$_REQUEST['question'];
if($type=='Multiple-Option'){
?>
 <table width="100%" height="auto" id="table1" style="border-collapse:collapse;border:2px solid #585858" align="center" cellpadding="1" rules="all">
  <tr bgcolor="#C0FFFF">
  <td width="2%" >Qs No</td>
  <td width="15%">Question</td>
  <td width="10%" align="center">
	Difficulty Level</td>
  <td width="10%">option1</td>
  <td width="10%">option2</td>
  <td width="10%">option3</td>
  <td width="10%">option4</td>
  <td width="10%">option5</td>
  <td width="3%">Answer</td>
  <td width="15%">Explanation</td>
  <td width="2%">Edit</td>
  <td width="3%">Delete</td>
 </tr>
<?php
//sanitize post value
$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
$item_per_page = 5;
//validate page number is really numaric
if(!is_numeric($page_number)){die('Invalid page number!');}

//get current starting point of records
$position = ($page_number * $item_per_page);


$sql_select="select * from test_question_multiple_choice where (category='$category_id' and question_added_by='$user' and  question_type='$type') ORDER BY question_id ASC LIMIT $position, $item_per_page";
  $rs_select=mysql_query($sql_select);
  
  $i=1;
  $color="#FFFBFF";
  while($row_select=mysql_fetch_array($rs_select))
  {
      $id=$row_select['question_id'];
      //echo "the id is".$id;
      $question=$row_select['question'];
      $option1=$row_select['choice1'];
      $option2=$row_select['choice2'];
      $option3=$row_select['choice3'];
      $option4=$row_select['choice4'];
      $option5=$row_select['choice5'];
      //$option6=$row_select['ans6'];
      $answer=$row_select['answer'];
      $explanation=$row_select['explanation'];
      $diff=$row_select['difficulty_level'];
       if($color=="#FFFBFF")
                 {
                    $color="#FFFFFF";
                 }
                else
                 {
                    $color="#FFFBFF";
                 }        
  
?>

 <tr bgcolor="<?php echo $color?>">  
 <td width="2%" valign="top"><?php echo $i; ?></td> 
  <td width="20%" valign="top" ><?php echo $question; ?></td>
  <td width="5%" valign="top"><?php echo $diff; ?></td>
  <td width="10%" valign="top"><?php echo $option1; ?></td>
  <td width="10%" valign="top"><?php echo $option2; ?></td>
  <td width="10%" valign="top"><?php echo $option3; ?></td>
  <td width="10%" valign="top"><?php echo $option4; ?></td>
  <td width="10%" valign="top"><?php echo $option5; ?></td>
  <td width="5%" valign="top"><?php echo $answer; ?></td>
  <td width="15%" valign="top"><?php echo $explanation; ?></td>
  <td width="2%" valign="top"><a href='index.php?id=edit_question&qid=<?php echo $id;?>'><img src="img/b_edit.png" border="0" width="16" height="16" ></a></td>
  <td width="3%" valign="top"><a href='?action=delete&qid=<?php echo $id;?>&category=<?php echo $category_id; ?>&question=<?php echo $type; ?>&user=<?php echo $user; ?>'><img src="img/b_drop.png" border="0" width="16" height="16" ></a></td>
  </tr>

<?php
$i=$i+1;
  }
  
  
    ?>
    </table>
<?php } 

if($type=='True/False'){
?>
 <table width="100%" height="auto" id="table1" style="border-collapse:collapse;border:2px solid #585858" align="center" cellpadding="1" rules="all">
  <tr bgcolor="#C0FFFF">
  <td width="2%" >Qs No</td>
  <td width="15%">Question</td>
  <td width="10%" align="center">
	Difficulty Level</td>
  <td width="10%">option1</td>
  <td width="10%">option2</td>
 
  <td width="3%">Answer</td>
  <td width="15%">Explanation</td>
  <td width="2%">Edit</td>
  <td width="3%">Delete</td>
 </tr>
<?php
//sanitize post value
$page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
$item_per_page = 5;
//validate page number is really numaric
if(!is_numeric($page_number)){die('Invalid page number!');}

//get current starting point of records
$position = ($page_number * $item_per_page);


$sql_select="select * from test_question_true_false where (category='$category_id' and question_added_by='$user' and  question_type='$type') ORDER BY question_id ASC LIMIT $position, $item_per_page";
  $rs_select=mysql_query($sql_select);
  
  $i=1;
  $color="#FFFBFF";
  while($row_select=mysql_fetch_array($rs_select))
  {
      $id=$row_select['question_id'];
      //echo "the id is".$id;
      $question=$row_select['question'];
      $option1=$row_select['choice1'];
      $option2=$row_select['choice2'];
      
      $answer=$row_select['answer'];
      $explanation=$row_select['explanation'];
      $diff=$row_select['difficulty_level'];
       if($color=="#FFFBFF")
                 {
                    $color="#FFFFFF";
                 }
                else
                 {
                    $color="#FFFBFF";
                 }        
  
?>

 <tr bgcolor="<?php echo $color?>">  
 <td width="2%" valign="top"><?php echo $i; ?></td> 
  <td width="20%" valign="top" ><?php echo $question; ?></td>
  <td width="5%" valign="top"><?php echo $diff; ?></td>
  <td width="10%" valign="top"><?php echo $option1; ?></td>
  <td width="10%" valign="top"><?php echo $option2; ?></td>
  
  <td width="5%" valign="top"><?php echo $answer; ?></td>
  <td width="15%" valign="top"><?php echo $explanation; ?></td>
  <td width="2%" valign="top"><a href='index.php?id=edit_question1&qid=<?php echo $id;?>'><img src="img/b_edit.png" border="0" width="16" height="16" ></a></td>
  <td width="3%" valign="top"><a href='?action1=delete&qid=<?php echo $id;?>&category=<?php echo $category_id; ?>&question=<?php echo $type; ?>&user=<?php echo $user; ?>'><img src="img/b_drop.png" border="0" width="16" height="16" ></a></td>
  </tr>

<?php
$i=$i+1;
  }
  
  
    ?>
    </table>
<?php } ?>

