
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
        $sql = "SELECT * FROM `blog_titles` WHERE `id` = $id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        if (!$row) {
            echo "No blog title found with this ID.";
            exit();
        }

        // Check if the form has been submitted
        if (isset($_POST['submit'])) {
            $b_title = $_POST['b_title'];
            $description = $_POST['description'];

            // Update the career entry
            $sql = "UPDATE `blog_titles` SET `b_title`='$b_title', `description`='$description' WHERE `id` = $id";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo '<script>window.location.href = "blog-title.php";</script>';
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
                <h1>Edit Blog Title</h1>
            </div>
            <!-- breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="blog-title.php">Blog Title</a></li>
                    <li class="breadcrumb-item " aria-current="page">Edit Blog Title</li>
                </ol>
            </nav>
            <!-- form -->
            <div class="container pt-5 w-50">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="qualification" class="form-label">Blog Title</label>
                        <input type="text" class="form-control" name="b_title" id="qualification" placeholder="Enter Qualification" value="<?php echo $row['b_title']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <h2>Blog Description</h2>
                        <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3" required><?php echo $row['description']; ?></textarea>
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