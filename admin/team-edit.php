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
    $name = '';
    $designation = '';
    $status = '';
    $id = '';

    // Check if an id is passed for editing an existing record
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM `team` WHERE id = $id";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $image = $row['image'];
            $name = $row['name'];
            $designation = $row['designation'];
            $status = $row['status'];
        } else {
            echo "Record not found.";
        }
    }

    if(isset($_POST['submit'])) {
        $name = $_POST['name'];
        $designation = $_POST['designation'];
        $status = $_POST['status'];

        if (!empty($_FILES['image']['name'])) {
            $image = $_FILES['image']['name'];
            $image_tmp = $_FILES['image']['tmp_name'];
            $upload_dir = 'uploads/team/'; // Ensure this directory exists and has write permissions
            $upload_file = $upload_dir . basename($image);

            if (!move_uploaded_file($image_tmp, $upload_file)) {
                echo "Failed to upload file.";
                exit();
            }
        } else {
            $upload_file = $image;
        }

        if ($id) {
            // Update existing record
            $sql = "UPDATE `team` SET `image`='$upload_file', `name`='$name', `designation`='$designation', `status`='$status' WHERE `id`=$id";
            $result = mysqli_query($conn, $sql);

            if($result){
                 // Use JavaScript to redirect
                echo '<script>window.location.href = "team";</script>';
                exit();
            } else {
                echo "Failed: " . mysqli_error($conn);
            }
        } else {
            // Insert new record
            $sql = "INSERT INTO `team`(`id`, `image`, `name`,`designation`, `status`) VALUES (NULL, '$upload_file', '$name', $designation , '$status')";
            $result = mysqli_query($conn, $sql);

            if($result){
                 // Use JavaScript to redirect
                echo '<script>window.location.href = "team";</script>';
                exit();
            } else {
                echo "Failed: " . mysqli_error($conn);
            }
        }
    }
?>

<div class='dashboard-app'>
    <div class='dashboard-content'>
        <div class='container-fluid'>
            <!-- page title -->
            <div class='container-fluid'>
                <h1><?php echo $id ? "Edit" : "Add"; ?> Team</h1>
            </div>
            <!-- breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="testimonial">Team</a></li>
                    <li class="breadcrumb-item" aria-current="page"><?php echo $id ? "Edit" : "Add"; ?> Team</li>
                </ol>
            </nav>
            <!-- form -->
            <div class="container pt-5 w-50">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Select Image</label>
                        <input class="form-control" type="file" name="image" id="formFile" <?php echo $id ? '' : 'required'; ?>>
                        <?php if ($id && $image): ?>
                            <img src="<?php echo $image; ?>" alt="Banner Image" style="width:100px; margin-top:10px;">
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="" value="<?php echo $name; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Designation</label>
                        <input type="text" name="designation" class="form-control" id="exampleFormControlInput1" placeholder="" value="<?php echo $designation; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Status</label>
                        <select class="form-select" name="status" aria-label="Default select example">
                            <option value="Active" <?php echo $status == 'Active' ? 'selected' : ''; ?>>Active</option>
                            <option value="Inactive" <?php echo $status == 'Inactive' ? 'selected' : ''; ?>>Inactive</option>
                        </select>
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

<?php 
    
}
?>
