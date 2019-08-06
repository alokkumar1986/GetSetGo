<?php
//logout.php
session_start();
setcookie("username", $username, time()-7600);
session_destroy();
header("location: ../index.html");
?>