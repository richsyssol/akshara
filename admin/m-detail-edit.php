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

// Check database connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Get product ID from URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch product details
    $sql = "SELECT * FROM machine_detail WHERE id = $product_id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    } else {
        die("Product not found.");
    }

    // Fetch existing images
    $image_sql = "SELECT * FROM sub_otherser_machine_images WHERE sub_machine_id = $product_id";
    $image_result = mysqli_query($conn, $image_sql);
} else {
    die("Invalid product ID.");
}

// Handle form submission for updating product details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? (int) $_POST['id'] : 0;
    $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '';
    $description = isset($_POST['description']) ? mysqli_real_escape_string($conn, $_POST['description']) : '';

    // Update  details (excluding images first)
    if ($id > 0) {
        $update_sql = "UPDATE machine_detail SET name = '$name', description = '$description' WHERE id = $id";
        mysqli_query($conn, $update_sql);
    }

    // Image Upload Handling
    if (!empty($_FILES['images']['name'][0])) {
        $target_dir = "uploads/";
        foreach ($_FILES['images']['name'] as $key => $image_name) {
            $target_file = $target_dir . basename($_FILES["images"]["name"][$key]);

            // Move uploaded file
            if (move_uploaded_file($_FILES["images"]["tmp_name"][$key], $target_file)) {
                // Insert each uploaded image into the database
                $insert_image_sql = "INSERT INTO sub_otherser_machine_images (sub_machine_id, image_path) 
                                     VALUES ($id, '$target_file')";
                mysqli_query($conn, $insert_image_sql);
            }
        }
    }

    // Redirect after successful update
    echo '<script>window.location.href = "machine-detail.php";</script>';
    exit();
}
}
?>

<div class='dashboard-app'>
    <div class='dashboard-content'>
        <div class='container-fluid'>
            <!-- page title -->
            <div class='container-fluid'>
                <h1>Edit Product Details</h1>
            </div>
            <!-- breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="blog">Edit Product Details</a></li>
                    <li class="breadcrumb-item" aria-current="page"> Edit Product Details</li>
                </ol>
            </nav>

    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

        <div class="mb-3">
            <label> Enter Sub-Service</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        </div>

        <div class="mb-3">
            <label>Sub-Service description</label>
            <textarea name="description" class="form-control" required><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>

    

        <div class="mb-3">
            <label>Select Image</label>
            <input type="file" name="images[]" class="form-control" multiple>
        </div>
            <div class="mb-3">
            <!--<label>Sub-Service description</label>-->
            <div>
           <?php 
            while ($image = mysqli_fetch_assoc($image_result)) { 
            ?>
                <img src="<?php echo $image['image_path']; ?>" alt="Product Image" style="width: 80px; height: 80px; margin-right: 5px;">
            <?php } ?>

                
            </div>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>

<!-- CKEditor for Product Description -->
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description');
</script>

</body>
</html>

























