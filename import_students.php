<?php
include 'db.php';

if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['csv_file']['tmp_name'];
    $handle = fopen($fileTmpPath, 'r');

    // ข้าม header แถวแรก
    fgetcsv($handle);

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $name = $data[0];
        $score = (int)$data[1];

        $stmt = $conn->prepare("INSERT INTO students (name, total_score) VALUES (?, ?)");
        $stmt->bind_param("si", $name, $score);
        $stmt->execute();
    }

    fclose($handle);
}

header("Location: dashboard.php");
exit();
?>
