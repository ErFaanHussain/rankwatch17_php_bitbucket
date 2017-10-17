<?php
include('includes/core.inc.php');
if(loggedIn){
  session_destroy();
  header('Location:index.php');
}
else{
  header('Location:index.php');
}

 ?>
