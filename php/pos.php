<?php
session_start();
$q = $_GET['q'];
if($q == 'loadProducts' && checkLog() == true){
    getProducts();
}else if($q == 'addProduct'){
    if(isset($_GET['name']) && isset($_GET['qty']) && isset($_GET['type']) && isset($_GET['dqty'])){
        checkProd($_GET['name'], $_GET['qty'], $_GET['type'], $_GET['dqty']);
    }else{
        echo 0;
    }
}else if($q == "pay"){
    $data = $_GET['data'];
    if(isset($data)){
        $arr = json_decode($data, true);
        pay($arr);
    }
    // echo $arr[0]['dscprtn'];
}else if($q == "orderNo"){
    include 'config.php';
    $sql = "SELECT unq_id FROM sales_order where so_id=(select max(so_id) from sales_order)";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) == 1){
        $id = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['unq_id'];
        }
        echo $id;
    }
    mysqli_close($conn);
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

function pay($data){
    include 'config.php';
    $ttlAmnt = 0;
    $ttlDep = 0;
    foreach($data as $row){
        $ttlAmnt += $row['prc'] * $row['qty'];
        $ttlDep += $row['depQty'] * $row['depPrice'];
    }
    $grndttl = $ttlAmnt + $ttlDep;
    $unq = date("Ymdhis");
    $sql = "INSERT INTO Sales_Order VALUES (null, '" . date("Y-m-d H:i:s") . "', '$ttlAmnt', '$ttlDep', '$grndttl', '".$_SESSION["u_id"]."', '" .$unq ."' ,0)";
    if($conn -> query($sql)){
        $last_id = $conn->insert_id;
        foreach ($data as $row) {
            $sel = "SELECT p.prod_id, qtty, rm_btl, rm_shll, rm_cs FROM products p LEFT JOIN inventory i ON i.prod_id = p.prod_id WHERE p.dscrptn = '".$row['dscprtn']."'";
            $result = mysqli_query($conn, $sel);
            if(mysqli_num_rows($result) == 1){
                while ($id = mysqli_fetch_assoc($result)) {
                    $ins = "INSERT INTO Sales_order_line VALUES(null,'" . $row['qty'] . "', '" . $row['prc'] . "', '" . $row['depType'] . "','".$id['prod_id']."', '$last_id',0, ".$row['depQty'].", '".$row['depPrice']."')";
                    if ($conn->query($ins)) {
                        $left = $id['qtty'] - $row['qty'];
                        $upd = "UPDATE inventory SET qtty = $left ";
                        if($row['depType'] == "Bottle"){
                            $rm_btl = $id['qtty'] + $row['qty'];
                            $upd .= ",rm_btl = $rm_btl";
                        }else if($row['depType'] == "Case"){
                            $rm_cs = $id['qtty'] + $row['qty'];
                            $upd .= ",rm_cs = $rm_cs";
                        } else if ($row['depType'] == "Shell") {
                            $rm_shll = $id['qtty'] + $row['qty'];
                            $upd .= ",rm_shll = $rm_shll";
                        }
                        $upd .= " WHERE prod_id = ".$id['prod_id']."";
                        if($conn->query($upd) == TRUE){
                            echo 1;
                        }
                    }
                    else{
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
            }else{
                echo "Too Many Products";
            }
        }
    }else{
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

function checkProd($prod, $qty, $type, $dq){
    include 'config.php';
    $sql = "SELECT * FROM products p LEFT JOIN inventory i ON i.prod_id = p.prod_id WHERE avail = 1 AND dscrptn = '$prod'";
    $result = mysqli_query($conn, $sql);
    $html = 0;
    $offset = 0;
    if(mysqli_num_rows($result) == 1){
        $html = "<tr>";
        while($row = mysqli_fetch_assoc($result)){
            if($row['qtty']-$qty >= 0){
                $amnt = $qty * $row['rtl_prc'];
                $ttlDep = 0;
                $depPrc = 0;
                if($type == "Bottle"){
                    $ttlDep = $row['BTL_empty_prc'] * $dq;
                    $depPrc = $row['BTL_empty_prc'];
                }elseif ($type == "Case") {
                    $ttlDep = $row['CASE_empty_prc'] * $dq;
                    $depPrc = $row['CASE_empty_prc'];
                }else if($type == "Shell"){
                    $ttlDep = $row['SHELL_empty_prc'] * $dq;
                    $depPrc = $row['SHELL_empty_prc'];
                }else{
                    $ttlDep = 0;
                }
                $amnt += $ttlDep;
                $html .= "
                    <td><input class='form-control btnSelect' type='number' value='" . $qty . "' onchange='setValue(this)'></td>
                    <td>" . $row['dscrptn'] . "</td>
                    <td>" . $row['rtl_prc'] . "</td>
                    <td>".$type. "</td>
                    <td>" . $dq . "</td>
                    <td>" . $depPrc . "</td>
                    <td>" . $amnt . "</td>
                    <td><button onCLick='remove(this)' class='btn btn-danger'><i class='fas fa-trash'></i></button></td>";
                $offset++;
            }else{
                $rem = $row['qtty'];
                echo "ERROR: Remaining Products of ". $prod . " is: ". $rem;
            }

        }
        $html .= "</tr>";
        if($offset > 0){
            echo $html;
        }
    }else{
        echo 0;
    }

}


function getProducts(){
    include 'config.php';
    $sql = "SELECT * FROM products p LEFT JOIN inventory i ON i.prod_id = p.prod_id WHERE i.qtty <> 0 AND avail = 1";
    $result = mysqli_query($conn, $sql);
    $html = '<option>No Products Available</option>';
    if(mysqli_num_rows($result) > 0){
        $html = "";
        while($row = mysqli_fetch_assoc($result)){
            $html .= '<option value="'.$row['dscrptn'].'">';
        }
    }
    echo $html;
    mysqli_close($conn);
}
?>
