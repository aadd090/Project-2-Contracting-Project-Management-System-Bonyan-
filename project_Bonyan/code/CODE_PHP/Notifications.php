<?php
// Database configuration
$host = '127.0.0.1:3306';
$dbUsername = 'root';
$dbPassword = '';
$dbname = 'bonyan';

// Set up DSN and options
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

// Fetching notifications
try {
    $stmt = $pdo->query('SELECT id, content FROM notifications');
    $notifications = $stmt->fetchAll();
} catch (\PDOException $e) {
    echo "Error fetching notifications: " . $e->getMessage();
    $notifications = [];
}

if (isset($_GET['deleteNotificationId'])) {
    $notificationId = $_GET['deleteNotificationId'];
    // Validate input (to prevent SQL injection)
    if (!is_numeric($notificationId)) {
        echo "Invalid input!";
        exit;
    }
    $sql = "DELETE FROM notifications WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $notificationId]);
    
    // Redirect back to the notifications page or handle accordingly
    // header("Location: notifications.php");
    // exit;
}
?>
