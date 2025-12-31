<?php 


    include 'include/db_conn.php';
    
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "DELETE FROM `blog` WHERE id = $id";
        $result = mysqli_query($conn, $sql);
        
        if($result){
            header("Location: blog.php");
            exit();
        } else {
            echo "Failed: " . mysqli_error($conn);
        }
    } else {
        echo "ID not set!";
    }
?>
