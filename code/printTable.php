<?php
$q = $_GET['q'];
if($q == "getSales"){
    getSalesLine($_GET['id']);
}else if($q == "getinfo"){
    getSalesInfo($_GET['id']);
}

function getSalesLine($id){
    include 'config.php';
    $sql = "SELECT * FROM sales_order so LEFT JOIN sales_order_line sol ON sol.so_id = sol.so_id LEFT JOIN products p ON p.prod_id = sol.prod_id WHERE unq_id = '$id'";
    $result = mysqli_query($conn, $get);
    if(mysqli_num_rows($result) > 0){
        $html = "";
        $ttl = 0;
        $dpst = 0;
        $grndTtl = 0;
        while($row = mysqli_fetch_assoc($result)){
            $due = $row['qntty'] * $row['prc'];
            $html .= "
            <tr>
                <td>".$row['qntty']."</td>
                <td>".$row['dscrptn']."<br />(".$row['prc'].")</td>
                <td>".$due."</td>
            </tr>";
        }
        echo $html;
    }
}

function getSalesInfo($id){
    include 'config.php';
    $sql = "";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) == 1){
        while($row = mysqli_fetch_assoc($result)){

        }
    }
}

?>