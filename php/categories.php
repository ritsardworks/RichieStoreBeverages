<?php
session_start();
$q = $_GET['q'];
if($q == "new"){
    if(isset($_GET['data'])){
        addCategory($_GET['data']);
    }
}else if($q == "refresh"){
    getCategories();
}

function addCategory($name){
    include 'config.php';
    $genId = uniqid();
    $sql = "INSERT INTO categories VALUES ('$genId', '$name')";
    if ($conn->query($sql) === TRUE) {
        echo 1;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;;
    }
}

function addToCategory($cat_id, $prod_id){
    include 'config.php';
    $sql = "INSERT INTO category_line VALUES(null, '$prod_id', '$cat_id', ".$_SESSION['u_id'].")";
    if ($conn->query($sql) === TRUE) {
        echo $sql;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;;
    }
}

function getCategories(){
    include 'config.php';
    $sql = "SELECT * FROM categories";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $html = "<table>";
        while ($row = mysqli_fetch_assoc($result)) {
            //need Code here
            $html .= "<tr>
            <td>".$row['name']."</td>
            <td><button value='".$row['cat_id']."' onClick='viewCategory(this)'>View</button></td>
            </tr>";
        }
        $html .= "</table>";
        echo $html;
    }else{
        echo "No Categories Yet!";
    }
}
?>