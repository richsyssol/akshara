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
    $name = '';
    $message = '';
    $status = '';
    $id = '';

    // Check if an id is passed for editing an existing record
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM `testimonial` WHERE id = $id";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $name = $row['name'];
            $message = $row['message'];
            $status = $row['status'];
        } else {
            echo "Record not found.";
        }
    }

    if(isset($_POST['submit'])) {
        $name = $_POST['name'];
        $message = $_POST['message'];
        $status = $_POST['status'];

        if ($id) {
            // Update existing record
            $sql = "UPDATE `testimonial` SET `name`='$name', `message`='$message', `status`='$status' WHERE `id`=$id";
            $result = mysqli_query($conn, $sql);

            if($result){
                // Use JavaScript to redirect
                echo '<script>window.location.href = "testimonial";</script>';
                exit();
            } else {
                echo "Failed: " . mysqli_error($conn);
            }
        } else {
            // Insert new record
            $sql = "INSERT INTO `testimonial`(`id`, `name`, `message`, `status`) VALUES (NULL, '$name', '$message', '$status')";
            $result = mysqli_query($conn, $sql);

            if($result){
                // Use JavaScript to redirect
                echo '<script>window.location.href = "testimonial";</script>';
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
                <h1><?php echo $id ? "Edit" : "Add"; ?> Testimonial</h1>
            </div>
            <!-- breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="testimonial">Testimonial</a></li>
                    <li class="breadcrumb-item" aria-current="page"><?php echo $id ? "Edit" : "Add"; ?> Testimonial</li>
                </ol>
            </nav>
            <!-- form -->
            <div class="container pt-5 w-50">
                <form action="" method="post" enctype="multipart/form-data">
                    <!--<div class="mb-3">-->
                    <!--    <label for="formFile" class="form-label">Select Image</label>-->
                    <!--    <input class="form-control" type="file" name="image" id="formFile" <?php //echo $id ? '' : 'required'; ?>>-->
                    <!--    <?php //if ($id && $image): ?>-->
                    <!--        <img src="<?php //echo $image; ?>" alt="Banner Image" style="width:100px; margin-top:10px;">-->
                    <!--    <?php //endif; ?>-->
                    <!--</div>-->
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="" value="<?php echo $name; ?>" required>
                    </div>
                    <div class="mb-3">
                      <label for="exampleFormControlTextarea1" class="form-label">Message</label>
                      <textarea class="form-control" name="message" id="exampleFormControlTextarea1" rows="3"><?php echo htmlspecialchars($message); ?></textarea>
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