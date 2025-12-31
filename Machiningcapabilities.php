    <?php include 'includes/header.php' ?>
<?php include'include/db_connect.php';?>


  <section class="page-title" style="background-image: url(asset/image/bg23.png);height:200px;">
    <nav aria-label="breadcrumb" class="py-5 mb-5">
        <h3 class=" fw-bold text-white ms-5" style="font-size:40px;">Machine</h3>
        <ol class="breadcrumb bg-transparent ">
            <li class="breadcrumb-item">
                <a href="https://akshara.demovoting.com/" class="textbg text-decoration-none">Home</a>
            </li>
            <li class="breadcrumb-item active text-white" aria-current="page">Machine </li>
        </ol>
    </nav>
</section>


<div class="container py-4">
    <div class="owl-carousel owl-theme">
             <?php
             
                        $sql = "SELECT * FROM `machine`";
                        $result = mysqli_query($conn, $sql);
                       
                        
                        while ($row = mysqli_fetch_assoc($result)){
                            ?>
        <!-- Card 1 -->
        <div class="item">
              
            <div class="card1">
                <div class="zoom-container">
                    <a href="machine_details.php?id=<?php echo $row['id'] ?>">
                    <img src="<?php echo 'admin/'.$row['image']; ?>" height="300" class="product-img-top" alt="Compressed Air">
                    </a>
                </div>
                <div class="card1-footer p-3">
                    <a href="machine_details.php?id=<?php echo $row['id'] ?>"><?php echo $row['name']; ?></a>
                </div>
            </div>
            
         
        </div>
   <?php
                }
            ?>
    </div>
</div>



 <script>
   $(document).ready(function(){
    $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });
});

    </script>













<?php include 'includes/footer.php' ?>