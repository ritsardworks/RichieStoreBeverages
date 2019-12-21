<?php
    function loggedIn(){
        if(isset($_SESSION['u_id'])){
            return true;
        }else{
            return false;
        }
    }
?>