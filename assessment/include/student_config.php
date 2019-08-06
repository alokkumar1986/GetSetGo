<?PHP
require_once("fg_student.php");

$fgstudent = new FGStudent();

//Provide your site name here
$fgstudent->SetWebsiteName('www.example.com');

//Provide the email address where you want to get notifications
$fgstudent->SetAdminEmail('alokkumar.nayak2009@gmail.com');

//Provide your database login details here:
//hostname, user name, password, database name and table name
//note that the script will create the table (for example, fgusers in this case)
//by itself on submitting register.php for the first time
$fgstudent->InitDB(/*hostname*/'166.62.8.83',
                      /*username*/'indusedu',
                      /*password*/'Indus#@!123',
                      /*database name*/'indusedu',
                      /*table name*/'student_data');

//For better security. Get a random string from this link: http://tinyurl.com/randstr
// and put it here
$fgstudent->SetRandomKey('qSRcVS6DrTzrPvr');

?>