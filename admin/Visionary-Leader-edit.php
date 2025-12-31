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

if (isset($_GET['id'])) {
    $eventId = $_GET['id'];
    $sql = "SELECT * FROM `visionaryl_leaders` WHERE id = $visionaryl_leadersId";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $event = mysqli_fetch_assoc($result);
    } else {
        echo "Event not found!";
        exit();
    }
} else {
    echo "Invalid request!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $image = $_FILES['image'];

    $targetDir = "uploads/";
    $imagePath = $visionary['image'];

    if ($image['name']) {
        $targetFile = $targetDir . basename($image['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            if (move_uploaded_file($image['tmp_name'], $targetFile)) {
                $imagePath = $targetFile;
            } else {
                echo "Failed to upload image.";
                exit();
            }
        } else {
            echo "Invalid image format!";
            exit();
        }
    }

    $updateSql = "UPDATE `visionaryl_leaders` SET `name` = '$name', `image` = '$imagePath' WHERE `id` = $visionaryl_leadersId";
    if (mysqli_query($conn, $updateSql)) {
        header("Location: Visionaryl-Leaders.php?msg=Event updated successfully");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<div class='dashboard-app'>
    <div class='dashboard-content'>
        <div class='container-fluid'>
            <!-- page title -->
            <div class='container-fluid'>
                <h1><?php echo $id ? "Edit" : "Add"; ?> Banner</h1>
            </div>
            <!-- breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="event">Banner</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo $id ? "Edit" : "Add"; ?> Banner</li>
                </ol>
            </nav>
            <!-- form -->
            <div class="container pt-5 w-50">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Event Image</label>
                        <input class="form-control" type="file" name="image" id="formFile" <?php echo $id ? '' : 'required'; ?>>
                        <?php if ($id && $image): ?>
                            <img src="<?php echo $image; ?>" alt="Banner Image" style="width:100px; margin-top:10px;">
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Event Title</label>
                        <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="abc.com" value="<?php echo $name; ?>" required>
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