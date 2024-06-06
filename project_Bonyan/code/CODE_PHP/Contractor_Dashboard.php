<?php
// Database configuration
$host = '127.0.0.1:3306';
$dbUsername = 'root';
$dbPassword = '';
$dbname = 'bonyan';
// PDO connection setup
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Handling form submissions for contacting
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['contact_submit'])) {
    // Collect and sanitize input
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    // Insert the data into the database
    $sql = "INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $email, $message]);

    // Redirect or show a success message
    echo 'Thank you for contacting us!';
}

// Handling project deletion
if (isset($_POST['delete']) && isset($_POST['project_id'])) {
    $projectId = $_POST['project_id'];

    $sql = "DELETE FROM projects WHERE project_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$projectId]);

    echo 'Project deleted successfully.';
}
?>
