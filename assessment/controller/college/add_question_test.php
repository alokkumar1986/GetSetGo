<?php require_once("../../include/membersite_config.php");

$fgmembersite->DBLogin();


 $test=$_REQUEST['test_id'];
 $cat=$_REQUEST['cat'];
// ----- Difficulty Level -----////
$diff=mysql_query("select count(*) from test_question_multiple_choice 
WHERE ((category =".$cat." ) AND (difficulty_level='difficult'))");
$rsss=mysql_fetch_array($diff);
$diff1=mysql_query("select count(*) from test_question_true_false
WHERE ((category =".$cat." ) AND (difficulty_level='easy'))");
$rsss1=mysql_fetch_array($diff1);
$diff11=mysql_query("select count(*) from test_question_true_false
WHERE ((category =".$cat." ) AND (difficulty_level='modorate'))");
$rsss11=mysql_fetch_array($diff11);

// ----- End Of Difficulty Level ---//

// ----- Easy Level -----////
$easy=mysql_query("select count(*) from test_question_true_false 
WHERE ((category =".$cat." ) AND (difficulty_level='difficult'))");
$rssss=mysql_fetch_array($easy);
$easy1=mysql_query("select count(*) from test_question_true_false
WHERE ((category =".$cat." ) AND (difficulty_level='easy'))");
$rssss1=mysql_fetch_array($easy1);
$easy11=mysql_query("select count(*) from test_question_true_false
WHERE ((category =".$cat." ) AND (difficulty_level='modorate'))");
$rssss11=mysql_fetch_array($easy11);

// ----- End Of Easy Level ---//

// ----- Easy Level -----////
/*$easy=mysql_query("select count(*) from test_question_true_false 
WHERE ((category =".$rs['category_id']." ) AND (difficulty_level='Difficult'))");
$rssss=mysql_fetch_array($diff);
$easy1=mysql_query("select count(*) from test_question_true_false
WHERE ((category =".$rs['category_id']." ) AND (difficulty_level='easy'))");
$rssss1=mysql_fetch_array($diff1);
$easy11=mysql_query("select count(*) from test_question_true_false
WHERE ((category =".$rs['category_id']." ) AND (difficulty_level='modorate'))");
$rssss11=mysql_fetch_array($diff11);*/

// ----- End Of Easy Level ---//

?>
<style>
#cboxContent{
width:500px !important;
}
#cboxLoadedContent{
width:500px !important;

}
</style>
<?php $sql=mysql_query("select * from test_category where category_id =$cat ")or die(mysql_error());
$rs=mysql_fetch_array($sql); ?>
<h3 align="center" style="border-bottom:1px solid #0033CC;">Add Questions From Each Section (Test : <?php echo $test; ?>)
<br /><font color="#FF0000"><?php echo $rs['name']; ?></font></h3>
<div class="row" style="margin-left: 0px !important;width:100%;margin:auto;">
<form action="" method="post" enctype="multipart/form-data">
<?php if($rsss){ ?>
					<div class="col-lg-6">
				 Difficulty	<input type="text" class="form-control" value="" placeholder="No Of Questions">
    				</div>
	<?php } ?>	
	<?php if($rsss1){ ?>
					<div class="col-lg-6">
				 Easy	<input type="text" class="form-control" value="" placeholder="No Of Questions">
    				</div>
	<?php } ?>
	<?php if($rsss1){ ?>
					<div class="col-lg-6">
				 Moderate	<input type="text" class="form-control" value="" placeholder="No Of Questions">
    				</div>
	<?php } ?>	
	
	<?php if($rssss){ ?>
					<div class="col-lg-6">
				 Difficulty	<input type="text" class="form-control" value="" placeholder="No Of Questions">
    				</div>
	<?php } ?>	
	<?php if($rssss1){ ?>
					<div class="col-lg-6">
				 Easy	<input type="text" class="form-control" value="" placeholder="No Of Questions">
    				</div>
	<?php } ?>
	<?php if($rssss1){ ?>
					<div class="col-lg-6">
				Moderate	<input type="text" class="form-control" value="" placeholder="No Of Questions">
    				</div>
	<?php } ?>				
				<p align="center"><input type="submit" class="btn btn-success" name="submit" value="Save" /></p>
				</form>	
	</div>
	

