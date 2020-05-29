<?php

$q = $_POST['viewkey'];
if(isset($q)){
  echo "sha1 of $q = " . sha1($q);
  // echo showUser();
}else {
  echo "<h1>Something went wrong!</h1>";
}

function showUser(){
    include '../../php/config.php';
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
        return $table;
    }else{
        return "No Users Found";
    }
    mysqli_close($conn);
}
?>
