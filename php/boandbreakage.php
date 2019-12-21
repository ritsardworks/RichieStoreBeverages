<?php
    $q = $_GET['q'];
    if($q == "showBreakage"){
        viewBreak();
    }

    function viewBreak(){
        $sql = "SELECT * FROM breakage";
    }
?>