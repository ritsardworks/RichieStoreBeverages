<?php
session_start();
$q = $_POST['q'];
if($q == "loadProducts"){
  getProducts();
}elseif ($q == "getProduct") {
  getIndProd($_POST['id']);
}elseif ($q == "gtBtl") {
  // code...
  getDetails($_POST['id'], 1);
}elseif ($q == "gtCs") {
  // code...
  getDetails($_POST['id'], 2);
}elseif ($q == "gtShll") {
  // code...
  getDetails($_POST['id'], 3);
}
function getIndProd($id){
  include '../php/config.php';
  $sql = "SELECT * FROM products p LEFT JOIN inventory i ON i.prod_id = p.prod_id WHERE p.prod_id = $id";
  $result = mysqli_query($conn, $sql);
  if(mysqli_num_rows($result) == 1){
    while($row = mysqli_fetch_assoc($result)){
      echo $row['qtty'];
    }
  }
  mysqli_close($conn);
}
function getDetails($id, $offSet){
  include '../php/config.php';
  $sql = "SELECT * FROM products p LEFT JOIN inventory i ON i.prod_id = p.prod_id WHERE p.prod_id = $id";
  $result = mysqli_query($conn, $sql);
  if(mysqli_num_rows($result) == 1){
    while($row = mysqli_fetch_assoc($result)){
      if($offSet == 1){
        echo $row['BTL_empty_prc'];
      }
      elseif ($offSet == 2) {
        // code...
        echo $row['CASE_empty_prc'];
      }elseif ($offSet == 3) {
        // code...
        echo $row['SHELL_empty_prc'];
      }
    }
  }
  mysqli_close($conn);
}
function getProducts(){
  include '../php/config.php';
  $sql = "SELECT * FROM products p LEFT JOIN inventory i ON i.prod_id = p.prod_id WHERE i.qtty <> 0 AND avail = 1";
  $result = mysqli_query($conn, $sql);
  $html = '<option>No Products Available</option>';
  if(mysqli_num_rows($result) > 0){
      $html = "";
      $offSet = 0;
      $html .="<tr>";
      while($row = mysqli_fetch_assoc($result)){
        if($offSet % 3 == 0){
          $html .= "</tr><tr>";
        }
        $html .= '<td><button type="button" name="button" class="btn btn-outline-dark btn-lg btn-block btnprod" style="height: 150px;" onclick="addToTicket(this)" value='.$row['prod_id'].'>'.$row['dscrptn'].'<br />(₱'.$row['rtl_prc'].')</button></td>';
        $offSet++;
      }
      $html .="</tr>";
  }
  echo $html;
  mysqli_close($conn);
}
?>
