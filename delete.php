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
    if ($_POST["confirm"] == "Yes") {
        $id = $_GET["id"];
        $sql = "DELETE FROM Users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "User deleted successfully";
            header("Location: dashboard.php"); 
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        header("Location: dashboard.php"); 
    }
} else {
    echo '
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
            text-align: center; /* Center the buttons */
        }

        .form-fields label {
            display: block;
            margin-bottom: 10px;
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

        /* New class for the "Yes" button */
        .form-fields input[type="submit"].btn-yes {
            background-color: #E23936;
        }
        
        .form-fields input[type="submit"].btn-yes:hover {
            background-color: #771E1B;
        }
    </style>
    <form method="POST" class="form-fields">
        <div class="form-heading">
            <h1>Delete Confirmation</h1>
        </div>
        <p>Are you sure you want to delete this user?</p>
        <input type="submit" name="confirm" value="Yes" class="btn-yes">
        <input type="submit" name="confirm" value="No">
    </form>';
}

$conn->close();
?>