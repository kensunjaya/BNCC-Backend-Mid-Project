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
    <title>Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #EEF5FF;
            padding: 20px;
        }

        .form-heading {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-fields {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            max-width: 500px;
            margin: auto;
        }

        .detail-box {
            background-color: #f1f1f1;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .logout-button {
            background-color: red;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            display: block;
            margin: auto;
            margin-top: 20px;
            width: 100px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .logout-button:hover {
            background-color: darkred;
        }

        .logout-button:active {
            background-color: #700;
        }
    </style>
</head>
<body>
    <div class="form-fields">
        <label>Photo:</label>
        <div class="detail-box">
            <img src='images/<?php echo $user['photo']; ?>' width='100'>
        </div>
        <label>Full Name:</label>
        <div class="detail-box">
            <p><?php echo $user['firstName']; ?> <?php echo $user['lastName']; ?></p>
        </div>
        <label>Email:</label>
        <div class="detail-box">
            <p><?php echo $user['email']; ?></p>
        </div>
        <label>Bio:</label>
        <div class="detail-box">
            <textarea readonly style="width: 100%; border: none; background: none;"><?php echo $user['bio']; ?></textarea>
        </div>
        <a class="logout-button" href="login.php">Logout</a>
    </div>
</body>
</html>