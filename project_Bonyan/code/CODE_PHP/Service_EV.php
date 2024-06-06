<?php
session_start(); // This should be at the top of your PHP script.
// After verifying the user's credentials

// Database configuration
$host = '127.0.0.1:3306';
$user = 'root';
$pass = '';
$dbname = 'bonyan';
$charset = 'utf8mb4';

// Create a new PDO connection
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['rating'], $_POST['notes'])) {
    if (!isset($_SESSION['user_id'])) {
        // Redirect to login or error page if user_id is not set
        header('Location: http://localhost/project_Bonyan/code/CODE_HTML/Homepagecustomr.html');
        exit();
    }

    $rating = $_POST['rating'];
    $notes = $_POST['notes'];
    $user_id = $_SESSION['user_id']; // Make sure this is set during user login

    // Insert the service evaluation into the database
    $stmt = $pdo->prepare("INSERT INTO service_evaluations (rating, notes, user_id, timestamp) VALUES (:rating, :notes, :user_id, NOW())");
    $stmt->execute([
        ':rating' => $rating,
        ':notes' => $notes,
        ':user_id' => $user_id
    ]);

    // Redirect to a thank you page or display a success message
    header('Location: http://localhost/project_Bonyan/code/CODE_HTML/Homepagecustomr.html');
    exit();
} else {
    // Redirect if form submission method is not POST
    header('Location:http://localhost/project_Bonyan/code/CODE_HTML/Homepagecustomr.html');
    exit();
}
?>
