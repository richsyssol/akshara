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




<div class='dashboard-app'>
    <div class='dashboard-content'>
        <!-- page title -->
        <div class='container-fluid'>
            <h1>Services</h1>
        </div>
        <!-- breadcrumb -->
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">Services</a></li>
        </ol>
        </nav>
        
        <?php 
            if(isset($_GET['msg'])){
                $msg = $_GET['msg'];
                
                echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                      '.$msg.'
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
            }
        ?>
        
        <div class="pt-5">
        <!-- Add Button -->
        <a href="services-add" class="btn btn-primary">Add Services</a>
        </div>
        <!-- table -->
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Sr.No</th>
                        <th scope="col">Image</th>
                        <th scope="col">Service</th>
                        <th scope="col">Sub-Service</th>
                        <th scope="col">Description</th>
                        <th scope="col">Details</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    include 'include/db_conn.php';
                    
                    $sql = "SELECT sub_services.*, services.ser_name 
                            FROM sub_services 
                            JOIN services ON sub_services.service_id = services.id";
                    
                    $result = mysqli_query($conn , $sql);
                    
                    if(mysqli_num_rows($result) > 0) {
                        $serial_number = 1; // Initialize serial number
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <th scope="row"><?php echo $serial_number++; ?></th>
                                <td><img src="<?php echo $row['image']; ?>" alt="service" style="width: 50px; height: 50px;"></td>
                                <td><?php echo $row['ser_name']; ?></td> <!-- Display service name instead of ID -->
                                <td><?php echo $row['sub_service']; ?></td>
                                <td>
                                   <?php 
                                        $description_words = explode(" ", $row['description']);
                                        $description_preview = implode(" ", array_slice($description_words, 0, 10));
                                        echo $description_preview . (count($description_words) > 10 ? '...' : '');
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        $details_words = explode(" ", $row['details']);
                                        $details_preview = implode(" ", array_slice($details_words, 0, 1));
                                        echo $details_preview . (count($details_words) > 1 ? '...' : '');
                                    ?>
                                </td>
                                <td>
                                    <a href="#" data-id="<?php echo $row['id']; ?>" class="deleteBtn"><i class="fa-solid fa-trash"></i></a> &nbsp; / &nbsp;
                                    <a href="services-edit?id=<?php echo $row['id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                </td>
                            </tr>
                        <?php 
                        }
                    } else {
                        echo "<tr><td colspan='7'>No records found</td></tr>"; // Updated colspan to match the number of columns
                    }
                    ?>
                </tbody>
            </table>
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
        window.location.href = 'services-delete.php?id=' + deleteId;
    });
});
</script>

<?php include 'attach/footer.php'; ?>

<?php 
    
}
?>