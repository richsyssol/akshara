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

    if(isset($_POST['submit'])) {
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $text = $_POST['text'];
        
        // Set the upload directory and move the uploaded file
        $upload_dir = 'uploads/service-feature/'; // Ensure this directory exists and has write permissions
        $upload_file = $upload_dir . basename($image);

        if (move_uploaded_file($image_tmp, $upload_file)) {
            // Insert the file path into the database
            $sql = "INSERT INTO `service_feature`(`id`, `image`, `text`) VALUES (NULL, '$upload_file', '$text')";
            $result = mysqli_query($conn, $sql);
            
            if($result){
                // Use JavaScript to redirect
                echo '<script>window.location.href = "service-feature";</script>';
                exit();
              
            } else {
                echo "Failed: " . mysqli_error($conn);
            }
        } else {
            echo "Failed to upload file.";
        }
    }
?>


<div class='dashboard-app'>
    <div class='dashboard-content'>
        <div class='container-fluid'>
        <!-- page title -->
            <div class='container-fluid'>
                <h1>Add Service Feature</h1>
            </div>
            <!-- breadcrumb -->
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="service-feature">Service Feature</a></li>
                <li class="breadcrumb-item"><a>Add Service Feature</a></li>
            </ol>
            </nav>
            <!-- form -->
            <div class="container pt-5 w-50">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="formFile" class="form-label">Select Image</label>
                    <input class="form-control" type="file" name="image" id="formFile" required>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Enter Service Feature</label>
                    <textarea class="form-control" name="text" id="exampleFormControlTextarea1" rows="3"><?php echo $text; ?></textarea>
                </div>
                <div>
                    <input type="submit" name="submit" value="Submit" class="btn btn-success">
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