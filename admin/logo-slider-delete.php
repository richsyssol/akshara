<?php 
    include 'include/db_conn.php';
    
    $id = $_GET['id'];
    $sql = "DELETE FROM `logo_slider` WHERE id = $id";
    $result = mysqli_query($conn,$sql);
    
    if($result){
        header("Location: logo-slider.php");
        exit();
    }
    else{
        echo "Failed: " . mysqli_error($conn);
    }
?>