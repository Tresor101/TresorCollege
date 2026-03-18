<?php
// db_connect.php
$host = 'srv1535.hstgr.io';
$db   = 'u244407333_rodb';
$user = 'u244407333_rodman';
$pass = 'mQ4#tZ8!vL2@rX7$kP9';
$charset = 'utf8mb4';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
$conn->set_charset($charset);
?>
