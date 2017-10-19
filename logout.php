<?php
include('includes/core.inc.php');
if(loggedIn){
  session_destroy();
  header('Location:index.php');
  // destroy session and redirect user back to login page
}
else{
  header('Location:index.php');
}

 ?>
