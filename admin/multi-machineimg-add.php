<?php 
session_start(); // Start the session

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true ) {
    // Redirect to login page if not logged in
    header("Location: login.php"); // Adjust path if needed
    exit(); // Ensure no further code is executed
} else {
    include 'attach/header.php'; 
    include 'attach/navbar.php';  
?>

<?php 
    include 'include/db_conn.php';

    if(isset($_POST['submit'])) {
        // $service_id = $_POST['service_id'];  
        // $service_id = $_POST['service_id'];  
        $sub_machine_id =  mysqli_insert_id($conn);

        // Check if file is uploaded
        if(isset($_FILES['image_path']) && $_FILES['image_path']['error'] == 0) {
            $image = $_FILES['image_path']['name']; // Get file name
            $image_tmp = $_FILES['image_path']['tmp_name']; // Get temp file path

            // Validate file type
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
            $file_ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));

            if (!in_array($file_ext, $allowed_types)) {
                echo "Invalid file type. Only JPG, JPEG, PNG & GIF allowed.";
                exit();
            }

            // Set the upload directory and move the uploaded file
            $upload_dir = 'uploads/events/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $upload_file = $upload_dir . basename($image);

            if (move_uploaded_file($image_tmp, $upload_file)) {
                // Insert file path into the database
                $upload_file = mysqli_real_escape_string($conn, $upload_file);
                
                $sql = "INSERT INTO `sub_otherser_machine_images`(`sub_machine_id`, `image_path`) 
                        VALUES ('$sub_machine_id', '$upload_file')";
                        
                if (mysqli_query($conn, $sql)) {
                    echo '<script>window.location.href = "machine-detail.php";</script>';
                    exit();
                } else {
                    echo "Failed: " . mysqli_error($conn);
                }
            } else {
                echo "Failed to upload file.";
            }
        } else {
            echo "No file uploaded or file upload error.";
        }
    }
?>

<div class='dashboard-app'>
    <div class='dashboard-content'>
        <div class='container-fluid'>
            <h1>Add Multiple Images</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="a-service">Images</a></li>
                    <li class="breadcrumb-item active">Add Multiple Images</li>
                </ol>
            </nav>

         <div class="container pt-5 w-50">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="formFile" class="form-label">Select Image</label>
            <input class="form-control" type="file" name="image_path" id="formFile" required>
        </div>
        <div>
           <input type="text" name="sub_machine_id" value="<?php echo isset($_GET['sub_machine_id']) ? $_GET['sub_machine_id'] : ''; ?>">

            <input type="submit" name="submit" value="Submit" class="btn btn-success">
        </div>
    </form>
</div>

        </div>
    </div>
</div>

<?php include 'attach/footer.php'; ?>

<?php } ?>
