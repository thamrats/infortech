<html>
<?php
// ขายระบบ ลด 80% link    https://devbanban.com/?p=4425
//ไฟล์เชื่อมต่อฐานข้อมูล
require_once 'condb.php';
//https://devbanban.com/?p=4425
//คิวรี่ข้อมูลมาแสดงในตาราง
$stmtChIn = $condb->prepare("SELECT * FROM tbl_checkIn as c INNER JOIN tbl_std as s ON c.std_code=s.std_code ORDER BY c.no DESC LIMIT 100");
$stmtChIn->execute();
$result = $stmtChIn->fetchAll();
//https://devbanban.com/?p=4425
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ระบบเช็คชื่อเข้าห้อง ระบบเช็คอินเข้าห้องสมุด by devbanban.com 2024</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

      <!-- sweet alert -->
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    
  </head>
  <body>
    <!-- start menu -->
    <nav class="navbar navbar-expand-lg" style="background-color: green">
      <div class="container">   
        <a class="navbar-brand text-white" href="http://www.kudruakham.ac.th">HOME</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">          
          <h4><a class="nav-link active text-white" aria-current="page" href="http://www.kudruakham.ac.th">โรงเรียนกุดเรือคำพิทยาคาร</a></h4>
            <!-- <li class="nav-item">
              <a class="nav-link active text-white" aria-current="page" href="https://devbanban.com/?p=4425">ขายระบบ ลด 80%</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white" href="https://www.facebook.com/sornwebsites/">จ้างพัฒนาต่อคลิก</a>
              </li>
              <li class="nav-item">
              <a class="nav-link text-white" href="https://devbanban.com/?p=4797">ระบบห้องสมุด</a>
            </li> -->
          </ul>
        </div>
      </div>
    </nav>
    <!-- end menu   https://devbanban.com/?p=4425-->
    <!-- start show check in   https://devbanban.com/?p=4425-->
    <div class="container">
      <div class="row">
        <div class="col-sm-2 mt-3"> </div>
        <div class="col-sm-8 mt-3"> 

          <form action="" method="post">
            <div class="form-group row mb-2">
            <center><img src="images\logo.jpg" alt="logo in a jacket" width="100" height="100"></center>
               <h4> พิมพ์รหัสนักเรียน/สแกนบาร์โค้ด</h4>
               <div class="col-sm-7">
                <input type="text" name="std_code" class="form-control form-control-lg" placeholder="รหัสนักเรียน" required minlength="2" style="background-color: #d7edca;" autofocus="on">
               </div>
               <div class="col-sm-5">
                <button type="submit" name="action" value="save" class="btn btn-primary btn-lg" style="width: 100%">ลงชื่อเข้าห้องคอมพิวเตอร์/ห้องสมุด</button>
               </div>
            </div>
          </form>
          <br>
          <center>
            <b>รายการลงชื่อเข้าห้องสมุด/ห้องเรียน </b>
          </center>
            <br>
          <table class="table table-striped  table-hover table-responsive table-bordered">
            <thead>
              <tr class="table-danger">
                <th width="5%">ลำดับ</th>
                <th width="10%">รหัส</th>
                <th width="45%">ชื่อ - สกุล</th>
                <th width="5%">ชั้น</th>
                <th width="5%">เพศ</th>
                <th width="25%">วันที่เข้าใช้งาน</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($result as $row) { ?>
              <tr>
                <td align="center"><?=$row['no'];?></td>
                <td><?=$row['std_code'];?></td>
                <td><?=$row['std_name'];?></td>
                <td><?=$row['std_class'];?></td>
                <td><?php if($row['std_sex']==1){ echo 'ชาย';}else{ echo 'หญิง'; }?></td>
                <td><?=date('d/m/Y H:i:s', strtotime($row['dateCreate']));?> น.</td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- end show check in   https://devbanban.com/?p=4425  -->

    <p class="text-center mt-5 mb-5"> Develop By devbanban.com @ 2024 <br></p>    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>

<?php 

//จ้างพัฒนาเพิ่มเติม ติดต่อมาที่แฟนเพจ : https://www.facebook.com/sornwebsites

// echo '<pre>';
// print_r($_POST);
//exit();

//สร้างเงื่อนไขตรวจสอบการส่งข้อมูลมาจากฟอร์ฒ

if(isset($_POST['std_code']) && isset($_POST['action']) && $_POST['action']=='save'){

//trigger exception in a "try" block
try { 

  //ตรวจสอบว่ามีรหัสนักเรียนอยู่ในระบบหรือไม่ 

      $stmtChkID = $condb->prepare("SELECT* FROM tbl_std WHERE std_code=:std_code");
       //bindparam STR // INT
      $stmtChkID->bindParam(':std_code', $_POST['std_code'], PDO::PARAM_INT);
      $stmtChkID->execute();
      $rowChk = $stmtChkID->fetch(PDO::FETCH_ASSOC);

      //นับจำนวนการคิวรี่
      if($stmtChkID->rowCount() !=1){
        echo '<script>
             setTimeout(function() {
              swal({
                  title: "ไม่พบรหัสนักเรียนในระบบ",
                  text: "กรุณาพิมพ์/สแกนใหม่อีกครั้ง",
                  type: "error"
              }, function() {
                  window.location = "index.php";
              });
            }, 1000);
        </script>';
           
      }else{

        //ประกาศตัวแปรรับค่าจากฟอร์ม
    $std_code = $_POST['std_code'];
    //sql insert
    $stmtInsert = $condb->prepare("INSERT INTO tbl_checkIn
    (std_code) VALUES (:std_code) ");

    //bindparam STR // INT
    $stmtInsert->bindParam(':std_code', $std_code, PDO::PARAM_INT);

    //จ้างพัฒนาเพิ่มเติม ติดต่อมาที่แฟนเพจ : https://www.facebook.com/sornwebsites

    
    //ถ้า stmt ทำงานถูกต้อง 
     if($stmtInsert->execute()){
    echo '
            <script>
              setTimeout(function() {
              swal({
                    title: "ลงชื่อเข้าใช้สำเร็จ!", //ข้อความ เปลี่ยนได้ เช่น บันทึกข้อมูลสำเร็จ!!
                    text: "กำลังกลับไปหน้าหลัก", //ข้อความเปลี่ยนได้ตามการใช้งาน
                    type: "success", //success, warning, danger
                    timer: 1000, //ระยะเวลา redirect 3000 = 3 วิ เพิ่มลดได้
                  showConfirmButton: false //ปิดการแสดงปุ่มคอนเฟิร์ม ถ้าแก้เป็น true จะแสดงปุ่ม ok ให้คลิกเหมือนเดิม
                }, function(){
                    window.location.href = "index.php"; //หน้าเพจที่เราต้องการให้ redirect ไป อาจใส่เป็นชื่อไฟล์ภายในโปรเจคเราก็ได้ครับ เช่น admin.php
                  });
          });
        </script>';
    } //if
  } //rowcount
} //catch exception
catch(Exception $e) {
  //echo 'Message: ' .$e->getMessage();
  //exit;
   echo '<script>
             setTimeout(function() {
              swal({
                  title: "เกิดข้อผิดพลาด",
                  text: "กรุณาติดต่อผู้ดูแลระบบ",
                  type: "error"
              }, function() {
                  window.location = "index.php";
              });
            }, 1000);
        </script>';
  }  //catch
} //isset devbanban.com
?>
</html>
