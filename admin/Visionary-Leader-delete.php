<?php 
    include 'include/db_conn.php';
    
    $id = $_GET['id'];
    $sql = "DELETE FROM `visionaryl_leaders` WHERE id = $id";
    $result = mysqli_query($conn,$sql);
    
    if($result){
        header("Location: Visionary-Leader.php");
        exit();
    }
    else{
        echo "Failed: " . mysqli_error($conn);
    }
?>