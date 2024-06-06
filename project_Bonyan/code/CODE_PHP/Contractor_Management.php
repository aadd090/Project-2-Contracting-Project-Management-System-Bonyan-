<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Database configuration
$host = '127.0.0.1:3306';
$dbUsername = 'root';
$dbPassword = '';
$dbname = 'bonyan';
$charset = 'utf8mb4';

// PDO connection setup
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $dbUsername, $dbPassword, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Fetch projects from the 'project' table
$stmt = $pdo->query("SELECT * FROM project");
$projects = $stmt->fetchAll();

// Handle form submissions for project management actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['delete']) && isset($_POST['project_id'])) {
        // Deleting a project
        $deleteStmt = $pdo->prepare("DELETE FROM project WHERE id = :id");
        $deleteStmt->execute([':id' => $_POST['project_id']]);
        header('Location: ' . $_SERVER['PHP_SELF']); // Prevent form resubmission
        exit();
    }
    // Other actions like suspending contractors can be handled here
}

?>