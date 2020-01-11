<?php
session_start();
include 'checkUser.php';
$q = $_GET['q'];
if($q == 'login'){
    login();
}
else if($q == 'regUser' && isset($_SESSION['u_id'])){
    addUser();
}else if($q == 'users' && checkLog() == true){
    $log = loggedIn();
    if($log == true){
        showUser();
    }else{
        header("Location: index.php");
    }
}else if($q == 'getUser' && checkLog() == true){
    getUser();
}else if($q == 'newProduct' && checkLog() == true){
    newProductEntry();
}else if($q == 'getProducts' && checkLog() == true){
    $log = loggedIn();
    if ($log == true) {
        showProducts();
    } else {
        header("Location: index.html");
    }
}else if ($q == "showProduct" && checkLog() == true) {
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        getProduct($id);
    }else{
        echo 0;
    }
}else if($q == "stock" && checkLog() == true){
    if(isset($_SESSION['prod_id'])){
        getStock($_SESSION['prod_id']);
    }
}else if($q == "newStock" && checkLog() == true){
    if(is_numeric($_GET['stock']) && is_numeric($_GET['prc'])&& is_numeric($_GET['btlRl'])&& is_numeric($_GET['shRl'])&& is_numeric($_GET['crRl'])){
        newStock($_GET['stock'], $_GET['prc'], $_GET['btlRl'], $_GET['shRl'], $_GET['crRl']);
    }else{
        echo 0;
    }
}else if($q == "updProd" && checkLog() == true){
    updateProduct($_GET['id']);
}else if($q == "deleteProd"){
    deleteProduct($_GET['id']);
}
else{
    echo ("index.html");
}

function checkLog(){
    if(isset($_SESSION['u_id'])){
        return true;
    }else{
        return false;
    }
}
// Update Inventory Bottle, Shell and Case Empties
function newStock($stock, $prc, $btRl, $shRl, $crRl ){
    include 'config.php';
    $sql = "INSERT INTO stock_in_line VALUES (null, '$stock', '$prc', ".$_SESSION['prod_id'].", '".date("Y-m-d H:i:s")."', ".$_SESSION['u_id'].", '$btRl', '$shRl', '$crRl')";
    if ($conn->query($sql) === TRUE) {
        $sql = "SELECT qtty, rm_btl, rm_shll, rm_cs FROM inventory WHERE prod_id = ".$_SESSION['prod_id']."";
        $new = 0;
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) == 1) {
            while ($row = mysqli_fetch_assoc($result)) {
                $new = $row['qtty'] + $stock;
                $newbtl = $row['rm_btl'] - $btRl;
                $newSh = $row['rm_shll'] - $shRl;
                $newCs = $row['rm_cs'] - $crRl;
                // Update Invenotry nalang with three new values for remains
            }
        }else{
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        if($new != 0){
            $sql = "UPDATE inventory SET qtty = $new, rm_btl = $newbtl, rm_shll = $newSh, rm_cs = $newCs WHERE prod_id = ".$_SESSION['prod_id']."";
            if ($conn->query($sql) === TRUE) {
                echo 1;
            }else{
                echo "Failed to Update Inventory.";
            }
        }else{
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }else{
        echo 0;
    }
    mysqli_close($conn);
    $sql = "INSERT INTO stock_in_line VALUES (null, '$stock', '$prc', ".$_SESSION['prod_id'].", '".date("Y-m-d H:i:s")."', ".$_SESSION['u_id'].")";
}

function getStock($id){
    include 'config.php';
    $html = 0;
    $sql = "SELECT * FROM products p LEFT JOIN inventory i ON i.prod_id = p.prod_id WHERE p.prod_id = $id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $html = "<div><h1>".$row['dscrptn']."</h1></div>
            <div><h2>Current Stock: ";
            if ($row['qtty'] < 15 && $row['qtty'] > 0) {
                $html .= '<span class="text-warning">' . $row['qtty'] . '</span>';
            } else if ($row['qtty'] == 0) {
                $html .= '<span class="text-danger">' . $row['qtty'] . '</span>';
            } else {
                $html .= '<span class="text-success">' . $row['qtty'] . '</span>';
            }
            $html .= "</h2></div>";
        }
    }
    $sql = "SELECT * FROM stock_in_line sil LEFT JOIN profiles p ON p.prof_id = sil.prof_id WHERE sil.prod_id = $id ORDER BY date DESC";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        $html = $html . "<table class='table table-striped table-bordered'>
                <thead class='thead-dark'>
            <th>Quantity</th>
            <th>Date Added</th>
            <th>Unit Price</th>
            <th>Empty Bottles</th>
            <th>Empty Shells</th>
            <th>Empty Case</th>
            <th>Added By</th>
        </thead>";
        while($row = mysqli_fetch_assoc($result)){
            $html = $html . "<tr>
            <td>".$row['qntty']."</td>
            <td>".$row['date']. "</td>
            <td>₱".$row['unt_prc']. "</td>
            <td>".$row['btl_rls']. "</td>
            <td>".$row['shll_rls']. "</td>
            <td>".$row['cs_rls']. "</td>
            <td>".$row['fname']." ".$row['mname'][0].". ".$row['lname']."</td>
            </tr>";
        }
        $html = $html . "</table>";
    }else{
        $html = $html . "<p><h3>No Stock In Record</h3></p>";
    }
    echo $html;
    mysqli_close($conn);
}

function deleteProduct($id){
    include 'config.php';
    $sql = "UPDATE products SET avail = 0 WHERE prod_id = $id";
    if ($conn->query($sql) === TRUE) {
        echo 1;
    } else {
        echo "Failed to Delete The Product!.";
    }
}

function getProduct($id){
    include 'config.php';
    if(is_numeric($id)){
        $sql = "SELECT * FROM products WHERE prod_id = $id";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) == 1){
            while ($row = mysqli_fetch_assoc($result)) {
                $_SESSION['prod_id'] = $row['prod_id'];
            }
            echo 1;
        }
        mysqli_close($conn);
    }else{
        echo 0;
    }

}

function updateProduct($id){
    include 'config.php';
    $desc = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['desc']));
    $rtl = htmlspecialchars(properString(mysqli_real_escape_string($conn, $_POST['rtl'])));
    $btl = htmlspecialchars(properString(mysqli_real_escape_string($conn, $_POST['btl'])));
    $cs = htmlspecialchars(properString(mysqli_real_escape_string($conn, $_POST['cs'])));
    $sh = htmlspecialchars(properString(mysqli_real_escape_string($conn, $_POST['sh'])));
    $sql = "UPDATE products SET dscrptn = '$desc', rtl_prc = '$rtl', BTL_empty_prc = '$btl', CASE_empty_prc = '$cs', SHELL_empty_prc = '$sh' WHERE prod_id = $id";
    if ($conn->query($sql) === TRUE) {
        echo 1;
    } else {
        echo "Failed to Update The Product!.";
    }
}

function showProducts(){
    include 'config.php';
    $sql = "SELECT * FROM products pr LEFT JOIN profiles ps ON ps.prof_id = pr.prof_id LEFT JOIN inventory i ON i.prod_id = pr.prod_id WHERE avail = 1";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $table = "<table class='table table-striped table-bordered'>
                    <thead class='thead-dark'>
                        <th>Description</th>
                        <th>Retail Price</th>
                        <th>Deposit Per Bottle</th>
                        <th>Deposit Per Case</th>
                        <th>Deposit Per Shell</th>
                        <th>Stock <br />/Bottles <br />/Shells <br />/Case</th>
                        <th>Action</th>
                    </thead>
                    <tbody id='prodTable'>";
        while($row = mysqli_fetch_assoc($result)) {
            $table = $table.
            '<tr>'
            .'<td clsas="label">'.$row['dscrptn'].'</td>'
            .'<td clsas="label">₱'.$row['rtl_prc'].'</td>'
            .'<td clsas="label">₱'.$row['BTL_empty_prc'].'</td>'
            .'<td clsas="label">₱'.$row['CASE_empty_prc'].'</td>'
            .'<td clsas="label">₱'.$row['SHELL_empty_prc'].'</td>';
            // .'<td clsas="label">'.$row['fname']." ". $row['lname'].'</td>'
            if($row['qtty'] < 15 && $row['qtty'] > 0){
                $table .= '<td><span class="text-warning">' . $row['qtty'] . '</span>/'.$row['rm_btl'].'/'.$row['rm_shll'].'/'.$row['rm_cs'].'</td>';
            }else if ($row['qtty'] == 0) {
                $table .= '<td><span class="text-danger">' . $row['qtty'] . '</span>/'.$row['rm_btl'].'/'.$row['rm_shll'].'/'.$row['rm_cs'].'</td>';
            }else{
                $table .= '<td><span class="text-success">' . $row['qtty'] . '</span>/'.$row['rm_btl'].'/'.$row['rm_shll'].'/'.$row['rm_cs'].'</td>';
            }
            $table .= '
            <td>
            <button class="btn btn-warning " value='.$row["prod_id"]. ' onclick="showLogProd(this)"><i class="fa fa-eye" aria-hidden="true"></i></button>
            <button class="btn btn-info " value=' . $row["prod_id"] . ' onclick="updateProd(this)"><i class="fa fa-list-alt" aria-hidden="true"></i></button>
            <button class="btn btn-danger " value=' . $row["prod_id"] . ' onclick="deleteProd(this)"><i class="fa fa-trash" aria-hidden="true"></i></button>
            </td>
            </tr>';
        }
        $table = $table. "</tbody></table>";
        echo $table;
    }else{
        echo "No Products Found!";
    }
    mysqli_close($conn);
}

function newProductEntry(){
    include 'config.php';
    $desc = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['desc']));
    $rtl = htmlspecialchars(properString(mysqli_real_escape_string($conn, $_POST['rtl'])));
    $btl = htmlspecialchars(properString(mysqli_real_escape_string($conn, $_POST['btl'])));
    $cs =htmlspecialchars(properString( mysqli_real_escape_string($conn, $_POST['cs'])));
    $sh = htmlspecialchars(properString(mysqli_real_escape_string($conn, $_POST['sh'])));
    $u_id = $_SESSION['u_id'];
    if(isset($desc) && isset($rtl) && isset($btl) && isset($cs) && isset($sh)){
        include 'config.php';
        $sql = "INSERT INTO Products VALUES(null, '$desc', '$rtl', '$btl', '$cs', '$u_id', 1, '$sh')";
        if ($conn->query($sql) === TRUE) {
            $last_id = $conn->insert_id;
            $sql = "INSERT INTO inventory VALUES (null, 0, $last_id, 0, 0, 0)";
            if($conn->query($sql) === TRUE){
                echo 1;
            }else{
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        else{
            echo "Error: " . $sql . "<br>" . $conn->error;
            echo "<br />Shell Value = ".$sh."";
        }
    }else{
        echo 3;
    }
}

function getUser(){
    $name = $_SESSION['uname'];
    echo $name;
}

function login(){
    include 'config.php';
    $usr = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['username']));
    $pass = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['password']));
    $sql = "SELECT * FROM credentials c LEFT JOIN profiles p ON p.prof_id = c.prof_id WHERE usrnm = '" . $usr . "' AND psswrd = '" . $pass . "'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) {
        // output data of each row
        echo 1;
        while ($row = mysqli_fetch_assoc($result)) {
            $_SESSION['u_id'] = $row['prof_id'];
            $_SESSION['uname'] = $row['usrnm'];
        }
    } else {
        echo 0;
    }
    mysqli_close($conn);
}

function addUser(){
    include 'config.php';
    $fname = htmlspecialchars((mysqli_real_escape_string($conn,test_input($_POST['fname']))));
    $mname = htmlspecialchars(properString(mysqli_real_escape_string($conn,test_input($_POST['mname']))));
    $lname = htmlspecialchars(properString(mysqli_real_escape_string($conn,test_input($_POST['lname']))));
    $cntctnmbr = htmlspecialchars(properString(mysqli_real_escape_string($conn,test_input($_POST['cntctnmbr']))));
    $utyp = htmlspecialchars(properString(mysqli_real_escape_string($conn,test_input($_POST['utyp']))));
    $psswrd = htmlspecialchars(properString(mysqli_real_escape_string($conn,test_input($_POST['psswrd']))));
    $address = htmlspecialchars(properString(mysqli_real_escape_string($conn,test_input($_POST['address']))));
    if(isset($fname) && isset($mname) && isset($lname) && isset($cntctnmbr) && isset($utyp) && isset($address) && isset($psswrd)){
        $uname = strtolower($fname[0].$mname[0].$lname);
        if($utyp == "Cashier"){
            $utyp == 1;
        }else if ($utyp == "Clerk") {
            $utyp == 2;
        }
        $sql = "INSERT INTO Profiles VALUES(null, '".$fname."', '".$mname."', '".$lname."', '".$cntctnmbr."', '".$address."', '".$utyp."')";
        if ($conn->query($sql) === TRUE) {
            //header("Location: home.php");
            $last_id = $conn->insert_id;
            $sql = "INSERT INTO credentials VALUES (null, '".$uname."', '".$psswrd."', '".$last_id."')";
            if ($conn->query($sql) === TRUE) {
                echo 1;
            }else{
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        mysqli_close($conn);
    }else{
        echo 3;
    }

}

function checkUser(){
    //Validate for duplication
}

function showUser(){
    include 'config.php';
    $sql = "SELECT * FROM profiles";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            $sql = "SELECT * FROM profiles";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                $table = "<table class='table table-striped table-bordered'>
                <thead class='thead-dark'>
                    <tr>
                    <th scope='col'>Firstname</th>
                    <th scope='col'>Middlename</th>
                    <th scope='col'>Lastname</th>
                    <th scope='col'>Contact #</th>
                    <th scope='col'>Address</th>
                    <th scope='col'>Title</th>
                    </tr>
                </thead>";
                while($row = mysqli_fetch_assoc($result)) {
                    $utyp = "N/A";
                    if($row['prof_type'] == 1){
                        $utyp = 'Cashier';
                    }else if($row['prof_type'] == 2){
                        $utyp = 'Clerk';
                    }
                    $table = $table.
                    '<tr>'
                    .'<td>'.$row['fname'].'</td>'
                    .'<td>'.$row['mname'].'</td>'
                    .'<td>'.$row['lname'].'</td>'
                    .'<td>'.$row['cntctnmbr'].'</td>'
                    .'<td>'.$row['addres'].'</td>'
                    .'<td>'.$utyp.'</td>
                    </tr>';
                }
                $table = $table. "</table>";
            }
        }
        echo $table;
    }else{
        echo "No Users Found";
    }
    mysqli_close($conn);
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function properString($string){
    $data = strtolower($string);
    $data = ucfirst($data);
    return $data;
}
?>
