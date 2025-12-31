<?php 
    include 'include/db_conn.php';
    
    $id = $_GET['id'];
    $sql = "DELETE FROM `sector-we-serve` WHERE id = $id";
    $result = mysqli_query($conn,$sql);
    
    if($result){
        header("Location: sector-we-serve.php");
        exit();
    }
    else{
        echo "Failed: " . mysqli_error($conn);
    }
?>