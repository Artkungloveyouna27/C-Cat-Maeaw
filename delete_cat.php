<?php
// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "its66040233104";
$password = "Y8ivR9C8";
$dbname =  "its66040233104";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่ามีการส่ง id มาหรือไม่
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // สร้าง SQL query สำหรับการลบข้อมูล
    $sql = "DELETE FROM CatBreeds WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('ลบข้อมูลสำเร็จ'); window.location.href = 'index.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
