<?php 
    include 'include/db_conn.php';
    
    $id = $_GET['id'];
    $sql = "DELETE FROM `serv` WHERE id = $id";
    $result = mysqli_query($conn,$sql);
    
    if($result){
        header("Location:  a-service.php");
        exit();
    }
    else{
        echo "Failed: " . mysqli_error($conn);
    }
?>