<?php
// Database configuration
$host = '127.0.0.1:3306';
$dbUsername = 'root';
$dbPassword = '';
$dbname = 'bonyan';

// Establishing a connection to the database
$mysqli = new mysqli($host, $dbUsername, $dbPassword, $dbname);

// Check if the connection was successful
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

// Function to sanitize user input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Handling login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user inputs
    $username = sanitize_input($_POST["username"]);
    $password = sanitize_input($_POST["password"]);

    // Prepare SQL statement to retrieve user information from the database
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    
    // Prepare the SQL statement
    if ($stmt = $mysqli->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ss", $username, $password);
        
        // Execute the prepared statement
        $stmt->execute();
        
        // Store the result
        $result = $stmt->get_result();
        
        // Check if there are any rows returned
        if ($result->num_rows == 1) {
            // Authentication successful
            $row = $result->fetch_assoc();
            $role = $row['role']; // Assuming 'role' is a column in your users table representing user role (e.g., admin, customer, contractor)
            
            // Redirect user based on their role 
            switch ($role) {
                case 'admin':
                    header("Location:http://localhost/project_Bonyan/code/CODE_HTML/Admin/Admin_Dashboard.html");
                    break;
                case 'customer':
                    header("Location:http://localhost/project_Bonyan/code/CODE_HTML/Homepagecustomr.html");
                    break;
                case 'contractor':
                    header("Location:http://localhost/project_Bonyan/code/CODE_HTML/Contractor/Contractor_Dashboard.html");
                    break;
                default:
                    // Redirect to a generic page or handle the case as per your requirement
                    break;
            }
        } else {
            // Authentication failed
            echo "Invalid username or password";
        }
        
        // Close the statement
        $stmt->close();
    } else {
        // Error in preparing the SQL statement
        echo "Error: " . $mysqli->error;
    }
    
    // Close the connection
    $mysqli->close();
}
?>
