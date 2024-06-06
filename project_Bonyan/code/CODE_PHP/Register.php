<?php
// Database configuration
$host = '127.0.0.1:3306';
$dbUsername = 'root';
$dbPassword = '';
$dbname = 'bonyan';

// Create connection
$mysqli = new mysqli($host, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['first-name'] ?? null;
    $lastName = $_POST['last-name'] ?? null;
    $username = $_POST['username'] ?? null;
    $password = $_POST['password'] ?? null;
    $phoneNumber = $_POST['phone-number'] ?? null;
    $email = $_POST['email'] ?? null;

    // Check for missing fields
    if (null === $firstName || null === $lastName || null === $username || 
        null === $password || null === $phoneNumber || null === $email) {
        die('Please fill all required fields.');
    }

    // Check for existing username
    $checkStmt = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    $checkStmt->close();

    if ($result->num_rows > 0) {
        echo "Username already exists. Please choose a different username.";
    } else {
        // Insert into the customer table
        $stmt1 = $mysqli->prepare("INSERT INTO customer (first_name, last_name, email, username, phone_number, password) VALUES (?, ?, ?, ?, ?, ?)");
        if (false === $stmt1) {
            die('MySQL prepare error: ' . $mysqli->error);
        }
        $stmt1->bind_param("ssssss", $firstName, $lastName, $email, $username, $phoneNumber, $password);

        // Insert into the users table
        $stmt2 = $mysqli->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        if (false === $stmt2) {
            die('MySQL prepare error: ' . $mysqli->error);
        }
        $role = 'customer';
        $stmt2->bind_param("sss", $username, $password, $role);

        // Execute the queries
        if ($stmt1->execute() && $stmt2->execute()) {
            echo "Customer and User registered successfully.";
            header('Location: http://localhost/project_Bonyan/code/CODE_HTML/Login.html');
            exit();
        } else {
            echo "Error: " . $stmt1->error . " and " . $stmt2->error;
        }

        // Close the prepared statements
        $stmt1->close();
        $stmt2->close();
    }

    // Close the database connection
    $mysqli->close();
}
?>
