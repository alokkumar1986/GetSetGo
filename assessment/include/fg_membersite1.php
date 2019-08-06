<?PHP
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
            $this->HandleError("UserName is empty!");
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
            return false;
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
        
        if($user_rec['Password'] != md5($pwd))
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
        $qry = "Select Staff_Name, Email, Role, actingrole from $this->tablename where User_Name='$username' and Password='$pwdmd5' and C_Code='y'";
        
        $result = mysql_query($qry,$this->connection);
        
        if(!$result || mysql_num_rows($result) <= 0)
        {
            $this->HandleError("Error logging in. The username or password does not match");
            return false;
        }
        
        $row = mysql_fetch_assoc($result);
        if ($_POST['remember'] == "yes"){
		setcookie("username", $username, time()+7600); 
		}
        $_SESSION['name_of_user']  = $row['Staff_Name'];
        $_SESSION['email_of_user'] = $row['Email'];
        $_SESSION['role'] = $row['Role'];
        $_SESSION['actingrole'] = $row['actingrole'];
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
        
        $result = mysql_query("Select Staff_Name, Email from $this->tablename where C_Code='$confirmcode'",$this->connection);   
        if(!$result || mysql_num_rows($result) <= 0)
        {
            $this->HandleError("Wrong confirm code.");
            return false;
        }
        $row = mysql_fetch_assoc($result);
        $user_rec['Staff_Name'] = $row['Staff_Name'];
        $user_rec['Email']= $row['Email'];
        
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
        
        $qry = "Update $this->tablename Set Password='".md5($newpwd)."' Where  `ID`='".$user_rec[ID]."'";
        
        if(!mysql_query( $qry ,$this->connection))
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
        
        $result = mysql_query("Select * from $this->tablename where Email='$email'",$this->connection);  

        if(!$result || mysql_num_rows($result) <= 0)
        {
            $this->HandleError("There is no user with email: $email");
            return false;
        }
        $user_rec = mysql_fetch_assoc($result);

        
        return true;
    }
    
    function SendUserWelcomeEmail(&$user_rec)
    {
        $mailer = new PHPMailer();
        
        $mailer->CharSet = 'utf-8';
        
        $mailer->AddAddress($user_rec['Email'],$user_rec['Staff_Name']);
        
        $mailer->Subject = "Welcome to ".$this->sitename;

        $mailer->From = $this->GetFromAddress();        
        
        $mailer->Body ="Hello ".$user_rec['Staff_Name']."\r\n\r\n".
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
        
        $mailer->Subject = "Registration Completed: ".$user_rec['Staff_Name'];

        $mailer->From = $this->GetFromAddress();         
        
        $mailer->Body ="A new user registered at ".$this->sitename."\r\n".
        "Name: ".$user_rec['Staff_Name']."\r\n".
        "Email address: ".$user_rec['Email']."\r\n";
        
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
        $email = $user_rec['Email'];
        
        $mailer = new PHPMailer();
        
        $mailer->CharSet = 'utf-8';
        
        $mailer->AddAddress($email,$user_rec['Staff_Name']);
        
        $mailer->Subject = "Your reset password request at ".$this->sitename;

        $mailer->From = $this->GetFromAddress();
        
        $link = $this->GetAbsoluteURLFolder().
                '/resetpwd.php?email='.
                urlencode($email).'&code='.
                urlencode($this->GetResetPasswordCode($email));

        $mailer->Body ="Hello ".$user_rec['name']."\r\n\r\n".
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
        $email = $user_rec['Email'];
        
        $mailer = new PHPMailer();
        
        $mailer->CharSet = 'utf-8';
        
        $mailer->AddAddress($email,$user_rec['Staff_Name']);
        
        $mailer->Subject = "Your new password for ".$this->sitename;

        $mailer->From = $this->GetFromAddress();
        
        $mailer->Body ="Hello ".$user_rec['Staff_Name']."\r\n\r\n".
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
        $validator->addValidation("name","req","Please fill in Name");
        $validator->addValidation("email","email","The input for Email should be a valid email value");
        $validator->addValidation("email","req","Please fill in Email");
        $validator->addValidation("username","req","Please fill in UserName");
        $validator->addValidation("password","req","Please fill in Password");

        
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
        $formvars['name'] = $this->Sanitize($_POST['name']);
        $formvars['email'] = $this->Sanitize($_POST['email']);
        $formvars['username'] = $this->Sanitize($_POST['username']);
        $formvars['password'] = $this->Sanitize($_POST['password']);
    }
    
    function SendUserConfirmationEmail(&$formvars)
    {
        $mailer = new PHPMailer();
        
        $mailer->CharSet = 'utf-8';
        
        $mailer->AddAddress($formvars['email'],$formvars['name']);
        
        $mailer->Subject = "Your registration with ".$this->sitename;

        $mailer->From = $this->GetFromAddress();        
        
        $confirmcode = $formvars['confirmcode'];
        
        $confirm_url = $this->GetAbsoluteURLFolder().'/confirmreg.php?code='.$confirmcode;
        
        $mailer->Body ="Hello ".$formvars['name']."\r\n\r\n".
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
        
        $mailer->Subject = "New registration: ".$formvars['name'];

        $mailer->From = $this->GetFromAddress();         
        
        $mailer->Body ="A new user registered at ".$this->sitename."\r\n".
        "Name: ".$formvars['name']."\r\n".
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
        $qry = "select User_Name from $this->tablename where $fieldname='".$field_val."'";
        $result = mysql_query($qry,$this->connection);   
        if($result && mysql_num_rows($result) > 0)
        {
            return false;
        }
        return true;
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
    
        $confirmcode = "y";
        
        $formvars['confirmcode'] = $confirmcode;
        
        $insert_query = 'insert into '.$this->tablename.'(
				
                Staff_Name,
                Email,
                User_Name,
                Password,
                C_Code
                )
                values
                (
                "' . $this->SanitizeForSQL($formvars['name']) . '",
                "' . $this->SanitizeForSQL($formvars['email']) . '",
                "' . $this->SanitizeForSQL($formvars['username']) . '",
                "' . md5($formvars['password']) . '",
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
	function Selectfaculty($id)
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database connection failed!");
            return false;
        }          
		
        if($id!='')
        $qry = "Select * from $this->tablename where ID='$id'";
        
        $result = mysql_query($qry,$this->connection);
        
        if(!$result || mysql_num_rows($result) <= 0)
        {
            $this->HandleError("Error Fetching Data");
            return false;
        }
        
       
        return $result;
    }
    /* Add Faculty  */
    function Addfaculty()
    {
        if(!$this->CheckLogin())
        {
            $this->HandleError("Not logged in!");
            return false;
        }
        
        if(empty($_POST['username']))
        {
            $this->HandleError("Username is empty!");
            return false;
        }
        if(empty($_POST['password']))
        {
            $this->HandleError("Password is empty!");
            return false;
        }
        if(empty($_POST['fname']))
        {
            $this->HandleError("First Name is empty!");
            return false;
        }
        if(empty($_POST['lname']))
        {
            $this->HandleError("Last Name is empty!");
            return false;
        }
        if(empty($_POST['email']))
        {
            $this->HandleError("Email is empty!");
            return false;
        }
        if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$_POST['email']))
  		{
  			$this->HandleError("Invalid Email Address!");
            return false;
  		}
        if(empty($_POST['mobileno']))
        {
            $this->HandleError("Mobile Number is empty!");
            return false;
        }
        if( (!is_numeric($_POST['mobileno'])) || (strlen($_POST['mobileno'])<10) ) { 
    		$this->HandleError("Invalid Mobile Number!");
            return false;
		}
         if(empty($_POST['typeinteviewer']))
        {
            $this->HandleError("Interviewer type is empty!");
            return false;
        }
        /*if(empty($_FILES['pic']['name']))
        {
            $this->HandleError("No Image is selected!");
            return false;
        }*/
        
        
        if(!$this->AddfacultyInDB($_POST['username'],$_POST['password'],$_POST['fname'],$_POST['lname'],$_POST['email'],$_POST['mobileno'],$_POST['typeinteviewer'],$_FILES['pic']['name'],$_FILES['pic']['tmp_name']))
        {
            return false;
        }
        return true;
    }
    
    function AddfacultyInDB($username,$password,$fname,$lname,$email,$mobileno,$typeinteviewer,$pic,$pictemp){
		if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        } 
        $rs=mysql_query("select * from staff where Email='$email'",$this->connection);
    $count=mysql_num_rows($rs);
    if($count==0){
        $pic1= time().$pic;
        $name=$fname.'  '.$lname;
        $qry = "insert into $this->tablename set User_Name='$username',Password=md5('$password'),Staff_Name='$name',Email='$email',Mobile='$mobileno',C_Code='y',Role='staff',Status='active',actingrole='$typeinteviewer',Photo='$pic1'";
        
        if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error inserting data into database \nquery:$qry");
            return false;
        }else{
			move_uploaded_file($pictemp,'uploads/'.$pic1);
		} 
		}else{
			$this->HandleDBError($email." exists in the database");
			return false;
		}    
        return true;
        
	}
	
	/* Upload Faculty */
	function Uploadfaculty()
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
        if(empty($_FILES['pic']['name']))
        {
            $this->HandleError("File isn't selected!");
            return false;
        }
       if ($_FILES['pic']['size'] > 0) { 

    $file = $_FILES['pic']['tmp_name']; 
    $handle = fopen($file,"r"); 
 	$i=0;
   while ($data = fgetcsv($handle,1000,",","'")) { 
   if($i!=0){
   	
    //$rs=mysql_query("select * from staff where Email='$data[6]'",$this->connection);
    //$count=mysql_num_rows($rs);
    $count=0;
    if($count==0){
	 if ($data[0]) { 
            $qry="INSERT INTO `staff` (
`Staff_Name` ,
`User_Name` ,
`Gender` ,
`DOB` ,
`Address` ,
`Mobile` ,
`Email` ,
`Password` ,

`Role` ,
`Status` ,
`actingrole`
)
VALUES (
                   '".addslashes($data[0])."', 
                    '".addslashes($data[1])."', 
                    '".addslashes($data[2])."', 
                    '".addslashes($data[3])."', 
                    '".addslashes($data[4])."', 
                    '".addslashes($data[5])."', 
                    '".addslashes($data[6])."', 
                    '".md5(addslashes($data[7]))."', 
                     
                    '".addslashes($data[8])."', 
                    '".addslashes($data[9])."',
                    '".addslashes($data[10])."' 
                )";
                             
           if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error in uploading.. \nquery:$qry");
            return false;
        }  
         }
    }else{
        	$this->HandleDBError($data[6]." exists and skipped");
			//return false;
		}  }
        $i++;     
    
     } 
} else {
	$this->HandleError("Upload can't possible!");
            return false;
}
        return true;
    }
    
    /* Add Student */
    
    function Addstudent()
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
        if(empty($_POST['name']))
        {
            $this->HandleError("Name is empty");
            return false;
        }
        if(empty($_POST['bputreg']))
        {
            $this->HandleError("BPUT Regd. No is empty");
            return false;
        }
        if(empty($_POST['email']))
        {
            $this->HandleError("Email is empty");
            return false;
        }
        if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$_POST['email']))
  		{
  			$this->HandleError("Invalid Email Address!");
            return false;
  		}
        if(empty($_POST['mobileno']))
        {
            $this->HandleError("Mobile Number is empty!");
            return false;
        }
        if( (!is_numeric($_POST['mobileno'])) || (strlen($_POST['mobileno'])<10) ) { 
    		$this->HandleError("Invalid Mobile Number!");
            return false;
		}
        if(empty($_POST['date']))
        {
            $this->HandleError("Date Of Birth is empty");
            return false;
        }
        if(empty($_POST['gender']))
        {
            $this->HandleError("Gender is empty");
            return false;
        }
        if(empty($_POST['college']))
        {
            $this->HandleError("College is n't selected");
            return false;
        }
        if(empty($_POST['stream']))
        {
            $this->HandleError("Branch is empty");
            return false;
        }
        if(empty($_POST['batch']))
        {
            $this->HandleError("Passout Year is empty");
            return false;
        }
        if(empty($_FILES['pic']['name']))
        {
            $this->HandleError("Image Field is empty");
            return false;
        }
         if(!$this->AddstudentInDB($_POST['name'],$_POST['bputreg'],$_POST['email'],$_POST['mobileno'],$_POST['date'],$_POST['gender'],$_POST['college'],$_POST['stream'],$_POST['batch'],$_FILES['pic']['name'],$_FILES['pic']['tmp_name']))
        {
            return false;
        }
        return true;
       
    }
     
    function AddstudentInDB($name,$bputreg,$email,$mobileno,$date,$gender,$college,$stream,$batch,$pic,$pic_tmp){
		if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        } 
        $rs=mysql_query("select * from student_data where (EMAIL_ID='$email' || REG_NO='$bputreg')",$this->connection);
    $count=mysql_num_rows($rs);
    if($count==0){
        $pic1= time().$pic;
         $qry = "insert into student_data set `REG_NO`='$bputreg',`USERNAME`='$email',`PASSWORD`=md5('$bputreg'),  `NAME`='$name', `GENDER`='$gender', `DOB`='$date', `MOBILE_NO`='$mobileno', `EMAIL_ID`='$email', `COLLEGE`='$college', `BRANCH`='$stream', `COURSE_YOP`='$batch',  `PIC`='$pic1', `C_Code`='y'";
        
        if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error inserting data into database \nquery:$qry");
            return false;
        }else{
			move_uploaded_file($pic_tmp,'uploads1/'.$pic1);
		} 
		}else{
			$this->HandleDBError($email." exists in the database");
			return false;
		}    
        return true;
        
	}
	/* End of Add student */
	
	/* Upload Student */
	function Uploadstudent()
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
        if(empty($_FILES['pic']['name']))
        {
            $this->HandleError("File isn't selected!");
            return false;
        }
       if ($_FILES['pic']['size'] > 0) { 

    $file = $_FILES['pic']['tmp_name']; 
    $handle = fopen($file,"r"); 
 	$i=0;
   while ($data = fgetcsv($handle,1000,",","'")) { 
   if($i!=0){
   	
    $rs=mysql_query("select * from student_data where ( REG_NO='$data[0]')",$this->connection);
    $count=mysql_num_rows($rs);
    if($count==0){
	 if ($data[0]) { 
            $qry="INSERT INTO `student_data` (`REG_NO`, `NAME`, `GENDER`, `DOB`, `MOBILE_NO`, `EMAIL_ID`, `COLLEGE`, `BRANCH`, `COURSE_YOP`, `C_Code`, `USERNAME`, `PASSWORD`, `STATE`, `UNIVERSITY`, `COURSE`) VALUES 
            
            ('".addslashes($data[0])."', 
            '".addslashes($data[1])."', 
            '".addslashes($data[2])."', 
            '".addslashes($data[3])."', 
            '".addslashes($data[4])."', 
            '".addslashes($data[5])."', 
            '".addslashes($data[6])."', 
            '".addslashes($data[7])."', 
            '".addslashes($data[8])."', 
            '".addslashes($data[9])."',
            '".addslashes($data[10])."', 
            '".addslashes($data[11])."',
            '".addslashes($data[10])."', 
            '".addslashes($data[11])."',
            '".addslashes($data[12])."',
            '".addslashes($data[13])."', 
            '".addslashes($data[14])."'
                      )";
                             
           if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error in uploading.. \nquery:$qry");
            return false;
        }  
         }
    }else{
        	$this->HandleDBError("Reg. No : ".$data[0]." exists and skipped");
			//return false;
		}  }
        $i++;     
    
     } 
} else {
	$this->HandleError("Upload can't possible!");
            return false;
}
        return true;
    }
    /*End of Upload Student */
	
    /* Deleting Faculty */
    function Deletefaculty($id){
    	
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
        $qry="delete from staff where ID='$id'";
           if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error in deleting the selected entry.. \nquery:$qry");
            return false;
        } 
        return true; 
        
	}
    
    /* Update Faculty */
    function Updatefaculty(){
    if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        } 
        $username=$_POST['username'];
        $password=$_POST['password'];
        
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        $email=$_POST['email'];
        $mobileno=$_POST['mobileno'];
        $typeinteviewer=$_POST['typeinteviewer'];
        $user=$_POST['user'];
        if($password==""){
			
		$qry = "Update $this->tablename set User_Name='$username',Staff_Name='$fname' '$lname',Email='$email',Mobile='$mobileno',Role='staff',Status='active',actingrole='$typeinteviewer' WHERE ID='$user'";	
		}else{
			$qry = "Update $this->tablename set User_Name='$username',Password=md5('$password'),Staff_Name='$fname' '$lname',Email='$email',Mobile='$mobileno',Role='staff',Status='active',actingrole='$typeinteviewer' WHERE ID='$user'";
		}
        
        
        if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error inserting data into database \nquery:$qry");
            return false;
        }   
        return true;	
		
	}
	
	/* Get Student */
	function Getstudent($id)
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database connection failed!");
            return false;
        }          
		
        if($id!='')
        $qry = "Select * from `student_data` where REG_NO='$id'";
        
        $result = mysql_query($qry,$this->connection);
        
        if(!$result || mysql_num_rows($result) <= 0)
        {
            $this->HandleError("Error Fetching Data");
            return false;
        }
        
       
        return $result;
    }
     function ThatDate($id){
	 	if(!$this->DBLogin())
        {
            $this->HandleError("Database connection failed!");
            return false;
        }
         $qry1="SELECT  `instance` FROM  `instance` WHERE  `college` = ( SELECT COLLEGE FROM student_data WHERE REG_NO =  '$id' ) ";
        $rs=mysql_query($qry1,$this->connection);
        $row=mysql_fetch_array($rs);
        if($row['instance']==''){
			$counter=1000;
		}else{
			$counter=$row['instance'];
		}
        $qry = "Select * from `ti` where REGD_NO ='$id' and DATE=CURDATE()";
        
        $result = mysql_query($qry,$this->connection);
        
        if(!$result || mysql_num_rows($result) >= $counter)
        {
            //$this->HandleError("Error Fetching Data");
            return true;
        }
       return false;          
		
	 }
	 function ThatDate1($id){
	 	if(!$this->DBLogin())
        {
            $this->HandleError("Database connection failed!");
            return false;
        }
        $qry1="SELECT  `instance` FROM  `instance` WHERE  `college` = ( SELECT COLLEGE FROM student_data WHERE REG_NO =  '$id' ) ";
        $rs=mysql_query($qry1,$this->connection);
        $row=mysql_fetch_array($rs);
        if($row['instance']==''){
			$counter=1000;
		}else{
			$counter=$row['instance'];
		}
        $qry = "Select * from `pi` where REGD_NO ='$id' and DATE=CURDATE()";
        
        $result = mysql_query($qry,$this->connection);
        
        if(!$result || mysql_num_rows($result) >= $counter)
        {
            //$this->HandleError("Error Fetching Data");
            return true;
        }
       return false;          
		
	 }
	 /*  Download Excel Technical */
	 function Downloadexceltec(){
	 	$string = 'header("Content-type: application/vnd.ms-excel")';
		$string.= 'header("Content-Disposition: attachment;Filename=document_name.xls")';

		$string.= "<html>";
		$string.= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
		$string.= "<body>";
		$string.= "<b>testdata1</b> \t <u>testdata2</u> \t \n ";
		$string.= "</body>";
		$string.= "</html>";
		return $string;
	 	
	 }
	 /*  End of Download Excel Technical */
	 
	 /*  Download PDF Technical */
	 function Dowloadpdftec(){
	 	return true;
	 }
     /*  End of Download PDF Technical */
     
     /*  Download Excel PI */
	 function Downloadexcelpi(){
	 	return true;
	 	
	 }
	 /*  End of Download Excel PI */
	 
	 /*  Download PDF Technical */
	 function Dowloadpdfpi(){
	 	return true;
	 }
     /*  End of Download PDF PI */
     function Addcollege()
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
        if(empty($_POST['name']))
        {
            $this->HandleError("Name is empty");
            return false;
        }
        if(empty($_POST['shortname']))
        {
            $this->HandleError("Short Name is empty");
            return false;
        }
        if(empty($_POST['state']))
        {
            $this->HandleError("State is empty");
            return false;
        }
        if(empty($_POST['university']))
        {
            $this->HandleError("University is empty");
            return false;
        }
        
         if(!$this->AddcollegeInDB($_POST['name'],$_POST['shortname'],$_POST['code'],$_POST['state'],$_POST['university']))
        {
            return false;
        }
        return true;
       
    }
     
    function AddcollegeInDB($name,$shortname,$code,$state,$university){
		if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        } 
        $rs=mysql_query("select * from college where (name LIKE '$name%' || short_name='$shortname')",$this->connection);
    $count=mysql_num_rows($rs);
    if($count==0){
        $pic1= time().$pic;
        $qry = "INSERT INTO `college` (`id`, `name`, `short_name`, `state`, `university`, `college_code`) VALUES (NULL, '$name', '$shortname', '$state', '$university', '$code')";
        
        if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error inserting data into database");
            return false;
        } 
		}else{
			$this->HandleDBError($name." exists in the database");
			return false;
		}    
        return true;
        
	}
	
	
	/* Add Branches */
	
	 function Addbranch()
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
        if(empty($_POST['branch']))
        {
            $this->HandleError("Branch is empty");
            return false;
        }
        if(empty($_POST['course']))
        {
            $this->HandleError("Course is empty");
            return false;
        }
      
         if(!$this->AddbranchInDB($_POST['college'],$_POST['code'],$_POST['course'],$_POST['branch']))
        {
            return false;
        }
        return true;
       
    }
     
    function AddbranchInDB($name,$code,$course,$branch){
		if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        } 
        $rs=mysql_query("select * from branch where (college = '$name' and course='$course' and branch ='$branch')",$this->connection);
    $count=mysql_num_rows($rs);
    if($count==0){
        $pic1= time().$pic;
        $qry = "INSERT INTO `branch` (`id`, `college`, `course`, `branch`, `college_code`) VALUES (NULL, '$name', '$course', '$branch', '$code')";
        
        if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error inserting data into database");
            return false;
        } 
		}else{
			$this->HandleDBError($branch." branch exists in the list of ".$name);
			return false;
		}    
        return true;
        
	}
	
	
	  /*  Add Notice */
    
    function Addnotice(){
    	
    	if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        } 
        if(!$this->CheckLogin())
        {
            $this->HandleError("Not logged in!");
            return false;
        }
        
        if(empty($_POST['date']))
        {
            $this->HandleError("Date is empty!");
            return false;
        }
        if(empty($_POST['title']))
        {
            $this->HandleError("Title is empty!");
            return false;
        }
        if(empty($_POST['news']))
        {
            $this->HandleError("Content is empty!");
            return false;
        }
        if(empty($_POST['cc']))
        {
            $this->HandleError("CC is empty!");
            return false;
        }
        if(empty($_POST['co-ordinator']))
        {
            $this->HandleError("Co-ordinator is empty!");
            return false;
        }
		
		$qry = "insert into notice set date='".$_POST['date']."',title='".$_POST['title']."',content='".$_POST['news']."',cc='".$_POST['cc']."',cordinator='".$_POST['co-ordinator']."',addeddate=CURDATE()";
        
        if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error inserting data into database \nquery:$qry");
            return false;
        }
		
		return true;
	}
    
    /*  Update Notice */
    
    function Updatenotice(){
    	
    	if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        } 
        if(!$this->CheckLogin())
        {
            $this->HandleError("Not logged in!");
            return false;
        }
        
        if(empty($_POST['date']))
        {
            $this->HandleError("Date is empty!");
            return false;
        }
        if(empty($_POST['title']))
        {
            $this->HandleError("Title is empty!");
            return false;
        }
        if(empty($_POST['news']))
        {
            $this->HandleError("Content is empty!");
            return false;
        }
        if(empty($_POST['cc']))
        {
            $this->HandleError("CC is empty!");
            return false;
        }
        if(empty($_POST['co-ordinator']))
        {
            $this->HandleError("Co-ordinator is empty!");
            return false;
        }
		
		$qry = "update notice set date='".$_POST['date']."',title='".$_POST['title']."',content='".$_POST['news']."',cc='".$_POST['cc']."',cordinator='".$_POST['co-ordinator']."',addeddate=CURDATE() where id='".$_POST['id']."'";
        
        if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error inserting data into database \nquery:$qry");
            return false;
        }
		
		return true;
	}
    
    
    
     /* Deleting Notice */
    function Deletenotice($id){
    	
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
        $qry="delete from notice where id='$id'";
           if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error in deleting the selected entry.. \nquery:$qry");
            return false;
        } 
        return true; 
        
	}
	function changephoto(){
		if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        } 
        
        $pic= time().$_FILES['filePhoto']['name'];
        $qry = "update staff set `Photo`='$pic' where ID='".$_POST['user']."'";
        
        if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error inserting data into database \nquery:$qry");
            return false;
        }else{
			move_uploaded_file($_FILES['filePhoto']['tmp_name'],'../admin/uploads1/'.$pic);
		} 
		    
        return true;
        
	}
	function Addinstance(){
		if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        } 
        if(empty($_POST['college']))
        {
            $this->HandleError("College is empty!");
            return false;
        }
        if(empty($_POST['instance']))
        {
            $this->HandleError("Instance is empty!");
            return false;
        }
        if(is_nan($_POST['instance'])){
			$this->HandleError("Instance is not a number!");
            return false;
		}
        $rs=mysql_query("select * from instance where (college = '".$_POST['shortname']."')",$this->connection);
    $count=mysql_num_rows($rs);
    if($count==0){
        
        $qry = "INSERT INTO `instance` (`id`, `college`, `instance`) VALUES (NULL, '".$_POST['shortname']."', '".$_POST['instance']."')";
        
        if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error inserting data into database");
            return false;
        } 
		}else{
			$this->HandleDBError($_POST['college']." instance exists in the list");
			return false;
		}   
        return true; 
	}
	
	/* Deleting Notice */
    function Deleteinstance($id){
    	
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
        $qry="delete from instance where id='$id'";
           if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error in deleting the selected entry.. \nquery:$qry");
            return false;
        } 
        return true; 
        
	}
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
 function Addknowledgebasecontent(){
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
        if(empty($_POST['category']))
        {
            $this->HandleError("Category is empty!");
            return false;
        }
        if(empty($_POST['name']))
        {
            $this->HandleError("File Name is empty!");
            return false;
        }
        if(empty($_FILES['file']['name']))
        {
            $this->HandleError("File is empty!");
            return false;
        }
        $pic=$_FILES['file']['name'];
        $pic_tmp=$_FILES['file']['tmp_name'];
        $qry="insert into knowledgebase_content (`id`, `name`, `category`, `file`, `addeddate`) VALUES (NULL, '$_POST[name]', '$_POST[category]', '$pic', CURDATE());";
           if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error inserting data into database \nquery:$qry");
            return false;
        }else{
			move_uploaded_file($pic_tmp,'../../../../material/'.$pic);
		}
        return true;
		
	}
	function Deleteknowledge($id){
    	
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
        $qry="delete from knowledgebase_content where id='$id'";
           if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error in deleting the selected entry.. \nquery:$qry");
            return false;
        } 
        return true; 
        
	}
function Searchsetting(){
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
        $college=implode(",",$_POST['college']);
        $yop=implode(",",$_POST['yop']);
         $qry="update search set college='".$college."', yop='".$yop."' where id='1'";
           if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error in updating the selected entry.. \nquery:$qry");
            return false;
        } 
        return true; 
        
        
	}
	/* Update Student */
    function Updatestudent(){
    if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        } 
        $username=$_POST['username'];
        $password=$_POST['password'];
        
        $name=$_POST['name'];
        $reg_no=$_POST['reg_no'];
        $email=$_POST['email'];
        $mobileno=$_POST['mobileno'];
        $gender=$_POST['gender'];
        $state=$_POST['state'];
        $university=$_POST['university'];
        $college=$_POST['college'];
        $course=$_POST['course'];
        $branch=$_POST['branch'];
        $yop=$_POST['yop'];
        
        $user=$_POST['user'];
        if($password==""){
			
		$qry = "Update `student_data` SET USERNAME='$username', `NAME` =  '$name', `REG_NO`='$reg_no', `EMAIL_ID`='$email', `GENDER`='$gender', `MOBILE_NO`='$mobileno', `STATE`='$state', `UNIVERSITY`='$university', `COLLEGE`='$college', `BRANCH`='$branch', `COURSE_YOP`='$yop', `COURSE`='$course'  WHERE  `student_data`.`REG_NO` =  '$reg_no'";	
		}else{
			//$qry = "Update $this->tablename set User_Name='$username',Password=md5('$password'),Staff_Name='$fname' '$lname',Email='$email',Mobile='$mobileno',Role='staff',Status='active',actingrole='$typeinteviewer' WHERE ID='$user'";
			$qry = "Update `student_data` SET `USERNAME`='$username', `PASSWORD`=md5('$password'),  `NAME` =  '$name', `REG_NO`='$reg_no', `EMAIL_ID`='$email', `GENDER`='$gender', `MOBILE_NO`='$mobileno', `STATE`='$state', `UNIVERSITY`='$university', `COLLEGE`='$college', `BRANCH`='$branch', `COURSE_YOP`='$yop', `COURSE`='$course'  WHERE  `student_data`.`REG_NO` =  '$reg_no'";
		}
		
        
        
        if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error inserting data into database \nquery:$qry");
            return false;
        }   
        return true;	
		
	}
	
	/* Upload College */
	function Uploadcollege()
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
        if(empty($_FILES['pic']['name']))
        {
            $this->HandleError("File isn't selected!");
            return false;
        }
       if ($_FILES['pic']['size'] > 0) { 

    $file = $_FILES['pic']['tmp_name']; 
    $handle = fopen($file,"r"); 
 	$i=0;
   while ($data = fgetcsv($handle,1000,",","'")) { 
   if($i!=0){
   	
    $rs=mysql_query("select * from college where ( (name='$data[0]' AND short_name='$data[1]') || college_code='$data[4]')",$this->connection);
    $count=mysql_num_rows($rs);
    if($count==0){
	 if ($data[0]) { 
            $qry="INSERT INTO `college` ( `name`, `short_name`, `state`, `university`, `college_code`, `college_email`) VALUES 
            
            ('".addslashes($data[0])."', 
            '".addslashes($data[1])."', 
            '".addslashes($data[2])."', 
            '".addslashes($data[3])."', 
            '".addslashes($data[4])."', 
            '".addslashes($data[5])."'
                      )";
                             
           if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error in uploading.. \nquery:$qry");
            return false;
        }  
         }
    }else{
        	$this->HandleDBError("College : ".$data[0]." exists and skipped");
			//return false;
		}  }
        $i++;     
    
     } 
} else {
	$this->HandleError("Upload can't possible!");
            return false;
}
        return true;
    }
    /*End of Upload College */
	function Selectcollege($id)
    {
        if(!$this->DBLogin())
        {
            $this->HandleError("Database connection failed!");
            return false;
        }          
		
        if($id!='')
        $qry = "Select * from `college` where id='$id'";
        
        $result = mysql_query($qry,$this->connection);
        
        if(!$result || mysql_num_rows($result) <= 0)
        {
            $this->HandleError("Error Fetching Data");
            return false;
        }
        
       
        return $result;
    }
    
    /* Update College */
    function Updatecollege(){
    if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        } 
        
        $name=$_POST['name'];
        $short_name=$_POST['short_name'];
        $state=$_POST['state'];
        $university=$_POST['university'];
        $college_code=$_POST['college_code'];
        
        $college_email=$_POST['college_email'];
        $id=$_POST['id'];
       
        
			
			$qry = "Update `college` SET `name`='$name', `short_name`='$short_name',  `state` =  '$state', `university`='$university', `college_code`='$college_code', `college_email`='$college_email' WHERE  `id` =  '$id'";
		
		
        
        
        if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error inserting data into database \nquery:$qry");
            return false;
        }   
        return true;	
		
	}
 function Addcourse()
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
        if(empty($_POST['college']))
        {
            $this->HandleError("College is empty");
            return false;
        }
        if(empty($_POST['course']))
        {
            $this->HandleError("Course is empty");
            return false;
        }
       
        
         if(!$this->AddcourseInDB($_POST['college'],$_POST['course']))
        {
            return false;
        }
        return true;
       
    }
     
    function AddcourseInDB($college,$course){
		if(!$this->DBLogin())
        {
            $this->HandleError("Database login failed!");
            return false;
        } 
        $rs=mysql_query("select * from course where (college ='$college' AND course='$course')",$this->connection);
    $count=mysql_num_rows($rs);
    if($count==0){
        $pic1= time().$pic;
        $qry = "INSERT INTO `course` (`college`, `course`) VALUES ( '$college', '$course')";
        
        if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error inserting data into database");
            return false;
        } 
		}else{
			$this->HandleDBError($course." exists in the courselist of ".$college );
			return false;
		}    
        return true;
        
	}
	/* Upload Course */
	function Uploadcourse()
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
        if(empty($_FILES['pic']['name']))
        {
            $this->HandleError("File isn't selected!");
            return false;
        }
       if ($_FILES['pic']['size'] > 0) { 

    $file = $_FILES['pic']['tmp_name']; 
    $handle = fopen($file,"r"); 
 	$i=0;
   while ($data = fgetcsv($handle,1000,",","'")) { 
   if($i!=0){
   	
    $rs=mysql_query("select * from `course` where ( course='$data[0]'  AND college='$data[1]')",$this->connection);
    $count=mysql_num_rows($rs);
    if($count==0){
	 if ($data[0]) { 
            $qry="INSERT INTO `course` (`course`, `college`) VALUES 
            
            ('".addslashes($data[0])."', 
            '".addslashes($data[1])."'
            
                      )";
                             
           if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error in uploading.. \nquery:$qry");
            return false;
        }  
         }
    }else{
        	$this->HandleDBError("Course : ".$data[0]." exists in the courselist of ".$data[1]." and skipped");
			//return false;
		}  }
        $i++;     
    
     } 
} else {
	$this->HandleError("Upload can't possible!");
            return false;
}
        return true;
    }
    /*End of Upload Course */
    
    /* Upload Branch */
	function Uploadbranch()
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
        if(empty($_FILES['pic']['name']))
        {
            $this->HandleError("File isn't selected!");
            return false;
        }
       if ($_FILES['pic']['size'] > 0) { 

    $file = $_FILES['pic']['tmp_name']; 
    $handle = fopen($file,"r"); 
 	$i=0;
   while ($data = fgetcsv($handle,1000,",","'")) { 
   if($i!=0){
   	
    $rs=mysql_query("select * from `branch` where ( college='$data[0]'  AND course='$data[1]' AND branch='$data[2]')",$this->connection);
    $count=mysql_num_rows($rs);
    if($count==0){
	 if ($data[0]) { 
            $qry="INSERT INTO `branch` (`college`, `course`, `branch`, `college_code`) VALUES 
            
            ('".addslashes($data[0])."', 
            '".addslashes($data[1])."',
            '".addslashes($data[2])."',
            '".addslashes($data[3])."'
            
                      )";
                             
           if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error in uploading.. \nquery:$qry");
            return false;
        }  
         }
    }else{
        	$this->HandleDBError("Branch : ".$data[2]." exists in the courselist of ".$data[0]." and skipped");
			//return false;
		}  }
        $i++;     
    
     } 
} else {
	$this->HandleError("Upload can't possible!");
            return false;
}
        return true;
    }
    /*End of Upload Branch */

}
?>