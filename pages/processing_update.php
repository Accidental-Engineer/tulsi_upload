<?php
session_start();
if (isset($_SESSION['progress_percent'])) {
   $progress_JSON = '{"progress" : '.$_SESSION['progress_percent'].'}';
   echo $progress_JSON;
   if ($_SESSION['progress_percent'] == 100 ) {
     $_SESSION['progress_percent'] = 0;
   }
   else if ($_SESSION['progress_percent'] == 99 ) {
     $_SESSION['progress_percent'] = 100;
   }
}


?>
