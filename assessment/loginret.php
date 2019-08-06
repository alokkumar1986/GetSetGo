<?php 
//session_start();
//error_reporting(E_ALL ^ E_NOTICE);
 
   // $reg = $_REQUEST['reg'];
   //$ip=$_SERVER['REMOTE_ADDR']; 
   
   //if(isset($_POST["submit"]))
		// {
	include"config.php";
		 $username=$_POST["username"];
		 $password =$_POST["password "];
			  
		 $qry=mysql_query("select username,password  from facultytab where username='$username' && password='$password'");
		 $a=mysql_fetch_array($qry);
		 
		 // if($a)
		 //{
		 
		 header("location:admin.php");
		 //}
		 //else
		 //{
		 //alert("error");
		 //}
		// }
		
		 ?>
   
   
	