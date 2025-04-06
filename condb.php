<html>
<?php
// Turn off all error reporting
//error_reporting(0);

//จ้างพัฒนาเพิ่มเติม ติดต่อมาที่แฟนเพจ : https://www.facebook.com/sornwebsites

$servername = "infortech.3bbddns.com";
$username = "root";
$password = "Sa1145011450$$";
$port = "21520";

try {
  $condb = new PDO("mysql:host=$servername;dbname=db_rollCall;charset=utf8", $username, $password, $port);
  // set the PDO error mode to exception
  //$condb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

//Set ว/ด/ป เวลา ให้เป็นของประเทศไทย
date_default_timezone_set('Asia/Bangkok');

// ขายระบบ ลด 80% link    https://devbanban.com/?p=4425

?>
</html>
