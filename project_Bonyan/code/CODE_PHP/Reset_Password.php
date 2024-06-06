<?php
// Database configuration
$host = '127.0.0.1:3306';
$dbname = 'bonyan';
$dbUsername = 'root'; // Replace with your actual database username
$dbPassword = ''; // Replace with your actual database password
$charset = 'utf8mb4';

// Create a new PDO connection
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    // Use defined variables for database credentials
    $pdo = new PDO($dsn, $dbUsername, $dbPassword, $options);
} catch (PDOException $e) {
    // Provide a helpful message if the connection fails
    die('Database connection failed: ' . $e->getMessage());
}

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['phone_number'])) {
    // Sanitize the input
    $phoneNumber = filter_var($_POST['phone_number'], FILTER_SANITIZE_NUMBER_INT);

    // Validate the phone number (you may enhance this logic)
    $stmt = $pdo->prepare("SELECT * FROM customer WHERE phone_number = :phone_number");
    $stmt->execute([':phone_number' => $phoneNumber]);
    $customer = $stmt->fetch();

    if ($customer) {
        // Generate a new password
        $newPassword = rand(100000, 999999); // Example: Generate a random 6-digit number

        // Update the customer's password in the database
        $updateStmt = $pdo->prepare("UPDATE customer SET password = :password WHERE phone_number = :phone_number");
        $updateStmt->execute([
            ':password' => password_hash($newPassword, PASSWORD_DEFAULT),
            ':phone_number' => $phoneNumber
        ]);

        echo "A new password has been sent to your phone number.";
        header('Location: http://localhost/project_Bonyan/code/CODE_HTML/Login.html');

    } else {
        echo "Phone number not found.";
        header('Location: http://localhost/project_Bonyan/code/CODE_HTML/Login.html');

    }
}
?>
