<?php
session_start();

// Only proceed if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Database configuration
$host = '127.0.0.1:3306';
$dbUsername = 'root';
$dbPassword = '';
$dbname = 'bonyan';

// Set up DSN and options
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Check if the action is set
if (isset($_POST['action']) && isset($_POST['tender_id'])) {
    $tenderId = $_POST['tender_id'];
    $action = $_POST['action'];
    $status = ($action == 'accept') ? 'Accepted' : 'Rejected';

    // Prepare the SQL statement based on the action
    $stmt = $pdo->prepare("UPDATE tenders SET status = :status WHERE id = :id");
    $stmt->execute([':status' => $status, ':id' => $tenderId]);

    // Redirect after action
    $redirectUrl = ($action == 'accept') ? 'Payment.html' : 'Create_Project.html';
    header('Location: ' . $redirectUrl);
    exit();
}
?>
