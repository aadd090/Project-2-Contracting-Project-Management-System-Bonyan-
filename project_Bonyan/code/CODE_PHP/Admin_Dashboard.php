<?php
session_start();
// Database configuration
$host = '127.0.0.1:3306';
$dbUsername = 'root';
$dbPassword = '';
$dbname = 'bonyan';

// Check if the user is logged in as an admin
if (!isset($_SESSION['admin_id'])) {
    // Redirect to the login page if not logged in
    header('Location: http://localhost/project_Bonyan/code/CODE_PHP/Login.php');
    exit();
}

// Create a new PDO connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Failed to connect to database: " . $e->getMessage());
}

// Handle POST request for adding a new project
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['new_project_name'])) {
    $newProjectName = $_POST['new_project_name'];
    
    // Insert the new project into the database
    $stmt = $pdo->prepare("INSERT INTO projects (name) VALUES (?)");
    $stmt->execute([$newProjectName]);
    
    // Redirect to avoid form resubmission
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Retrieve existing projects from the database
$projects = [];
$stmt = $pdo->query("SELECT * FROM projects");
$projects = $stmt->fetchAll();

// Retrieve projects for tender from the database
$projectsForTender = [];
$stmt = $pdo->query("SELECT * FROM projects WHERE status = 'For Tender'");
$projectsForTender = $stmt->fetchAll();

// Retrieve current tenders from the database
$tenders = [];
$stmt = $pdo->query("SELECT * FROM tenders WHERE status = 'Open'");
$tenders = $stmt->fetchAll();

// Retrieve contractors from the database
$contractors = [];
$stmt = $pdo->query("SELECT * FROM contractors");
$contractors = $stmt->fetchAll();

// Retrieve invoices from the database
$invoices = [];
$stmt = $pdo->query("SELECT * FROM invoices");
$invoices = $stmt->fetchAll();

// Handle payment processing form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['invoice_id'])) {
    $invoiceId = $_POST['invoice_id'];
    // Payment processing logic goes here...
    // For example, updating the invoice status to "Paid"
    $updateStmt = $pdo->prepare("UPDATE invoices SET status = 'Paid' WHERE id = ?");
    $updateStmt->execute([$invoiceId]);

    // Redirect to avoid form resubmission
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

?>