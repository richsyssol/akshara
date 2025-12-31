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
?>

<div class='dashboard-app'>
    <div class='dashboard-content'>
        <!-- page title -->
        <div class='container-fluid'>
            <h1>	Service Details</h1>
        </div>
        <!-- breadcrumb -->
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="#">	Service Details</a></li>
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
        <a href="a-servicedetails-add.php" class="btn btn-primary">Add Service Details</a>
        </div>
        <!-- table -->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Sr.No</th>
                    <th scope="col">	ServiceDetail Image</th>
                    <th scope="col">	Service Name</th>
                             <th scope="col">	Service Title</th>
                        <th scope="col">	Service Discription</th>                
                        <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                include 'include/db_conn.php';
                // $id = intval($_GET['id']); // Get the machine id from the URL
                
                // SQL query with joins
                $sql = "SELECT  ser_details.order_id, ser_details.name,  ser_details.description, 
                        serv.name AS serv_name, sub_otherser_serv_image.image_path AS sub_serv_image
                        FROM  ser_details
                        LEFT JOIN serv ON  ser_details.serv_id = serv.id
                        LEFT JOIN sub_otherser_serv_image ON sub_otherser_serv_image.sub_serv_id = serv.id
                        WHERE  ser_details.serv_id"; // We directly use $id here
                
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    $serial_number = 1; // Initialize serial number
                    while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <th scope="row"><?php echo $serial_number++; ?></th>
                            <!--<td><img src="<?php echo $row['image']; ?>" alt="Event Image" style="width: 50px; height: 50px;"></td>-->
                                <td>
                                    <?php
                                        // Fetch images associated with this sub-service
                                        $sub_serv_id  = $row['order_id']; 
                                        $sql_images = "SELECT * FROM sub_otherser_serv_image WHERE sub_serv_id  = '$sub_serv_id'";
                                        $result_images = mysqli_query($conn, $sql_images);


                                        while ($image_row = mysqli_fetch_array($result_images)) {
                                            echo '<img src="' . $image_row['image_path'] . '" alt="service" style="width: 50px; height: 50px; margin-right: 5px;">';
                                        }
                                    ?>
                                    
                                </td>

                            <td><?php echo $row['serv_name']; ?></td> 
                            <td><?php echo $row['name']; ?></td> 
                            <td><?php echo $row['description']; ?></td> 
                            <td>
                                <a href="#" data-id="<?php echo $row['order_id']; ?>" class="deleteBtn"><i class="fa-solid fa-trash"></i></a> 
                                <a href="a-servicedetails-edit?id=<?php echo $row['order_id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                            </td>
                        </tr>
                        <?php 
                    }
                } else {
                    echo "<tr><td colspan='6'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        window.location.href = 'a-servicedetails-delete.php?id=' + deleteId;
    });
});
</script>

<?php include 'attach/footer.php'; ?>
<?php 
}
?>
