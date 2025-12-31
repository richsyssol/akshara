<?php 
    include 'include/db_conn.php';
    
    $order_id = $_GET['id'];

    // Delete related records in sub_otherser_event_images first
    $sql1 = "DELETE FROM `sub_otherser_event_images` WHERE sub_event_id=$order_id";
    mysqli_query($conn, $sql1);

    // Now delete from event_detail
    $sql2 = "DELETE FROM `event_detail` WHERE order_id=$order_id";
    $result = mysqli_query($conn, $sql2);
    
    if($result){
        header("Location:  a-productdetails.php");
        exit();
    }
    else{
        echo "Failed: " . mysqli_error($conn);
    }
?>
