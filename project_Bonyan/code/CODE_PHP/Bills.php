<?php
// Database configuration
$host = '127.0.0.1:3306';  // Ensure your DB host is correct, and port is specified if not default
$dbUsername = 'root';      // Typically 'root' is used for localhost, but ensure it is your DB username
$dbPassword = '';          // Ensure your DB password is correct; often empty for localhost but not recommended for production
$dbname = 'bonyan';        // The name of your database
$charset = 'utf8mb4';      // Recommended charset for compatibility

// Data Source Name
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";  // Ensure variables are correctly used
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // Throw exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // Fetch results as associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                   // Use real prepared statements
];

try {
    $pdo = new PDO($dsn, $dbUsername, $dbPassword, $options);  // Correct variable names used for username and password
} catch (PDOException $e) {  // Removed the unnecessary namespace slash before PDOException
    echo "Connection failed: " . $e->getMessage();  // Provide a user-friendly error message
    exit();  // Exit script if connection fails
}

// Fetch bills from the database
$sql = "SELECT * FROM bills"; // Adjust SQL based on your actual bills table structure
$stmt = $pdo->query($sql);
$bills = $stmt->fetchAll();

// Optionally, you can handle the case where no bills are found
if (empty($bills)) {
    echo "No bills found.";  // User-friendly message if no bills are available
}
?>
