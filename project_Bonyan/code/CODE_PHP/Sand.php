<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not
    header("Location: login.php");
    exit();
}
// Database configuration
$host = '127.0.0.1:3306';
$dbUsername = 'root';
$dbPassword = '';
$dbname = 'bonyan';

// Create a new PDO connection
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

// Retrieve messages from the database
$messages = [];
$stmt = $pdo->prepare("SELECT * FROM messages WHERE user_id = :user_id ORDER BY timestamp ASC");
$stmt->execute([':user_id' => $_SESSION['user_id']]);
$messages = $stmt->fetchAll();

?>
<?php
// This file would be named send_message.php or similar
session_start();

// Check user session and the message POST data
if (isset($_SESSION['user_id']) && isset($_POST['text'])) {
    // Include the database connection code here...
    
    // Sanitize the input
    $text = trim($_POST['text']);
    $userId = $_SESSION['user_id']; // The ID of the sending user

    // Insert the message into the database
    $stmt = $pdo->prepare("INSERT INTO messages (user_id, text, timestamp) VALUES (:user_id, :text, NOW())");
    $stmt->execute([':user_id' => $userId, ':text' => $text]);

    // Redirect back to the chat page
    header("Location: chat.php");
    exit();
}

// If the user is not logged in or the text is not set, redirect to the chat page
header("Location: chat.php");
exit();
?>
