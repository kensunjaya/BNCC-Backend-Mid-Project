<!DOCTYPE html>

<style>
    .short-search-bar {
        width: 50%; 
        margin: auto;
    }
</style>

<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-light bg-light">
        <div class="navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link btn btn-light" href="dashboard.php">Dashboard <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-light" href="profile.php">Profile</a>
                </li>
            </ul>
        </div>
    </nav>
    <div style='background-color: #FFFFFF; padding: 20px; border-radius: 10px; width: 60%; margin: auto; margin-bottom: 20px;'>
        <form action="dashboard.php" method="get">
            <div class="input-group rounded">
                <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" name="query" />
                <div class="input-group-append">
                    <input class="btn btn-outline-secondary" type="submit" id="search-addon" value="Search">
                </div>
            </div>
        </form>
    <br/>

<?php
echo "<body style='background-color: #EEF5FF;'>";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "attendance_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = isset($_GET['query']) ? $_GET['query'] : '';
$sql = "SELECT id, CONCAT(firstname, ' ', lastname) AS fullname, email, photo FROM Users WHERE role != 'admin' AND CONCAT(firstname, ' ', lastname) LIKE ?";
$stmt = $conn->prepare($sql);
$searchTerm = "%" . $query . "%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<table class='table table-striped' style='width:100%;'>";
    echo "<thead><tr><th>ID</th><th>Photo</th><th>Full Name</th><th>Email</th><th>Actions</th></tr></thead>";
    echo "<tbody>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["id"]."</td>";
        echo "<td><img src='images/" . $row["photo"]. "' width='100'></td>";
        echo "<td>".$row["fullname"]."</td><td>".$row["email"]."</td>";
        echo "<td><a href='View.php?id=".$row["id"]."' class='btn btn-success'>View</a> <a href='edit.php?id=".$row["id"]."' class='btn btn-primary'>Edit</a> <a href='delete.php?id=".$row["id"]."' class='btn btn-danger'>Delete</a></td></tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "0 results";
}
echo "</div>"; 
echo "<br>";
echo "</table>";
echo "<div style='width: 50%; margin: auto; text-align: center;'><a href='register.php ####' class='btn btn-warning'>Add New User +</a></div>";
$conn->close();
?>
</body>
</html>