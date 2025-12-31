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

if (isset($_POST['submit'])) {
    // Check if Event ID is provided
    if (!isset($_POST['event_id']) || empty($_POST['event_id'])) {
        die("Error: Event ID is required.");
    }

    $event_id = $_POST['event_id'];  
    $name = strtoupper($_POST['name']);  
    $description = $_POST['description']; 
    $image_path = ''; // Default empty image value

    // Check if Event ID exists in the `event` table
    $check_service = mysqli_query($conn, "SELECT id FROM event WHERE id = '$event_id'");
    if (mysqli_num_rows($check_service) == 0) {
        die("Error: Invalid Event ID.");
    }

    // Image Upload (if provided)
    if (!empty($_FILES['image_path']['name'][0])) { 
        $image_name = $_FILES['image_path']['name'][0]; // Taking the first image
        $image_tmp = $_FILES['image_path']['tmp_name'][0];
        $upload_dir = 'uploads/machine-image/';
        $upload_file = $upload_dir . basename($image_name);

        if (move_uploaded_file($image_tmp, $upload_file)) {
            $image_path = $upload_file;
        }
    }

    // Insert Event Details
    $sql_sub_service = "INSERT INTO `event_detail` (`event_id`, `image`, `name`, `description`) 
                        VALUES ('$event_id', '$image_path', '$name', '$description')";

    $result = mysqli_query($conn, $sql_sub_service);
      
    if ($result) {
        $sub_event_id = mysqli_insert_id($conn);
        $upload_dir = 'uploads/machine-image/'; 
        $uploaded_images = [];

        // Multiple Image Upload
        foreach ($_FILES['image_path']['tmp_name'] as $key => $tmp_name) {
            if ($key == 0) continue; // Skip the first image (already stored)

            $image_name = $_FILES['image_path']['name'][$key];
            $image_tmp = $_FILES['image_path']['tmp_name'][$key];
            $upload_file = $upload_dir . basename($image_name);

            if (move_uploaded_file($image_tmp, $upload_file)) {
                $uploaded_images[] = $upload_file;

                // Insert Images into `sub_otherser_event_images` Table
                $sql_image = "INSERT INTO `sub_otherser_event_images` (`sub_event_id`, `image_path`) 
                              VALUES ('$sub_event_id', '$upload_file')";
                $result_image = mysqli_query($conn, $sql_image);

                if (!$result_image) {
                    echo "Failed to insert image: " . mysqli_error($conn);
                    break;
                }
            }
        }

        // Redirect on success
        echo '<script>window.location.href = "a-productdetails";</script>';
        exit();
    } else {
        echo "Failed to insert sub-service: " . mysqli_error($conn);
    }
}
?>





<div class='dashboard-app'>
    <div class='dashboard-content'>
        <div class='container-fluid'>
        <!-- page title -->
            <div class='container-fluid'>
                <h1>Edit Product</h1>
            </div>
            <!-- breadcrumb -->
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="a-productdetails">Product Details</a></li>
                <li class="breadcrumb-item"><a>Add Product Details</a></li>
            </ol>
            </nav>
            <!-- form -->
            <div class="container pt-5 w-50">
<form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Select Product Details</label>
        <select class="form-select" name="event_id" required>
            <option value="" selected disabled>Select a Product Details</option>
            <?php
            include 'include/db_conn.php';
            $result = mysqli_query($conn, "SELECT * FROM event"); 
            while ($row = mysqli_fetch_array($result)) {
                echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
            }
            ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Enter Product Details</label>
        <input type="text" name="name" class="form-control" placeholder="Enter Event Name" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Product Details description</label>
        <textarea class="form-control" name="description" rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Select Images</label>
        <input class="form-control" type="file" name="image_path[]" multiple required>
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

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('exampleFormControlTextarea1');
    CKEDITOR.replace('exampleFormControlTextarea2');
</script>

<?php 
    
}
?>



