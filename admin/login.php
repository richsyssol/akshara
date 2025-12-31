<?php 
include 'attach/header.php'; 
session_start(); // Start the session to access error messages

// Retrieve error message from session
$error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : '';
// Clear error message from session
unset($_SESSION['error_message']);
?>

<div class="container-fluid login">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h3 class="card-title text-center mb-4">Login</h3>
                    
                    <!-- Display error message -->
                    <?php if ($error_message): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>
                    
                    <form action="auth.php" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" id="username" placeholder="Enter your username" >
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" >
                        </div>
                        <div class="d-grid">
                            <input type="submit" name="login" value="Login" class="btn btn-primary">
                        </div>
                    </form>
                    <div class="text-center mt-3">
                        <a href="forgot_pass.php" class="text-decoration-none">Forgot your password?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'attach/footer.php'; ?>
