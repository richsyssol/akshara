<?php 
session_start(); // Start the session

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true ) {
    // Redirect to login page if not logged in
    header("Location: login.php"); // Adjust path if needed
    exit(); // Ensure no further code is executed
}
else{
    include 'attach/header.php'; 
    include 'attach/navbar.php';  
 
?>

<?php 
    include 'include/db_conn.php';

    // Get the career ID from the URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Fetch the existing data
        $sql = "SELECT * FROM `blog_faq` WHERE `id` = $id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        if (!$row) {
            echo "No blog title found with this ID.";
            exit();
        }

        // Check if the form has been submitted
        if (isset($_POST['submit'])) {
            $que = $_POST['que'];
            $ans = $_POST['ans'];

            // Update the career entry
            $sql = "UPDATE `blog_faq` SET `que`='$que', `ans`='$ans' WHERE `id` = $id";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo '<script>window.location.href = "blog-faq.php";</script>';
                exit();
            } else {
                echo "Failed: " . mysqli_error($conn);
            }
        }
    } else {
        echo "No ID provided.";
        exit();
    }
?>

<div class='dashboard-app'>
    <div class='dashboard-content'>
        <div class='container-fluid'>
            <!-- page title -->
            <div class='container-fluid'>
                <h1>Edit Blog FAQ</h1>
            </div>
            <!-- breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="blog-faq.php">Blog FAQ</a></li>
                    <li class="breadcrumb-item " aria-current="page">Edit Blog FAQ</li>
                </ol>
            </nav>
            <!-- form -->
            <div class="container pt-5 w-50">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="qualification" class="form-label">Enter Queastion</label>
                        <input type="text" class="form-control" name="que" id="qualification" placeholder="Enter Qualification" value="<?php echo $row['que']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <h2>Enter Answer</h2>
                        <textarea class="form-control" name="ans" id="exampleFormControlTextarea1" rows="3" required><?php echo $row['ans']; ?></textarea>
                    </div>
                    <div>
                        <input type="submit" name="submit" value="Update" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'attach/footer.php'; ?>

<!-- Include CKEditor script -->
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('exampleFormControlTextarea1');
</script>

<?php 
    
}
?>