<?php
include 'db.php';

$name = $_POST['name'];
$score = $_POST['score'];

$sql = "INSERT INTO students (name, total_score) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $name, $score);
$stmt->execute();

header("Location: dashboard.php");
exit();
?>
