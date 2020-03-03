<?php
$q = $_POST['item'];
if($q == "Sales"){
  echo getSales();
}

function getSales(){
  include '../php/sales.php';
  $html = "<table class='table table-striped table-bordered'>
      <thead class='thead-dark'>
          <tr>
              <th>Order #</th>
              <th>Order Date</th>
              <th>Total</th>
              <th>Returnables</th>
              <th>Refunded</th>
              <th>Due Amount</th>
              <th>Sold By</th>
              <th></th>
          </tr>
      </thead>
      <tbody id='bodyProducts'>".sales()."
      </tbody>
  </table>";
  return $html;
}
?>
