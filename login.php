<?php
session_start();

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "attendance_system";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST["email"];
    $password = md5($_POST["password"]);

    $sql = "SELECT * FROM Users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $password == $user['password']) { 
        $_SESSION['user_id'] = $user['id'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid email or password";
    }

    if (isset($_POST['remember'])) {
        setcookie('username', $_POST['username'], time() + (30 * 24 * 60 * 60));
        setcookie('password', $_POST['password'], time() + (30 * 24 * 60 * 60));
    } else {
        if (isset($_COOKIE['username'])) {
            setcookie('username', '', time() - 3600);
        }
        if (isset($_COOKIE['password'])) {
            setcookie('password', '', time() - 3600);
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Login</title>
    <link rel="stylesheet" href="style_login.css">
</head>
<body>
    <form action="login.php" method="POST">
        <div class="form-heading">
            <h1 class="teks-login">Login Form</h1>
        </div>
        <div class="form-fields">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <div class="checkbox-container">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember me</label>
            </div>
            <br>
            <input type="submit" value="Login">
        </div>
    </form>
</body>
</html>