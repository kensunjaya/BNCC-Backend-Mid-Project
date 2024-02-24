<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "attendance_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $photo = "default.jpg"; 
    if (isset($_FILES['image'])) {
        if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $originalName = $_FILES['image']['name'];
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            $newName = uniqid() . '.' . $extension;
            $photo = $newName;
            $upload_dir = 'images/'; 
            if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir.$photo)) {
                echo "File uploaded successfully.";
            } else {
                echo "File upload failed.";
            }
        } else {
            echo "File upload error: " . $_FILES['image']['error'];
        }
    }

    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $bio = $_POST["bio"];
    $password = md5($firstname . "123"); 

    $sql = "INSERT INTO Users (firstname, lastname, email, bio, photo, password) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $firstname, $lastname, $email, $bio, $photo, $password);

    if ($stmt->execute()) {
        echo "New record created successfully";
        header("Location: dashboard.php"); 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
        <title>User Registration</title>
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
                    background-color: #007BFF;
                    color: #fff;
                    padding: 10px 20px;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                }

                .form-fields input[type="submit"]:hover {
                    background-color: #0056b3;
                }
        </style>
</head>
<body>
    <form method="post" action="register.php" enctype="multipart/form-data">
        <div class="form-heading">
            <h1 class="login-txt">Register</h1>
            <h1 class="form-txt">Form</h1>
        </div>
        <div class="form-fields">
            <label for="image">Image:</label>
            <img id="imagePreview" src="#" alt="Image Preview" style="display: none;"/><br>
            <input type="file" id="image" name="image" required><br><br>
            <label for="firstname">First name:</label>
            <input type="text" id="firstname" name="firstname" required><br>
            <label for="lastname">Last name:</label>
            <input type="text" id="lastname" name="lastname" required><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            <label for="bio">Bio:</label>
            <textarea id="bio" name="bio" required></textarea><br>
            <input type="submit" value="Register">
        </div>
    </form>
</body>
</html>

<img id="imagePreview" src="#" alt="Image Preview" style="display: none;"/>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById('imagePreview').style.display = 'block';
                document.getElementById('imagePreview').src = e.target.result;
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    document.getElementById('image').addEventListener('change', function() { readURL(this); });
</script>