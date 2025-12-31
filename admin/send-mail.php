<?php
// PHPMailer configuration
require_once '../phpmailer/src/PHPMailer.php';
require_once '../phpmailer/src/SMTP.php';
require_once '../phpmailer/src/Exception.php';
require_once 'include/db_conn.php';




if (isset($_POST['forgot'])) {
    $username = $_POST['username'];

    // Check if the username exists in the database
    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // Generate a random token for password reset
        $token = bin2hex(random_bytes(16));
    
        // Set the reset token and expiry time in the database
        $expiry_time = date('Y-m-d H:i:s', strtotime('+1 hour')); // 1 hour expiry time
        $query = "UPDATE user SET reset_token = '$token', reset_expiry = '$expiry_time' WHERE username = '$username'";
        mysqli_query($conn, $query);
    
        // Send the password reset link using PHPMailer
        
        
        // mail function start
        
        
function send_password_reset_email($user_email, $token) {
    $mail = new PHPMailer\PHPMailer\PHPMailer();

    // Set mailer to use SMTP
    $mail->isSMTP();

    // Set SMTP server details
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'namratayevale7@gmail.com';
    $mail->Password = 'pflyupscjvghxfzx';
    $mail->SMTPSecure = 'ssl'; // or 'ssl' for SSL
    $mail->Port = 465; // or 465 for SSL

    // Set sender email and name
    $mail->setFrom('your_email_address', 'Your Name');

    // Add recipient email and name
    $mail->addAddress($user_email, $user['username']);

    // Set email subject and body
    $mail->Subject = 'Password Reset Link';
    $mail->Body = 'Click on the following link to reset your password: https://precision.demovoting.com/admin/reset_password.php?token=' . $token . ' Reset Password';

    // Send the email
    if (!$mail->send()) {
        return false;
    } else {
        return true;
    }
}
        
        //mail function end
        
        
        
        
       
        if (send_password_reset_email($user['username'], $token)) {
            echo "Password reset link sent to your email!";
        } else {
            echo "Failed to send password reset link!";
        }
    }
    else {
        echo "Username not found!";
    }
}






























?>