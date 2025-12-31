<?php
// Include your database connection file
include 'include/db_conn.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token exists in the database and is not expired
    $query = "SELECT * FROM user WHERE reset_token = '$token' AND reset_expiry > NOW()";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // Display a form to reset the password
        ?>
        <!--<form action="" method="post">-->
        <!--    <label for="password">Enter new password:</label>-->
        <!--    <input type="password" name="password" required>-->
        <!--    <input type="submit" name="reset" value="Reset Password">-->
        <!--</form>-->
        <div class="container-fluid login">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <h3 class="card-title text-center mb-4">Send Mail</h3>
                            <form action="" method="post">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Enter New Password</label>
                                    <input type="password" name="password" class="form-control" id="username" placeholder="Enter your Password" required>
                                </div>
                                <div class="d-grid">
                                    <input type="submit" name="reset" value="Reset Password" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
    } else {
        echo "Invalid or expired token!";
    }
}

if (isset($_POST['reset'])) {
    $password = $_POST['password'];
    $token = $_GET['token'];

    // Hash the password using password_hash()
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Update the user's password in the database
    $query = "UPDATE user SET password = '$hashed_password', reset_token = '', reset_expiry = NULL WHERE reset_token = '$token'";
    mysqli_query($conn, $query);

    // Redirect to login.php page
    header('Location: login.php');
    exit;
}
?>