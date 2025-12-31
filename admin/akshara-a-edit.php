<?php 
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true ) {
    header("Location: login.php");
    exit();
}

include 'attach/header.php'; 
include 'attach/navbar.php';  
include 'include/db_conn.php';

// Fetch existing data
$id = $_GET['id'];
$sql = "SELECT * FROM aksharaabout WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// Update logic
if(isset($_POST['update'])) {
    $text = $_POST['text'];
    
    // Handle Image Upload
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $upload_dir = 'uploads/aksharaabout/';
        $image_path = $upload_dir . basename($image);
        move_uploaded_file($image_tmp, $image_path);
    } else {
        $image_path = $row['image'];
    }

    // Handle Video Upload
    if (!empty($_FILES['video']['name'])) {
        $video = $_FILES['video']['name'];
        $video_tmp = $_FILES['video']['tmp_name'];
        $video_path = $upload_dir . basename($video);
        move_uploaded_file($video_tmp, $video_path);
    } else {
        $video_path = $row['video'];
    }

    // Update Query
    $update_sql = "UPDATE aksharaabout SET image='$image_path', video='$video_path', text='$text' WHERE id=$id";
    if (mysqli_query($conn, $update_sql)) {
        echo '<script>window.location.href = "akshara-about";</script>';
        exit();
    } else {
        echo "Database Error: " . mysqli_error($conn);
    }
}
?>

<div class='dashboard-app'>
    <div class='dashboard-content'>
        <div class='container-fluid'>
            <h1>Edit About</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="banner">About Us</a></li>
                    <li class="breadcrumb-item"><a>Edit About Us</a></li>
                </ol>
            </nav>
            <div class="container pt-5 w-50">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Select Image</label>
                        <input class="form-control" type="file" name="image" id="formFile">
                        <img src="<?php echo $row['image']; ?>" width="100">
                    </div>
                    
                    <div class="mb-3">
                        <label for="video">Video:</label>
                        <input type="file" name="video" id="play-video" accept="video/*">
                        <video width="200" controls>
                            <source src="<?php echo $row['video']; ?>" type="video/mp4">
                        </video>
                    </div>
                    
                    <div class="mb-3">
                        <h2>Text</h2>
                        <textarea class="form-control" name="text" id="exampleFormControlTextarea1" rows="3"><?php echo $row['text']; ?></textarea>
                    </div>
                    
                    <div>
                        <input type="submit" name="update" value="Update" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'attach/footer.php'; ?>

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('exampleFormControlTextarea1');
</script>
