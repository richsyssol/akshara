<?php 
    include 'include/db_conn.php';
    
    $id = $_GET['id'];
    $sql = "DELETE FROM `a_scope` WHERE id = $id";
    $result = mysqli_query($conn,$sql);
    
    if($result){
        header("Location: acc-scope.php");
        exit();
    }
    else{
        echo "Failed: " . mysqli_error($conn);
    }
?>