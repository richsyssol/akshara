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

   // Initialize variables
$image = '';
$text = '';
$video = '';
$id = '';

// Check if an id is passed for editing an existing record
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Use intval for security
    $sql = "SELECT * FROM `aksharaabout` WHERE `id` = $id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $image = $row['image'];
        $text = $row['text'];
        $video = $row['video']; // Fetch existing video
    } else {
        echo "Record not found.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $text = mysqli_real_escape_string($conn, $_POST['text']); // Secure the input

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $upload_dir = 'uploads/about-us/images/';
        $upload_file_image = $upload_dir . basename($image);

        if (!move_uploaded_file($image_tmp, $upload_file_image)) {
            echo "Failed to upload image.";
            exit();
        }
    } else {
        // Use the existing image path if no new image is uploaded
        $upload_file_image = $image;
    }

    // Handle video upload
    if (!empty($_FILES['video']['name'])) {
        $video = $_FILES['video']['name'];
        $video_tmp = $_FILES['video']['tmp_name'];
        $upload_dir = 'uploads/aksharaabout/videos/';
        $upload_file_video = $upload_dir . basename($video);

        if (!move_uploaded_file($video_tmp, $upload_file_video)) {
            echo "Failed to upload video.";
            exit();
        }
    } else {
        // Use the existing video path if no new video is uploaded
        $upload_file_video = $video;
    }

    if ($id) {
        // Update existing record
        $sql = "UPDATE `aksharaabout` 
                SET `image` = '$upload_file_image', `text` = '$text', `video` = '$upload_file_video' 
                WHERE `id` = $id";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Redirect on success
            echo '<script>window.location.href = "akshara-about.php";</script>';
            exit();
        } else {
            echo "Failed to update: " . mysqli_error($conn);
        }
    } else {
        // Insert new record
        $sql = "INSERT INTO `aksharaabout`(`image`, `text`, `video`) 
                VALUES ('$upload_file_image', '$text', '$upload_file_video')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Redirect on success
            echo '<script>window.location.href = "akshara-about.php";</script>';
            exit();
        } else {
            echo "Failed to insert: " . mysqli_error($conn);
        }
    }
}
?>

<div class='dashboard-app'>
    <div class='dashboard-content'>
        <div class='container-fluid'>
            <!-- page title -->
            <div class='container-fluid'>
                <h1><?php echo $id ? "Edit" : "Add"; ?> About Us</h1>
            </div>
            <!-- breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="banner">About Us</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $id ? "Edit" : "Add"; ?> About Us</li>
                </ol>
            </nav>
            <!-- form -->
            <div class="container pt-5 w-50">
             <form method="post" enctype="multipart/form-data">
    <label for="image">Image:</label>
    <input type="file" name="image" id="image"><br>

    <label for="video">Video:</label>
    <input type="file" name="video" id="video"><br>

    <label for="text">Text:</label>
    <textarea name="text" id="text"><?php echo htmlspecialchars($text); ?></textarea><br>

    <button type="submit" name="submit">Submit</button>
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
