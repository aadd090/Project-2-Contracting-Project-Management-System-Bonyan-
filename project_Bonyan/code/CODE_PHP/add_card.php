<?php
session_start(); // Start session if not already started

// Database configuration
$host = '127.0.0.1:3306';
$dbUsername = 'root';
$dbPassword = '';
$dbname = 'bonyan';

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract and sanitize input data
    $nameOnCard = filter_input(INPUT_POST, 'name-on-card', FILTER_SANITIZE_STRING);
    $cardNumber = filter_input(INPUT_POST, 'card-number', FILTER_SANITIZE_NUMBER_INT);
    $expirationDate = filter_input(INPUT_POST, 'expiration-date', FILTER_SANITIZE_STRING);
    $cvc = filter_input(INPUT_POST, 'cvc', FILTER_SANITIZE_NUMBER_INT);

    try {
        // Connect to database
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute SQL statement
        $sql = "INSERT INTO your_table_name (name_on_card, card_number, expiration_date, cvc) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nameOnCard, $cardNumber, $expirationDate, $cvc]);

        // Set success message
        $_SESSION['message'] = 'Card added successfully!';
    } catch (PDOException $e) {
        // Set error message
        $_SESSION['error'] = "Error adding card: " . $e->getMessage();
    }

    // Redirect back to account page or display a message
    header('Location: add_card.php');
    exit();
}
?>

<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['message']; ?>
    </div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger">
        <?= $_SESSION['error']; ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>
?>
