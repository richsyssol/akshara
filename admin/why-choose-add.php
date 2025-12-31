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
    $video = $_FILES['video']['name'];
    $video_tmp = $_FILES['video']['tmp_name'];
    $text = $_POST['text'];

    // Set the upload directory
    $upload_dir = 'uploads/aksharaabout/'; // Ensure this directory exists and has write permissions
    $image_path = $upload_dir . basename($image);
    $video_path = $upload_dir . basename($video);

    // Move uploaded files to the directory
    $image_uploaded = move_uploaded_file($image_tmp, $image_path);
    $video_uploaded = move_uploaded_file($video_tmp, $video_path);

    if ($image_uploaded && $video_uploaded) {
        // Insert file paths into the database
        $sql = "INSERT INTO `why-choose`(`id`, `image`, `video`, `text`) VALUES (NULL, '$image_path', '$video_path', '$text')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Use JavaScript to redirect
            echo '<script>window.location.href = "why-choose";</script>';
            exit();
        } else {
            echo "Database Error: " . mysqli_error($conn);
        }
    } else {
        echo "Failed to upload files.";
    }
}
?>

?>


<div class='dashboard-app'>
    <div class='dashboard-content'>
        <div class='container-fluid'>
        <!-- page title -->
            <div class='container-fluid'>
                <h1>Add About</h1>
            </div>
            <!-- breadcrumb -->
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="banner">About US</a></li>
                <li class="breadcrumb-item"><a>Add About Us</a></li>
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
                                 
                 <label for="video">Video:</label>
    <input type="file" name="video" id="video">
                </div>
                
        
                <div class="mb-3">
                    <h2>Text</h2>
                    <!--<label for="exampleFormControlTextarea1" class="form-label">Text</label>-->
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
