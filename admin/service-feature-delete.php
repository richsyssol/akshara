<?php 
    include 'include/db_conn.php';
    
    $id = $_GET['id'];
    $sql = "DELETE FROM `service_feature` WHERE id = $id";
    $result = mysqli_query($conn,$sql);
    
    if($result){
        header("Location: service-feature.php");
        exit();
    }
    else{
        echo "Failed: " . mysqli_error($conn);
    }
?>