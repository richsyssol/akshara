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
        
        
        $id = intval($_GET['id']);
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $event_id = $_POST['event_id'];

        // Set the upload directory and move the uploaded file
        $upload_dir = 'uploads/events/'; // Ensure this directory exists and has write permissions
        $upload_file = $upload_dir . basename($image);

        if (move_uploaded_file($image_tmp, $upload_file)) {
            // Insert the file path into the database
            $sql = "INSERT INTO `event_detail`(`id`, `event_id`, `image`) VALUES (NULL, '$event_id' , '$upload_file')";
            $result = mysqli_query($conn, $sql);
            
            if($result){
                // Use JavaScript to redirect
                echo '<script>window.location.href = "detail-event";</script>';
                exit();
              
            } else {
                echo "Failed: " . mysqli_error($conn);
            }
        } else {
            echo "Failed to upload file.";
        }
    }
?>


<div class='dashboard-app'>
    <div class='dashboard-content'>
        <div class='container-fluid'>
        <!-- page title -->
            <div class='container-fluid'>
                <h1>Add Detail Event</h1>
            </div>
            <!-- breadcrumb -->
            <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="event">Event</a></li>
                <li class="breadcrumb-item"><a>Add Detail Event</a></li>
            </ol>
            </nav>
            <!-- form -->
            <div class="row">
                <div class="col-lg-7">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Sr.No</th>
                            <th scope="col">Event Detail Image</th>
                            <th scope="col">Event Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        include 'include/db_conn.php';
                        $id = intval($_GET['id']);
                        // Modified SQL query to include event name
                        $sql = "SELECT event_detail.id, event_detail.image, event.name AS event_name
                                FROM event_detail
                                JOIN event ON event_detail.event_id = event.id 
                                WHERE event_detail.event_id=$id";
                                
                               
                                
                        $result = mysqli_query($conn, $sql);
                        
                        if (mysqli_num_rows($result) > 0) {
                            $serial_number = 1; // Initialize serial number
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <tr>
                                    <th scope="row"><?php echo $serial_number++; ?></th>
                                    <td><img src="<?php echo $row['image']; ?>" alt="Event Image" style="width: 50px; height: 50px;"></td>
                                    <td><?php echo $row['event_name']; ?></td> <!-- Display event name instead of ID -->
                                    <td>
                                        <a href="#" data-id="<?php echo $row['id']; ?>" class="deleteBtn"><i class="fa-solid fa-trash"></i></a> 
                                    </td>
                                </tr>
                                <?php 
                            }
                        } else {
                            echo "<tr><td colspan='4'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                </div>
                <div class="col-lg-5">
                    <div class="container w-100">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Select Image</label>
                                <input class="form-control" type="file" name="image" id="formFile" required>
                            </div>
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Select Event</label>
                                <select class="form-select" name="event_id" aria-label="Default select example">
                                    <?php
                                        include 'include/db_conn.php';
                                        $result = mysqli_query($conn, "SELECT * FROM event"); 
                                        while ($row = mysqli_fetch_array($result)) {
                                            ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>

                            
                            <div>
                                <input type="submit" name="submit" value="Submit" class="btn btn-success">
                            </div>
                        </form>
                    </div>

                </div>
                
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               You want to delete this record?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>

<!--script for delete-->
<script>
$(document).ready(function(){
    var deleteId;

    // When delete button is clicked
    $('.deleteBtn').on('click', function(){
        deleteId = $(this).data('id');
        $('#deleteModal').modal('show');
    });

    // When confirm delete button in the modal is clicked
    $('#confirmDelete').on('click', function(){
        window.location.href = 'detail-event-delete.php?id=' + deleteId;
    });
});
</script>







<?php include 'attach/footer.php'; ?>

<?php 
    
}
?>