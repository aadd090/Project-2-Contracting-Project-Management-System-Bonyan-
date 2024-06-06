<?php
$host = '127.0.0.1';
$dbUsername = 'root';
$dbPassword = '';
$dbname = 'bonyan';

// Create connection using MySQLi
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$customerID = "i";  // Assuming this is fetched from session or request

// SQL query to select projects for a specific customer using CustomerID
$sql = "SELECT ProjectID, ProjectName, ProjectRequirements FROM customerprojects WHERE CustomerID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customerID);
$stmt->execute();
$result = $stmt->get_result();

// Prepare an array to hold project data
$projects = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
}

// Close connection
$stmt->close();
$conn->close();
?>