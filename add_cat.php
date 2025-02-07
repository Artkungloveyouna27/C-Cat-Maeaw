<?php
// การเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "its66040233104";
$password = "Y8ivR9C8";
$dbname =  "its66040233104";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $name_th = $_POST['name_th'];
    $name_en = $_POST['name_en'];
    $description = $_POST['description'];
    $characteristics = $_POST['characteristics'];
    $care_instructions = $_POST['care_instructions'];
    $image_url = $_POST['image_url'];
    $is_visible = isset($_POST['is_visible']) ? 1 : 0;

    // คำสั่งเตรียมเพื่อหลีกเลี่ยงการโจมตี SQL injection
    $stmt = $conn->prepare("INSERT INTO CatBreeds (name_th, name_en, description, characteristics, care_instructions, image_url, is_visible) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssi", $name_th, $name_en, $description, $characteristics, $care_instructions, $image_url, $is_visible);

    if ($stmt->execute()) {
        echo "<script>alert('เพิ่มข้อมูลสำเร็จ'); window.location.href = 'admin.php';</script>";
    } else {
        echo "ข้อผิดพลาด: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข้อมูลสายพันธุ์แมว</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet"> <!-- Icon font -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('https://images.dmc.tv/wallpaper/raw/9941.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #fff;
        }

        .navbar {
            background-color: rgba(0, 0, 0, 0.7);
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

        .form-container {
            max-width: 700px;
            margin: 50px auto;
            padding: 30px;
            background-color: rgba(0, 0, 0, 0.6);
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        }

        h2 {
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            border-radius: 5px;
            padding: 15px;
            font-size: 1rem;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }

        .form-control:focus {
            border-color: #ff9800;
            box-shadow: 0 0 8px rgba(255, 152, 0, 0.6);
        }

        .checkbox label {
            color: #fff;
            font-size: 1rem;
        }

        button {
            background-color: #ff9800;
            color: white;
            padding: 12px 30px;
            font-size: 1.2rem;
            border-radius: 5px;
            border: none;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #e68900;
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

<div class="container form-container">
    <h2>เพิ่มข้อมูลสายพันธุ์แมว</h2>

    <form action="add_cat.php" method="post">
        <div class="form-group">
            <label for="name_th">ชื่อสายพันธุ์ (ไทย):</label>
            <input type="text" class="form-control" id="name_th" name="name_th" required>
        </div>

        <div class="form-group">
            <label for="name_en">ชื่อสายพันธุ์ (อังกฤษ):</label>
            <input type="text" class="form-control" id="name_en" name="name_en" required>
        </div>

        <div class="form-group">
            <label for="description">คำอธิบาย:</label>
            <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
        </div>

        <div class="form-group">
            <label for="characteristics">ลักษณะทั่วไป:</label>
            <textarea class="form-control" id="characteristics" name="characteristics" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label for="care_instructions">คำแนะนำการเลี้ยงดู:</label>
            <textarea class="form-control" id="care_instructions" name="care_instructions" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label for="image_url">URL ของรูปภาพ:</label>
            <input type="text" class="form-control" id="image_url" name="image_url">
        </div>

        <div class="form-group checkbox">
            <label for="is_visible">แสดงผลในเว็บไซต์:</label>
            <input type="checkbox" id="is_visible" name="is_visible" checked>
        </div>

        <button type="submit" name="submit">เพิ่มข้อมูล</button>
    </form>
</div>

<div class="footer">
    <p>© 2025 ข้อมูลสายพันธุ์แมว | <a href="#">ติดต่อเรา</a></p>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</body>
</html>

