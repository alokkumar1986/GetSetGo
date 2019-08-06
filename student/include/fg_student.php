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
        
       $qry="INSERT INTO `pi` (`REGD_NO`, `INTERVIEWER`, `CLARITY`, `ARTICULATION`, `USAGES`, `CONFIDENCE`, `BODY_LANG`, `LISTENING`, `APPEARANCE`, `MANNERS`, `COMM_FEEDBACK`, `PREP_FEEDBACK`, `OTHER_FEEDBACK`, `RATING`, `TIME_START`, `TIME_END`, `TIME_TAKEN`, `DATE`) VALUES ( $_POST[reg_no],'".$_POST[interviewer]."', $_POST[clarity], $_POST[articulation], $_POST[usage], $_POST[confidence], $_POST[bodylang], $_POST[listening], $_POST[appearance], $_POST[manners], '".$_POST['communifeedback']."', '".$_POST['prepfeedback']."', '".$_POST['otherfeedback']."', $_POST[overallrating], '".$_POST[timestarted]."', CURTIME(), TIMEDIFF(CURTIME(),'$_POST[timestarted]'), CURDATE())";

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
        
       $qry="INSERT INTO `ti` (`REGD_NO`, `INTERVIEWER`, `PER_DISPOSITION`, `CAREER`, `COMMUNICATION`, `KNOWLEDGE_AREA`, `IT_AWARNESS`, `CONFIDENCE`, `TECH_FEEDBACK`, `OTHER_FEEDBACK`, `RATING`, `TIME_START`, `TIME_END`, `TIME_TAKEN`, `DATE`) VALUES ( $_POST[reg_no],'".$_POST[interviewer]."', $_POST[personaldisposition], $_POST[career], $_POST[communication], $_POST[knowledge], $_POST[itawareness], $_POST[confidence], '".$_POST['techfeedback']."', '".$_POST['otherfeedback']."', $_POST[overallrating],'".$_POST[timestarted]."', CURTIME(),  TIMEDIFF(CURTIME(),'$_POST[timestarted]'), CURDATE())";
                             
           if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error in Saving the result.. \nquery:$qry");
            return false;
        } 
        $_SESSION['data']="Technical Interview Of Regd No".$_POST[reg_no]." has been saved successfully";
        return true; 
	}
     
}
?>