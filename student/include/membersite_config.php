<?PHP 
    define('ENVIRONMENT', "local");
    define('FORCED_DEBUG', 1);
    define('AUDIT_TRAIL', 1);
require_once("fg_membersite.php");

$fgmembersite = new FGMembersite();

//Provide your site name here
$fgmembersite->SetWebsiteName('www.induseducation.in');

//Provide the email address where you want to get notifications
$fgmembersite->SetAdminEmail('alokkumar.nayak2009@gmail.com');

//Provide your database login details here:
//hostname, user name, password, database name and table name
//note that the script will create the table (for example, fgusers in this case)
//by itself on submitting register.php for the first time
// $fgmembersite->InitDB(/*hostname*/'166.62.8.83',
//                       /*username*/'indusedu',
//                       password'Indus#@!123',
//                       /*database name*/'indusedu',
//                       /*table name*/'student_data');

$fgmembersite->InitDB(/*hostname*/'localhost',
                      /*username*/'root',
                      /*password*/'',
                      /*database name*/'indusedu_webcms',
                      /*table name*/'student_data');


//For better security. Get a random string from this link: http://tinyurl.com/randstr
// and put it here
$fgmembersite->SetRandomKey('0909qSRcVS6DrTzrPvr');

?>