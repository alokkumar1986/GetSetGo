<?PHP
require_once("checklogin.php");
if(isset($_POST['submitted']))
{
   if($fgmembersite->Updatenotice())
   {
        $fgmembersite->RedirectToURL("?id=updatednotice");
   }
}
$fgmembersite->DBLogin();
$item=$_GET['id1'];
$rs=mysql_query("select * from notice where id='$item'");
?>
<script language="javascript" type="text/javascript" src="js/niceforms.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="css/niceforms-default.css" />

<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
    </script>

           
  <fieldset>
<legend><font color="#330099" ><strong>Edit Notice</strong></font></legend>      
    <div class="form">
         <form action="" method="post" class="niceform">
         <div><span class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
<input type='hidden' name='submitted' id='submitted' value='1'/>
                <fieldset>
                <table>
                <?php while($row=mysql_fetch_array($rs)){
		?>
		<input type="hidden" name="id" value="<?php echo $item; ?>" />
                    <tr>
                        <td><label for="date">Date:</label></td>
                        <td><input type="date" name="date" id="date" size="54" value="<?php echo $row['date']; ?>" /></td>
                    </tr>
                    <tr>
                        <td><label for="title">Tiltle:</label></td>
                        <td><input type="text" name="title" id="" size="54" value="<?php echo $row['title']; ?>"/></td>
                    </tr>
                    
               
                    
                    <tr>
                        <td valign="top"><label for="news">Content:</label></td>
                       <td><textarea id="area3" name="news" style="width: 450px; height: 100px;"><?php echo $row['content']; ?></textarea> </td>
						
                    </tr><tr><td colspan="2">&nbsp;</td></tr>
                  <tr>
                        <td valign="top"><label for="cc">CC:</label></td>
                       <td><textarea name="cc" style="width:450px; height: 20px;"><?php echo $row['cc']; ?></textarea> </td>
						
                    </tr><tr><td colspan="2">&nbsp;</td></tr>
                    <tr>
                        <td valign="top"><label for="coordinator">Co-ordinator:</label></td>
                       <td><textarea name="co-ordinator" style="width: 450px; height: 20px;"><?php echo $row['cordinator']; ?></textarea> </td>
						
                    </tr>
                    <tr><td colspan="2">&nbsp;</td></tr>
                     <tr><td>&nbsp;</td><td>
                    <input type="submit" name="submit" id="submit" class="btn btn-success"  value="Submit" />
                    </td>
                     </tr>
                     <?php } ?>
                   </table>  
                    
                </fieldset>
                
         </form>
		</div>