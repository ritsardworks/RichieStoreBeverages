<?php

session_start();
$q = $_GET['q'];
if($q == "getSales" && checkLog() == true){
    sales();
}else if($q=='setId'){
    // salesLine($_GET['id']);
    $_SESSION['o_id'] = $_GET['id'];
    if(isset($_SESSION['o_id'])){
        echo 1;
    }else{ echo 0;}
}else if($q == "getLine" && isset($_SESSION['o_id']) && checkLog() == true){
    salesLine($_SESSION['o_id']);
}else if($q == "refund"){
    refundItem($_GET['id'], $_POST['qty']);
}else{
    echo "index.html";
}

function checkLog()
{
    if (isset($_SESSION['u_id'])) {
        return true;
    } else {
        return false;
    }
}

function refundItem($id,$qty){
    include 'config.php';
    $get = "SELECT * FROM sales_order_line sol LEFT JOIN sales_order so ON so.so_id = sol.so_id LEFT JOIN inventory i ON i.prod_id = sol.prod_id WHERE sol_id = $id";
    $result = mysqli_query($conn, $get);
    if(mysqli_num_rows($result) == 1){
        while($row = mysqli_fetch_assoc($result)){
            $dpst = $row['ttl_dpst'] - ($row['depqty'] * $row['depprc']);
            $rem = $row['qntty'] - $qty;
            if($rem == 0){
              $stat = 1;
            }else{
              $stat = 0;
            }
            $updQty = $row['qtty'] + $qty;
            $updItems = "UPDATE inventory SET qtty = $updQty WHERE inv_id = ".$row['inv_id']."";
            if($conn->query($updItems)){
              $date = date("Y-m-d H:i:s");
              $ref = "INSERT INTO refunds VALUES(null, '$date', '$qty', '$id', '".$_SESSION['u_id']."')";
              if($conn->query($ref)){
                $upd = "UPDATE sales_order_line SET refund = $stat, qntty = $rem WHERE sol_id = $id";
                if ($conn->query($upd) === TRUE) {
                    $updDpst = "UPDATE sales_order SET ttl_dpst = $dpst WHERE so_id = ".$row['so_id']."";
                    if ($conn->query($updDpst) === TRUE) {
                        $updInv = "UPDATE inventory SET ";
                        if($row['dpst'] == "Bottle"){
                            $updInv .= "rm_btl = " . ($row['rm_btl'] - $row['depqty']);
                        } else if ($row['dpst'] == "Case") {
                            $updInv .= "rm_cs = " . ($row['rm_cs'] - $row['depqty']);
                        } else if ($row['dpst'] == "Shell") {
                            $updInv .= "rm_shll = " . ($row['rm_shll'] - $row['depqty']);
                        }
                        $updInv .= " WHERE inv_id = ". $row['inv_id'];
                        if ($conn->query($updDpst) === TRUE) {
                            echo 1;
                        } else {
                            echo "Error: " . $updDpst . "<br>" . $conn->error;
                        }
                    }else{
                        echo "Error: " . $updDpst . "<br>" . $conn->error;
                    }
                } else {
                    echo "Error: " . $upd . "<br>" . $conn->error;
                }
              }else{
                echo "Error: " . $upd . "<br>" . $conn->error;
              }
            }else{
              echo "Error: " . $upd . "<br>" . $conn->error;
            }
        }
    }else{
        echo "Too Many Products!";
    }
}

function salesLine($o_id){
    include 'config.php';
    $sql = "SELECT * FROM sales_order_line sol LEFT JOIN sales_order so ON sol.so_id = so.so_id LEFT JOIN products p ON p.prod_id = sol.prod_id WHERE so.unq_id = '$o_id'";
    $_id = $o_id;
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $html = "
        <div class='row'>
            <div class='col-6'>
                <h1>Order No:<span class='text-success'>".$_id."</span></h1>
            </div>
            <div class='col-6 text-right'>
                <button class='btn btn-secondary' onclick='printLine($o_id)'><i class='fa fa-print' aria-hidden='true'></i> Print</button>
            </div>
        </div>
        <table class='table table-striped table-bordered'>
            <thead class='thead-dark'>
                <tr>
                    <th>Qty.</th>
                    <th>Item Description</th>
                    <th>Retail Price</th>
                    <th>Deposit</th>
                    <th>Total Deposit</th>
                    <th>Due</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id='bodyProducts'>";
        while ($row = mysqli_fetch_assoc($result)) {
            $html .= "<tr>";
            $da = $row['prc'] * $row['qntty'] + $row['depqty'] * $row['depprc'];
            $html .= "
            <td>".$row['qntty']."</td>
            <td>".$row['dscrptn']."</td>
            <td>".$row['prc']."</td>
            <td>".$row['dpst']. "/". $row['depqty']."/". $row['depprc']."</td>
            <td>".$row['depqty'] * $row['depprc']."</td>
            <td>".$da."</td>
            ";
            if($row['refund'] == 0 && $row['dpst'] != "N/A"){
                // $html .= "<td><button class='btn btn-danger' value='" . $row['sol_id'] . "' onclick='refund(this)'>Refund</button></td>";
                $html .= "<td><button type='button' class='btn btn-warning' data-toggle='modal' data-target='#exampleModalCenter' value='".$row['sol_id']."+".$row['qntty']."' onclick='refundThis(this.value)'>
                  Refund
                </button></td>";
            }else if($row['refund'] == 1){
                $html .= "<td><span class='text-success'>REFUNDED!</span></td>";
            }else{
                $html .= "<td></td>";
            }
            $html .= "</tr>";
        }
        $html .= "</tbody></table>";
        echo $html;
    }else{
        echo "< class='text-center'>No Items To Show!</>";
    }
}
function sales(){
    include 'config.php';
    $sql = "SELECT * FROM sales_order ORDER BY date DESC";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $html = "";
        while($row = mysqli_fetch_assoc($result)){
            $o_id = $row['unq_id'];
            $html .= '<tr>';
            $html .= "
            <td>".$row['unq_id']. "</td>
            <td>" . $row['date'] . "</td>
            <td>" . $row['ttl_amnt'] . "</td>
            <td>" . $row['ttl_dpst'] . "</td>
            <td>" . $row['grndttl'] . "</td>
            ";
            $getName = "SELECT fname, mname, lname FROM profiles WHERE prof_id = '".$row['prof_id']."'";
            $resultName = mysqli_query($conn, $getName);
            if (mysqli_num_rows($resultName) == 1) {
                while ($rowName = mysqli_fetch_assoc($resultName)) {
                $html .= "<td>" . $rowName['fname'] . " " . $rowName['mname'][0] . ". " . $rowName['lname'] . "</td>";
                }
            }else{
                $html .= "<td></td>";
            }
            $html .= "
            <td>
                <button class='btn btn-warning' value='".$row['unq_id']."' onclick='viewSale(this)'><i class='fa fa-eye' aria-hidden='true'></i></button>
                <button class='btn btn-secondary' onclick='printLine($o_id)'><i class='fa fa-print' aria-hidden='true'></i></button>
            </td>";
            $html .= '</tr>';
        }
        echo $html;
    }else{
        echo "<tr><td colspan='7' class='text-center'>No Sales Yet!</td></tr>";
    }
}
?>
