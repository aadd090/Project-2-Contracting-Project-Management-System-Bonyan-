<?php
session_start();

// Database configuration
$host = '127.0.0.1:3306';
$dbUsername = 'root';
$dbPassword = '';
$dbname = 'bonyan';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract and sanitize input data
    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phoneNumber = filter_input(INPUT_POST, 'phoneNumber', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);

    try {
        // Connect to the database
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbUsername, $dbPassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare update queries based on the role
        if ($role === 'customer') {
            $sql = "UPDATE customer SET first_name = ?, last_name = ?, username = ?, password = ?, phone_number = ?, email = ? WHERE CustomerID = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$firstName, $lastName, $username, $password, $phoneNumber, $email, $_SESSION['user_id']]);
        } elseif ($role === 'contractor') {
            $sql = "UPDATE contractor SET first_name = ?, last_name = ?, username = ?, password = ?, phone_number = ?, email = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$firstName, $lastName, $username, $password, $phoneNumber, $email, $_SESSION['user_id']]);
        } else {
            throw new Exception('Invalid role specified.');
        }

        // Update `users` table for both roles
        $sql = "UPDATE users SET username = ?, password = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $password, $_SESSION['user_id']]);

        // Set a success message
        $_SESSION['message'] = 'Account updated successfully.';
    } catch (PDOException $e) {
        // Set error message
        $_SESSION['error'] = "Error updating account: " . $e->getMessage();
    } catch (Exception $e) {
        // Handle other exceptions
        $_SESSION['error'] = "General error: " . $e->getMessage();
    }

    // Redirect back to the account page or display a message
    header('Location: /project_Bonyan/code/CODE_PHP/Homepagecustomr.html');
    exit();
}
