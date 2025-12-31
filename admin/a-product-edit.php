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

    // Get the ID from the URL
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        
        // Fetch existing data
        $sql = "SELECT * FROM sub_services WHERE id = $id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
    }

    // Handle form submission for updating data
    if(isset($_POST['submit'])) {
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $service_id  = $_POST['service_id'];  
        $sub_service = $_POST['sub_service'];  
        $description = $_POST['description']; 
        $details = $_POST['details'];  

        // Set the upload directory and move the uploaded file if a new image is uploaded
        if (!empty($image)) {
            $upload_dir = 'uploads/services/'; // Ensure this directory exists and has write permissions
            $upload_file = $upload_dir . basename($image);
            move_uploaded_file($image_tmp, $upload_file);
        } else {
            // If no new image is uploaded, keep the existing image
            $upload_file = $row['image'];
        }

        // Update the record in the database
        $sql = "UPDATE `sub_services` SET 
                `image` = '$upload_file', 
                `service_id` = '$service_id', 
                `sub_service` = '$sub_service', 
                `description` = '$description', 
                `details` = '$details' 
                WHERE id = $id";
                
        $result = mysqli_query($conn, $sql);
        
        if($result){
            // Use JavaScript to redirect
            echo '<script>window.location.href = "services";</script>';
            exit();
          
        } else {
            echo "Failed: " . mysqli_error($conn);
        }
    }
?>




<div class='dashboard-app'>
    <div class='dashboard-content'>
        <div class='container-fluid'>
        <!-- page title -->
            <div class='container-fluid'>
                <h1>Edit Service</h1>
            </div>
            <!-- breadcrumb -->
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="services">Services</a></li>
                <li class="breadcrumb-item"><a>Edit Service</a></li>
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
                            $result_services = mysqli_query($conn, "SELECT * FROM services"); 
                            while ($row_service = mysqli_fetch_array($result_services)) {
                                ?>
                                <option value="<?php echo $row_service['id']; ?>" <?php if($row['service_id'] == $row_service['id']) echo 'selected'; ?>><?php echo $row_service['ser_name']; ?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Enter Sub-Service</label>
                    <input type="text" name="sub_service" class="form-control" id="exampleFormControlInput1" placeholder="Enter Event Name" value="<?php echo $row['sub_service']; ?>" required>
                </div>
                <div class="mb-3">
                  <label for="exampleFormControlTextarea1" class="form-label">Sub-Service Description</label>
                  <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"><?php echo $row['description']; ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Select Image</label>
                    <input class="form-control" type="file" name="image" id="formFile">
                    <!-- Display existing image -->
                    <img src="<?php echo $row['image']; ?>" alt="service" style="width: 100px; height: 100px; margin-top: 10px;">
                </div>
                <div class="mb-3">
                  <label for="exampleFormControlTextarea1" class="form-label">Sub-Service Details</label>
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



