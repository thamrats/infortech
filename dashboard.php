<?php
include 'db.php';

// ดึงข้อมูลนักเรียน
$student_query = "SELECT name, total_score FROM students";
$student_result = $conn->query($student_query);

// ดึงข้อมูลเกณฑ์
$criteria_query = "SELECT name, score FROM criteria";
$criteria_result = $conn->query($criteria_query);

$student_names = [];
$student_scores = [];

$criteria_names = [];
$criteria_scores = [];

$total_students = 0;
$sum_scores = 0;
$total_criteria = 0;


if ($student_result->num_rows > 0) {
    while($row = $student_result->fetch_assoc()) {
        $student_names[] = $row['name'];
        $student_scores[] = $row['total_score'];
        $total_students++;
        $sum_scores += $row['total_score'];
    }
    
}

if ($criteria_result->num_rows > 0) {
    while($row = $criteria_result->fetch_assoc()) {
        $criteria_names[] = $row['name'];
        $criteria_scores[] = $row['score'];
        $total_criteria++;
    }
}

$average_score = $total_students > 0 ? round($sum_scores / $total_students, 2) : 0;
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Dashboard ห้องเรียน</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<!-- Header -->
<div class="bg-gradient-to-r from-purple-600 to-indigo-600 p-4 flex justify-between items-center text-white">
    <h1 class="text-2xl font-bold">ระบบจัดการห้องเรียน</h1>
    <div>
        <span>สวัสดี, ผู้ดูแล</span>
        <button class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded ml-4">ออกจากระบบ</button>
        <button onclick="openModal('importModal')" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
  นำเข้ารายชื่อนักเรียน
</button>
<!-- Import Modal -->
<div id="importModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
  <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
    <h2 class="text-xl font-bold mb-4">นำเข้ารายชื่อนักเรียน (CSV)</h2>
    <form method="POST" action="import_students.php" enctype="multipart/form-data">
      <input type="file" name="csv_file" accept=".csv" class="w-full mb-4 border p-2" required>
      <div class="text-sm text-gray-500 mb-4">* ไฟล์ควรมีคอลัมน์: name,total_score</div>
      <div class="flex justify-end">        
        <button type="button" onclick="closeModal('importModal')" class="text-black px-4 py-2 rounded px-mr-2 px-4 py-2">ยกเลิก</button>        
        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">นำเข้า</button>
      </div>
    </form>
  </div>
</div>

    </div>
</div>

<div class="p-6">

    <!-- Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-gradient-to-r from-blue-500 to-blue-700 p-6 rounded-lg shadow-lg text-white text-center">
            <h2 class="text-lg">จำนวนนักเรียนทั้งหมด</h2>
            <p class="text-3xl font-bold mt-2"><?php echo $total_students; ?></p>
        </div>
        <div class="bg-gradient-to-r from-green-400 to-green-600 p-6 rounded-lg shadow-lg text-white text-center">
            <h2 class="text-lg">คะแนนเฉลี่ย</h2>
            <p class="text-3xl font-bold mt-2"><?php echo $average_score; ?></p>
        </div>
        <div class="bg-gradient-to-r from-purple-400 to-purple-600 p-6 rounded-lg shadow-lg text-white text-center">
            <h2 class="text-lg">เกณฑ์การให้คะแนน</h2>
            <p class="text-3xl font-bold mt-2"><?php echo $total_criteria; ?></p>
        </div>
    </div>

    <!-- ตารางข้อมูล -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- นักเรียน -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">จัดการนักเรียน</h2>
                <!-- ปุ่มเปิด modal เพิ่มนักเรียน -->
                 
<button onclick="openModal('studentModal')" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">เพิ่มนักเรียน</button>

<!-- Modal นักเรียน -->
<div id="studentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
  <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
    <h2 class="text-xl font-bold mb-4">เพิ่มนักเรียน</h2>
    <form method="POST" action="add_student.php">
      <input name="name" placeholder="ชื่อนักเรียน" class="w-full border p-2 mb-4" required>
      <input name="score" placeholder="คะแนนรวมเริ่มต้น" class="w-full border p-2 mb-4" type="number" required>
      <div class="flex justify-end">
        <button type="button" onclick="closeModal('studentModal')" class="mr-2 px-4 py-2">ยกเลิก</button>
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">บันทึก</button>
      </div>
    </form>
  </div>
</div> 
            </div>
            
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2">ชื่อ</th>
                        <th class="p-2">คะแนนรวม</th>
                        <th class="p-2">แก้ไข</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($student_names as $index => $name): ?>
                    <tr class="border-b">
                        <td class="p-2"><?php echo $name; ?></td>
                        <td class="p-2"><?php echo $student_scores[$index]; ?></td>
                        <td>
    <button 
      onclick="openEditstudentModal(<?= $index['id'] ?>, '<?= htmlspecialchars($index['name']) ?>', <?= $index['total_score'] ?>)" 
      class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
      อัพเดท
    </button>
  </td>
                    </tr>
                    <?php endforeach; ?>
                    
                </tbody>
            </table>
        </div>

        <!-- เกณฑ์การให้คะแนน -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">เกณฑ์การให้คะแนน</h2>
               <!-- ปุ่มเปิด modal เพิ่มเกณฑ์ -->
<button onclick="openModal('criteriaModal')" class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded">เพิ่มเกณฑ์</button>

<!-- Modal เกณฑ์ -->
<div id="criteriaModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
  <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
    <h2 class="text-xl font-bold mb-4">เพิ่มเกณฑ์การให้คะแนน</h2>
    <form method="POST" action="add_criteria.php">
      <input name="name" placeholder="ชื่อเกณฑ์" class="w-full border p-2 mb-4" required>
      <input name="score" placeholder="คะแนน" class="w-full border p-2 mb-4" type="number" required>
      <div class="flex justify-end">
        <button type="button" onclick="closeModal('criteriaModal')" class="mr-2 px-4 py-2">ยกเลิก</button>
        <button type="submit" class="bg-purple-500 hover:bg-purple-600 text-white px-4 py-2 rounded">บันทึก</button>
      </div>
    </form>
  </div>
</div>
            </div>
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="p-2">ชื่อเกณฑ์</th>
                        <th class="p-2">คะแนน</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($criteria_names as $index => $name): ?>
                    <tr class="border-b">
                        <td class="p-2"><?php echo $name; ?></td>
                        <td class="p-2"><?php echo $criteria_scores[$index]; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

    <!-- กราฟ -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
        
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-bold mb-4">กราฟคะแนนนักเรียน</h2>
            <canvas id="studentChart"></canvas>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-bold mb-4">กราฟคะแนนตามเกณฑ์</h2>
            <canvas id="criteriaChart"></canvas>
        </div>

    </div>

</div>

<script>
// ข้อมูลจาก PHP
const studentNames = <?php echo json_encode($student_names); ?>;
const studentScores = <?php echo json_encode($student_scores); ?>;
const criteriaNames = <?php echo json_encode($criteria_names); ?>;
const criteriaScores = <?php echo json_encode($criteria_scores); ?>;

// กราฟนักเรียน
const ctxStudent = document.getElementById('studentChart').getContext('2d');
new Chart(ctxStudent, {
    type: 'bar',
    data: {
        labels: studentNames,
        datasets: [{
            label: 'คะแนนรวม',
            data: studentScores,
            backgroundColor: 'rgba(91, 142, 255, 0.7)',
            borderRadius: 8
        }]
    },
    options: {
        scales: {
            y: { beginAtZero: true }
        }
    }
});

// กราฟเกณฑ์
const ctxCriteria = document.getElementById('criteriaChart').getContext('2d');
new Chart(ctxCriteria, {
    type: 'pie',
    data: {
        labels: criteriaNames,
        datasets: [{
            data: criteriaScores,
            backgroundColor: [
                'rgba(75, 192, 192, 0.7)',
                'rgba(255, 99, 132, 0.7)',
                'rgba(255, 205, 86, 0.7)',
                'rgba(153, 102, 255, 0.7)',
                'rgba(54, 162, 235, 0.7)'
            ],
            borderColor: '#fff',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
    }
});
</script>
<script>
function openModal(id) {
  document.getElementById(id).classList.remove('hidden');
  document.getElementById(id).classList.add('flex');
}

function closeModal(id) {
  document.getElementById(id).classList.add('hidden');
  document.getElementById(id).classList.remove('flex');
}
</script>
<!-- Edit Modal -->
<div id="editstudentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
  <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
    <h2 class="text-xl font-bold mb-4">แก้ไขคะแนนนักเรียน</h2>
    <form method="POST" action="update_student.php">
      <input type="hidden" name="id" id="editstudentId">
      <div class="mb-4">
        <label class="block mb-1">ชื่อนักเรียน</label>
        <input type="text" id="editstudentName" class="w-full border p-2" readonly>
      </div>
      <div class="mb-4">
        <label class="block mb-1">คะแนน</label>
        <input type="number" name="score" id="editstudentScore" class="w-full border p-2" required>
      </div>
      <div class="flex justify-end">
        <button type="button" onclick="closeModal('editstudentModal')" class="mr-2 px-4 py-2">ยกเลิก</button>
        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">บันทึก</button>
      </div>
    </form>
  </div>
</div>
<script>
function openEditstudentModal(id, name, score) {
  document.getElementById('editstudentId').value = id;
  document.getElementById('editstudentName').value = name;
  document.getElementById('editstudentScore').value = score;
  openModal('editstudentModal');
}
</script>

</body>
</html>