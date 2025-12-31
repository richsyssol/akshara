<?php
$servername = "localhost";
$username = "u809801411_akshara";
$password = "dUS[+~S1=";
$dbname = "u809801411_akshara";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
};

// echo "Connected successfully";
?>
