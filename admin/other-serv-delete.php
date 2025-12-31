<?php 
    include 'include/db_conn.php';
    
    $id = $_GET['id'];
    $sql = "DELETE FROM `sub_other_ser` WHERE id = $id";
    $result = mysqli_query($conn,$sql);
    
    if($result){
        header("Location: other_serv.php");
        exit();
    }
    else{
        echo "Failed: " . mysqli_error($conn);
    }
?>