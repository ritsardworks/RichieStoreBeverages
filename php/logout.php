<?php
    session_start();
    unset($_SESSION['u_id']);
    session_destroy();
    echo 1;
?>