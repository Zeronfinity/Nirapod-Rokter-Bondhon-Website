<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname =  "nirobdb";

// Create connection
$conn = mysqli_connect($servername, $username, $password,$dbname);

// Check connection
if ($conn == false) {
    die("Connection failed: " . $conn->connect_error);
} 
// echo "Connected successfully"; 



?>