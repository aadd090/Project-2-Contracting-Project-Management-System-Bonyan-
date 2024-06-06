<?php
// Database configuration
$host = '127.0.0.1:3306';
$dbUsername = 'root';
$dbPassword = '';
$dbname = 'bonyan';

header('Content-Type: application/json');

// Create connection
$mysqli = new mysqli($host, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($mysqli->connect_error) {
    echo json_encode(['success' => false, 'message' => "Connection failed: " . $mysqli->connect_error]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input
    $firstName = $mysqli->real_escape_string($_POST['first-name']);
    $lastName = $mysqli->real_escape_string($_POST['last-name']);
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = $mysqli->real_escape_string($_POST['password']);
    $confirmPassword = $mysqli->real_escape_string($_POST['confirm-password']);
    $phoneNumber = $mysqli->real_escape_string($_POST['phone-number']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $workInstitution = $mysqli->real_escape_string($_POST['work-institution']);
    $commercialNumber = $mysqli->real_escape_string($_POST['commercial-number']);
    $job = $mysqli->real_escape_string($_POST['job']);
    $services = $mysqli->real_escape_string($_POST['services']);
    $region = $mysqli->real_escape_string($_POST['region']);
    $city = $mysqli->real_escape_string($_POST['city']);

    // Check required fields
    if (empty($firstName) || empty($lastName) || empty($username) || empty($password) ||
        empty($phoneNumber) || empty($email) || empty($job) || empty($services) ||
        empty($region) || empty($city)) {
        echo json_encode(['success' => false, 'message' => 'Please fill all required fields.']);
        $mysqli->close();
        exit;
    }

    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
        $mysqli->close();
        exit;
    }

    // Check if username exists
    $stmt = $mysqli->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Username already exists.']);
        $stmt->close();
        $mysqli->close();
        exit;
    }
    $stmt->close();

    // Insert contractor into the database
    $stmt = $mysqli->prepare("INSERT INTO contractor (first_name, last_name, work_institution, commercial_number, username, password, phone_number, job, services, region, city) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $firstName, $lastName, $workInstitution, $commercialNumber, $username, $password, $phoneNumber, $job, $services, $region, $city);
    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Error registering contractor: ' . $stmt->error]);
        $stmt->close();
        $mysqli->close();
        exit;
    }
    $stmt->close();

    // Insert user into the users table
    $stmt = $mysqli->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'contractor')");
    $stmt->bind_param("ss", $username, $password);
    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'Error registering user: ' . $stmt->error]);
        $stmt->close();
        $mysqli->close();
        exit;
    }
    $stmt->close();

    // Redirect to login page after success
    header("Location: http://localhost/project_Bonyan/code/CODE_HTML/Login.html");
    $mysqli->close();
    exit;
}
?>
