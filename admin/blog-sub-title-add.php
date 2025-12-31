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
        $b_title_id    = $_POST['b_title_id'];  
        $sub_title = $_POST['sub_title'];  
        $s_description = $_POST['s_description']; 

        // Insert the form data into the database
        $sql = "INSERT INTO `blog_sub_titles`(`id`, `b_title_id`, `sub_title`, `s_description`) VALUES (NULL, '$b_title_id', '$sub_title', '$s_description')";
        $result = mysqli_query($conn, $sql);
        
        if($result){
            // Use JavaScript to redirect
            echo '<script>window.location.href = "blog-sub-title.php";</script>';
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
                <h1>Add Blog Sub-Title</h1>
            </div>
            <!-- breadcrumb -->
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="blog-sub-title.php">Blog Sub-Title</a></li>
                    <li class="breadcrumb-item"><a>Add Blog Sub-Title</a></li>
                </ol>
            </nav>
            <!-- form -->
            <div class="container pt-5 w-50">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Select Title</label>
                        <select class="form-select" name="b_title_id" aria-label="Default select example">
                            <?php
                                $result = mysqli_query($conn, "SELECT * FROM blog_titles"); 
                                while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['b_title']; ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Enter Sub-Title</label>
                        <input type="text" name="sub_title" class="form-control" id="exampleFormControlInput1" placeholder="Enter Sub-Title" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Enter Description</label>
                        <textarea class="form-control" name="s_description" id="exampleFormControlTextarea1" rows="3"></textarea>
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

<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('exampleFormControlTextarea1');
</script>

<?php 
    
}
?>