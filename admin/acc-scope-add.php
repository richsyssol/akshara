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

    if(isset($_POST['submit'])) {
        $pdf = $_FILES['pdf']['name'];
        $pdf_tmp = $_FILES['pdf']['tmp_name'];
        
        // Set the upload directory and move the uploaded file
        $upload_dir = 'uploads/certificate/'; // Ensure this directory exists and has write permissions
        $upload_file = $upload_dir . basename($pdf);

        // Check if the file is a valid PDF
        $file_type = pathinfo($upload_file, PATHINFO_EXTENSION);
        if($file_type == 'pdf') {
            if (move_uploaded_file($pdf_tmp, $upload_file)) {
                // Insert the file path into the database
                $sql = "INSERT INTO `a_scope`(`id`, `pdf`) VALUES (NULL, '$upload_file')";
                $result = mysqli_query($conn, $sql);
                
                if($result){
                    // Use JavaScript to redirect
                    echo '<script>window.location.href = "acc-scope";</script>';
                    exit();
                  
                } else {
                    echo "Failed: " . mysqli_error($conn);
                }
            } else {
                echo "Failed to upload file.";
            }
        } else {
            echo "Only PDF files are allowed.";
        }
    }
?>

<div class='dashboard-app'>
    <div class='dashboard-content'>
        <div class='container-fluid'>
            <!-- page title -->
            <div class='container-fluid'>
                <h1>Add Certificate</h1>
            </div>
            <!-- breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="certificate">ACCREDITATIONS SCOPE</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add ACCREDITATIONS SCOPE</li>
                </ol>
            </nav>
            <!-- form -->
            <div class="container pt-5 w-50">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Select PDF</label>
                        <input class="form-control" type="file" name="pdf" id="formFile" required>
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
<?php 
    
}
?>