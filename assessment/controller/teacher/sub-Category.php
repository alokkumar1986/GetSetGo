<?PHP if(isset($_POST['submitted']))
{
 if($fgmembersite->Addcategory())
 {  
  $fgmembersite->HandleDBError("Sub-Category Added Successfully");
 }
}
$arrConditions = array('parentId' => 0);
$testcategory = $fgmembersite->getWhereCustomActionValues("USP_ADMIN_TEST", "TCT", $arrConditions);
if(!empty($testcategory['result'])){
  $data  = $testcategory['result'];
  //echo "<pre>";print_r($data);exit;
}
?>

<title>Add Sub-Category</title>
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<!-- <script type= "text/javascript" src= "../../js/college.js"></script>
<script type="text/javascript" src="../../js/bootstrap-datepicker.js"></script> -->
<style type="text/css">
.input-group{
width:97px;
}
</style>
          <!--   <link rel="stylesheet" href="../../css/datepicker.css"> -->
            <!--<div id='fg_membersite'>--><div>
            <form id='changepwd' action='' method='post' enctype="multipart/form-data">

              <fieldset style="float:center;" >
                <legend><font color="#330099" ><strong>Add Sub-Category</strong></font></legend>

                <div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
                <input type='hidden' name='submitted' id='submitted' value='1' />
                <div class="row">
                  <div class="col-md-12">
                    <p><select name="category[]" class="validate[required] text-input form-control p" style="color: grey;width:98% !important;" onchange="subCategory(this.value, '1');">
                      <option value="" selected="selected">-Select Parent Category-</option>
                      <?php $i=0; $j=0; $rootcat='';$subcat='';$subsubcat='';
                       foreach ($data as $cat) { ?>                        
                       <option value="<?php echo $cat['category_id']; ?>"><?php echo $cat['name']; ?></option> 
                     <?php } ?>
                   </optgroup>
                 </select>
               </p>
               <p><select name="category[]" class="validate[required] text-input form-control 1" style="color: grey;width:98% !important;display:none;" onchange="subCategory(this.value, '2');"></select></p>
               <p><select name="category[]" class="validate[required] text-input form-control 2" style="color: grey;width:98% !important;display:none;" onchange="subCategory(this.value, '3');"></select></p>
               <p><select name="category[]" class="validate[required] text-input form-control 3" style="color: grey;width:98% !important;display:none;" onchange="subCategory(this.value, '4');"></select></p>
               <p><select name="category[]" class="validate[required] text-input form-control 4" style="color: grey;width:98% !important;display:none;"></select></p>
               <input type="text" name="name" class="form-control sname" placeholder="Sub-Category Name" style="color: grey;width:98% !important;"/>
               <br/>
               <input type='button' class="btn btn-success" id="button1" name='Submit' value='Submit' onclick="return formValidate();"/> &nbsp;&nbsp;&nbsp;<!--<a href="?id=upload category" class="btn btn-danger" style="float: right;margin-left:10px;margin-right:10px;">Upload Subject/Category CSV</a>-->&nbsp;&nbsp;&nbsp;<a href="?id=view sub-Category" class="btn btn-info" style="float: right;">View Sub-Category </a>
             </div>
           </div>
         </fieldset>
       </form>
</div>

<script> 
$(document).ready(function(){
  $('.btnConfirmOk').on('click', function(){
    $('#changepwd').submit();
  });
});

function formValidate(){
  if($(".p option:selected").val()==''){
     $("#myModal").modal();
     $('.modal-body .msg').html('Parent Category can not be blank!');
     $(".p").focus();
     return false;
  }

  if($(".sname").val()==''){
    $("#myModal").modal();
     $('.modal-body .msg').html('Sub-Category Name can not be blank!');
     $(".sname").focus();
     return false;
  }

  $("#confirmModal").modal();
  return true;  
}
 //var i = 0;
 function subCategory(parentId, ctrlId){
  //i+=1;

  $.ajax({
    type   : 'post',
    url    : 'ajaxCall.php',
    data   : {method: 'getSubcategory',parentId : parentId, },
    success: function(result){
    //console.log(result);
    if(result!=''){
      $("."+ctrlId).show();
      $("."+ctrlId).html(result);
      var ctrlNum = parseInt(ctrlId);
      //console.log(ctrlNum);
      for(var i=1; i<5; i++){
        if(i>ctrlNum){
          $("."+i).html('');
          $("."+i).hide();
          //console.log(i);
        }
      }
    }
  }
  });
 }
 </script>