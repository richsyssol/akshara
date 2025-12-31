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
    $service_id = $_POST['service_id'];  
    $sub_service = strtoupper($_POST['sub_service']);  
    $description = $_POST['description']; 
    $details = $_POST['details'];  

    // Insert sub-service details and get the unique ID
    $sql_sub_service = "INSERT INTO `sub_other_ser`(`id`, `service_id`, `sub_service`, `description`, `details`) 
                        VALUES (NULL, '$service_id', '$sub_service', '$description', '$details')";
    $result = mysqli_query($conn, $sql_sub_service);

    if ($result) {
        // Get the last inserted sub-service ID
        $sub_service_id = mysqli_insert_id($conn);

        $upload_dir = 'uploads/other_serv/'; // Ensure this directory exists and has write permissions
        $uploaded_images = [];

        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            $image_name = $_FILES['images']['name'][$key];
            $image_tmp = $_FILES['images']['tmp_name'][$key];
            $upload_file = $upload_dir . basename($image_name);

            if (move_uploaded_file($image_tmp, $upload_file)) {
                $uploaded_images[] = $upload_file;

                // Insert each image linked to the sub-service ID
                $sql_image = "INSERT INTO `sub_otherser_service_images`(`id`, `sub_service_id`, `image_path`) 
                              VALUES (NULL, '$sub_service_id', '$upload_file')";
                $result_image = mysqli_query($conn, $sql_image);

                if (!$result_image) {
                    echo "Failed to insert image: " . mysqli_error($conn);
                    break;
                }
            }
        }

        if (!empty($uploaded_images)) {
            echo '<script>window.location.href = "other_serv";</script>';
            exit();
        } else {
            echo "Failed to upload files.";
        }
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
                <h1>Add Quality policy</h1>
            </div>
            <!-- breadcrumb -->
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="other_serv">Quality policy</a></li>
                <li class="breadcrumb-item"><a>Add Quality policy</a></li>
            </ol>
            </nav>
            <!-- form -->
            <div class="container pt-5 w-50">
            <form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Select Service</label>
        <select class="form-select" name="service_id" aria-label="Default select example">
            <?php
            include 'include/db_conn.php';
            $result = mysqli_query($conn, "SELECT * FROM other_ser"); 
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['ser_name']; ?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Enter Sub-Service</label>
        <input type="text" name="sub_service" class="form-control" id="exampleFormControlInput1" placeholder="Enter Event Name" required>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Sub-Service description</label>
        <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label for="formFile" class="form-label">Select Images</label>
        <input class="form-control" type="file" name="images[]" id="formFile" multiple required>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Sub-Service Details</label>
        <textarea class="form-control" name="details" id="exampleFormControlTextarea2" rows="3"></textarea>
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



