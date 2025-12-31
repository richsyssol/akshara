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
    $id = '';
    $text = '';

    // Check if an id is passed for editing an existing record
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM `quality_policy` WHERE id = $id";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
           
            $text = $row['text'];
        } else {
            echo "Record not found.";
        }
    }

    if(isset($_POST['submit'])) {
        
        $text = $_POST['text']; // Update or insert 'text' field
        
        if ($id) {
            // Update existing record
            $sql = "UPDATE `quality_policy` SET `text`='$text' WHERE `id`=$id";
        } else {
            // Insert new record
            $sql = "INSERT INTO `quality_policy`(`text`, `creation_on`) VALUES ('$text', NOW())";
        }

        $result = mysqli_query($conn, $sql);

        if($result){
             // Use JavaScript to redirect
            echo '<script>window.location.href = "quality-policy";</script>';
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
                <h1><?php echo $id ? "Edit" : "Add"; ?> Sector We Serve</h1>
            </div>
            <!-- breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="quality-policy">Quality Policy</a></li>
                    <li class="breadcrumb-item " aria-current="page"><?php echo $id ? "Edit" : "Add"; ?> Quality Policy</li>
                </ol>
            </nav>
            <!-- form -->
            <div class="container pt-5 w-50">
                <form action="" method="post">
                    <div class="mb-3">
                        <h2>Text</h2>
                        <!--<label for="exampleFormControlTextarea1" class="form-label">Text</label>-->
                        <textarea class="form-control" name="text" id="exampleFormControlTextarea1" rows="3"><?php echo $text; ?></textarea>
                    </div>
                    <div>
                        <input type="submit" name="submit" value="<?php echo $id ? 'Update' : 'Add'; ?>" class="btn btn-success">
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