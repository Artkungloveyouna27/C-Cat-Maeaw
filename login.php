<?php
session_start();

// ตรวจสอบว่ามีการส่งข้อมูลมาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // เช็ค username และ password
    if ($username === "Artkung" && $password === "Loveyouna") {
        $_SESSION["admin_logged_in"] = true; // ตั้งค่าสถานะ login
        header("Location: admin.php"); // ไปที่หน้า admin
        exit();
    } else {
        $error = "Username หรือ Password ไม่ถูกต้อง!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>เข้าสู่ระบบ Admin</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>เข้าสู่ระบบ Admin</h2>
        <?php if (isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
        <form method="POST" action="">
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">เข้าสู่ระบบ</button>
        </form>
    </div>
</body>
</html>
