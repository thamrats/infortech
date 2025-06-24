<?php
header('Content-Type: application/json');
$servername = "infortech.3bbddns.com";
$username = "root";
$password = "Sa1145011450$$";
$dbname = "guidance_system";
$port = 21520;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);
$conn->set_charset('utf8');

if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed']));
}

$action = $_GET['action'] ?? '';

if ($action === 'saveStudent') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? '';
    $fullName = $data['fullName'];
    $classRoom = $data['classRoom'];
    $studentNumber = $data['studentNumber'];
    $studentIdNumber = $data['studentIdNumber'];
    $citizenId = $data['citizenId'];
    $academicYear = $data['academicYear'];
    $phone = $data['phone'];
    $lineId = $data['lineId'];
    $facebook = $data['facebook'];

    if ($id) {
        $stmt = $conn->prepare("UPDATE students SET fullName=?, classRoom=?, studentNumber=?, studentIdNumber=?, citizenId=?, academicYear=?, phone=?, lineId=?, facebook=? WHERE id=?");
        $stmt->bind_param("sssssssssi", $fullName, $classRoom, $studentNumber, $studentIdNumber, $citizenId, $academicYear, $phone, $lineId, $facebook, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO students (fullName, classRoom, studentNumber, studentIdNumber, citizenId, academicYear, phone, lineId, facebook) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $fullName, $classRoom, $studentNumber, $studentIdNumber, $citizenId, $academicYear, $phone, $lineId, $facebook);
    }
    $stmt->execute();
    echo json_encode(['success' => true]);
}

if ($action === 'getStudents') {
    $search = $_GET['search'] ?? '';
    $stmt = $conn->prepare("SELECT * FROM students WHERE fullName LIKE ? OR classRoom LIKE ? OR academicYear LIKE ?");
    $searchParam = "%$search%";
    $stmt->bind_param("sss", $searchParam, $searchParam, $searchParam);
    $stmt->execute();
    $result = $stmt->get_result();
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}

if ($action === 'getStudent') {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM students WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    echo json_encode($result->fetch_assoc());
}

if ($action === 'deleteStudent') {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM students WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo json_encode(['success' => true]);
}

if ($action === 'savePortfolio') {
    $id = $_POST['id'] ?? '';
    $studentId = $_POST['studentId'];
    $faculty = $_POST['faculty'];
    $major = $_POST['major'];
    $university = $_POST['university'];
    $roundStatus = $_POST['roundStatus'];
    $link = $_POST['link'];
    $pdfPath = '';

    if (isset($_FILES['pdfFile']) && $_FILES['pdfFile']['name']) {
        $pdfPath = 'uploads/' . uniqid() . '.pdf';
        move_uploaded_file($_FILES['pdfFile']['tmp_name'], $pdfPath);
    }

    if ($id) {
        $stmt = $conn->prepare("UPDATE portfolios SET studentId=?, faculty=?, major=?, university=?, roundStatus=?, pdfPath=?, link=? WHERE id=?");
        $stmt->bind_param("issssssi", $studentId, $faculty, $major, $university, $roundStatus, $pdfPath, $link, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO portfolios (studentId, faculty, major, university, roundStatus, pdfPath, link) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssss", $studentId, $faculty, $major, $university, $roundStatus, $pdfPath, $link);
    }
    $stmt->execute();
    echo json_encode(['success' => true]);
}

if ($action === 'getPortfolios') {
    $search = $_GET['search'] ?? '';
    $stmt = $conn->prepare("SELECT p.*, s.fullName as studentName FROM portfolios p JOIN students s ON p.studentId = s.id WHERE s.fullName LIKE ? OR p.faculty LIKE ? OR p.university LIKE ? OR p.roundStatus LIKE ?");
    $searchParam = "%$search%";
    $stmt->bind_param("ssss", $searchParam, $searchParam, $searchParam, $searchParam);
    $stmt->execute();
    $result = $stmt->get_result();
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}

if ($action === 'getPortfolio') {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM portfolios WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    echo json_encode($result->fetch_assoc());
}

if ($action === 'deletePortfolio') {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM portfolios WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo json_encode(['success' => true]);
}

if ($action === 'getStatistics') {
    $university = $conn->query("SELECT university, COUNT(*) as count FROM portfolios GROUP BY university")->fetch_all(MYSQLI_ASSOC);
    $faculty = $conn->query("SELECT faculty, COUNT(*) as count FROM portfolios GROUP BY faculty")->fetch_all(MYSQLI_ASSOC);
    $major = $conn->query("SELECT major, COUNT(*) as count FROM portfolios GROUP BY major")->fetch_all(MYSQLI_ASSOC);
    $roundStatus = $conn->query("SELECT roundStatus, COUNT(*) as count FROM portfolios GROUP BY roundStatus")->fetch_all(MYSQLI_ASSOC);

    $stats = [
        'university' => array_column($university, 'count', 'university'),
        'faculty' => array_column($faculty, 'count', 'faculty'),
        'major' => array_column($major, 'count', 'major'),
        'roundStatus' => array_column($roundStatus, 'count', 'roundStatus')
    ];
    echo json_encode($stats);
}

$conn->close();
?>