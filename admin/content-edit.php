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
    $mission = '';
    $why_us = '';

    // Check if an id is passed for editing an existing record
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM `content` WHERE id = $id";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
           
            $mission = $row['mission'];
            $why_us = $row['why_us'];
        } else {
            echo "Record not found.";
        }
    }

    if(isset($_POST['submit'])) {
        
        $mission = $_POST['mission']; // Update or insert 'text' field
        $why_us = $_POST['why_us'];
        
        if ($id) {
            // Update existing record
            $sql = "UPDATE `content` SET `mission`='$mission',`why_us`='$why_us' WHERE `id`=$id";
        } else {
            // Insert new record
            $sql = "INSERT INTO `content`(`mission`,`why_us`, `creation_on`) VALUES ('$mission','$why_us', NOW())";
        }

        $result = mysqli_query($conn, $sql);

        if($result){
             // Use JavaScript to redirect
            echo '<script>window.location.href = "content";</script>';
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
                <h1><?php echo $id ? "Edit" : "Add"; ?> Objective  </h1>
            </div>
            <!-- breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="content">Objective</a></li>
                    <li class="breadcrumb-item " aria-current="page"><?php echo $id ? "Edit" : "Add"; ?>Objective</li>
                </ol>
            </nav>
            <!-- form -->
            <div class="container pt-5 w-50">
                <form action="" method="post">
                    <!--<div class="mb-3">-->
                    <!--    <h2>Mission</h2>-->
                        <!--<label for="exampleFormControlTextarea1" class="form-label">Text</label>-->
                    <!--    <textarea class="form-control" name="mission" id="exampleFormControlTextarea1" rows="3"><?php echo $mission; ?></textarea>-->
                    <!--</div>-->
                    <div class="mb-3">
                        <h2>Objective</h2>
                        <!--<label for="exampleFormControlTextarea1" class="form-label">Text</label>-->
                        <textarea class="form-control" name="why_us" id="exampleFormControlTextarea2" rows="3"><?php echo $why_us; ?></textarea>
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
    CKEDITOR.replace('exampleFormControlTextarea2');
</script>

<?php 
    
}
?>