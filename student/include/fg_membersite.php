<?PHP error_reporting(0);
require_once("class.phpmailer.php");
require_once("formvalidator.php");

class FGMembersite
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
    function FGMembersite()
    {
        $this->sitename = 'www.induseducation.in';
        $this->rand_key = '0909qSRcVS6DrTzrPvr';
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
    
    //-------Main Operations ----------------------
    function RegisterUser()
    {
        if(!isset($_POST['submitted']))
        {
           return false;
        }
        
        $formvars = array();
        
        if(!$this->ValidateRegistrationSubmission())
        {
            return false;
        }
        
        $this->CollectRegistrationSubmission($formvars);
        
        if(!$this->SaveToDatabase($formvars))
        {
            return false;
        }
        
        /*if(!$this->SendUserConfirmationEmail($formvars))
        {
            return false;
        }

        $this->SendAdminIntimationEmail($formvars);
        */
        return true;
    }

    function ConfirmUser()
    {
        if(empty($_GET['code'])||strlen($_GET['code'])<=10)
        {
            $this->HandleError("Please provide the confirm code");
            return false;
        }
        $user_rec = array();
        if(!$this->UpdateDBRecForConfirmation($user_rec))
        {
            return false;
        }
        
        $this->SendUserWelcomeEmail($user_rec);
        
        $this->SendAdminIntimationOnRegComplete($user_rec);
        
        return true;
    }    
    
    function Login()
    {   

        if(empty($_POST['username']))
        {

            $this->HandleError("User Name is empty!");
            return false;
        }
       
        if(empty($_POST['password']))
        {
            $this->HandleError("Password is empty!");
            return false;
        }
        
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        
        if(!isset($_SESSION)){ session_start(); }

        if(!$this->CheckLoginInDB($username,$password))
        {
            return false;
        }
        
        $_SESSION[$this->GetLoginSessionVar()] = $username;
        
        return true;
    }
    
    function CheckLogin()
    {
         if(!isset($_SESSION)){ session_start(); }

         $sessionvar = $this->GetLoginSessionVar();
         
         if(empty($_SESSION[$sessionvar]))
         {
           if(isset($_COOKIE["name_of_user2"]) && isset($_COOKIE["regno_of_user"]) && isset($_COOKIE["email_of_user"]) && isset($_COOKIE["college"]) && isset($_COOKIE["branch"]) && isset($_COOKIE["role"])){
             $_SESSION['name_of_user2']  = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['name_of_user2']); 
             $_SESSION['regno_of_user']  = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['regno_of_user']);;
             $_SESSION['email_of_user'] = preg_replace('#[^a-z0-9.]#i', '', $_COOKIE['email_of_user']);;
             $_SESSION['college'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['college']);;
             $_SESSION['branch'] = preg_replace('#[^a-z0-9]#i', '', $_COOKIE['branch']);;
             $_SESSION['role'] = 'Student';
         }else{
            return false;
            }
         }
         return true;
    }
    
    function UserFullName()
    {
        return isset($_SESSION['name_of_user'])?$_SESSION['name_of_user']:'';
    }
    
    function UserEmail()
    {
        return isset($_SESSION['email_of_user'])?$_SESSION['email_of_user']:'';
    }
    
    function LogOut()
    {
        session_start();
        
        $sessionvar = $this->GetLoginSessionVar();
        
        $_SESSION[$sessionvar]=NULL;
        
        unset($_SESSION[$sessionvar]);
    }
    
    function EmailResetPasswordLink()
    {
        if(empty($_POST['email']))
        {
            $this->HandleError("Email is empty!");
            return false;
        }
        $user_rec = array();
        if(false === $this->GetUserFromEmail($_POST['email'], $user_rec))
        {
            return false;
        }
        if(false === $this->SendResetPasswordLink($user_rec))
        {
            return false;
        }
        return true;
    }
    
    function ResetPassword()
    {
        if(empty($_GET['email']))
        {
            $this->HandleError("Email is empty!");
            return false;
        }
        if(empty($_GET['code']))
        {
            $this->HandleError("reset code is empty!");
            return false;
        }
        $email = trim($_GET['email']);
        $code = trim($_GET['code']);
        
        if($this->GetResetPasswordCode($email) != $code)
        {
            $this->HandleError("Bad reset code!");
            return false;
        }
        
        $user_rec = array();
        if(!$this->GetUserFromEmail($email,$user_rec))
        {
            return false;
        }
        
        $new_password = $this->ResetUserPasswordInDB($user_rec);
        if(false === $new_password || empty($new_password))
        {
            $this->HandleError("Error updating new password");
            return false;
        }
        
        if(false == $this->SendNewPassword($user_rec,$new_password))
        {
            $this->HandleError("Error sending new password");
            return false;
        }
        return true;
    }
    
    function ChangePassword()
    {
        if(!$this->CheckLogin())
        {
            $this->HandleError("Not logged in!");
            return false;
        }
        
        if(empty($_POST['oldpwd']))
        {
            $this->HandleError("Old password is empty!");
            return false;
        }
        if(empty($_POST['newpwd']))
        {
            $this->HandleError("New password is empty!");
            return false;
        }
        
        if(empty($_POST['renewpwd']))
        {
            $this->HandleError("Retype password is empty!");
            return false;
        }
        if($_POST['renewpwd']!=$_POST['newpwd']){
		$this->HandleError("Password doesn't match! Try again.");
            return false;	
		}
        
        $user_rec = array();
        if(!$this->GetUserFromEmail($this->UserEmail(),$user_rec))
        {
            return false;
        }
        
        $pwd = trim($_POST['oldpwd']);
        
        if($user_rec['PASSWORD'] != md5($pwd))
        {
            $this->HandleError("The old password does not match!");
            return false;
        }
        $newpwd = trim($_POST['newpwd']);
        
        if(!$this->ChangePasswordInDB($user_rec, $newpwd))
        {
            return false;
        }
        return true;
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
    {   ob_start();
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
        $this->HandleError($err."\r\n ".mysqli_error());
    }
    
    function GetFromAddress()
    {
        if(!empty($this->from_address))
        {
            return $this->from_address;
        }

        $host = $_SERVER['SERVER_NAME'];

        $from ="nobody@$host";
        return $from;
    } 
    
    function GetLoginSessionVar()
    {
        $retvar = md5($this->rand_key);
        $retvar = 'usr_'.substr($retvar,0,10);
        return $retvar;
    }
    
	
	
    function CheckLoginInDB($username,$password)
    {

        if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        }    
        
        $username = $this->SanitizeForSQL($username);
        $pwdmd5 = md5($password);
        $qry = "Select * from $this->tablename where (USERNAME='$username' and PASSWORD='$pwdmd5' and C_Code='y')";
        
        $result = mysqli_query($this->connection, $qry);
       
        if(!$result || mysqli_num_rows($result) <= 0)
        {
            $this->HandleError("Error logging in. The username or password does not match");
            return false;
        }
        
        $row = mysqli_fetch_assoc($result);
        if ($_POST['remember'] == "yes"){
		setcookie("username", $username, time()+7600); 
		}
	setcookie('PHPSESSID', session_id(), time()+24*60*60);
                setcookie("name_of_user2", $row['NAME'], time()+ 24*60*60);
                setcookie("regno_of_user", $row['REG_NO'], time()+ 24*60*60);
                setcookie("email_of_user", $row['EMAIL_ID'], time()+ 24*60*60);
                setcookie("college", $row['COLLEGE'], time()+ 24*60*60);
                setcookie("branch", $row['BRANCH'], time()+ 24*60*60);
                setcookie("role", "Student", time()+ 24*60*60);
    		    $_SESSION['name_of_user2']  = $row['NAME'];
				$_SESSION['regno_of_user']  = $row['REG_NO'];
    		    $_SESSION['email_of_user'] = $row['EMAIL_ID'];
				$_SESSION['college'] = $row['COLLEGE'];
				$_SESSION['branch'] = $row['BRANCH'];
				$_SESSION['role'] = 'Student';
        //$_SESSION['actingrole'] = $row['actingrole'];
		$qry = "Select * from `activitylog` where REG_NO='".$_SESSION['regno_of_user']."'";
        
        $result = mysqli_query($this->connection,$qry);
        
        if(!$result || mysqli_num_rows($result) <= 0)
        {
		$qry1 = "INSERT INTO `activitylog` (`activity`, `in`, `out`, `reg_no`) VALUES ('on', now(), '', '".$_SESSION['regno_of_user']."')";
        
        $result1 = mysqli_query($this->connection, $qry1);
		}else{
		$qry1 = "Update `activitylog` set `activity`='on', `in`=now(), `out`='' where (`reg_no`='".$_SESSION['regno_of_user']."')";
        
        $result1 = mysqli_query($this->connection, $qry1);
		
		}
        return true;
    }
    
    function UpdateDBRecForConfirmation(&$user_rec)
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        }   
        $confirmcode = $this->SanitizeForSQL($_GET['code']);
        
        $result = mysql_query("Select NAME, EMAIL_ID from $this->tablename where C_Code='$confirmcode'",$this->connection);   
        if(!$result || mysql_num_rows($result) <= 0)
        {
            $this->HandleError("Wrong confirm code.");
            return false;
        }
        $row = mysql_fetch_assoc($result);
        $user_rec['NAME'] = $row['NAME'];
        $user_rec['EMAIL']= $row['EMAIL_ID'];
        
        $qry = "Update $this->tablename Set C_Code='y' Where  C_Code='$confirmcode'";
        
        if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error inserting data to the table\nquery:$qry");
            return false;
        }      
        return true;
    }
    
    function ResetUserPasswordInDB($user_rec)
    {
        $new_password = substr(md5(uniqid()),0,10);
        
        if(false == $this->ChangePasswordInDB($user_rec,$new_password))
        {
            return false;
        }
        return $new_password;
    }
    
    function ChangePasswordInDB($user_rec, $newpwd)
    {
        $newpwd = $this->SanitizeForSQL($newpwd);
        
        $qry = "Update $this->tablename Set PASSWORD='".md5($newpwd)."' Where  `REG_NO`='".$user_rec[REG_NO]."'";
        
        if(!mysqli_query($this->connection, $qry))
        {
            $this->HandleDBError("Error updating the password \nquery:$qry");
            return false;
        }     
        return true;
    }
    
    function GetUserFromEmail($email,&$user_rec)
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        }   
        $email = $this->SanitizeForSQL($email);
        
        $result = mysqli_query($this->connection, "Select * from $this->tablename where EMAIL_ID='$email'");  

        if(!$result || mysqli_num_rows($result) <= 0)
        {
            $this->HandleError("There is no user with email: $email");
            return false;
        }
        $user_rec = mysqli_fetch_assoc($result);

        
        return true;
    }
    
    function SendUserWelcomeEmail(&$user_rec)
    {
        $mailer = new PHPMailer();
        
        $mailer->CharSet = 'utf-8';
        
        $mailer->AddAddress($user_rec['EMAIL'],$user_rec['NAME']);
        
        $mailer->Subject = "Welcome to ".$this->sitename;

        $mailer->From = $this->GetFromAddress();        
        
        $mailer->Body ="Hello ".$user_rec['NAME']."\r\n\r\n".
        "Welcome! Your registration  with ".$this->sitename." is completed.\r\n".
        "\r\n".
        "Regards,\r\n".
        "Adminstrator\r\n".
        $this->sitename;

        if(!$mailer->Send())
        {
            $this->HandleError("Failed sending user welcome email.");
            return false;
        }
        return true;
    }
    
    function SendAdminIntimationOnRegComplete(&$user_rec)
    {
        if(empty($this->admin_email))
        {
            return false;
        }
        $mailer = new PHPMailer();
        
        $mailer->CharSet = 'utf-8';
        
        $mailer->AddAddress($this->admin_email);
        
        $mailer->Subject = "Registration Completed: ".$user_rec['NAME'];

        $mailer->From = $this->GetFromAddress();         
        
        $mailer->Body ="A new user registered at ".$this->sitename."\r\n".
        "Name: ".$user_rec['NAME']."\r\n".
        "Email address: ".$user_rec['EMAIL']."\r\n";
        
        if(!$mailer->Send())
        {
            return false;
        }
        return true;
    }
    
    function GetResetPasswordCode($email)
    {
       return substr(md5($email.$this->sitename.$this->rand_key),0,10);
    }
    
    function SendResetPasswordLink($user_rec)
    {
        $email = $user_rec['EMAIL'];
        
        $mailer = new PHPMailer();
        
        $mailer->CharSet = 'utf-8';
        
        $mailer->AddAddress($email,$user_rec['NAME']);
        
        $mailer->Subject = "Your reset password request at ".$this->sitename;

        $mailer->From = $this->GetFromAddress();
        
        $link = $this->GetAbsoluteURLFolder().
                '/resetpwd.php?email='.
                urlencode($email).'&code='.
                urlencode($this->GetResetPasswordCode($email));

        $mailer->Body ="Hello ".$user_rec['NAME']."\r\n\r\n".
        "There was a request to reset your password at ".$this->sitename."\r\n".
        "Please click the link below to complete the request: \r\n".$link."\r\n".
        "Regards,\r\n".
        "Webmaster\r\n".
        $this->sitename;
        
        if(!$mailer->Send())
        {
            return false;
        }
        return true;
    }
    
    function SendNewPassword($user_rec, $new_password)
    {
        $email = $user_rec['EMAIL'];
        
        $mailer = new PHPMailer();
        
        $mailer->CharSet = 'utf-8';
        
        $mailer->AddAddress($email,$user_rec['NAME']);
        
        $mailer->Subject = "Your new password for ".$this->sitename;

        $mailer->From = $this->GetFromAddress();
        
        $mailer->Body ="Hello ".$user_rec['NAME']."\r\n\r\n".
        "Your password is reset successfully. ".
        "Here is your updated login:\r\n".
        "username:".$user_rec['User_Name']."\r\n".
        "password:$new_password\r\n".
        "\r\n".
        "Login here: ".$this->GetAbsoluteURLFolder()."/login.php\r\n".
        "\r\n".
        "Regards,\r\n".
        "Webmaster\r\n".
        $this->sitename;
        
        if(!$mailer->Send())
        {
            return false;
        }
        return true;
    }    
    
    function ValidateRegistrationSubmission()
    {
        //This is a hidden input field. Humans won't fill this field.
        if(!empty($_POST[$this->GetSpamTrapInputName()]) )
        {
            //The proper error is not given intentionally
            $this->HandleError("Automated submission prevention: case 2 failed");
            return false;
        }
        
        $validator = new FormValidator();
        $validator->addValidation("username","req","Please fill in Username");
        $validator->addValidation("password","password","Please fill in Password");
        $validator->addValidation("fname","req","Please fill in First Name");
        $validator->addValidation("lname","req","Please fill in Last Name");
        $validator->addValidation("email","req","Please fill in Email");
        $validator->addValidation("mobile","req","Please fill in Mobile Number");
        $validator->addValidation("dob","password","Please fill in Date Of Birth");
        $validator->addValidation("gender","req","Please fill in Gender");
        $validator->addValidation("state","req","Please fill in State");
        $validator->addValidation("university","req","Please fill in University");
        $validator->addValidation("college","req","Please fill in College");
        $validator->addValidation("course","req","Please fill in Course");
        $validator->addValidation("branch","req","Please fill in Branch");
        $validator->addValidation("reg","req","Please fill in Reg_No");
        $validator->addValidation("yop","req","Please fill in Year Of Pass Out");

        
        if(!$validator->ValidateForm())
        {
            $error='';
            $error_hash = $validator->GetErrors();
            foreach($error_hash as $inpname => $inp_err)
            {
                $error .= $inpname.':'.$inp_err."\n";
            }
            $this->HandleError($error);
            return false;
        }        
    
        return true;
    }
    function CollectRegistrationSubmission(&$formvars)
    {
        $formvars['username'] = $this->Sanitize($_POST['username']);
        $formvars['password'] = $this->Sanitize($_POST['password']);
        $formvars['fname'] = $this->Sanitize($_POST['fname']);
        $formvars['lname'] = $this->Sanitize($_POST['lname']);
        $formvars['email'] = $this->Sanitize($_POST['email']);
        $formvars['mobile'] = $this->Sanitize($_POST['mobile']);
        $formvars['dob'] = $this->Sanitize($_POST['dob']);
        $formvars['gender'] = $this->Sanitize($_POST['gender']);
        $formvars['state'] = $this->Sanitize($_POST['state']);
        $formvars['university'] = $this->Sanitize($_POST['university']);
		if($formvars['university'] == ""){
		$formvars['university'] = $this->Sanitize($_POST['university1']);
		}
        $formvars['college'] = $this->Sanitize($_POST['college']);
		if($formvars['college'] == ""){
		$formvars['college'] = $this->Sanitize($_POST['college1']);
		}
        $formvars['course'] = $this->Sanitize($_POST['course']);
		if($formvars['course'] == ""){
		$formvars['course'] = $this->Sanitize($_POST['course1']);
		}
        $formvars['branch'] = $this->Sanitize($_POST['branch']);
		if($formvars['branch'] == ""){
		$formvars['branch'] = $this->Sanitize($_POST['branch1']);
		}
        $formvars['reg'] = $this->Sanitize($_POST['reg']);
        $formvars['yop'] = $this->Sanitize($_POST['yop']);
        
    }
    
    function SendUserConfirmationEmail(&$formvars)
    {
        $mailer = new PHPMailer();
        
        $mailer->CharSet = 'utf-8';
        
        $mailer->AddAddress($formvars['email'],$formvars['fname']);
        
        $mailer->Subject = "Your registration with ".$this->sitename;

        $mailer->From = $this->GetFromAddress();        
        
        $confirmcode = $formvars['confirmcode'];
        
        $confirm_url = $this->GetAbsoluteURLFolder().'/confirmreg.php?code='.$confirmcode;
        
        $mailer->Body ="Hello ".$formvars['fname']."\r\n\r\n".
        "Thanks for your registration with ".$this->sitename."\r\n".
        "Please click the link below to confirm your registration.\r\n".
        "$confirm_url\r\n".
        "\r\n".
        "Regards,\r\n".
        "Adminstrator\r\n".
        $this->sitename;

        if(!$mailer->Send())
        {
            $this->HandleError("Failed sending registration confirmation email.");
            return false;
        }
        return true;
    }
    function GetAbsoluteURLFolder()
    {
        $scriptFolder = (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) ? 'https://' : 'http://';
        $scriptFolder .= $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
        return $scriptFolder;
    }
    
    function SendAdminIntimationEmail(&$formvars)
    {
        if(empty($this->admin_email))
        {
            return false;
        }
        $mailer = new PHPMailer();
        
        $mailer->CharSet = 'utf-8';
        
        $mailer->AddAddress($this->admin_email);
        
        $mailer->Subject = "New registration: ".$formvars['fname'];

        $mailer->From = $this->GetFromAddress();         
        
        $mailer->Body ="A new user registered at ".$this->sitename."\r\n".
        "Name: ".$formvars['fname']."\r\n".
        "Email address: ".$formvars['email']."\r\n".
        "UserName: ".$formvars['username'];
        
        if(!$mailer->Send())
        {
            return false;
        }
        return true;
    }
    
    function SaveToDatabase(&$formvars)
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        }
        if(!$this->Ensuretable())
        {
            return false;
        }
        if(!$this->IsFieldUnique($formvars,'email'))
        {
            $this->HandleError("This email is already registered");
            return false;
        }
        
        if(!$this->IsFieldUnique($formvars,'username'))
        {
            $this->HandleError("This UserName is already used. Please try another username");
            return false;
        }        
        if(!$this->InsertIntoDB($formvars))
        {
            $this->HandleError("Inserting to Database failed!");
            return false;
        }
        return true;
    }
    
    function IsFieldUnique($formvars,$fieldname)
    {
        $field_val = $this->SanitizeForSQL($formvars[$fieldname]);
        $qry = "select username from $this->tablename where $fieldname='".$field_val."'";
        $result = mysql_query($qry,$this->connection);   
        if($result && mysql_num_rows($result) > 0)
        {
            return false;
        }
        return true;
    }
    
    function DBLogin()
    {
        
        //$con=mysqli_connect($this->db_host,$this->username,$this->pwd);
        $this->connection = mysqli_connect($this->db_host,$this->username,$this->pwd) or die(mysqli_connect_errno());
        
        if(!$this->connection)
        {    
            $this->HandleDBError("Database Login failed! Please make sure that the DB login credentials provided are correct");
            return false;
        }

        if(!mysqli_select_db($this->connection, $this->database))
        {
            $this->HandleDBError('Failed to select database: '.$this->database.' Please make sure that the database name provided is correct');
            return false;
        }
        if(!mysqli_query($this->connection, "SET NAMES 'UTF8'"))
        {
            $this->HandleDBError('Error setting utf8 encoding');
            return false;
        }
        return true;
    }    
    
    function Ensuretable()
    {
        $result = mysql_query("SHOW COLUMNS FROM $this->tablename");   
        if(!$result || mysql_num_rows($result) <= 0)
        {
            return $this->CreateTable();
        }
        return true;
    }
    
    /*function CreateTable()
    {
        $qry = "Create Table $this->tablename (".
                "id_user INT NOT NULL AUTO_INCREMENT ,".
                "name VARCHAR( 128 ) NOT NULL ,".
                "email VARCHAR( 64 ) NOT NULL ,".
                "phone_number VARCHAR( 16 ) NOT NULL ,".
                "username VARCHAR( 16 ) NOT NULL ,".
                "password VARCHAR( 32 ) NOT NULL ,".
                "confirmcode VARCHAR(32) ,".
                "PRIMARY KEY ( id_user )".
                ")";
                
        if(!mysql_query($qry,$this->connection))
        {
            $this->HandleDBError("Error creating the table \nquery was\n $qry");
            return false;
        }
        return true;
    }*/
    
    function InsertIntoDB(&$formvars)
    {
    
        $confirmcode = $this->MakeConfirmationMd5($formvars['email']);
        
        $formvars['confirmcode'] = $confirmcode;
		$coll=explode('-',$formvars['college']);
		$formvars['college1']=$coll[0];
		$formvars['college2']=$coll[1];
        $formvars['name']= $formvars['fname']." ".$formvars['lname'];
        $insert_query = 'insert into '.$this->tablename.' 				
                (
                `REG_NO`,
                `USERNAME`, 
                `PASSWORD`, 
                `NAME`, 
                `GENDER`, 
                `DOB`, 
                `MOBILE_NO`, 
                `EMAIL_ID`, 
                `STATE`, 
                `UNIVERSITY`, 
                `COLLEGE`,
				`COLLEGE_FULLNAME`, 
                `COURSE`, 
                `BRANCH`, 
                `COURSE_YOP`,
                `C_Code`
                )
                values
                (
                "' . $this->SanitizeForSQL($formvars['reg']) . '",
                "' . $this->SanitizeForSQL($formvars['username']) . '",
                "' . md5($formvars['password']) . '",
                "' . $this->SanitizeForSQL($formvars['name']) . '",
                "' . $this->SanitizeForSQL($formvars['gender']) . '",
                "' . $this->SanitizeForSQL($formvars['dob']) . '",
                "' . $this->SanitizeForSQL($formvars['mobile']) . '",
                "' . $this->SanitizeForSQL($formvars['email']) . '",
                "' . $this->SanitizeForSQL($formvars['state']) . '",
                "' . $this->SanitizeForSQL($formvars['university']) . '",
                "' . $this->SanitizeForSQL($formvars['college2']) . '",
				"' . $this->SanitizeForSQL($formvars['college1']) . '",
                "' . $this->SanitizeForSQL($formvars['course']) . '",
                "' . $this->SanitizeForSQL($formvars['branch']) . '",
                "' . $this->SanitizeForSQL($formvars['yop']) . '",
                "' . $confirmcode . '"
                )';      
        if(!mysql_query( $insert_query ,$this->connection))
        {
            $this->HandleDBError("Error inserting data to the table\nquery:$insert_query");
            return false;
        }        
        return true;
    }
    function MakeConfirmationMd5($email)
    {
        $randno1 = rand();
        $randno2 = rand();
        return md5($email.$this->rand_key.$randno1.''.$randno2);
    }
    function SanitizeForSQL($str)
    {
        if( function_exists( "mysql_real_escape_string" ) )
        {
              $ret_str = mysql_real_escape_string( $str );
        }
        else
        {
              $ret_str = addslashes( $str );
        }
        return $ret_str;
    }
    
 /*
    Sanitize() function removes any potential threat from the
    data submitted. Prevents email injections or any other hacker attempts.
    if $remove_nl is true, newline chracters are removed from the input.
    */
    function Sanitize($str,$remove_nl=true)
    {
        $str = $this->StripSlashes($str);

        if($remove_nl)
        {
            $injections = array('/(\n+)/i',
                '/(\r+)/i',
                '/(\t+)/i',
                '/(%0A+)/i',
                '/(%0D+)/i',
                '/(%08+)/i',
                '/(%09+)/i'
                );
            $str = preg_replace($injections,'',$str);
        }

        return $str;
    }    
    function StripSlashes($str)
    {
        if(get_magic_quotes_gpc())
        {
            $str = stripslashes($str);
        }
        return $str;
    }   
	 /* ------------------------------------------------------------------------------------
		---------------------------Compose1 Message-------------------------------- */	
		
		function compose1(){
		if(!$this->CheckLogin())
        {
            $this->HandleError("Not logged in!");
            return false;
        }
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        } 
		$formvars['college'] = $this->Sanitize($_POST['college']);
		$formvars['from'] = $this->Sanitize($_POST['from']);
		$formvars['to'] = $this->Sanitize($_POST['to']);
        $formvars['course'] = $this->Sanitize($_POST['course']);
        $formvars['branch'] = $this->Sanitize($_POST['branch']);
        $formvars['message'] = $this->Sanitize($_POST['message']);
        $formvars['yop'] = $this->Sanitize($_POST['yop']);
		if(empty($formvars['college'])){
		 $this->HandleError("College is Empty!");
            return false;
		}
		if(empty($formvars['course'])){
		 $this->HandleError("Course is Empty!");
            return false;
		}
		if(empty($formvars['branch'])){
		 $this->HandleError("Branch is Empty!");
            return false;
		}
		if(empty($formvars['yop'])){
		 $this->HandleError("Year Of Passing Out is Empty!");
            return false;
		}
		if(empty($formvars['message'])){
		 $this->HandleError("Message is Empty!");
            return false;
		}
		
		$qry="INSERT INTO `message` (`id`, `message`, `sentfrom`, `to`, `college`, `course`, `branch`, `date`) VALUES (NULL, '".$formvars['message']."', '".$formvars['from'] ."', '".$formvars['to']."', '".$formvars['college']."', '".$formvars['course']."', '".$formvars['branch']."', CURDATE());";
      if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error in Inserting Data.. \nquery:$qry");
            return false;
        } 
		return true;
		}
		
		
		/* ------------------------------------------------------------------------------------
		---------------------------End Of Compose Message-------------------------------- */	
    
// function connection(){
// $servername = "localhost";
// $username = "root";
// $password = "";
// // mysqli_close();
// try {
//     $conn = new PDO("mysql:host=$servername;dbname=indusedu_webcms", $username, $password);
//     // set the PDO error mode to exception
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
//     //echo "Connected successfully"; 
//     }
// catch(PDOException $e)
//     {
//     echo "Connection failed: " . $e->getMessage();
//     }
//     return $conn;
// }


function getWhereCustomActionValues($procedure, $action, $arrConditions, $paginated=false, $page_no=1, $records_per_page = 10) {
    $arrConditions['limit']='';
       
        if($paginated){
        $offset = ($page_no - 1) * $records_per_page;
        $arrConditions['offset'] = $offset;
        $arrConditions['limit'] = $records_per_page;
        }     

    return $this->callProc($procedure, $action, $arrConditions);
}

function callProc($strProcName, $strProcAction, $arrVals)
{
//$pdo = $this->pdo;
    $parmaset = '';
    $debug = $this->debug_enabled();
    $audit = $this->audit_enabled(); //for audit trail

if ($this->debug_enabled()) {
    $debug = 0;
}

if (!empty($arrVals)) {

//for audit trail
    if ($audit) {
        $parmaset .= "@p_audit=1 ,";
    }
    //print_r($arrVals);
    foreach ($arrVals as $key => $val) {
        //echo $val;
        $parmaset .= '@p_' . $key . "='" . str_replace(array("'", "\\", '"'), array("''", "\\\\\\\\", '\"'), $val) . "',";
    }

    if ($debug) {
        $parmaset .= "@p_debug=1";
    }


    $parmaset = rtrim($parmaset, ',');

} else {
    $parmaset .= "@p_empty='1'";
}

$sql = "CALL $strProcName('$strProcAction', \"$parmaset\")";

 // if($strProcAction=="TST"){
 //  echo $sql;exit;   
 //  }
                

//dbgl('sqls', $sql);
//
$result_set = $this->execQuery($sql);
//echo "<pre>";print_r($result_set);

if(!empty($result_set['error'])){

    return array('errors' => $result_set['error'], 'result' => []);

}


if ($debug) {
    $result_set_copy = $result_set['result_set'];
    $result = array_pop($result_set_copy);

    //dbgl('sqls', '>> ' . $result[0][0]);
    //dbgl('sqls', '>> SQL Error: ' . $conn->errorInfo()[1]);
}
//echo "<pre>";print_r($result_set);
if ($debug) {

    array_pop($result_set['result_set']);
}

//echo "<pre>";print_r($result_set);exit;
if (empty($result_set['result_set'])) {
    return array('errors' => $result_set['error'], 'result' => []);
} else {
    return array('errors' => $result_set['error'],'result' => $result_set['result_set']);
}

}

/**
* Executes the given sql query and returns the result set
*
* @param $strSql The sql query to be executed
* @return array
*/
function execQuery($strSql)
{
      if(!$this->CheckLogin())
        {
            $this->HandleError("Not logged in!");
            return false;
        }
        if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        } 
      
    try {
            
                if(!empty($this->connection)){
                $stmt = $this->connection->prepare($strSql);
                //$stmt = $conn->prepare("select * from users");
                $stmt->execute();
                //$stmt->store_result();
                //print_r($stmt);
                }else{
                    echo "No coonection found";
                }
                
               

    } catch(mysqli_sql_exception $e){
          echo $e->errorMessage();
          echo vd('Error occured in query: <strong style="color:#f8ac59;">' . $strSql . '</strong>');
      return ['error'=>true, 'msg'=> $e->errorMessage()];
        }

// if (!$exec) dd( $pdo->errorInfo());
         
      
      try {   
            $result_set = array();
            $myrow     = array();
            $this->stmt_bind_assoc($stmt, $myrow);
            $result = $stmt->get_result();
            //print_r($result);exit;
            $count=0;
            //echo mysqli_num_rows($result);exit;
            if(mysqli_num_rows($result)>1){

                while($row = $result->fetch_assoc()){
                 //print_r($row);
                 $result_set[$count] = $row;
                 $count++;
            }

            }else{

                while($row = mysqli_fetch_assoc($result)){
                 $result_set = $row;
                 $count++;
            }

            }
            
                  
        } catch (mysqli_sql_exception $e) {
                   // echo vd('Error occured in query: <strong style="color:#f8ac59;">' . $strSql . '</strong>');
                   //return ['error'=>true, 'msg'=> $pdo->errorInfo()];
        }
    //echo "<pre>"; print_r($myrow);//exit;
    return array("result_set"=>$result_set, "error"=> mysqli_error($this->connection));
}

function stmt_bind_assoc(&$stmt, &$out){
    $data = mysqli_stmt_result_metadata($stmt);
    $fields = array();
    $out= array();

    $fields[0] = $stmt;
    $count = 1;

    while($field = mysqli_fetch_field($data)){
        $fields[$count] = &$out[$field->name];
        $count++;
    }
    call_user_func_array(mysqli_stmt_bind_result, $fields);
}
function debug_enabled()
{
    return (ENVIRONMENT == 'dev' || ENVIRONMENT == 'local' || FORCED_DEBUG);
}

function audit_enabled()
{
    return (ENVIRONMENT == 'dev' || ENVIRONMENT == 'live' || AUDIT_TRAIL);
}


function vd($args)
    {

        if (debug_enabled()) {
            echo '<pre  style="background: #000;    color: #52f952;    font-weight: bold;    border: 0;">';
            foreach (func_get_args() as $var) {
                var_dump($var);
            }

            echo '</pre>';

            $bt = debug_backtrace();
            $caller = array_shift($bt);

            dbgl('vds', 'vd called from: ' . $caller['file'] . ' at ' . $caller['line']);
        }
    }
    
function dbgl($typ, $msg)
{
    if (debug_enabled()) {
        $GLOBALS['dl'][$typ][] = $msg;
    }

}
    
}
?>