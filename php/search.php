<?php
$q = $_GET['q'];
if($q == "searchProd"){
    showProducts($_GET['data']);
}else if($q == 'searchOrder'){
    searchOrder($_GET['data']);
}

function searchOrder($name){
    include 'config.php';
    $sql = "SELECT * FROM sales_order WHERE unq_id LIKE '%$name%' ORDER BY date DESC";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $html = "";
        while ($row = mysqli_fetch_assoc($result)) {
            $html .= '<tr>';
            $html .= "
            <td>" . $row['unq_id'] . "</td>
            <td>" . $row['date'] . "</td>
            <td>" . $row['ttl_amnt'] . "</td>
            <td>" . $row['ttl_dpst'] . "</td>
            <td>" . $row['grndttl'] . "</td>
            ";
            $getName = "SELECT fname, mname, lname FROM profiles WHERE prof_id = '" . $row['prof_id'] . "'";
            $resultName = mysqli_query($conn, $getName);
            if (mysqli_num_rows($resultName) == 1) {
                while ($rowName = mysqli_fetch_assoc($resultName)) {
                    $html .= "<td>" . $rowName['fname'] . " " . $rowName['mname'][0] . ". " . $rowName['lname'] . "</td>";
                }
            } else {
                $html .= "<td></td>";
            }
            $html .= "
            <td>
                <button class='btn btn-warning' value='" . $row['unq_id'] . "' onclick='viewSale(this)'><i class='fa fa-eye' aria-hidden='true'></i></button>
            </td>";
            $html .= '</tr>';
        }
        echo $html;
    } else {
        echo "<tr>
                <td colspan='7' class='text-center'>No Products Found!</td>
            </tr>";
    }
}

function showProducts($name)
{
    include 'config.php';
    $sql = "SELECT * FROM products pr LEFT JOIN profiles ps ON ps.prof_id = pr.prof_id LEFT JOIN inventory i ON i.prod_id = pr.prod_id WHERE avail = 1 AND dscrptn LIKE '%$name%'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $table = "<table class='table table-striped table-bordered'>
                    <thead class='thead-dark'>
                        <th>Description</th>
                        <th>Retail Price</th>
                        <th>Deposit Per Bottle</th>
                        <th>Deposit Per Case</th>
                        <th>Deposit Per Shell</th>
                        <th>Added By</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </thead>
                    <tbody id='prodTable'>";
        while ($row = mysqli_fetch_assoc($result)) {
            $table = $table .
                '<tr>'
                . '<td clsas="label">' . $row['dscrptn'] . '</td>'
                . '<td clsas="label">' . $row['rtl_prc'] . '</td>'
                . '<td clsas="label">' . $row['BTL_empty_prc'] . '</td>'
                . '<td clsas="label">' . $row['CASE_empty_prc'] . '</td>'
                . '<td clsas="label">' . $row['SHELL_empty_prc'] . '</td>'
                . '<td clsas="label">' . $row['fname'] . " " . $row['lname'] . '</td>';
            if ($row['qtty'] < 15 && $row['qtty'] > 0) {
                $table .= '<td class="text-warning">' . $row['qtty'] . '</td>';
            } else if ($row['qtty'] == 0) {
                $table .= '<td class="text-danger">' . $row['qtty'] . '</td>';
            } else {
                $table .= '<td class="text-success">' . $row['qtty'] . '</td>';
            }
            $table .= '<td>
            <button class="btn btn-warning " value=' . $row["prod_id"] . ' onclick="showLogProd(this)"><i class="fa fa-eye" aria-hidden="true"></i></button> 
            <button class="btn btn-info " value=' . $row["prod_id"] . ' onclick="updateProd(this)"><i class="fa fa-list-alt" aria-hidden="true"></i></button>
            <button class="btn btn-danger " value=' . $row["prod_id"] . ' onclick="deleteProd(this)"><i class="fa fa-trash" aria-hidden="true"></i></button>
            </td>
            </tr>';
        }
        $table = $table . "</tbody></table>";
        echo $table;
    } else {
        $table = "<table class='table table-striped table-bordered'>
                    <thead class='thead-dark'>
                        <th>Description</th>
                        <th>Retail Price</th>
                        <th>Deposit Per Bottle</th>
                        <th>Deposit Per Case</th>
                        <th>Deposit Per Shell</th>
                        <th>Added By</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </thead>
                    <tbody id='prodTable'>
                        <tr>
                            <td colspan='8' class='text-center'>No Products Found!</td>
                        </tr>
                    </tbody>
                    </table>";
        echo $table;
    }
    mysqli_close($conn);
}
?>