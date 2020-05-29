<?php
include 'checkUser.php';
if(loggedIn == false){
  header( "Refresh:5; url=index.html", true);
}
?>
