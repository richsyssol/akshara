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
        $sql = "SELECT * FROM `location` WHERE `id` = $id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        if (!$row) {
            echo "No career found with this ID.";
            exit();
        }

        // Check if the form has been submitted
        if (isset($_POST['submit'])) {
            $link = $_POST['link'];
            $city = $_POST['city'];
            $address = $_POST['address'];

            // Update the career entry
            $sql = "UPDATE `location` SET `link`='$link', `city`='$city', `address`='$address' WHERE `id` = $id";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo '<script>window.location.href = "location";</script>';
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
                <h1>Edit Location</h1>
            </div>
            <!-- breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="location">Location</a></li>
                    <li class="breadcrumb-item " aria-current="page">Edit Location</li>
                </ol>
            </nav>
            <!-- form -->
            <div class="container pt-5 w-50">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="link" class="form-label">Map Link</label>
                        <input type="text" class="form-control" name="link" id="link" placeholder="Enter Map Link" value="<?php echo $row['link']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">City Name</label>
                        <input type="text" class="form-control" name="city" id="city" placeholder="Enter City Name" value="<?php echo $row['city']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" id="address" placeholder="Enter Address" value="<?php echo $row['address']; ?>" required>
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