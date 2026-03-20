<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "afro_nova_test_hub";

$conn = new mysqli("localhost", "root", "", "afro_nova_test_hub");

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}
?>