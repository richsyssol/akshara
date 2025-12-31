<?php 
    include 'include/db_conn.php';
    
    $id = $_GET['id'];
    $sql = "DELETE FROM `location` WHERE id = $id";
    $result = mysqli_query($conn,$sql);
    
    if($result){
        header("Location: location.php");
        exit();
    }
    else{
        echo "Failed: " . mysqli_error($conn);
    }
?>
