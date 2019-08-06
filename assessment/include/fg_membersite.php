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
        $this->rand_key = '2220iQx5oBk66oVZep222';
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

        $this->connection = mysqli_connect($this->db_host,$this->username,$this->pwd,'') or die(mysqli_connect_errno());

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
	
	/* Add User  */
    function Adduser()
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
            $this->HandleError("Type is empty!");
            return false;
        }
		if(!empty($_POST['staff'])){
		$actingrole= $_POST['staff'];
		}
		if(!empty($_POST['teacher'])){
		$actingrole= $_POST['teacher'];
		}
		if(!empty($_POST['admin'])){
		$actingrole= $_POST['admin'];
		}
		if(!empty($_POST['college'])){
		$actingrole= $_POST['college'];
		}
		
		/*if(empty($_POST['actingrole']))
        {
            $this->HandleError("Type is empty!");
            return false;
        }
        /*if(empty($_FILES['pic']['name']))
        {
            $this->HandleError("No Image is selected!");
            return false;
        }*/
        
        
        if(!$this->AdduserInDB($_POST['username'],$_POST['password'],$_POST['fname'],$_POST['lname'],$_POST['email'],$_POST['mobileno'],$_POST['typeinteviewer'],$actingrole,$_FILES['pic']['name'],$_FILES['pic']['tmp_name']))
        {
            return false;
        }
        return true;
    }
    
    function AdduserInDB($username,$password,$fname,$lname,$email,$mobileno,$typeinteviewer,$actingrole,$pic,$pictemp){
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
        $qry = "insert into $this->tablename set User_Name='$username',Password=md5('$password'),Staff_Name='$name',Email='$email',Mobile='$mobileno',C_Code='y',Role='$typeinteviewer',Status='active',actingrole='$actingrole',Photo='$pic1'";
        
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
            $qry="INSERT INTO `student_data` (`REG_NO`, `NAME`, `GENDER`, `DOB`, `MOBILE_NO`, `EMAIL_ID`, `COLLEGE`, `BRANCH`, `COURSE_YOP`, `C_Code`, `USERNAME`, `PASSWORD`, `STATE`, `UNIVERSITY`, `COURSE`, `COLLEGE_FULLNAME`) VALUES 
            
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
           
            '".addslashes($data[12])."',
            '".addslashes($data[13])."', 
            '".addslashes($data[14])."',
			'".addslashes($data[15])."'
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
	
	/* University */
	function Adduniversity(){
	
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
        $rs=mysql_query("select * from `university` where (university LIKE '$_POST[university]%' || state='$_POST[state]')",$this->connection);
    $count=mysql_num_rows($rs);
    if($count==0){
        
        $qry = "INSERT INTO `university` (`id`, `university`, `state`) VALUES (NULL, '".$_POST['university']."', '".$_POST['state']."')";
        
        if(!mysql_query( $qry ,$this->connection))
        {
            $fgmembersite->HandleDBError("Error inserting data into database");
            return false;
        } 
		}else{
			$this->HandleDBError($_POST['university']." exists in the database");
			return false;
		}    
		return true;
	
	
	
	}
	
	
	
	
	
	/* ------ ---------*/
	
	
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
   	
    $rs=mysql_query("select * from college where ( name='$data[0]' AND short_name='$data[1]' || college_code='$data[4]')",$this->connection);
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
    
    function Addcategory(){
		 
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
            $this->HandleError("Subject/Category is empty");
            return false;
        }
        
         $rs=mysql_query("select * from `test_category` where name='".$_POST['name']."' and parent_category_id='".$_POST['category']."'",$this->connection);
    $count=mysql_num_rows($rs);
    if($count==0){
        $qry="INSERT INTO `test_category` (`category_id`, `name`, `parent_category_id`) VALUES (NULL, '".$_POST['name']."', '".$_POST['category']."');";
                             
           if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error in uploading.. \nquery:$qry");
            return false;
        } 
        }else{
        	$this->HandleDBError($_POST['name']." exists, isn't added");
			return false;
		}  
		
		return true;
		}
		
		function Addcategory1(){
		 
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
            $this->HandleError("Subject/Category is empty");
            return false;
        }
        
         $rs=mysql_query("select * from `test_category` where name='".$_POST['name']."'",$this->connection);
    $count=mysql_num_rows($rs);
    if($count==0){
        $qry="INSERT INTO `test_category` (`category_id`, `name`, `parent_category_id`) VALUES (NULL, '".$_POST['name']."', '0');";
                             
           if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error in uploading.. \nquery:$qry");
            return false;
        } 
        }else{
        	$this->HandleDBError($_POST['name']." exists, isn't added");
			return false;
		}  
		
		return true;
		}
		
		/* ------------------------------------------------------------------------------------
		---------------------------Question Add To The database -------------------------------- */
	function Addquestion(){
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
		if($_POST['subject']=='True/False'){
		
		$question=strip_tags($_POST['summernote']);
		if(empty($question))
        {
            $this->HandleError("Question field cann't be blank! ");
            return false;
        }
		$option_1=strip_tags($_POST['option_1']);
		$option_2=strip_tags($_POST['option_2']);
		
		if(empty($option_1) || empty($option_2))
        {
            $this->HandleError("All 2 choices should be filled ! ");
            return false;
        }
		if(empty($_POST['diff']))
        {
            $this->HandleError("Difficulty Level cann't be blank! ");
            return false;
        }
		if(empty($_POST['answer']))
        {
            $this->HandleError("Answer cann't be blank! ");
            return false;
        }
		$answer=implode(",",$_POST['answer']);
		$qry="INSERT INTO `test_question_true_false` (`question_id`, `category`, `question`, `choice1`, `choice2`, `answer`, `difficulty_level`, `explanation`, `question_added_by`, `question_type`) VALUES (NULL, '".$_POST['cat']."', '".$_POST['summernote']."', '".$_POST['option_1']."', '".$_POST['option_2']."', '".$answer."', '".$_POST['diff']."', '".$_POST['summernote1']."', '".$_POST['user']."', '".$_POST['subject']."');";
                             
           if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error in Inserting Data.. \nquery:$qry");
            return false;
        } 
		
		}
		if($_POST['subject']=='Multiple-Option'){
		$question=strip_tags($_POST['summernote']);
		if(empty($question))
        {
            $this->HandleError("Question field cann't be blank! ");
            return false;
        }
		$option_1=strip_tags($_POST['option_1']);
		$option_2=strip_tags($_POST['option_2']);
		//$option_3=strip_tags($_POST['option_3']);
		/*if(empty($option_1) || empty($option_2) )
        {
            $this->HandleError("Atleast First 3 choices should be filled ! ");
            return false;
        }*/
		if(empty($_POST['diff']))
        {
            $this->HandleError("Difficulty Level cann't be blank! ");
            return false;
        }
		if(empty($_POST['answer']))
        {
            $this->HandleError("Answer cann't be blank! ");
            return false;
        }
		$answer=implode(",",$_POST['answer']);
		$qry="INSERT INTO `test_question_multiple_choice` (`question_id`, `category`, `question`, `choice1`, `choice2`, `choice3`, `choice4`, `choice5`, `answer`, `difficulty_level`, `explanation`, `question_added_by`, `question_type`) VALUES (NULL, '".$_POST['cat']."', '".$_POST['summernote']."', '".$_POST['option_1']."', '".$_POST['option_2']."', '".$_POST['option_3']."', '".$_POST['option_4']."', '".$_POST['option_5']."', '".$answer."', '".$_POST['diff']."', '".$_POST['summernote1']."', '".$_POST['user']."', '".$_POST['subject']."');";
                             
           if(!mysql_query( $qry ,$this->connection))
        {   
		    $this->HandleDBError("Error in Inserting Data.. \nquery:$qry");
            return false;
        } else{
		$_SESSION['flag']=1;
		}		
		}
		return true;
}

/* ------------------------------------------------------------------------------------
		---------------------------End Question Add To The database -------------------------------- */
		
		
/* -------------------------------------------------------------------------------------
  		------------------------------- Upload Question To The Database Via CSV ------------------------- */
		
		function Uploadquestion()
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
		if(empty($_POST['subject']))
        {
            $this->HandleError("Question type cann't be blank ");
            return false;
        } 
		if(empty($_POST['category']))
        {
            $this->HandleError("Category cann't be blank ");
            return false;
        } 
		if(empty($_FILES['pic']['name']))
        {
            $this->HandleError("File is empty ");
            return false;
        }
		if($_POST['subject']=='True/False'){
		
		
		
		if ($_FILES['pic']['size'] > 0) { 

    $file = $_FILES['pic']['tmp_name']; 
    $handle = fopen($file,"r"); 
 	$i=0;
   while ($data = fgetcsv($handle,1000,",","'")) { 
   if($i!=0){
   	
   
	 if ($data[0]) { 
            $qry="INSERT INTO `test_question_true_false` (`category`, `question`, `choice1`, `choice2`, `answer`, `difficulty_level`, `explanation`, `question_added_by`, `question_type`) VALUES
            
            ('".$_POST['category']."', 
            '".addslashes($data[0])."', 
            '".addslashes($data[1])."', 
            '".addslashes($data[2])."', 
            '".addslashes($data[3])."', 
            '".addslashes($data[4])."',
			'".addslashes($data[5])."',
					
			'".$_POST['user']."',
			'".$_POST['subject']."'
                      )";
                             
           if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error in uploading.. \nquery:$qry");
            return false;
        }  
         }
    }
        $i++;     
    
     } 
} else {
	$this->HandleError("Upload can't possible!");
            return false;
}
		
		
		}
		if($_POST['subject']=='Multiple-Option'){
		
		
		if ($_FILES['pic']['size'] > 0) { 

    $file = $_FILES['pic']['tmp_name']; 
    $handle = fopen($file,"r"); 
 	$i=0;
   while ($data = fgetcsv($handle,1000,",","'")) { 
   if($i!=0){
   	
   
	 if ($data[0]) { 
            $qry="INSERT INTO `test_question_multiple_choice` (`category`, `question`, `choice1`, `choice2`, `choice3`, `choice4`, `choice5`, `answer`, `difficulty_level`, `explanation`, `question_added_by`, `question_type`) VALUES
            
            ('".$_POST['category']."', 
            '".addslashes($data[0])."', 
            '".addslashes($data[1])."', 
            '".addslashes($data[2])."', 
            '".addslashes($data[3])."', 
            '".addslashes($data[4])."',
			'".addslashes($data[5])."',
			'".addslashes($data[6])."',
			'".addslashes($data[7])."',
			'".addslashes($data[8])."',
			
			'".$_POST['user']."',
			'".$_POST['subject']."'
                      )";
                             
           if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error in uploading.. \nquery:$qry");
            return false;
        }  
         }
    }
        $i++;     
    
     } 
} else {
	$this->HandleError("Upload can't possible!");
            return false;
}
		}
		return true;
		}		
	
	
	
	/* ------------------------------------------------------------------------------------
		---------------------------Question Update To The database -------------------------------- */
	function Updatequestion(){
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
		if($_POST['subject1']=='True/False'){
		
		
		$question=strip_tags($_POST['summernote']);
		if(empty($question))
        {
            $this->HandleError("Question field cann't be blank! ");
            return false;
        }
		$option_1=strip_tags($_POST['option_1']);
		$option_2=strip_tags($_POST['option_2']);
		
		if(empty($option_1) || empty($option_2)  )
        {
            $this->HandleError("All 2 choices should be filled ! ");
            return false;
        }
		if(empty($_POST['diff']))
        {
            $this->HandleError("Difficulty Level cann't be blank! ");
            return false;
        }
		if(empty($_POST['answer']))
        {
            $this->HandleError("Answer cann't be blank! ");
            return false;
        }
		$answer=implode(",",$_POST['answer']);
		$qry="update `test_question_true_false` set `question`='".$_POST['summernote']."', `choice1`='".$_POST['option_1']."', `choice2`='".$_POST['option_2']."', `answer`='".$answer."', `difficulty_level`='".$_POST['diff']."', `explanation`= '".$_POST['summernote1']."'  where question_id='".$_POST['question_id']."'";
                         
           if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error in Updating.. \nquery:$qry");
            return false;
        } 
		
		
		
		}
		if($_POST['subject1']=='Multiple-Option'){
		$question=strip_tags($_POST['summernote']);
		if(empty($question))
        {
            $this->HandleError("Question field cann't be blank! ");
            return false;
        }
		$option_1=strip_tags($_POST['option_1']);
		$option_2=strip_tags($_POST['option_2']);
		$option_3=strip_tags($_POST['option_3']);
		/*if(empty($option_1) || empty($option_2) || empty($option_3) )
        {
            $this->HandleError("Atleast First 3 choices should be filled ! ");
            return false;
        }*/
		if(empty($_POST['diff']))
        {
            $this->HandleError("Difficulty Level cann't be blank! ");
            return false;
        }
		if(empty($_POST['answer']))
        {
            $this->HandleError("Answer cann't be blank! ");
            return false;
        }
		$answer=implode(",",$_POST['answer']);
		$qry="update `test_question_multiple_choice` set `question`='".$_POST['summernote']."', `choice1`='".$_POST['option_1']."', `choice2`='".$_POST['option_2']."', `choice3`='".$_POST['option_3']."', `choice4`='".$_POST['option_4']."', `choice5`='".$_POST['option_5']."', `answer`='".$answer."', `difficulty_level`='".$_POST['diff']."', `explanation`= '".$_POST['summernote1']."'  where question_id='".$_POST['question_id']."'";
                         
           if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error in Updating.. \nquery:$qry");
            return false;
        } 
		
		}
		return true;
}

/* ------------------------------------------------------------------------------------
		---------------------------Add Section To The database -------------------------------- */	
		
		function Addsection(){
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
		if(empty($_POST['sections']))
        {
            $this->HandleError("Section cann't be blank! ");
            return false;
        }
		if(empty($_POST['category']))
        {
            $this->HandleError("Category cann't be blank! ");
            return false;
        }
		$category=implode(",",$_POST['category']);
		$qry="INSERT INTO `test_section` (`section_id`, `section_name`, `category`) VALUES (NULL, '".$_POST['sections']."', '".$category."')";
                         
        if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error in Inserting Data.. \nquery:$qry");
            return false;
        } 
		else{
		$_SESSION['flagsection']=1;
		}	
		return true;
		}
		
		
		/* ------------------------------------------------------------------------------------
		---------------------------End Add Section To The database -------------------------------- */	
		
		
		/* ------------------------------------------------------------------------------------
		---------------------------End Question Add To The database -------------------------------- */	
		
		/* ------------------------------------------------------------------------------------
		---------------------------Create Test -------------------- -------------------------------- */	
		
		function Createtest(){
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
		if(empty($_POST['test_name']))
        {
            $this->HandleError("Test Name  cann't be blank! ");
            return false;
        }
		if(empty($_POST['test_name']))
        {
            $this->HandleError("Test Name  cann't be blank! ");
            return false;
        }
		if(empty($_POST['test_unique_code']))
        {
            $this->HandleError("Test Unique Code  cann't be blank! ");
            return false;
        }
		if(empty($_POST['modules']))
        {
            $this->HandleError("Sections cann't be blank! ");
            return false;
        }
		$modules=implode(",",$_POST['modules']);
		$qry="INSERT INTO `test_tests` (`test_id`, `test_name`, `sections`, `status`) VALUES ('".$_POST['test_unique_code']."', '".$_POST['test_name']."', '".$modules."', 'n')";
         $sql="select * from `test_tests` where `test_id`='".$_POST['test_unique_code']."'";  
		 $rs=mysql_query($sql);
		 $count=mysql_num_rows($rs);
		 if($count!=1){              
        if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error in Inserting Data.. \nquery:$qry");
            return false;
        }
		}else{
		$this->HandleDBError("Test Unique Id is already in the database.. \nquery:$qry");
            return false;
		}
		return true;
		}
		
		/* ------------------------------------------------------------------------------------
		---------------------------End Create Test -------------------------------- */	

/* ------------------------------------------------------------------------------------
		---------------------------Add Section To The database -------------------------------- */	
		
		function Addsectioncat(){
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
		$count=$_POST['count'];
		
		$test=$_POST['test'];
		for($i=1;$i<=$count;$i++){
		$cat=implode(",",$_POST["cat$i"]);
		$qry="INSERT INTO `test_section_category` (`id`, `test_id`, `section_name`, `category`) VALUES (NULL, '".$test."', '".$_POST["section$i"]."' , '".$cat."')";
      if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error in Inserting Data.. \nquery:$qry");
            return false;
        } 
		$this->HandleError("Database login failed!\nquery:$qry");  
		}
		
		
		//return true;
		}
		
		
		/* ------------------------------------------------------------------------------------
		---------------------------End Add Section To The database -------------------------------- */	
		
		/* ------------------------------------------------------------------------------------
		---------------------------Compose Message-------------------------------- */	
		
		function compose(){
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
        $formvars['course'] = $this->Sanitize($_POST['course']);
        $formvars['branch'] = implode(",",$_POST['branch']);
		
        $formvars['message'] = $this->Sanitize($_POST['message']);
        $formvars['yop'] = implode(",",$_POST['yop']);
		if(empty($formvars['college'])){
		 $this->HandleError("College is Empty!");
            return false;
		}
		if(empty($formvars['course'])){
		 $this->HandleError("Course is Empty!");
            return false;
		}
		if(empty($formvars['branch'])){
		 $this->HandleError("Branch is Empty! " );
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
		
		$qry="INSERT INTO `message` (`id`, `message`, `sentfrom`, `to`, `college`, `course`, `branch`, `date`) VALUES (NULL, '".$formvars['message']."', '".$formvars['from'] ."', '".$formvars['yop']."', '".$formvars['college']."', '".$formvars['course']."', '".$formvars['branch']."', CURDATE());";
		//$this->HandleDBError("Error in Inserting Data.. \nquery:$qry");
        //return false;
      if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error in Inserting Data.. \nquery:$qry");
            return false;
        } 
		return true;
		}
		
		
		/* ------------------------------------------------------------------------------------
		---------------------------End Of Compose Message-------------------------------- */	
		
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
		/*if(empty($formvars['yop'])){
		 $this->HandleError("Year Of Passing Out is Empty!");
            return false;
		}*/
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
    
	
	/* ------------------------------------------------------------------------------------
		---------------------------Add question set -------------------------------- */
		function Addquestionset(){
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
		$formvars['test'] = $this->Sanitize($_POST['test']);
		$formvars['cnt'] = $this->Sanitize($_POST['cnt']);
		$k=$formvars['cnt'];
		$section = $this->Sanitize($_POST['section'.$k]);
		$formvars['catcount'] = $this->Sanitize($_POST['catcount']);
		$mark_of_each_question = $this->Sanitize($_POST['mark_of_each_question'.$k]);
		$negative_marking_of_each_wrong_answer = $this->Sanitize($_POST['negative_marking_of_each_wrong_answer'.$k]);
		$duration = $this->Sanitize($_POST['duration'.$k]);
		for($i=1;$i<=$formvars['catcount'];$i++){
		$category = $this->Sanitize($_POST['category'.$i]);
		$mdiff1= $this->Sanitize($_POST['mdiff'.$i]);
		$measy1= $this->Sanitize($_POST['measy'.$i]);
		$mmod1= $this->Sanitize($_POST['mmod'.$i]);
		$tdiff1= $this->Sanitize($_POST['tdiff'.$i]);
		$teasy1= $this->Sanitize($_POST['teasy'.$i]);
		$tmod1= $this->Sanitize($_POST['tmods'.$i]);
		$qry="INSERT INTO `test_questionset` (`test_id`, `section`, `category`, `type`, `difficulty`, `easy`, `moderate`) VALUES ('".$formvars['test']."', '".$section ."', '".$category."', 'Multiple Choice', '".$mdiff1."', '".$measy1."', '".$mmod1."')";
		$qry1="INSERT INTO `test_questionset` (`test_id`, `section`, `category`, `type`, `difficulty`, `easy`, `moderate`) VALUES ('".$formvars['test']."', '".$section ."', '".$category."', 'True/False', '".$tdiff1."', '".$teasy1."', '".$tmod1."')";
      if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error in Inserting Data.. \nquery:$qry");
            return false;
        } 
		if(!mysql_query( $qry1 ,$this->connection))
        {
            $this->HandleDBError("Error in Inserting Data.. \nquery:$qry1");
            return false;
        } 
		}
		$qry2="INSERT INTO `test_section_setting` (`test_id`, `section`, `eachquestionmark`, `eachwronganswer`, `time`) VALUES ('".$formvars['test']."', '".$section ."', '".$mark_of_each_question."', '".$negative_marking_of_each_wrong_answer."', '".$duration."')";
		if(!mysql_query( $qry2 ,$this->connection))
        {
            $this->HandleDBError("Error in Inserting Data.. \nquery:$qry2");
            return false;
        } 
        // $this->HandleError("Database login failed!\nerror:$category");
        return true;
		}	

/* ------------------------------------------------------------------------------------
		---------------------------End Add question set -------------------------------- */	
		
		
			/* ------------------------------------------------------------------------------------
		---------------------------test activation-------------------------------- */	
    
	   function testsetting(){
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
		$formvars['test'] = $this->Sanitize($_POST['test']);
		$formvars['college'] = $this->Sanitize($_POST['college']);
		$formvars['shortname'] = $this->Sanitize($_POST['shortname']);
        $formvars['yop'] = $this->Sanitize($_POST['yop']);
		$yop=str_replace('multiselect-all,','', implode(",",$formvars['yop']));
        $formvars['sdate'] = $this->Sanitize($_POST['sdate']);
        $formvars['edate'] = $this->Sanitize($_POST['edate']);
        $formvars['sectionduration'] = $this->Sanitize($_POST['sectionduration']);
		$formvars['calculator'] = $this->Sanitize($_POST['calculator']);
		$formvars['instance'] = $this->Sanitize($_POST['instance']);
		$formvars['result'] = $this->Sanitize($_POST['result']);
		$qry1="select * from `test_setting` where test_id='".$formvars['test']."'";
		$rs=mysql_query($qry1);
		$count=mysql_num_rows($rs);
		//$this->HandleError("Database login failed!\nquery:$count");
            //return false;
		if($count<='0'){
		$section=mysql_query("select * from `test_section_setting` where test_id='".$formvars['test']."' ",$this->connection);
		while($rowsection=mysql_fetch_array($section)){
		$selectcat=mysql_query("select * from `test_section_category` where test_id='".$formvars['test']."' and section_name='".$rowsection['section']."' ",$this->connection);
		if($rowscat=mysql_fetch_array($selectcat)){
		$cat1=$rowscat['category'];
		}
		$cat=explode(",",$cat1);
		foreach($cat as $cate){
		
		$totalque=mysql_query("select * from `test_questionset` where test_id='".$formvars['test']."' and section='".$rowsection['section']."' and category='".$cate."' and type='Multiple Choice'",$this->connection);
		if($rowsque=mysql_fetch_array($totalque)){
		$noque1=$rowsque['difficulty']+$rowsque['easy']+$rowsque['moderate'];
		
		}
		$totalque1=mysql_query("select * from `test_questionset` where test_id='".$formvars['test']."' and section='".$rowsection['section']."' and category='".$cate."' and type='True/False'",$this->connection);
		if($rowsque1=mysql_fetch_array($totalque1)){
		$noque2=$rowsque1['difficulty']+$rowsque1['easy']+$rowsque1['moderate'];
		}
		$noque=$noque1+$noque2;
		$sql=mysql_query("INSERT INTO `online_test` 
		(`id`, 
		`test_id`, 
		`CATEGORY`, 
		`optinal`, 
		`TOTAL_NO_QUESTION`, 
		`EACH_QUE_MARK_CORRECT`, 
		`EACH_QUE_MARK_WRONG`, 
		`test_name`, 
		`CAT_NAME`, 
		`DATE_TIME_START`, 
		`duration`, 
		`DATE`, 
		`STATUS`, 
		`MAX_DATE`) 
		VALUES 
		(NULL, 
		'".$formvars['test']."', 
		'".$rowsection['section']."', 
		'', 
		$noque, 
		'".$rowsection['eachquestionmark']."', 
		'".$rowsection['eachwronganswer']."', 
		'".$formvars['test']."', 
		'".$rowsection['section']."', 
		'".$formvars['sdate']."', 
		'".$rowsection['time']."', 
		'".$formvars['sdate']."', 
		'ACTIVE', 
		'".$formvars['edate']."');");
		
		 $sqlcat=mysql_query("select `category_id` from test_category where name='".$cate."'",$this->connection); 
		 if($rowcat=mysql_fetch_array($sqlcat)){
		 $cat_id=$rowcat['category_id'];
		 }
		$queid=mysql_query("select * from `test_question_multiple_choice` where category='".$cat_id."' and difficulty_level='easy' order by rand() Limit 0,$rowsque[easy] ",$this->connection);  
		$count=mysql_num_rows($queid);
		$queid1=mysql_query("select * from `test_question_multiple_choice` where category='".$cat_id."' and difficulty_level='difficult' order by rand() Limit 0,$rowsque[difficulty] ",$this->connection);
		$count1=mysql_num_rows($queid1);
		$queid2=mysql_query("select * from `test_question_multiple_choice` where category='".$cat_id."' and difficulty_level='modorate' order by rand() Limit 0,$rowsque[moderate] ",$this->connection);
		$count2=mysql_num_rows($queid2);
		$quid='';
		while($rowqueid=mysql_fetch_array($queid)){
		$insertqry=mysql_query("INSERT INTO `questions`
		(`id`,
		`question`,
		`subject_id`,
		`cat_id`,
		`ans1`,
		`ans2`,
		`ans3`,
		`ans4`,
		`ans5`,
		`ans6`,
		`corans`,
		`difficulty`,
		`expl`,
		`company`,
		`test`,
		`source`,
		`weight ratio`,
		`test_names`) VALUES 
		('".$rowqueid['question_id']."', '".$rowqueid['question']."', '".$rowsection['section']."',
		'".$cat_id."',
		'".$rowqueid['choice1']."',
		'".$rowqueid['choice2']."',
		'".$rowqueid['choice3']."',
		'".$rowqueid['choice4']."',
		'".$rowqueid['choice5']."', '', '".$rowqueid['answer']."', '".$rowqueid['difficulty_level']."', '".$rowqueid['explanation']."', '', '".$formvars['test']."', '', '', '')",$this->connection);
		$quid.=$rowqueid['question_id'].",";
		
		}
		
		while($rowqueid1=mysql_fetch_array($queid1)){
		$insertqry=mysql_query("INSERT INTO `questions`
		(`id`,
		`question`,
		`subject_id`,
		`cat_id`,
		`ans1`,
		`ans2`,
		`ans3`,
		`ans4`,
		`ans5`,
		`ans6`,
		`corans`,
		`difficulty`,
		`expl`,
		`company`,
		`test`,
		`source`,
		`weight ratio`,
		`test_names`) VALUES 
		('".$rowqueid1['question_id']."', '".$rowqueid1['question']."', '".$rowsection['section']."',
		'".$cat_id."',
		'".$rowqueid1['choice1']."',
		'".$rowqueid1['choice2']."',
		'".$rowqueid1['choice3']."',
		'".$rowqueid1['choice4']."',
		'".$rowqueid1['choice5']."', '', '".$rowqueid1['answer']."', '".$rowqueid1['difficulty_level']."', '".$rowqueid1['explanation']."', '', '".$formvars['test']."', '', '', '')",$this->connection);
		$quid.=$rowqueid1['question_id'].",";
		}
		while($rowqueid2=mysql_fetch_array($queid2)){
		$insertqry=mysql_query("INSERT INTO `questions`
		(`id`,
		`question`,
		`subject_id`,
		`cat_id`,
		`ans1`,
		`ans2`,
		`ans3`,
		`ans4`,
		`ans5`,
		`ans6`,
		`corans`,
		`difficulty`,
		`expl`,
		`company`,
		`test`,
		`source`,
		`weight ratio`,
		`test_names`) VALUES 
		('".$rowqueid2['question_id']."', '".$rowqueid2['question']."', '".$rowsection['section']."',
		'".$cat_id."',
		'".$rowqueid2['choice1']."',
		'".$rowqueid2['choice2']."',
		'".$rowqueid2['choice3']."',
		'".$rowqueid2['choice4']."',
		'".$rowqueid2['choice5']."', '', '".$rowqueid2['answer']."', '".$rowqueid2['difficulty_level']."', '".$rowqueid2['explanation']."', '', '".$formvars['test']."', '', '', '')",$this->connection);
		$quid.=$rowqueid2['question_id'].",";
		
		}
		
		$queid3=mysql_query("select * from `test_question_true_false` where category='".$cat_id."' and difficulty_level='easy' order by rand() Limit 0,$rowsque[easy] ",$this->connection);  
		
		$queid4=mysql_query("select * from `test_question_true_false` where category='".$cat_id."' and difficulty_level='difficult' order by rand() Limit 0,$rowsque[difficulty] ",$this->connection);
		
		$queid5=mysql_query("select * from `test_question_true_false` where category='".$cat_id."' and difficulty_level='modorate' order by rand() Limit 0,$rowsque[moderate] ",$this->connection);
		
		
		
		
		while($rowqueid3=mysql_fetch_array($queid3)){
		$insertqry=mysql_query("INSERT INTO `questions`
		(`id`,
		`question`,
		`subject_id`,
		`cat_id`,
		`ans1`,
		`ans2`,
		`ans3`,
		`ans4`,
		`ans5`,
		`ans6`,
		`corans`,
		`difficulty`,
		`expl`,
		`company`,
		`test`,
		`source`,
		`weight ratio`,
		`test_names`) VALUES 
		('".$rowqueid3['question_id']."', '".$rowqueid3['question']."', '".$rowsection['section']."',
		'".$cat_id."',
		'".$rowqueid3['choice1']."',
		'".$rowqueid3['choice2']."',
		'',
		'',
		'', '', '".$rowqueid3['answer']."', '".$rowqueid3['difficulty_level']."', '".$rowqueid3['explanation']."', '', '".$formvars['test']."', '', '', '')",$this->connection);
		$quid.=$rowqueid3['question_id'].",";
		}
		while($rowqueid4=mysql_fetch_array($queid4)){
		$insertqry=mysql_query("INSERT INTO `questions`
		(`id`,
		`question`,
		`subject_id`,
		`cat_id`,
		`ans1`,
		`ans2`,
		`ans3`,
		`ans4`,
		`ans5`,
		`ans6`,
		`corans`,
		`difficulty`,
		`expl`,
		`company`,
		`test`,
		`source`,
		`weight ratio`,
		`test_names`) VALUES 
		('".$rowqueid4['question_id']."', '".$rowqueid4['question']."', '".$rowsection['section']."',
		'".$cat_id."',
		'".$rowqueid4['choice1']."',
		'".$rowqueid4['choice2']."',
		'',
		'',
		'', '', '".$rowqueid4['answer']."', '".$rowqueid4['difficulty_level']."', '".$rowqueid4['explanation']."', '', '".$formvars['test']."', '', '', '')",$this->connection);
		$quid.=$rowqueid4['question_id'].",";
		
		}
		while($rowqueid5=mysql_fetch_array($queid5)){
		$insertqry=mysql_query("INSERT INTO `questions`
		(`id`,
		`question`,
		`subject_id`,
		`cat_id`,
		`ans1`,
		`ans2`,
		`ans3`,
		`ans4`,
		`ans5`,
		`ans6`,
		`corans`,
		`difficulty`,
		`expl`,
		`company`,
		`test`,
		`source`,
		`weight ratio`,
		`test_names`) VALUES 
		('".$rowqueid5['question_id']."', '".$rowqueid5['question']."', '".$rowsection['section']."',
		'".$cat_id."',
		'".$rowqueid5['choice1']."',
		'".$rowqueid5['choice2']."',
		'',
		'',
		'', '', '".$rowqueid5['answer']."', '".$rowqueid5['difficulty_level']."', '".$rowqueid5['explanation']."', '', '".$formvars['test']."', '', '', '')",$this->connection);
		$quid.=$rowqueid5['question_id'].",";
		
		}
		$quid1=rtrim($quid, ",");
		//$this->HandleError("This test is already activated.\n$quid1");
        //return false;
		$sqltest=mysql_query("INSERT INTO `test_question` (`id`, `test_id`, `question_id`, `c_id`) VALUES (NULL, '".$formvars['test']."',
		 '".$quid1."', '".$rowsection['section']."');",$this->connection);
		}
		 
		
		
		}
		
		$qry="INSERT INTO `test_setting` (`test_id`, `start_date`, `end_date`, `for_college`, `for_yop`, `duration`, `calculator`,`instance`, `result`) VALUES ('".$formvars['test']."', '".$formvars['sdate']."', '".$formvars['edate']."', '".$formvars['college']."', '".$yop."', '".$formvars['sectionduration']."', '".$formvars['calculator']."', '".$formvars['instance']."' , '".$formvars['result']."')";
		if(!mysql_query( $qry ,$this->connection))
        {
            $this->HandleDBError("Error in Inserting Data.. \nquery:$qry2");
            return false;
        }
		}else{
		
		$qry1222="select * from `test_setting` where test_id='".$formvars['test']."' and for_college='".$formvars['college']."'";
		$rs22=mysql_query($qry1222);
		$count122=mysql_num_rows($rs22);
		if($count122<='0'){
		$qry12222="INSERT INTO `test_setting` (`test_id`, `start_date`, `end_date`, `for_college`, `for_yop`, `duration`, `calculator`,`instance`, `result`) VALUES ('".$formvars['test']."', '".$formvars['sdate']."', '".$formvars['edate']."', '".$formvars['college']."', '".$yop."', '".$formvars['sectionduration']."', '".$formvars['calculator']."', '".$formvars['instance']."', '".$formvars['result']."')";
		if(!mysql_query( $qry12222 ,$this->connection))
        {
            $this->HandleDBError("Error in Inserting Data.. \nquery:$qry12222");
            return false;
        }}
	else{
		$this->HandleError("This test is already activated.\n");
        return false;
		}
		}
		
		
		
		//$this->HandleError("Database login failed!/nerror:$formvars[sdate]");
        //return false;
		return true;
		}
	/* ------------------------------------------------------------------------------------
		---------------------------	End of test activation-------------------------------- */


        
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