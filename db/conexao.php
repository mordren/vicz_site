<?php
$servername = "localhost";
$database = "u833298392_vicz";
$username = "u833298392_mordren";
$password = "7:aMtn?W";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>