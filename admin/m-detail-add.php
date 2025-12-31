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
    $machine_id = $_POST['machine_id'];  
    $name = strtoupper($_POST['name']);  
    $description = $_POST['description']; 

    // Insert sub-service details and get the unique ID
    $sql_sub_service = "INSERT INTO `machine_detail`(`id`, `machine_id`, `name`, `description`) 
                        VALUES (NULL, '$machine_id', '$name', '$description')";
    $result = mysqli_query($conn, $sql_sub_service);

    if ($result) {
        // Get the last inserted sub-service ID
        $sub_machine_id  = mysqli_insert_id($conn);

        $upload_dir = 'uploads/machine-image/'; // Ensure this directory exists and has write permissions
        $uploaded_images = [];

        foreach ($_FILES['image_path']['tmp_name'] as $key => $tmp_name) {
            $image_name = $_FILES['image_path']['name'][$key];
            $image_tmp = $_FILES['image_path']['tmp_name'][$key];
            $upload_file = $upload_dir . basename($image_name);

            if (move_uploaded_file($image_tmp, $upload_file)) {
                $uploaded_images[] = $upload_file;

                // Corrected query (removed space in `sub_machine_id`)
                $sql_image = "INSERT INTO `sub_otherser_machine_images`(`id`, `sub_machine_id`, `image_path`) 
                              VALUES (NULL, '$sub_machine_id', '$upload_file')";
                $result_image = mysqli_query($conn, $sql_image);

                if (!$result_image) {
                    echo "Failed to insert image: " . mysqli_error($conn);
                    break;
                }
            }
        }

        if (!empty($uploaded_images)) {
            echo '<script>window.location.href = "machine-detail";</script>';
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
                <li class="breadcrumb-item"><a href="machine-detail">Quality policy</a></li>
                <li class="breadcrumb-item"><a>Add Quality policy</a></li>
            </ol>
            </nav>
            <!-- form -->
            <div class="container pt-5 w-50">
            <form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Select Service</label>
        <select class="form-select" name="machine_id" aria-label="Default select example">
            <?php
            include 'include/db_conn.php';
            $result = mysqli_query($conn, "SELECT * FROM machine"); 
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Enter Sub-Service</label>
        <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="Enter Event Name" required>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Sub-Service description</label>
        <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label for="formFile" class="form-label">Select Images</label>
        <input class="form-control" type="file" name="image_path[]" id="formFile" multiple required>
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



