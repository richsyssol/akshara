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
        $link = $_POST['link'];
        $city = $_POST['city'];
        $address = $_POST['address'];
        

        $sql = "INSERT INTO `location` (`id`, `link`, `city`, `address`) VALUES (NULL, '$link', '$city', '$address')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo '<script>window.location.href = "location";</script>';
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
                <h1>Add Location</h1>
            </div>
            <!-- breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="location">Location</a></li>
                    <li class="breadcrumb-item" aria-current="page">Add Location</li>
                </ol>
            </nav>
            <!-- form -->
            <div class="container pt-5 w-50">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Map Link</label>
                        <input type="text" class="form-control" name="link" id="exampleFormControlInput1" placeholder="Enter Map Link" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">City Name</label>
                        <input type="text" class="form-control" name="city" id="exampleFormControlInput1" placeholder="Enter City Name" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" id="exampleFormControlInput1" placeholder="Enter Address" required>
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


