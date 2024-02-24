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
    die("User with ID $user_id not found");
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View User</title>
    <style>
        * {
            box-sizing: border-box;
        }

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

        .form-fields label {
            display: block;
            margin-bottom: 10px;
        }

        .form-fields input[type="text"],
        .form-fields input[type="email"],
        .form-fields textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 20px;
            max-width: 100%; 
            resize: vertical; 
        }
    </style>
</head>
<body>
    <div class="form-heading">
        <h1>User Details</h1>
    </div>
    <div class="form-fields">
        <label for="photo">Photo:</label><br>
        <img id="photo" src='images/<?php echo $user['photo']; ?>' width='100'><br><br>
        <label for="firstName">First Name:</label><br>
        <input type="text" id="firstName" name="firstName" value="<?php echo isset($user['firstName']) ? $user['firstName'] : ''; ?>" disabled><br>
        <label for="lastName">Last Name:</label><br>
        <input type="text" id="lastName" name="lastName" value="<?php echo isset($user['lastName']) ? $user['lastName'] : ''; ?>" disabled><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>" disabled><br>
        <label for="bio">Bio:</label><br>
        <textarea id="bio" name="bio" disabled><?php echo isset($user['bio']) ? $user['bio'] : ''; ?></textarea><br>
    </div>
</body>
</html>