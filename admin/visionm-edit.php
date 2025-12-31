<?php 
session_start(); // Start the session

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true ) {
    // Redirect to login page if not logged in
    header("Location: login.php"); // Adjust path if needed
    exit(); // Ensure no further code is executed
} else {
    include 'attach/header.php'; 
    include 'attach/navbar.php';  
}

include 'include/db_conn.php';

if (isset($_GET['id'])) {
    $eventId = $_GET['id'];
    // Correct the query by using the correct column 'id'
    $sql = "SELECT * FROM `vision-mission` WHERE id = $eventId"; 
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $event = mysqli_fetch_assoc($result);
        $name = $event['name'];
        $image = $event['image'];
    } else {
        echo "vision-mission not found!";
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
    $imagePath = $event['image']; // Use $event instead of $visionary

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

    // Correct the query by using the correct column 'id'
    $updateSql = "UPDATE `vision-mission` SET `name` = '$name', `image` = '$imagePath' WHERE `id` = $eventId"; 
    if (mysqli_query($conn, $updateSql)) {
        // header("Location: visionm.php?msg=Event updated successfully");
        header("Location: visionm.php.php?msg=Event updated successfully");
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
                <h1>Edit vision-mission</h1>
            </div>
            <!-- breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="event">vision-mission</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit vision-mission</li>
                </ol>
            </nav>
            <!-- form -->
            <div class="container pt-5 w-50">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">vision-mission Image</label>
                        <input class="form-control" type="file" name="image" id="formFile">
                        <?php if ($image): ?>
                            <img src="<?php echo $image; ?>" alt="Banner Image" style="width:100px; margin-top:10px;">
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">vision-mission Title</label>
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

