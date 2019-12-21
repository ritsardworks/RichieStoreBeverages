<?php
    $id = $_GET['q'];
    include '../php/config.php';
    $sql = "SELECT fname, mname, lname, date FROM profiles p LEFT JOIN sales_order so ON so.prof_id = p.prof_id WHERE unq_id = '$id'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) == 1){
        while($row = mysqli_fetch_assoc($result)){
            $name = $row['fname']." ".$row['mname'][0].". ".$row['lname'];
            $date = $row['date'];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="style.css">
        <title>Receipt</title>
        <script src="../jquery.min.js"></script>
    </head>
    <body>
        <div class="ticket">
            <p class="centered"><h1 class="centered">Richie Leosala Store 
                <br />and 
                <br />
                General Merchandise</h1></p>
            <p class="centered">Purok 3 Picasales St. <br />Mangagoy Bislig City</p></p>
            <?php
                echo "
                <b>Order No: <br />$id</b>
                <br />
                <br />Date: ". date("m/d/y", strtotime($date))."<br />Time: ".date("H:ia", strtotime($date));
            ?>
            <table>
                <thead>
                    <tr>
                        <th class="quantity">Qty.</th>
                        <th class="description">Description</th>
                        <th class="price">Due</th>
                    </tr>
                </thead>
                <tbody id="salesTicket">
                    <?php
                        $sql = "SELECT * FROM sales_order so LEFT JOIN sales_order_line sol ON sol.so_id = so.so_id LEFT JOIN products p ON p.prod_id = sol.prod_id WHERE unq_id = '$id'";
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0){
                            $html = "";
                            $ttl = 0;
                            $dpst = 0;
                            $grndTtl = 0;
                            while($row = mysqli_fetch_assoc($result)){
                                $due = $row['qntty'] * $row['prc'];
                                $ttl += $due;
                                $dpst = $row['ttl_dpst'];
                                $grndTtl += $ttl + $dpst;
                                if($row['dpst'] == "N/A" || $row['dpst'] == 0 ){
                                    $html .= "<td>" . $row['qntty'] . "</td>
                                    <td>" . $row['dscrptn'] . "<br />(₱" . $row['prc'] . ")";
                                }else{
                                    $html .= "
                                    <tr>
                                        <td>" . $row['qntty'] . "<br /><br />
                                        " . $row['depqty'] . "</td>
                                        <td>" . $row['dscrptn'] . "<br />(₱" . $row['prc'] . ")<br />Deposit: <br />
                                        " . $row['dpst'] . " (" . $row['depprc'] . ")</td>";
                                    }
                                if($row['dpst'] == "N/A" || $row['dpst'] == 0){
                                    $html .= "<td>₱" . $due . "<br /></td>";
                                }else{
                                    $html .= "<td>₱" . $due . "<br />
                                    <br/>₱" . $row['depqty'] * $row['depprc'] . "
                                    </td>";
                                }
                                $html .= "</tr>";
                            }
                            $html .= "
                            <tr>
                                <td colspan='2'>Total: </td>
                                <td>₱$ttl</td>
                            </tr>
                            <tr>
                                <td colspan='2'>Deposit:</td>
                                <td>₱$dpst</td>
                            </tr>
                            <tr>
                                <td colspan='2'>Grand Total:</td>
                                <td>₱<b>$grndTtl</b></td>
                            </tr>
                            ";
                            echo $html;
                        }
                    ?>
                </tbody>
            </table>
            <p class="centered">Thanks for your purchase!</p>
            <p class="" id="info">
                <?php
                    echo "Sold By:<br /><b>" . $name ."</b>";
                ?>
            </p>
            <p class="centered">
                <?php
                echo "<img alt='testing' src='barcode.php?codetype=Code128&size=60&text=".$id."&print=true' style='width: 160px; max-width: 160px;'/>";
                ?>
            </p>
        </div>
        <button id="btnPrint" class="hidden-print">Print</button>
        <script src="script.js"></script>
    </body>
</html>