<?php 
session_start(); // Start the session

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirect to login page if not logged in
    header("Location: login.php"); // Adjust path if needed
    exit(); // Ensure no further code is executed
} else {
    include 'attach/header.php'; 
    include 'attach/navbar.php';  

    include 'include/db_conn.php';

    // Check if id is set in URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Fetch the existing record
        $sql = "SELECT * FROM `aksharaeng` WHERE `id` = $id";
        $result = mysqli_query($conn, $sql);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $record = mysqli_fetch_assoc($result);
            $existing_image = $record['image'];
            $existing_video = $record['video'];
            $existing_text = $record['text'];
        } else {
            echo "Record not found.";
            exit();
        }
    } else {
        echo "Invalid request.";
        exit();
    }

    if (isset($_POST['submit'])) {
        $text = $_POST['text'];
        $image_path = $existing_image;
        $video_path = $existing_video;

        // Handle image upload
        if (!empty($_FILES['image']['name'])) {
            $image = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];
            $upload_dir = 'uploads/aksharaabout/';
            $image_path = $upload_dir . basename($image);
            if (!move_uploaded_file($image_tmp, $image_path)) {
                echo "Failed to upload image.";
                exit();
            }
        }

        // Handle video upload
        if (!empty($_FILES['video']['name'])) {
            $video = $_FILES['video']['name'];
            $video_tmp = $_FILES['video']['tmp_name'];
            $upload_dir = 'uploads/aksharaabout/';
            $video_path = $upload_dir . basename($video);
            if (!move_uploaded_file($video_tmp, $video_path)) {
                echo "Failed to upload video.";
                exit();
            }
        }

        // Update the record in the database
        $sql = "UPDATE `aksharaeng` SET `image` = '$image_path', `video` = '$video_path', `text` = '$text' WHERE `id` = $id";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Redirect after successful update
            echo '<script>window.location.href = "akshara-engineers";</script>';
            exit();
        } else {
            echo "Database Error: " . mysqli_error($conn);
        }
    }
?>

<div class='dashboard-app'>
    <div class='dashboard-content'>
        <div class='container-fluid'>
        <!-- page title -->
            <div class='container-fluid'>
                <h1>Edit About</h1>
            </div>
            <!-- breadcrumb -->
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="banner">About Us</a></li>
                <li class="breadcrumb-item"><a>Edit About Us</a></li>
            </ol>
            </nav>
            <!-- form -->
            <div class="container pt-5 w-50">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="formFile" class="form-label">Select Image</label>
                    <input class="form-control" type="file" name="image" id="formFile">
                    <!--<p>Current Image: <a href="<?php echo $existing_image; ?>" target="_blank">View</a></p>-->
                </div>
                
                <div class="mb-3">
                    <label for="video">Video:</label>
                    <input type="file" name="video" id="video">
                    <!--<p>Current Video: <a href="<?php echo $existing_video; ?>" target="_blank">View</a></p>-->
                </div>
                
                <div class="mb-3">
                    <h2>Text</h2>
                    <textarea class="form-control" name="text" id="exampleFormControlTextarea1" rows="3"><?php echo $existing_text; ?></textarea>
                </div>
                <div>
                    <input type="submit" name="submit" value="Update" class="btn btn-success">
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
