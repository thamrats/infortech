<?php
include 'db.php';

$name = $_POST['name'];

$sql = "INSERT INTO students (name, total_score) VALUES ('$name', 0)";
if ($conn->query($sql) === TRUE) {
    echo "เพิ่มนักเรียนเรียบร้อยแล้ว";
} else {
    echo "เกิดข้อผิดพลาด: " . $conn->error;
}

$conn->close();
?>