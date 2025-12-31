<?php 
    include 'include/db_conn.php';
    
    $order_id = $_GET['id'];
    $sql = "DELETE FROM `ser_details` WHERE order_id=$order_id";
    $result = mysqli_query($conn,$sql);
    
    if($result){
        header("Location: a-servicedetails.php");
        exit();
    }
    else{
        echo "Failed: " . mysqli_error($conn);
    }
?>