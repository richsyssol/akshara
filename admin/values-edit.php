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

$value = null; // Initialize the $value variable

if (isset($_GET['id'])) {
    $valueId = $_GET['id']; // Correct variable name
    $sql = "SELECT * FROM `value` WHERE id = $valueId";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $value = mysqli_fetch_assoc($result); // Renamed to $value for clarity
    } else {
        echo "Value not found!";
        exit();
    }
} else {
    echo "Invalid request!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $title = $_POST['title']; // Title added here
    $image = $_FILES['image'];

    $targetDir = "uploads/visionary/";
    $imagePath = isset($value['image']) ? $value['image'] : ''; // Default to existing image if available

    if ($image['name']) {
        $targetFile = $targetDir . basename($image['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Validate the file type
        if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            if (move_uploaded_file($image['tmp_name'], $targetFile)) {
                $imagePath = $targetFile; // Update the image path
            } else {
                echo "Failed to upload image.";
                exit();
            }
        } else {
            echo "Invalid image format!";
            exit();
        }
    }

    // Update the database record
    $updateSql = "UPDATE `value` SET `name` = '$name', `title` = '$title', `image` = '$imagePath' WHERE `id` = $valueId";
    if (mysqli_query($conn, $updateSql)) {
        header("Location: values.php?msg=Value updated successfully");
        exit();
    } else {
        echo "Database Error: " . mysqli_error($conn);
    }
}
?>

<div class='dashboard-app'>
    <div class='dashboard-content'>
        <div class='container-fluid'>
            <!-- page title -->
            <div class='container-fluid'>
                <h1><?php echo isset($value) ? "Edit" : "Add"; ?> Banner</h1>
            </div>
            <!-- breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="value">value</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo isset($value) ? "Edit" : "Add"; ?> value</li>
                </ol>
            </nav>
            <!-- form -->
            <div class="container pt-5 w-50">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">value Image</label>
                        <input class="form-control" type="file" name="image" id="formFile" <?php echo isset($value) ? '' : 'required'; ?>>
                        <?php if (isset($value) && isset($value['image']) && $value['image']): ?>
                            <img src="<?php echo $value['image']; ?>" alt="Banner Image" style="width:100px; margin-top:10px;">
                        <?php endif; ?>
                    </div>
                    <div class="mb-3"> 
                        <label for="exampleFormControlInput1" class="form-label">value Title</label>
                        <input type="text" name="title" class="form-control" id="exampleFormControlInput1" placeholder="abc.com" value="<?php echo isset($value['title']) ? $value['title'] : ''; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">value name</label>
                        <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="abc.com" value="<?php echo isset($value['name']) ? $value['name'] : ''; ?>" required>
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
