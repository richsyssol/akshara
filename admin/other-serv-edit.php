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

if (isset($_GET['id'])) {
    // Fetch existing sub-service data
    $sub_service_id = intval($_GET['id']);
    $sql = "SELECT * FROM `sub_other_ser` WHERE id = $sub_service_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo "Sub-service not found!";
        exit();
    }
}

if (isset($_POST['submit'])) {
    // Get the updated data from the form
    $service_id = $_POST['service_id'];  
    $sub_service = strtoupper($_POST['sub_service']);  
    $description = $_POST['description']; 
    $details = $_POST['details'];  

    // Update the sub-service details
    $sql_update_sub_service = "UPDATE `sub_other_ser` 
                            SET `service_id` = '$service_id', `sub_service` = '$sub_service', `description` = '$description', `details` = '$details' 
                            WHERE `id` = $sub_service_id";
    $result_update = mysqli_query($conn, $sql_update_sub_service);

    if ($result_update) {
        // If images are uploaded, update them as well
        if (!empty($_FILES['images']['name'][0])) {
            $upload_dir = 'uploads/other_serv/';
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
        }

        echo '<script>window.location.href = "other_serv";</script>';
        exit();
    } else {
        echo "Failed to update sub-service: " . mysqli_error($conn);
    }
}
?>




<div class='dashboard-app'>
    <div class='dashboard-content'>
        <div class='container-fluid'>
        <!-- page title -->
            <div class='container-fluid'>
                <h1>Edit Qaulity Policy</h1>
            </div>
            <!-- breadcrumb -->
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="other_serv">Qaulity</a></li>
                <li class="breadcrumb-item"><a>Qaulity Policy</a></li>
            </ol>
            </nav>
            <!-- form -->
            <div class="container pt-5 w-50">
            <form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Select Service</label>
        <select class="form-select" name="service_id" aria-label="Default select example">
            <?php
            $result = mysqli_query($conn, "SELECT * FROM other_ser"); 
            while ($service_row = mysqli_fetch_array($result)) {
                ?>
                <option value="<?php echo $service_row['id']; ?>" <?php echo $row['service_id'] == $service_row['id'] ? 'selected' : ''; ?>>
                    <?php echo $service_row['ser_name']; ?>
                </option>
                <?php
            }
            ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Enter Sub-Service</label>
        <input type="text" name="sub_service" class="form-control" id="exampleFormControlInput1" value="<?php echo $row['sub_service']; ?>" required>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Sub-Service description</label>
        <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"><?php echo $row['description']; ?></textarea>
    </div>
    <div class="mb-3">
        <label for="formFile" class="form-label">Select Images</label>
        <input class="form-control" type="file" name="images[]" id="formFile" multiple>
    </div>

    

    <div class="mb-3">
        <label for="exampleFormControlTextarea2" class="form-label">Sub-Service Details</label>
        <textarea class="form-control" name="details" id="exampleFormControlTextarea2" rows="3"><?php echo $row['details']; ?></textarea>
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

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('exampleFormControlTextarea1');
    CKEDITOR.replace('exampleFormControlTextarea2');
</script>

<?php 
    
}
?>



