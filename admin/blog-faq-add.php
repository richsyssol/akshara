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
        $blog_id = $_POST['blog_id'];  
        $que = $_POST['que'];  
        $ans = $_POST['ans']; 

        // Insert the form data into the database
        $sql = "INSERT INTO `blog_faq`(`id`, `blog_id`, `que`, `ans`) VALUES (NULL, '$blog_id', '$que', '$ans')";
        $result = mysqli_query($conn, $sql);
        
        if($result){
            // Use JavaScript to redirect
            echo '<script>window.location.href = "blog-faq.php";</script>';
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
                <h1>Add Blog Title</h1>
            </div>
            <!-- breadcrumb -->
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="blog-title.php">Blog Title</a></li>
                <li class="breadcrumb-item"><a>Add Blog Title</a></li>
            </ol>
            </nav>
            <!-- form -->
            <div class="container pt-5 w-50">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Select Blog</label>
                    <select class="form-select" name="blog_id" aria-label="Default select example">
                        <?php
                            include 'include/db_conn.php';
                            $result = mysqli_query($conn, "SELECT * FROM blog"); 
                            while ($row = mysqli_fetch_array($result)) {
                                ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['title']; ?></option>
                                <?php
                            }
                        ?>
                      
                    </select>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Enter Queastion</label>
                    <input type="text" name="que" class="form-control" id="exampleFormControlInput1" placeholder="Enter Queastion" required>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Enter Answer</label>
                    <input type="text" name="ans" class="form-control" id="exampleFormControlInput1" placeholder="Enter Answer" required>
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





