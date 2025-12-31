<?php include 'includes/header.php' ?>
<?php include'include/db_connect.php';?>

<Style>
     .content-scroll {
      max-height: 380px;
      overflow-y: auto;
      direction: ltr; /* Scrollbar on the left */
      padding-left: 10px; /* Padding to avoid text clashing with scrollbar */
    }
    .content-scroll * {
      direction: rtl; /* Text remains left-to-right */
      text-align: left;
    }
    .content-scroll::-webkit-scrollbar {
      width: 5px;
    }
    .content-scroll::-webkit-scrollbar-thumb {
      background-color: grey;
    }
           .container11 {
      max-width: 1000px;
      margin: 40px auto;
      /*padding: 20px;*/
      background: #fff;
      border-radius: 10px;
      /* box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); */
    }
         .process-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 30px;
        }

        .box {
            width: 200px;
            height: 80px;
            background-color: #3498db;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            border-radius: 10px;
            position: relative;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 1s forwards;
        }

        .arrow {
            width: 50px;
            height: 2px;
            background-color: black;
            position: relative;
            opacity: 0;
            transform: translateX(-20px);
            animation: fadeInRight 1s forwards;
        }

        .arrow::after {
            content: "";
            position: absolute;
            right: -5px;
            top: -5px;
            border-top: 6px solid transparent;
            border-bottom: 6px solid transparent;
            border-left: 10px solid black;
        }

        /* Animation Delays */
        .box:nth-child(1) { animation-delay: 0.5s; }
        .arrow:nth-child(2) { animation-delay: 1s; }
        .box:nth-child(3) { animation-delay: 1.5s; }
        .arrow:nth-child(4) { animation-delay: 2s; }
        .box:nth-child(5) { animation-delay: 2.5s; }
        .arrow:nth-child(6) { animation-delay: 3s; }
        .box:nth-child(7) { animation-delay: 3.5s; }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

</Style>

  <section class="page-title" style="background-image: url(asset/image/bg23.png);height:200px;">
        <nav aria-label="breadcrumb" class="py-5 mb-5 ">
          <h3 class="fw-bold text-white ms-5 " style="font-size:40px;">About Us</h3>
          <ol class="breadcrumb bg-transparent ">
             <li class="breadcrumb-item">
           <a href="https://akshara.demovoting.com/" class="textbg text-decoration-none">Home</a>
                  </li>
            <li class="breadcrumb-item active text-white" aria-current="page">About Us</li>
          </ol>
        </nav>
        </section>



<section>
  <div class="container py-5">
    <!-- Header Section -->
    <div class="text-center">
      <h1 class="custom-underline with-underline centered-heading">Welcome to Akshara Engineers</h1>
      <div class="custom-underline"></div>
    </div>

    <div class="row align-items-center mt-4">
      <?php
      // SQL query to fetch data
      $sql = "SELECT * FROM `aksharaeng`";
      $result = mysqli_query($conn, $sql);

      if ($result && mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
              $text = $row['text'];
              $image = $row['image'];
      ?>
      <!-- Right Content Section -->
      <div class="col-md-6">
        <div class="content-scroll">
        <p ><?php echo $row['text']; ?></p>
          <a href="#" class="presentation-button">Corporate Presentation</a>
        </div>
      </div>

      <!-- Left Image/Video Section -->
      <!--<div class="col-md-6 img-section">-->
      <!--      <img src="<?php echo 'admin/'.$row['image']; ?>" alt="Owner Image" class="shadow " style="height: 350px; width:600px;  border-radius: 10px; /* Optional */ ">-->

      <!--  </div>-->
      <div class="col-md-6 col-12 img-section">
    <img src="<?php echo 'admin/'.$row['image']; ?>" alt="Owner Image" class="img-fluid shadow" style="max-height: 350px; width: 100%; border-radius: 10px;">
</div>


      </div>
      <?php
          }
          }
      ?>
    </div>  
  </div>
</section>





<!-- CSS Styling -->
<style>*/
/* Zoom Effect */
/*.zoom-effect {*/
/*    transform: translateY(50px) scale(0.9);*/
/*    transition: all 0.5s ease-in-out;*/
/*    opacity: 0;*/
/*}*/

/*.zoom-effect:hover {*/
/*    transform: translateY(0px) scale(1);*/
/*    opacity: 1;*/
/*}*/

/* Apply zoom effect on section load */
/*.content-scroll, .img-section img, .presentation-button {*/
/*    animation: zoomIn 0.8s ease-out forwards;*/
/*}*/

/*@keyframes zoomIn {*/
/*    0% {*/
/*        transform: translateY(80px) scale(0.9);*/
/*        opacity: 0;*/
/*    }*/
/*    100% {*/
/*        transform: translateY(0px) scale(1);*/
/*        opacity: 1;*/
/*    }*/
/*}*/

/* Additional Styling */
/*h1.centered-heading {*/
/*    font-size: 2.5rem;*/
/*    font-weight: bold;*/
/*}*/

/*p.description {*/
/*    font-size: 1.2rem;*/
/*    color: #666;*/
/*    margin-bottom: 20px;*/
/*}*/

/*.presentation-button {*/
/*    display: inline-block;*/
/*    padding: 10px 20px;*/
/*    background-color: #007bff;*/
/*    color: white;*/
/*    text-decoration: none;*/
/*    border-radius: 5px;*/
/*    font-weight: bold;*/
/*}*/

/*.presentation-button:hover {*/
/*    background-color: #0056b3;*/
/*}*/
/*</style>







<!--owner introduction-->
<section style="background-color:#f4f4f4;"> 
<div class="container py-5">
<div class="row align-items-center">
               <?php
  
                $sql = "SELECT * FROM `visionaryl_leaders`";
                $result = mysqli_query($conn, $sql);
               
                
               
                
                while ($row = mysqli_fetch_assoc($result)){
                    ?>
      <!-- Left Card -->
      <div class="col-12 col-sm-7 col-md-4">
          
    <div class="testimonial-card text-center">
        
        <img src="<?php echo 'admin/'.$row['image']; ?>" alt="Owner Image" class="shadow img-fluid" style="height: 300px; width:300px; ">
        <h5 class="mt-3 fw-bold">Mr. Om Vijay Sangale</h5>
    </div>
</div>

      
      <!-- Right Content -->
      <div class="col-md-8 py-5">
        <div class="testimonial-text py-5 shadow">
               <h3 class="mb-2 fw-bold">Visionary Leaders</h3>
          <p class="" style="    text-align: justify;"><?php echo $row['name']; ?></p>


        </div>
      </div>
    <?php
                }
            ?>
    </div>
    
  </div>
</section>





<section class="mb-5 ">
    <div class="container11 about-section">
        <div class="section11">
      <div class="icon23" style="margin-left: -90px;">
<i class="fa-solid fa-circle-question" style="font-size:70px;"></i>
      </div>
      <div class="text" style="    text-align: justify;">
        <h3 class="fw-bold">Why Choose Akshara Engineers? </h3>
        <p>
          <b>ISO 9001:2015 Certified:</b> Ensuring the highest standards in quality management.
        </p>
        <p>
          <b>Advanced Technology:</b> Equipped with cutting-edge machinery like the SF3015G Fiber Laser Cutter and Amada Promecam Bending Machine for unmatched precision.
        </p>
        <p >
          <b>Experienced Leadership:</b> Guided by our founder, Mr. Om Vijay Sangale, a Mechanical Engineering graduate and a visionary entrepreneur. 
        </p>
      </div>
    </div>

    <div class="section11">
      <div class="icon22" style="margin-left: -90px;">
    <i class="fa-solid fa-handshake-angle" style="font-size:75px;"></i>
      </div>
      <div class="text">
        <h2 class="fw-bold">Our Commitment</h2>
        <p style="    text-align: justify;" >
          At Akshara Engineers, we strive to deliver solutions that combine innovation, quality, and precision. Whether you're looking for intricate metal designs for your home or heavy-duty industrial components, we ensure that every project exceeds your expectations. Partner with us for all your fabrication and manufacturing needs, and experience the Akshara Engineers difference.
        </p>
      </div>
    </div>
  </div>
</section>


<section class="py-3">
    <h2 class="mb-5 custom-underline with-underline centered-heading">Process</h2>
    <div class="container-fluid">
        <div class="d-flex justify-content-center">
            <img src="asset/image/akp.png" alt="Process Flow Image" class="img-fluid shadow" style="max-height: 443px; width: 100%; max-width: 1083px;">
        </div>
    </div>
</section>


<!--<section class=" py-3" >-->
<!--      <h2 class="mb-5  custom-underline with-underline centered-heading">Process</h2>-->
<!--    <div class="container-fluid">-->
<!--        <div class="d-flex justify-content-center">-->
<!--            <img src="asset/image/akp.png" alt="Process Flow Image" class="shadow " style="height: 443px;width: 1083px;">-->
<!--        </div>-->
<!--    </div>-->
<!--</section>-->



<!--<section class=" py-3" >-->
<!--      <h2 class="mb-5  custom-underline with-underline centered-heading">Process</h2>-->
<!--    <div class="container-fluid">-->
<!--       <div class="process-container">-->
<!--        <div class="box">A</div>-->
<!--        <div class="arrow"></div>-->
<!--        <div class="box">B</div>-->
<!--        <div class="arrow"></div>-->
<!--        <div class="box">C</div>-->
<!--        <div class="arrow"></div>-->
<!--        <div class="box">D</div>-->
        
<!--    </div>-->
<!--    <br>-->
<!--      <div class="container-fluid">-->
<!--       <div class="process-container">-->
<!--        <div class="box">A</div>-->
<!--        <div class="arrow"></div>-->
<!--        <div class="box">B</div>-->
<!--        <div class="arrow"></div>-->
<!--        <div class="box">C</div>-->
<!--        <div class="arrow"></div>-->
<!--        <div class="box">D</div>-->
        
<!--    </div>-->

<!--    </div>-->
<!--</section>-->












<section class="values-section text-center">
  <h2 class="mb-5 custom-underline with-underline centered-heading">Values</h2>
  <div class="container">
     
    <div class="owl-carousel owl-theme">
           <?php
                $sql = "SELECT * FROM `value`";
                $result = mysqli_query($conn, $sql);
               
                
                while ($row = mysqli_fetch_assoc($result)){
                    ?>
      <!-- Teamwork -->
      <div class="item">
        <div class="value-icon mb-3">
           <img src="<?php echo 'admin/'.$row['image']; ?>" style="font-size: 2.3rem;"></i>
        </div>
        <h4 class="value-title "><?php echo $row['title']; ?></h4>
        <p style=""><?php echo $row['name']; ?></p>
      </div>

  <?php
                }
            ?>
    </div>
   
  </div>
</section>


<section>
    <div class="container py-5">
        <div class="row">
            <?php
            $sql = "SELECT * FROM `vision-mission`";
            $result = mysqli_query($conn, $sql);
            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

            if (count($data) >= 2) {
                $vision = $data[0]; // First row for Vision
                $mission = $data[1]; // Second row for Mission
            ?>
                <!-- Vision Column -->
                <div class="col-md-6">
                    <div class="content-box2 text-center">
                        <div class="value-icon mb-3">
                            <!--<img src="<?php echo 'admin/' . $vision['image']; ?>" alt="Vision Image" class="shadow img-fluid" style="height: 300px; width:300px;">-->
                             <i class="fa-solid fa-circle-check" style="font-size: 2.3rem;"></i>
                        </div>
                        <h2 class="fw-bold mb-3">Vision</h2>
                        <p class="text-justify"><?php echo $vision['name']; ?></p>
                    </div>
                </div>

                <!-- Mission Column -->
                <div class="col-md-6">
                    <div class="content-box text-center" style="left: 170;">
                        <div class="value-icon mb-3">
                               <i class="fa-solid fa-bullseye" style="font-size: 2.3rem;"></i>
                            <!--<img src="<?php echo 'admin/' . $mission['image']; ?>" alt="Mission Image" class="shadow img-fluid" style="height: 300px; width:300px;">-->
                        </div>
                        <h2 class="fw-bold mb-3">Mission</h2>
                
                            <ul>
                            <p style="text: justify;"><?php echo $mission['name']; ?></p>
                           
                           
                        </ul>
                    </div>
                </div>
            <?php
            } else {
                echo "<p class='text-center'>No data available</p>";
            }
            ?>
        </div>
    </div>
</section>




<!-- Accreditation Section -->
<section style="background-color: #f4f4f4;">
  <div class="container py-5">
    <h2 class="mb-5 custom-underline with-underline centered-heading">Certifications</h2>
    <div class="row justify-content-center g-4">
      <?php
        $sql = "SELECT * FROM `certification`";
        $result = mysqli_query($conn, $sql);
        $modalCounter = 1; // To assign unique IDs to modals

        while ($row = mysqli_fetch_assoc($result)) {
          $modalId = "modalCertificate" . $modalCounter;
      ?>
      <!-- Certificate Card -->
      <div class="col-md-3 col-sm-6 col-12">
        <div class="border border-dark p-3 text-center shadow">
          <div class="p-2">
            <img src="<?php echo 'admin/' . $row['image']; ?>"  alt="Certificate <?php echo $modalCounter; ?>"  class="img-fluid" data-bs-toggle="modal" data-bs-target="#<?php echo $modalId; ?>" style="cursor: pointer; height: auto; max-height: 350px;">
          </div>
        </div>
      </div>

      <!-- Modal for the Certificate -->
      <div class="modal fade" id="<?php echo $modalId; ?>" tabindex="-1" aria-labelledby="<?php echo $modalId; ?>Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
              <img src="<?php echo 'admin/' . $row['image']; ?>" 
                   alt="Certificate <?php echo $modalCounter; ?>" 
                   class="img-fluid" 
                   style="max-height: 570px;">
            </div>
          </div>
        </div>
      </div>
      <?php
          $modalCounter++; // Increment modal ID counter
        }
      ?>
    </div>
  </div>
</section>





<!-- Owl Carousel Script -->
<script>
  $(document).ready(function () {
    $(".owl-carousel").owlCarousel({
      loop: true,
      margin: 10,
      nav: false,
      dots: true,
      autoplay: true,
      autoplayTimeout: 3000,
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

<script>
    document.querySelector('.scroll-up').addEventListener('click', function () {
      const scrollContainer = document.querySelector('.content-scroll');
      scrollContainer.scrollTop -= 50; // Scroll up by 50px
    });

    document.querySelector('.scroll-down').addEventListener('click', function () {
      const scrollContainer = document.querySelector('.content-scroll');
      scrollContainer.scrollTop += 50; // Scroll down by 50px
    });
  </script>



<?php include 'includes/footer.php' ?>