<?php include 'attach/header.php'; ?>

<?php
// Include your database connection file
include 'include/db_conn.php';

?>

<!--<form action="send-mail.php" method="post">-->
<!--    <label for="username">Enter your username:</label>-->
<!--    <input type="text" name="username" required>-->
<!--    <input type="submit" name="forgot" value="Send Reset Link">-->
<!--</form>-->

<div class="container-fluid login">
    <!--<div>-->
    <!--    <img src="asset/image/logo.png">-->
    <!--</div>-->
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="card-title text-center mb-4">Send Mail</h3>
                        <form action="send-mail.php" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">Enter Your Email</label>
                                <input type="text" name="username" class="form-control" id="username" placeholder="Enter your Email" required>
                            </div>
                            <div class="d-grid">
                                <input type="submit" name="forgot" value="Send Reset Link" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include 'attach/footer.php'; ?>