<?php 
    include 'include/db_conn.php';
    
    $id = $_GET['id'];
    $sql = "DELETE FROM `why_choose` WHERE id = $id";
    $result = mysqli_query($conn,$sql);
    
    if($result){
        header("Location: why-choose.php");
        exit();
    }
    else{
        echo "Failed: " . mysqli_error($conn);
    }
?>