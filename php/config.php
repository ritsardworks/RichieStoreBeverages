<?php
$servername = "localhost";
$username = "root";
// $password = "root";
$password = "root";
$dbname = "mydb";
// $servername = "192.168.1.24:143";
// $username = "adminritsard";
// $password = "Leosala99";
// $dbname = "mydb";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
} 
?>