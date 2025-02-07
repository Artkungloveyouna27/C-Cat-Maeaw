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

// ตรวจสอบว่ามีการเปลี่ยนแปลงสถานะการแสดงภาพ
if (isset($_GET['toggle_visibility']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $toggle = $_GET['toggle_visibility'] == '1' ? 0 : 1; // เปลี่ยนสถานะจาก 1 เป็น 0 หรือจาก 0 เป็น 1

    // อัปเดตสถานะ is_visible ในฐานข้อมูล
    $sql = "UPDATE CatBreeds SET is_visible = $toggle WHERE id = $id";
    $conn->query($sql);
    header("Location: visible.php"); // รีเฟรชหน้าเมื่อทำการอัปเดตแล้ว
    exit();
}

// ดึงข้อมูลจากฐานข้อมูล
$sql = "SELECT * FROM CatBreeds";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลสายพันธุ์แมว</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"> <!-- Icon font -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('https://preview.redd.it/cute-cartoon-cats-v0-xuhklb4dy13b1.png?width=1080&crop=smart&auto=webp&s=ae6799a8ad868f3bdf76d31c183c8f6b20d90173');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #fff; /* ใช้สีขาวสำหรับข้อความ */
        }

        .container {
            margin-top: 30px;
        }

        h2 {
            text-align: center;
            font-size: 2.5rem;
            font-weight: bold;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.6);
            margin-bottom: 30px;
        }

        .navbar {
            background-color: rgba(0, 0, 0, 0.7); /* ทึบมากขึ้น */
            margin-bottom: 20px;
        }

        .navbar a {
            color: white !important;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .navbar a:hover {
            color: #ff9800 !important;
        }

        .table {
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            margin-top: 20px;
        }

        th, td {
            text-align: center;
            vertical-align: middle;
            color: #fff;
            font-size: 1.1rem;
            padding: 15px;
        }

        th {
            background-color: rgba(0, 0, 0, 0.8);
        }

        td img {
            border-radius: 8px;
            max-width: 100px;
        }

        .btn-warning, .btn-danger, .btn-success {
            padding: 10px 15px;
            font-size: 1rem;
            margin: 5px;
            border-radius: 5px;
        }

        .btn-warning:hover {
            background-color: #ffb300;
        }

        .btn-danger:hover {
            background-color: #e53935;
        }

        .btn-success:hover {
            background-color: #43a047;
        }

        .footer {
            text-align: center;
            margin-top: 50px;
            font-size: 1rem;
            color: #fff;
        }

        .footer a {
            color: #ff9800;
            text-decoration: none;
        }

        .footer a:hover {
            color: #fff;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="admin.php">Home Admin</a></li>
                <li><a href="add_cat.php">Add Cat</a></li>
                <li><a href="imageList.php" target="_blank">IMG</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <h2>ข้อมูลสายพันธุ์แมว</h2>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ชื่อสายพันธุ์</th>
                <th>คำอธิบาย</th>
                <th>ลักษณะ</th>
                <th>คำแนะนำการเลี้ยงดู</th>
                <th>รูปภาพ</th>
                <th>แสดงผล</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['name_th']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['characteristics']; ?></td>
                    <td><?php echo $row['care_instructions']; ?></td>
                    <td><img src="<?php echo $row['image_url']; ?>" alt="Cat Image"></td>
                    <td>
                        <?php if ($row['is_visible'] == 1) { ?>
                            <span class="text-success">แสดง</span>
                        <?php } else { ?>
                            <span class="text-danger">ซ่อน</span>
                        <?php } ?>
                    </td>
                    <td>
                        <a href="edit_cat.php?id=<?php echo $row['id']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i> แก้ไข</a>
                        <a href="?toggle_visibility=<?php echo $row['is_visible']; ?>&id=<?php echo $row['id']; ?>" class="btn btn-<?php echo ($row['is_visible'] == 1) ? 'danger' : 'success'; ?>">
                            <?php echo ($row['is_visible'] == 1) ? 'ซ่อนรูป' : 'แสดงรูป'; ?>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="footer">
    <p>© 2025 ข้อมูลสายพันธุ์แมว | <a href="#">ติดต่อเรา</a></p>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>
</html>



