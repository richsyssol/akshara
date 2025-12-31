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
        $designation = $_POST['designation'];
        $qualification = $_POST['qualification'];
        $experience = $_POST['experience'];
        $about = $_POST['about'];

        $sql = "INSERT INTO `career` (`id`, `designation`, `qualification`, `experience`, `about`) VALUES (NULL, '$designation', '$qualification', '$experience', '$about')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo '<script>window.location.href = "career";</script>';
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
                <h1>Add Career</h1>
            </div>
            <!-- breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="career">Career</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Career</li>
                </ol>
            </nav>
            <!-- form -->
            <div class="container pt-5 w-50">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Designation</label>
                        <input type="text" class="form-control" name="designation" id="exampleFormControlInput1" placeholder="Enter Designation" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Qualification</label>
                        <input type="text" class="form-control" name="qualification" id="exampleFormControlInput1" placeholder="Enter Qualification" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Experience</label>
                        <input type="text" class="form-control" name="experience" id="exampleFormControlInput1" placeholder="Enter Experience" required>
                    </div>
                    <div class="mb-3">
                        <h2>About Role</h2>
                        <!--<label for="exampleFormControlTextarea1" class="form-label">Text</label>-->
                        <textarea class="form-control" name="about" id="exampleFormControlTextarea1" rows="3" required></textarea>
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

<!-- Include CKEditor script -->
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('exampleFormControlTextarea1');
</script>

<?php 
    
}
?>
