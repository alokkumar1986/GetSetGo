<?PHP if(isset($_POST['submitted']))
{
 if($fgmembersite->Addcategory())
 {  
  $fgmembersite->HandleDBError("Sub-Category Added Successfully");
 }
}
$arrConditions = array();
$testcategory = $fgmembersite->getWhereCustomActionValues("USP_ADMIN_TEST", "TCT", $arrConditions);
if(!empty($testcategory['result'])){
  $data  = $testcategory['result'];
 //echo "<pre>";print_r($data);exit;
}
?>

<title>Add Sub-Category</title>

<script type= "text/javascript" src = "../../js/college.js"></script>
<script type="text/javascript" src="../../js/bootstrap-datepicker.js"></script>

<script type="text/javascript">
            // When the document is ready
            $(document).ready(function () {
              
              $('#date2').datepicker({
                format: "yyyy/mm/dd"
              });  
              
            });
            </script>
            <style type="text/css">
            select {
              
              width:207px;
            }
            .input-group{
              width:97px;
            }
            </style>
            <link rel="stylesheet" href="../../css/datepicker.css">
            <!--<div id='fg_membersite'>--><div>
            <form id='changepwd' action='' method='post' enctype="multipart/form-data">

              <fieldset style="float:center;" >
                <legend><font color="#330099" ><strong>Add Sub-Category</strong></font></legend>

                <div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
                <input type='hidden' name='submitted' id='submitted' value='1' />
                <div class="row">
                  <div class="col-md-12">
                    <p><select name="category" class="validate[required] text-input form-control" style="color: grey;width:98% !important;">
                      <option value="" selected="selected">-Select Parent Category-</option>
                      <?php $i=0; $j=0; $rootcat='';$subcat='';$subsubcat='';
                       foreach ($data as $cat) { 
                         
                         if((($rootcat == '') || ( $rootcat == $cat['name1'])) && $i==0){ 
                          $rootcat    =  $cat['name1'];
                          $subcat     =  $cat['name2'];
                          $subsubcat  =  $cat['name3'];
                          $i++; ?>
                          <option value="<?php echo $cat['cat_id1']; ?>"><?php echo $rootcat; ?></option>
                        <?php }else{
                          $i++;
                        }
                         //exit;
                        ?>
                       <option value=""></option>
                     <?php } ?>
                   </optgroup>
                 </select>
               </p>
               <input type="text" name="name" placeholder="Sub-Category Name" />
               <br/>
               <input type='submit' class="btn btn-success" id="button1" name='Submit' value='Submit' /> &nbsp;&nbsp;&nbsp;<!--<a href="?id=upload category" class="btn btn-danger" style="float: right;margin-left:10px;margin-right:10px;">Upload Subject/Category CSV</a>-->&nbsp;&nbsp;&nbsp;<a href="?id=view sub-Category" class="btn btn-info" style="float: right;">View Sub-Category </a>
             </div>
           </div>
         </fieldset>
       </form>
</div>
<!--
Form Code End (see html-form-guide.com for more info.)
-->
<script type='text/javascript' src="../../../../javascript/bootstrap.min.js"></script>
<script> 
$(document).ready(function(){
 $('#button1').button();
 $('#button1').click(function() {
 $(this).button('loading');
});
 </script>