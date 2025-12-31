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

    // Get the career ID from the URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Fetch the existing data
        $sql = "SELECT * FROM `career` WHERE `id` = $id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        if (!$row) {
            echo "No career found with this ID.";
            exit();
        }

        // Check if the form has been submitted
        if (isset($_POST['submit'])) {
            $designation = $_POST['designation'];
            $qualification = $_POST['qualification'];
            $experience = $_POST['experience'];
            $about = $_POST['about'];

            // Update the career entry
            $sql = "UPDATE `career` SET `designation`='$designation', `qualification`='$qualification', `experience`='$experience', `about`='$about' WHERE `id` = $id";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo '<script>window.location.href = "career";</script>';
                exit();
            } else {
                echo "Failed: " . mysqli_error($conn);
            }
        }
    } else {
        echo "No ID provided.";
        exit();
    }
?>

<div class='dashboard-app'>
    <div class='dashboard-content'>
        <div class='container-fluid'>
            <!-- page title -->
            <div class='container-fluid'>
                <h1>Edit Career</h1>
            </div>
            <!-- breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="career">Career</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Career</li>
                </ol>
            </nav>
            <!-- form -->
            <div class="container pt-5 w-50">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="designation" class="form-label">Designation</label>
                        <input type="text" class="form-control" name="designation" id="designation" placeholder="Enter Designation" value="<?php echo $row['designation']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="qualification" class="form-label">Qualification</label>
                        <input type="text" class="form-control" name="qualification" id="qualification" placeholder="Enter Qualification" value="<?php echo $row['qualification']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="experience" class="form-label">Experience</label>
                        <input type="text" class="form-control" name="experience" id="experience" placeholder="Enter Experience" value="<?php echo $row['experience']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <h2>About Role</h2>
                        <textarea class="form-control" name="about" id="exampleFormControlTextarea1" rows="3" required><?php echo $row['about']; ?></textarea>
                    </div>
                    <div>
                        <input type="submit" name="submit" value="Update" class="btn btn-primary">
                    </div>
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