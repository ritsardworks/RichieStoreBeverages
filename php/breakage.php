<?php
session_start();
include 'checkUser.php';
if(isset($_GET['q']) && isset($_SESSION['u_id'])){
  $q = $_GET['q'];
}elseif (isset($_POST['viewKey']) && isset($_SESSION['u_id'])) {
  $qw = $_POST['viewKey'];
}else{
  echo ("index.html");
}
if(isset($q)){
  if($q == "getNames"){
      getNames();
  }else if($q == "getProducts"){
      getProducts();
  }else if($q == "getBreakage"){
    getBreakage();
  }
}
if(isset($qw)){
  if($qw == "newBreakage"){
    if(isset($_POST['qty']) && isset($_POST['prd_id']) && isset($_POST['type']) && isset($_POST['prf_id'])){
      $qty = test_input($_POST['qty']);
      $prd_id = test_input($_POST['prd_id']);
      $type = test_input($_POST['type']);
      $prf_id = test_input($_POST['prf_id']);
      if(is_numeric($qty) && is_numeric($prd_id) && is_numeric($prf_id)){
        newBreakage($prf_id, $prd_id, $qty, $type);
        // echo 4;
      }
      // echo 3;
    }else{
      echo 1;
    }
  }else{
    echo 0;
  }
}

function newBreakage($prof_id, $prod_id, $qty, $type){
  include 'config.php';
  $date = date("Y-m-d H:i:s");
  $sql = "INSERT INTO breakage VALUES(null, '$qty','$prod_id', '$type','$date', '$prof_id', ".$_SESSION['u_id'].")";
  if($conn -> query($sql)){
    echo "New Record Added!";
  }else{
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

function getBreakage(){
  include 'config.php';
  $sql = "SELECT b.break_id, b.qty, p.dscrptn, b.type, b.date, pr1.fname AS fn1, pr1.mname AS mn1, pr1.lname AS ln1, pr2.fname, pr2.mname, pr2.lname FROM breakage b LEFT JOIN Products p ON p.prod_id = b.prod_id LEFT JOIN profiles pr1 ON pr1.prof_id = b.break_by LEFT JOIN profiles pr2 ON pr2.prof_id = b.rec_by WHERE avail = 1";
  $result = mysqli_query($conn, $sql);
  $html = 0;
  if (mysqli_num_rows($result) > 0) {
      $html = null;
      while ($row = mysqli_fetch_assoc($result)) {
        $name1 = $row['fn1']. " ". $row['mn1']. ". ".$row['ln1'];
        $name2 = $row['fname']. " ". $row['mname']. ". ".$row['lname'];
        $html .= "<tr>
        <td>".$row['qty']."</td>
        <td>".$row['dscrptn']."</td>
        <td>".$row['type']."</td>
        <td>".$row['date']."</td>
        <td>".$name1."</td>
        <td>".$name2."</td>
        <td></td>
        </tr>";
      }
  } else {
      $html = "<tr><td class='text-center' colspan='7'>No Records Yet!</td></tr>";
  }
  echo $html;
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
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
