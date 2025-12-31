<?php 
session_start(); // Start the session

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true ) {
    // Redirect to login page if not logged in
    header("Location: login.php"); // Adjust path if needed
    exit(); // Ensure no further code is executed
}
else{
    include 'attach/header.php'; 
    include 'attach/navbar.php';  
 
?>
 






<div class='dashboard-app'>
    <div class='dashboard-content'>
        <div id="root">
  <div class="container pt-5">
    <div class="row align-items-stretch">
        <?php
            include 'include/db_conn.php';
            // SQL query to count the total number of products
            $sql = "SELECT COUNT(*) AS total_services FROM `services`";
            $result = mysqli_query($conn, $sql);
        
            // Fetch the result as an associative array
            $row = mysqli_fetch_assoc($result);
        
            // Get the total count of products
            $total_services = $row['total_services'];
        ?>
      <div class="c-dashboardInfo col-lg-3 col-md-6">
        <div class="wrap">
          <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">Total Services</h4>
          <span class="hind-font caption-12 c-dashboardInfo__count"><?php echo $total_services; ?></span>
        </div>
      </div>
      <?php
            include 'include/db_conn.php';
            // SQL query to count the total number of products
            $sql = "SELECT COUNT(*) AS total_products FROM `product`";
            $result = mysqli_query($conn, $sql);
        
            // Fetch the result as an associative array
            $row = mysqli_fetch_assoc($result);
        
            // Get the total count of products
            $total_products = $row['total_products'];
        ?>
      <div class="c-dashboardInfo col-lg-3 col-md-6">
        <div class="wrap">
          <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">Total Products</h4>
          <span class="hind-font caption-12 c-dashboardInfo__count"><?php echo $total_products; ?></span>
        </div>
      </div>
      <?php
            include 'include/db_conn.php';
            // SQL query to count the total number of products
            $sql = "SELECT COUNT(*) AS total_sub_services FROM `sub_services`";
            $result = mysqli_query($conn, $sql);
        
            // Fetch the result as an associative array
            $row = mysqli_fetch_assoc($result);
        
            // Get the total count of products
            $total_sub_services = $row['total_sub_services'];
        ?>
      <div class="c-dashboardInfo col-lg-3 col-md-6">
        <div class="wrap">
          <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">Total Sub-Services</h4>
          <span class="hind-font caption-12 c-dashboardInfo__count"><?php echo $total_sub_services; ?></span>
        </div>
      </div>
      <?php
            include 'include/db_conn.php';
            // SQL query to count the total number of products
            $sql = "SELECT COUNT(*) AS total_blogs FROM `blog`";
            $result = mysqli_query($conn, $sql);
        
            // Fetch the result as an associative array
            $row = mysqli_fetch_assoc($result);
        
            // Get the total count of products
            $total_blogs = $row['total_blogs'];
        ?>
      <div class="c-dashboardInfo col-lg-3 col-md-6">
        <div class="wrap">
          <h4 class="heading heading5 hind-font medium-font-weight c-dashboardInfo__title">Total Blog</h4>
          <span class="hind-font caption-12 c-dashboardInfo__count"><?php echo $total_blogs; ?></span>
        </div>
      </div>
    </div>
  </div>
</div>

    </div>
</div>



<?php include 'attach/footer.php'; ?>
 <?php 
    
}
?>
