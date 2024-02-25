<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "attendance_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM Users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>User Profile</title>
        <link rel="stylesheet" href="style_profile.css">
    </head>
    <body>
        <div class="form-fields">
            <label>Photo :</label>
            <div class="detail-box">
                <img src='gambar/<?php echo $user['photo']; ?>' width='100'>
            </div>
            <label>Nama Panjang :</label>
            <div class="detail-box">
                <p><?php echo $user['firstName']; ?> <?php echo $user['lastName']; ?></p>
            </div>
            <label>Email :</label>
            <div class="detail-box">
                <p><?php echo $user['email']; ?></p>
            </div>
            <label>Biodata Pengguna :</label>
            <div class="detail-box">
                <textarea readonly style="width: 100%; border: none; background: none;"><?php echo $user['bio']; ?></textarea>
            </div>
            <a class="logout-button" href="login.php">Keluar</a>
        </div>
    </body>
</html>