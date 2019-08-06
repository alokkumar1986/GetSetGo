<?Php

$username="root";
$password="";
$hostname="localhost";
$dbhandel=mysql_connect($hostname,$username,$password) or die("unable to connect to mysql");
$selected=mysql_select_db("assessmenttest",$dbhandel)
or die("unable to connect to database");
?>