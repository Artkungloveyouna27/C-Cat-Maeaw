<?php
// เชื่อมต่อฐานข้อมูล (Connect to the database)
$servername = "localhost";
$username = "its66040233104";
$password = "Y8ivR9C8";
$dbname =  "its66040233104";



$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// รับค่าคำค้นหาจากฟอร์ม (Get search value from form)
$search = isset($_POST['search']) ? $_POST['search'] : '';

// สร้าง SQL query สำหรับค้นหาข้อมูล (Create SQL query to search data)
$sql = "SELECT * FROM CatBreeds WHERE (name_th LIKE '%$search%' OR name_en LIKE '%$search%') AND is_visible = 1";
$result = $conn->query($sql);

$conn->close();
?>

<?php
session_start();

// ตรวจสอบว่ามีการเข้าสู่ระบบหรือยัง
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แสดงข้อมูลสายพันธุ์แมว (Display Cat Breeds Information)</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('https://nypost.com/wp-content/uploads/sites/2/2019/09/fat-cat.jpg?resize=1536,1020&quality=75&strip=all');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #fff;
        }

        .navbar {
            background-color: rgba(0, 0, 0, 0.7);
            margin-bottom: 30px;
        }

        .navbar a {
            color: white !important;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .navbar a:hover {
            color: #ff9800 !important;
        }

        .container {
            margin-top: 100px;
        }

        .search-box {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
        }

        .search-box input {
            width: 50%;
            border-radius: 50px;
            padding: 10px;
            font-size: 1.1rem;
        }

        h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 30px;
            font-weight: bold;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.6);
        }

        .cat-card {
            border: 1px solid #ddd;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            margin-bottom: 30px;
            transition: transform 0.3s;
        }

        .cat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.3);
        }

        .cat-card img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .cat-card h3 {
            text-align: center;
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #333;
        }

        .btn-edit, .btn-delete {
            margin-top: 10px;
            background-color: #ff9800;
            color: white;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 25px;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-edit:hover, .btn-delete:hover {
            background-color: #e68900;
        }

        .btn-delete {
            background-color: #f44336;
        }

        .btn-delete:hover {
            background-color: #e53935;
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

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="admin.php">Home Admin</a></li>
                <li><a href="add_cat.php">Add Cat</a></li>
                <li><a href="visible.php">Edit</a></li>
                <li><a href="imageList.php" target="_blank">IMG</a></li>
                <li><a href="logout.php">ออกจากระบบ</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <h2>สายพันธุ์แมวยอดนิยม (Popular Cat Breeds)</h2>
    
    <!-- ฟอร์มค้นหาข้อมูล (Search form) -->
    <form method="POST" action="">
        <div class="search-box">
            <input type="text" class="form-control" name="search" placeholder="ค้นหาสายพันธุ์แมว... (Search for cat breeds...)" value="<?php echo htmlspecialchars($search); ?>">
        </div>
    </form>

    <div class="row">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='col-md-4'>";
                echo "<div class='cat-card'>";
                echo "<h3>" . $row['name_th'] . " (" . $row['name_en'] . ")</h3>";
                echo "<img src='" . $row['image_url'] . "' alt='Image'>";
                echo "<p><strong>คำอธิบาย:</strong> " . $row['description'] . "</p>";
                echo "<p><strong>ลักษณะทั่วไป:</strong> " . $row['characteristics'] . "</p>";
                echo "<p><strong>คำแนะนำการเลี้ยงดู:</strong> " . $row['care_instructions'] . "</p>";
                echo "<a href='edit_cat.php?id=" . $row['id'] . "' class='btn-edit'>แก้ไข (Edit)</a> | ";
                echo "<a href='delete_cat.php?id=" . $row['id'] . "' class='btn-delete'>ลบ (Delete)</a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p class='text-center'>ไม่มีข้อมูลแสดง (No data to display)</p>";
        }
        ?>
    </div>
</div>

<div class="footer">
    <p>© 2025 ข้อมูลสายพันธุ์แมว | <a href="#">ติดต่อเรา</a></p>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</body>
</html>

