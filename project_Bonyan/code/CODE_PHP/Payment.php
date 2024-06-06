<?php
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

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data - validate and sanitize this in a real-world application
    $amount = $_POST['amount'] ?? 0;
    $projectName = $_POST['projectName'] ?? '';
    $customerName = $_POST['customerName'] ?? '';
    $paymentDate = date('Y-m-d'); // For simplicity, using the current date
    $status = 'Completed'; // Example status

    // Prepare SQL statement
    $sql = "INSERT INTO payment (amount, paymentDate, status, projectName, customerName) VALUES (:amount, :paymentDate, :status, :projectName, :customerName)";
    $stmt = $pdo->prepare($sql);

    // Bind parameters and execute
    try {
        $stmt->execute([
            ':amount' => $amount,
            ':paymentDate' => $paymentDate,
            ':status' => $status,
            ':projectName' => $projectName,
            ':customerName' => $customerName
        ]);
        echo "Payment recorded successfully!";
    } catch (\PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
