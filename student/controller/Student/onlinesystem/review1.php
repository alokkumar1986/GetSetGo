<?php
if($j=='1'){
$a="Q";
?>
<input type=hidden value='<?php echo $a; ?>' id="Q">
<input type=hidden value='1' id="QA">

<?php
}else if($j=='2'){

$a="R";
?>
<input type=hidden value='<?php echo $a; ?>' id="R">
<input type=hidden value='1' id="RA">

<?php

}else if($j=='3'){
$a="S";
?>
<input type=hidden value='<?php echo $a; ?>' id="S">
<input type=hidden value='1' id="SA">

<?php

}else if($j=='4'){
$a="T";
?>
<input type=hidden value='<?php echo $a; ?>' id="T">
<input type=hidden value='1' id="TA">

<?php

}
for($s=1;$s<=$dur;$s++)
{ ?>
<input type="hidden" name="<?php echo $a; ?><?php echo $s; ?>"  value="0" />
<a href="#<?php echo $a; ?><?php echo $s; ?>" onclick="randq('<?php echo $a; ?><?php echo $s; ?>','<?php echo $s; ?>','<?php echo $a; ?>'); ">
<div class="review" align=right id="<?php echo $a; ?><?php echo $s; ?>" >

<font color="#000"><?php echo $s; ?></font></div></a>
<?php
} $s--; ?>
