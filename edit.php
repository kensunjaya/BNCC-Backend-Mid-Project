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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST["firstName"];
    $lastname = $_POST["lastName"];
    $email = $_POST["email"];
    $bio = $_POST["bio"]; 

    $photo = $user['photo'];
    if ($_FILES['photo']['name']) {
        $newName = uniqid() . '.' . pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/' . $newName);
        $photo = $newName;
    }

    $sql = "UPDATE Users SET firstname = ?, lastname = ?, email = ?, bio = ?, photo = ? WHERE id = ?"; 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $firstname, $lastname, $email, $bio, $photo, $user_id); 
    if ($stmt->execute()) {
        echo "Record updated successfully";
        header("Location: dashboard.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
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
        .form-fields input[type="submit"] {
            background-color: #ffc107; 
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 20px 0;
            cursor: pointer;
            transition: 0.3s;
            border-radius: 5px;
        }

        .form-fields input[type="submit"]:hover {
            background-color: #e0a800; 
        }

        .form-fields .button-container {
            text-align: center;
        }

    </style>
</head>
<body>
    <div class="form-heading">
        <h1>Edit User</h1>
    </div>
    <div class="form-fields">
    <form method="POST" enctype="multipart/form-data">
        <label for="photo">Photo:</label><br>
        <img src='images/<?php echo $user['photo']; ?>' width='100'><br><br><br>
        <input type="file" id="photo" name="photo"><br><br>
        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" value="<?php echo isset($user['firstName']) ? $user['firstName'] : ''; ?>" required>
        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" value="<?php echo isset($user['lastName']) ? $user['lastName'] : ''; ?>" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>" required>
        <label for="bio">Bio:</label>
        <textarea id="bio" name="bio" required><?php echo isset($user['bio']) ? $user['bio'] : ''; ?></textarea>
        <div class="button-container">
            <input type="submit" value="Update">
        </div>
    </form>
</div>
</body>
</html>