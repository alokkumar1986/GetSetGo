<?php
 
// See if the HTTP request has set $count as the 
// result of a Cookie called "count"
if(!isset($count)) {
  // No cookie called count, set the counter to zero  
  $count = 0;
 
  // .. and set a cookie with the "start" time
  // of this stateful interaction
  $start = time(  );
  setcookie("start", $start, time(  )+600, "/", "", 0);
 
} else {
    $count++;
}
 
// Set a cookie "count" with the current value
setcookie("count", $count, time(  )+600, "/", "", 0);
 
?>
<!DOCTYPE HTML PUBLIC 
   "-//W3C//DTD HTML 4.0 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd" >
<html>
  <head><title>Cookies</title></head>
  <body>
    <p>This page comes with cookies: Enjoy! 
    <br>count = <?=$count ?>.
    <br>start = <?=$start ?>.
    <p>This session has lasted 
      <?php 
        $duration = time(  ) - $start; 
	echo "$duration"; 
      ?> 
      seconds.
  </body>
</html>