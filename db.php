<?php
$host = "infortech.3bbddns.com";
$user = "root";
$pass = "Sa1145011450$$";
$dbname = "classroom_db";
$port = "21520";
$conn = new mysqli($host, $user, $pass, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}
?>
