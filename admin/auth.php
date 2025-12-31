<?php 
include 'include/db_conn.php';

// Start the session
session_start();

// Function to sanitize inputs
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Initialize error message
$error_message = '';

// Login user
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if required fields are set
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = sanitize_input($_POST['username']);
        $password = sanitize_input($_POST['password']);

        // Validate inputs
        if (empty($username) || empty($password)) {
            $error_message = "Please fill in all required fields.";
        } else {
            // Prepare the SQL statement to prevent SQL injection
            $stmt = $conn->prepare("SELECT password FROM user WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $hashed_password = $row['password'];

                // Verify password
                if (password_verify($password, $hashed_password)) {
                    $_SESSION['username'] = $username;
                    $_SESSION['loggedin'] = true;
                    // Redirect to index.php
                    header("Location: index");
                    exit();
                } else {
                    $error_message = "Invalid password.";
                }
            } else {
                $error_message = "User not found.";
            }

            $stmt->close();
        }
    } else {
        $error_message = "Please fill in the required fields.";
    }
    
    // Redirect back to login page with error message
    $_SESSION['error_message'] = $error_message;
    header("Location: login");
    exit();
}

$conn->close();
?>
