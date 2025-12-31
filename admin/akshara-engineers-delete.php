<?php 
    include 'include/db_conn.php';
    
    $id = $_GET['id'];
    $sql = "DELETE FROM `aksharaeng` WHERE id = $id";
    $result = mysqli_query($conn,$sql);
    
    if($result){
        header("Location: akshara-engineers.php");
        exit();
    }
    else{
        echo "Failed: " . mysqli_error($conn);
    }
?>