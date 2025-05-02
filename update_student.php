<?php
include 'db.php';

$id = $_POST['id'];
$score = $_POST['score'];

$sql = "UPDATE students SET total_score = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $score, $id);
$stmt->execute();

header("Location: dashboard.php");
exit();
?>
