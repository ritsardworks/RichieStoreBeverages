<?php
session_start();
$q = $_GET['q'];
if($q == "getNames"){
    getNames();
}else if($q == "getProducts"){
    getProducts();
}
function getProducts(){
    include 'config.php';
    $sql = "SELECT * FROM products WHERE avail = 1";
    $result = mysqli_query($conn, $sql);
    $html = 0;
    if (mysqli_num_rows($result) > 0) {
        $html = null;
        while ($row = mysqli_fetch_assoc($result)) {
            $html .= "<option value='" . $row['prod_id'] . "'>" . $row['dscrptn'] . "</option>";
        }
    } else {
        $html = 1;
    }
    echo $html;
}

function getNames(){
    include 'config.php';
    $sql = "SELECT * FROM profiles";
    $result = mysqli_query($conn, $sql);
    $html = 0;
    if(mysqli_num_rows($result) > 0){
        $html = null;
        while ($row = mysqli_fetch_assoc($result)) {
            $html .= "<option value='" . $row['prof_id'] ."'>".$row['fname'] . " ." . $row['mname'][0] . " " . $row['lname']."</option>";
        }
    }else{
        $html = 1;
    }
    echo $html;
}
?>