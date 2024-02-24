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
    <title>User Login</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #EEF5FF;
            font-family: Arial, sans-serif;
        }
        form {
            display: flex;
            padding: 40px;
            background-color: #B4D4FF;
            box-shadow: 20px 20px 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px 10px 10px 10px;


        }
        .form-heading {
            margin-right: 10px;
            width: 175px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .form-fields {
            padding: 30px;
            display: flex;
            flex-direction: column;
        }
        label {
            display: inline-block;
            width: 150px;
            text-align: left;
            margin-right: 10px;
        }
        input[type="submit"] {
            margin-left: 110px;
        }
        input[type="password"], input[type="email"] {
            border-radius: 7px;
        }
        input[type="submit"] {
            border-radius: 7px;
            background-color: #86B6F6;
            color: #fff;
            font-size: 15px;
            width: 100px;
            padding: 8px;
            border: none;
            cursor: pointer;
            display: block;
            margin: 0 auto;
        }
        input[type="submit"]:hover {
            background-color: #5C8EE6;
        }
        .login-txt {
            font-size: 40px;
            margin: 0;
            color: #fff;
            background-color: #86B6F6;
            padding: 10px;
            border-radius: 10px 10px 0 0;
        }
        .form-txt {
            font-size: 40px;
            margin: 0;
            color: #86B6F6;
            background-color: #fff;
            padding: 10px;
            border-radius: 0 0 10px 10px;
        }
    </style>
</head>
<body>
    <form action="login.php" method="POST">
        <div class="form-heading">
            <h1 class="login-txt">Login</h1>
            <h1 class="form-txt">Form</h1>
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