<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ice_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname)or die("Could not connect to mysql".mysqli_error($con));

?>