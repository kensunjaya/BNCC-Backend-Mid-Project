<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "attendance_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_GET['id'];

$sql = "SELECT * FROM Users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("Cannot find user with ID : $user_id");
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>List semua user :</title>
    <link rel="stylesheet" href="style_view.css">
</head>
<body>
    <div class="form-heading">
        <h2 style="color:green;">Detil Pengguna</h2>
    </div>
    <div class="form-fields">
        <label for="photo">Photo : </label><br>
        <img id="photo" src='gambar/<?php echo $user['photo']; ?>' width='100'><br><br>
        <label for="firstName">Nama Depan : </label><br>
        <input type="text" id="firstName" name="firstName" value="<?php echo isset($user['firstName']) ? $user['firstName'] : ''; ?>" disabled><br>
        <label for="lastName">Nama Belakang : </label><br>
        <input type="text" id="lastName" name="lastName" value="<?php echo isset($user['lastName']) ? $user['lastName'] : ''; ?>" disabled><br>
        <label for="email">E-Mail : </label><br>
        <input type="email" id="email" name="email" value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>" disabled><br>
        <label for="bio">Biodata Pengguna : </label><br>
        <textarea id="bio" name="bio" disabled><?php echo isset($user['bio']) ? $user['bio'] : ''; ?></textarea><br>
    </div>
</body>
</html>