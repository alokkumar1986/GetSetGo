<?PHP
require_once("class.phpmailer.php");
require_once("formvalidator.php");

class FGStudent
{
    var $admin_email;
    var $from_address;
    
    var $username;
    var $pwd;
    var $database;
    var $tablename;
    var $connection;
    var $rand_key;
    
    var $error_message;
    
    //-----Initialization -------
    function FGStudent()
    {
        $this->sitename = 'www.example.com';
        $this->rand_key = '0iQx5oBk66oVZep';
    }
    
    function InitDB($host,$uname,$pwd,$database,$tablename)
    {
        $this->db_host  = $host;
        $this->username = $uname;
        $this->pwd  = $pwd;
        $this->database  = $database;
        $this->tablename = $tablename;
        
    }
    function SetAdminEmail($email)
    {
        $this->admin_email = $email;
    }
    
    function SetWebsiteName($sitename)
    {
        $this->sitename = $sitename;
    }
    
    function SetRandomKey($key)
    {
        $this->rand_key = $key;
    }
     //-------Public Helper functions -------------
    function GetSelfScript()
    {
        return htmlentities($_SERVER['PHP_SELF']);
    }    
    
    function SafeDisplay($value_name)
    {
        if(empty($_POST[$value_name]))
        {
            return'';
        }
        return htmlentities($_POST[$value_name]);
    }
    
    function RedirectToURL($url)
    {
        header("Location: $url");
        exit;
    }
    
    function GetSpamTrapInputName()
    {
        return 'sp'.md5('KHGdnbvsgst'.$this->rand_key);
    }
    
    function GetErrorMessage()
    {
        if(empty($this->error_message))
        {
            return '';
        }
        $errormsg = nl2br(htmlentities($this->error_message));
        return $errormsg;
    }    
    //-------Private Helper functions-----------
    
    function HandleError($err)
    {
        $this->error_message .= $err."\r\n";
    }
    
    function HandleDBError($err)
    {
        $this->HandleError($err."\r\n ".mysql_error());
    }
     function DBLogin()
    {

        $this->connection = mysql_connect($this->db_host,$this->username,$this->pwd);

        if(!$this->connection)
        {   
            $this->HandleDBError("Database Login failed! Please make sure that the DB login credentials provided are correct");
            return false;
        }
        if(!mysql_select_db($this->database, $this->connection))
        {
            $this->HandleDBError('Failed to select database: '.$this->database.' Please make sure that the database name provided is correct');
            return false;
        }
        if(!mysql_query("SET NAMES 'UTF8'",$this->connection))
        {
            $this->HandleDBError('Error setting utf8 encoding');
            return false;
        }
        return true;
    }    
    //-------Main Operations ----------------------
    
    
	
	 function AddresultPi(){
    	//return true;
		 if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        }
        
        $var = $_POST['prepfeedback'];
        //$prepfeedback=implode(",",$var);
        $var1 = $_POST['communifeedback'];
        //$communifeedback=implode(",",$var1);
        $var2=$_POST['otherfeedback'];
        
       /* $sql=mysql_query("select * from `student_data` where `REG_NO`='".$_POST['reg_no']."'")or die(mysql_error());
        if($ros=mysql_fetch_array($sql)){
        require '../PHPMailer/PHPMailerAutoload.php';
        

        $clarity=$_POST['clarity']*74;
        $mail = new PHPMailer;
        $mail->isSMTP();                                      
        $mail->Host = 'smtp.gmail.com';                       
        $mail->SMTPAuth = true;                               
        $mail->Username = 'alokkumar.nayak2009@gmail.com';                   
        $mail->Password = 'alok101010100';              
        $mail->SMTPSecure = 'ssl'; 
        $mail->SMTPDebug = 1;                           
        $mail->Port = 465;                                    
        $mail->From = 'induseducationbbsr@gmail.com';
        $mail->FromName = 'Indus Education';
        $mail->addAddress($ros[EMAIL_ID], $ros[NAME]);
        $mail->addAddress('alokkumar.nayak2009@gmail.com', 'Indus Education');
        $mail->addReplyTo('alokkumar.nayak2009@gmail.com', 'Indus Education');
        $mail->WordWrap = 50;
        $mail->isHTML(true);
        $mail->Subject = 'Personal Interview Report';
        $mail->Body = "<table cellspacing='0' cellpadding='0' width='100%'>
        <tr><td>
                <table cellspacing='0' cellpadding='0' width='100%'>
                <tr>
        
        <td colspan='2'>
                        
                <b>Dear ".$ros[NAME]."</b> <br/> Regd No: ".$ros[REG_NO]."<br /> Branch: ".$ros['BRANCH']."
                <p align='justify'>The following result has been generated based on your performance during <b><em>'Employability Assessment Program'</em></b> conducted on <b>".date('dS M Y')."</b>. Please understand the importance of it and take care of the areas where your score is less than 3.5. </p> </td>
      </tr>
            </table>
            <br />
            <h4>Personal Interview Score</h4>
            <table cellspacing='0' cellpadding='0' id='tab' style='background-repeat:repeat-x;background-position:left top;width: 33em;border  :1px solid #e5e5e5;'>
      <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Clarity- </td>
        <td class='value last' style='width:50%;'><img src=\'http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png\' style='vertical-align: middle;margin: 3px 3px 3px 0;' alt='' width=".$clarity." height='16' />".$_POST[clarity]."
                </td>
      </tr>
      <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Articulation- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST['articulation']." height='16' />".$_POST[articulation]."</td>
      </tr>
            <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Usage- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST[usage]." height='16' />".$_POST[usage]."</td>
      </tr>
            <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Confidence- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST['confidence']." height='16' />".$_POST[confidence]."</td>
      </tr>
            <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Body Language- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST[bodylang]." height='16' />".$_POST[bodylang]."</td>
      </tr>
            <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Listening- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST[listening]." height='16' />".$_POST[listening]."</td>
      </tr>
            <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Appearance- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST[appearance]." height='16' />".$_POST[appearance]."</td>
      </tr>
            <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Manners- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST[manners]." height='16' />".$_POST[manners]."</td>
      </tr>
            </table>
            
            <p></p>
            <h5>&nbsp;&nbsp;&nbsp;&nbsp;1-Very Poor    &nbsp;&nbsp;&nbsp;&nbsp; 2-Poor     &nbsp;&nbsp;&nbsp;&nbsp;    3- Average     &nbsp;&nbsp;&nbsp;&nbsp;   4-Good  &nbsp;&nbsp;&nbsp;&nbsp;      5-Very Good </h5>     


        <table cellspacing='0' cellpadding='0' width='100%'>
        <tr><td>
        <h4>FeedBack</h4>
        <ul>
        <li>".$var." </li>
        <li>".$var1." </li>
        <li>".$var2." </li>
        </ul>
        
        
            <p></p>
            <h5>&nbsp;&nbsp;&nbsp;&nbsp;1-Very Poor    &nbsp;&nbsp;&nbsp;&nbsp; 2-Poor     &nbsp;&nbsp;&nbsp;&nbsp;    3- Average     &nbsp;&nbsp;&nbsp;&nbsp;   4-Good  &nbsp;&nbsp;&nbsp;&nbsp;      5-Very Good </h5>     


        
        <p>A good <b><em>overall score</em></b> for any student would be <b><em>4 and above</em></b>.</P 

<p>The overall score is calculated based on giving different weightage to different parameters and then finally calculating the overall score. 
</p>
        <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
        <hr/>
                <span align='center'><i>Disclaimer: This is a computer generated email. Please don't reply back. </i></span>
</td></tr></table>";
//$mail->Body    = $msg;
    if(!$mail->send()) {
    $this->HandleDBError("Message can't be sent..");
    return false;
    }
    }    */
        
       $qry="INSERT INTO `pi` (`REGD_NO`, `INTERVIEWER`, `CLARITY`, `ARTICULATION`, `USAGES`, `CONFIDENCE`, `BODY_LANG`,
        `LISTENING`, `APPEARANCE`, `MANNERS`, `COMM_FEEDBACK`, `PREP_FEEDBACK`, `OTHER_FEEDBACK`, `RATING`, `TIME_START`,
         `TIME_END`, `TIME_TAKEN`, `DATE`) VALUES ( $_POST[reg_no],'".$_POST[interviewer]."', $_POST[clarity], $_POST[articulation],
          $_POST[usage], $_POST[confidence], $_POST[bodylang], $_POST[listening], $_POST[appearance], $_POST[manners],
           '".$_POST['communifeedback']."', '".$_POST['prepfeedback']."', '".$_POST['otherfeedback']."', $_POST[overallrating], 
           '".$_POST[timestarted]."', CURTIME(), TIMEDIFF(CURTIME(),'$_POST[timestarted]'), CURDATE())";

           if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error in Saving the result.. \nquery:$qry");
            return false;
        } 
        $_SESSION['data']="Personal Interview Of Regd No".$_POST[reg_no]." has been saved successfully";
        return true; 
	}
	 function AddresultTechnical(){
    	//return true;
		 if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        }
        
        $var = $_POST['techfeedback'];
        //$prepfeedback=implode(",",$var);
        //$var1 = $_POST['communifeedback'];
        //$communifeedback=implode(",",$var1);
        $var1=$_POST['otherfeedback'];
        
        $sql=mysql_query("select * from `student_data` where `REG_NO`='".$_POST['reg_no']."'")or die(mysql_error());
        if($ros=mysql_fetch_array($sql)){
        require '../PHPMailer/PHPMailerAutoload.php';
        

        $clarity=$_POST['clarity']*74;
        $mail = new PHPMailer;
        $mail->isSMTP();                                      
        $mail->Host = 'smtp.gmail.com';                       
        $mail->SMTPAuth = true;                               
        $mail->Username = 'induseducationbbsr@gmail.com';                   
        $mail->Password = 'indusedu';              
        $mail->SMTPSecure = 'ssl'; 
        $mail->SMTPDebug = 1;                           
        $mail->Port = 465;                                    
        $mail->From = 'induseducationbbsr@gmail.com';
        $mail->FromName = 'Indus Education';
        $mail->addAddress($ros[EMAIL_ID], $ros[NAME]);
        $mail->addAddress('alokkumar.nayak2009@gmail.com', 'Indus Education');
        $mail->addReplyTo('induseducationbbsr@gmail.com', 'Indus Education');
        $mail->WordWrap = 50;
        $mail->isHTML(true);
        $mail->Subject = 'Technical Interview Report';
        $mail->Body = "<table cellspacing='0' cellpadding='0' width='100%'>
        <tr><td>
                <table cellspacing='0' cellpadding='0' width='100%'>
                <tr>
        
        <td colspan='2'>
                        
                <b>Dear ".$ros[NAME]."</b> <br/> Regd No: ".$ros[REG_NO]."<br /> Branch: ".$ros['BRANCH']."
                <p align='justify'>The following result has been generated based on your performance during <b><em>'Employability Assessment Program'</em></b> conducted on <b>".date('dS M Y')."</b>. Please understand the importance of it and take care of the areas where your score is less than 3.5. </p> </td>
      </tr>
            </table>
            <br />
            <h4>Technical Interview Score</h4>
            <table cellspacing='0' cellpadding='0' id='tab' style='background-repeat:repeat-x;background-position:left top;width: 33em;border  :1px solid #e5e5e5;'>
      <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Personal Dispositon- </td>
        <td class='value last' style='width:50%;'><img src=\'http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png\' style='vertical-align: middle;margin: 3px 3px 3px 0;' alt='' width=".$_POST[personaldisposition]." height='16' />".$_POST[personaldisposition]."
                </td>
      </tr>
      <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Career- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST['career']." height='16' />".$_POST[career]."</td>
      </tr>
            <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Communication- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST[communication]." height='16' />".$_POST[communication]."</td>
      </tr>
            <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Knowledge in own area- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST[knowledge]." height='16' />".$_POST[knowledge]."</td>
      </tr>
            <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>IT Awareness- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST[itawareness]." height='16' />".$_POST[itawareness]."</td>
      </tr>
            <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Confidence- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST[confidence]." height='16' />".$_POST[confidence]."</td>
      </tr>
            
            </table>
            
            <p></p>
            <h5>&nbsp;&nbsp;&nbsp;&nbsp;1-Very Poor    &nbsp;&nbsp;&nbsp;&nbsp; 2-Poor     &nbsp;&nbsp;&nbsp;&nbsp;    3- Average     &nbsp;&nbsp;&nbsp;&nbsp;   4-Good  &nbsp;&nbsp;&nbsp;&nbsp;      5-Very Good </h5>     


        <table cellspacing='0' cellpadding='0' width='100%'>
        <tr><td>
        <h4>FeedBack</h4>
        <ul>
        <li>".$var." </li>
        <li>".$var1." </li>
        </ul>
        
        
            <p></p>
            <h5>&nbsp;&nbsp;&nbsp;&nbsp;1-Very Poor    &nbsp;&nbsp;&nbsp;&nbsp; 2-Poor     &nbsp;&nbsp;&nbsp;&nbsp;    3- Average     &nbsp;&nbsp;&nbsp;&nbsp;   4-Good  &nbsp;&nbsp;&nbsp;&nbsp;      5-Very Good </h5>     


        
        <p>A good <b><em>overall score</em></b> for any student would be <b><em>4 and above</em></b>.</P 

<p>The overall score is calculated based on giving different weightage to different parameters and then finally calculating the overall score. 
</p>
        <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
        <hr/>
                <span align='center'><i>Disclaimer: This is a computer generated email. Please don't reply back. </i></span>
</td></tr></table>";
//$mail->Body    = $msg;
    if(!$mail->send()) {
    $this->HandleDBError("Message can't be sent..");
    return false;
    }
    }    
        
       
$qry="INSERT INTO `ti` (`REGD_NO`, `INTERVIEWER`, `PER_DISPOSITION`, `CAREER`, `COMMUNICATION`, `KNOWLEDGE_AREA`, 
`IT_AWARNESS`, `CONFIDENCE`, `TECH_FEEDBACK`, `OTHER_FEEDBACK`, `RATING`, `TIME_START`, `TIME_END`, `TIME_TAKEN`, `DATE`) 
VALUES ( $_POST[reg_no],'".$_POST[interviewer]."', $_POST[personaldisposition], $_POST[career], $_POST[communication], $_POST[knowledge], $_POST[itawareness], $_POST[confidence], '".$_POST['techfeedback']."', '".$_POST['otherfeedback']."', $_POST[overallrating],'".$_POST[timestarted]."', CURTIME(),  TIMEDIFF(CURTIME(),'$_POST[timestarted]'), CURDATE())";
                             
       if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error in Saving the result.. \nquery:$qry");
            return false;
        } 
        $_SESSION['data']="Technical Interview Of Regd No".$_POST[reg_no]." has been saved successfully";
        return true; 
	}
	
	function Addresultcombine(){
	
	if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        }

				$var = $_POST['prepfeedback'];
				$prepfeedback=implode(",",$var);
				$var1 = $_POST['communifeedback'];
				$communifeedback=implode(",",$var1);
				$var2 = $_POST['techfeedback'];
				$techfeedback=implode(",",$var2);
				$sql=mysql_query("select * from `student_data` where `REG_NO`='".$_POST['reg_no']."'")or die(mysql_error());
if($ros=mysql_fetch_array($sql)){
require '../PHPMailer/PHPMailerAutoload.php';
$count=1;
$feedback='<ul>';
$choice=explode(",", $communifeedback);
foreach($choice as $a) {
if($a!='')
$feedback.= "<li> ".$a."</li>";
$count++; } 							
$count=1;
$choice=explode(",", $row1['PREP_FEEDBACK']);
foreach($choice as $a) {
if($a!='')
$feedback."<li> ".$a."</li>"; 
$count++; } 
$feedback.="<li>".$_POST['otherhrfeedback']."</li></ul>";
// '".$techfeedback."', '".$_POST['othertechfeedback'].
$feedback1='<ul>';    
$choice1=explode(",", $techfeedback);
foreach($choice1 as $a) {
if($a!='')
$feedback1.="<li> ".$a."</li>";
$count++; } 
$feedback1.="<li>". $_POST['othertechfeedback']."</li></ul>";

$mail = new PHPMailer;
 
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';                       // Specify main and backup server
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'induseducationbbsr@gmail.com';                   
$mail->Password = 'indusedu';              
$mail->SMTPSecure = 'ssl'; 
$mail->SMTPDebug = 1;                           
$mail->Port = 465;                                    
$mail->From = 'induseducationbbsr@gmail.com';
$mail->FromName = 'Indus Education';
$mail->addAddress($ros[EMAIL_ID], $ros[NAME]);
$mail->addAddress('alokkumar.nayak2009@gmail.com', 'Indus Education');
$mail->addReplyTo('induseducationbbsr@gmail.com', 'Indus Education');
$mail->WordWrap = 50;
$mail->isHTML(true);
$mail->Subject = 'Interview Report';
                   $mail->Body = 
"<table cellspacing='0' cellpadding='0' width='100%'>
<tr><td>
                <table cellspacing='0' cellpadding='0' width='100%'>
                <tr>
        
        <td colspan='2'>
                        
                <b>Dear ".$ros[NAME]."</b> <br/> Regd No: ".$ros[REG_NO]."<br /> Branch: ".$ros['BRANCH']."
                <p align='justify'>The following result has been generated based on your performance during <b><em>'Employability Assessment Program'</em></b> conducted on <b>".date('dS M Y')."</b>. Please understand the importance of it and take care of the areas where your score is less than 3.5. </p> </td>
      </tr>
            </table>
            <br />
            <h4>HR Score</h4>
            <table cellspacing='0' cellpadding='0' id='tab' style='background-repeat:repeat-x;background-position:left top;width: 33em;border  :1px solid #e5e5e5;'>
      <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Clarity- </td>
        <td class='value last' style='width:50%;'><img src=\'http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png\' style='vertical-align: middle;margin: 3px 3px 3px 0;' alt='' width=".$clarity." height='16' />".$_POST[clarity]."
                </td>
      </tr>
      <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Articulation- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST['articulation']." height='16' />".$_POST[articulation]."</td>
      </tr>
            <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Usage- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST[usage]." height='16' />".$_POST[usage]."</td>
      </tr>
            <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Confidence- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST['confidence']." height='16' />".$_POST[confidence]."</td>
      </tr>
            <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Body Language- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST[bodylang]." height='16' />".$_POST[bodylang]."</td>
      </tr>
            <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Listening- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST[listening]." height='16' />".$_POST[listening]."</td>
      </tr>
            <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Appearance- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST[appearance]." height='16' />".$_POST[appearance]."</td>
      </tr>
            <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Manners- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST[manners]." height='16' />".$_POST[manners]."</td>
      </tr>
            </table>
            
            <p></p>
            <h5>&nbsp;&nbsp;&nbsp;&nbsp;1-Very Poor    &nbsp;&nbsp;&nbsp;&nbsp; 2-Poor     &nbsp;&nbsp;&nbsp;&nbsp;    3- Average     &nbsp;&nbsp;&nbsp;&nbsp;   4-Good  &nbsp;&nbsp;&nbsp;&nbsp;      5-Very Good </h5>     


        <table cellspacing='0' cellpadding='0' width='100%'>
        <tr><td>
        <h4>HR FeedBack</h4>
    ".$feedback."
        
        <h4>Tech Score</h4>
            <table cellspacing='0' cellpadding='0' id='tab' style='background-repeat:repeat-x;background-position:left top;width: 33em;border  :1px solid #e5e5e5;'>
      <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>IT Skills- </td>
        <td class='value last' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' style='vertical-align: middle;margin: 3px 3px 3px 0;' alt='' width=".$_POST[itskill]." height='16' />".$_POST[itskill]."
                </td>
      </tr>
      <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Domain Knowledge- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST[domainknow]." height='16' />".$_POST[domainknow]."</td>
      </tr>
            <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Sectorial Knowledge- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST[sectorialknow]." height='16' />".$_POST[sectorialknow]."</td>
      </tr>
            <tr>
        <td class='first' style='width:27%;text-align:right;border-right: 1px solid #e5e5e5;'>Project- </td>
        <td class='value' style='width:50%;'><img src='http://localhost/new/GetSetGo/assessment/controller/admin/bar1.png' vertical-align: middle;margin: 3px 3px 3px 0; alt='' width=".$_POST[project]." height='16' />".$_POST[project]."</td>
      </tr>
            
            </table>
            
            <p></p>
            <p></p>
            <h5>&nbsp;&nbsp;&nbsp;&nbsp;1-Very Poor    &nbsp;&nbsp;&nbsp;&nbsp; 2-Poor     &nbsp;&nbsp;&nbsp;&nbsp;    3- Average     &nbsp;&nbsp;&nbsp;&nbsp;   4-Good  &nbsp;&nbsp;&nbsp;&nbsp;      5-Very Good </h5>     


        <table cellspacing='0' cellpadding='0' width='100%'>
        <tr><td>
        <h4>Tech FeedBack</h4>
    ".$feedback1."
        
        </td></tr>
        </table>
        <p>A good <b><em>overall score</em></b> for any student would be <b><em>4 and above</em></b>.</P 

<p>The overall score is calculated based on giving different weightage to different parameters and then finally calculating the overall score. 
</p>
        <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
        <hr/>
                <span align='center'><i>Disclaimer: This is a computer generated email. Please don't reply back. </i></span>
</td></tr></table>";
//$mail->Body    = $msg;
if(!$mail->send()) {
   echo 'Message could not be sent.';
  // echo 'Mailer Error: ' . $mail->ErrorInfo;
   exit;
}
}

$qry="INSERT INTO `tipi` (`REGD_NO`, `INTERVIEWER`, `CLARITY`, `ARTICULATION`, `USAGES`, `CONFIDENCE`, `BODY_LANG`, `LISTENING`, `APPEARANCE`, `MANNERS`,`COMM_FEEDBACK`, `PREP_FEEDBACK`, `OTHER_HR_FEEDBACK`,`IT_SKILLS`, `SECT_KNOW`, `DOMAIN_KNOW`, `PROJECT`, `TECH_FEEDBACK`, `OTHER_TECH_FEEDBACK`, `TIME_START`, `TIME_END`, `TIME_TAKEN`, `DATE`) VALUES ( $_POST[reg_no],'".$_POST[interviewer]."', $_POST[clarity], $_POST[articulation], $_POST[usage], $_POST[confidence], $_POST[bodylang], $_POST[listening], $_POST[appearance], $_POST[manners], '".$communifeedback."', '".$prepfeedback."', '".$_POST[otherhrfeedback]."', $_POST[itskill], $_POST[sectorialknow], $_POST[domainknow], $_POST[project], '".$techfeedback."', '".$_POST[othertechfeedback]."', '".$_POST[timestarted]."', CURTIME(), TIMEDIFF(CURTIME(),'$_POST[timestarted]'), CURDATE())";
if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error in Saving the result.. \nquery:$qry");
            return false;
        } 
$_SESSION['data']="Combine Interview(TI+PI) Of Regd No".$_POST[reg_no]." has been saved successfully";
 return true;
//header("location: search.php");
}		
	
	
//}
     
}
?>