<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@400;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        
        <!-- bootstrap icons  -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> 
        
        <!-- Swiper js CDN -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
    
        <!-- Adding our common css file  -->
        <link rel="stylesheet" href="css/common.css">

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <?php require('include/links.php'); ?>
    <title><?php echo $settings_r['site_title'] ?> - About  </title>

    <!-- Adding css -->
    <style>
        .box:hover{
             border-top-color: var(--teal)  !important; /*as we can not overwrite inbuilt functioin of bootstrap so mark as !important so it will execute  */
             transform: scale(1.03); /* it will transfrom the contenet in 1.03 multiplier when we hover it   */
             transition: all 0.3s; /* it will tanslate all the content after 0.3s  */
        }
        
    </style>
</head>
<body>
<!-- header -->
<?php require('include/header.php'); ?>

<!-- heading of About us  -->
<div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">ABOUT US </h2>
    <div class="h-line bg-dark"></div>
    <p class="text-center mt-3">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sit vel 
        animi aspernatur similique, <br>recusandae consectetur adipisci 
        omnis labore odit numquam.</p>
</div>

<!-- Person Description & Photo -->
<div class="container">
    <div class="row justify-content-between align-items-center">
        <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
            <h3 class="mb-3 ">Lorem, ipsum dolor.</h3>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis error
                 numquam debitis, architecto atque neque animi.
                 Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis error
                 numquam debitis, architecto atque neque animi.
            </p>
        </div>
        <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1">
            <img src="images/about/about.jpg" class="w-100">
        </div>
    </div>
</div>

<!--About box -->
<div class="container mt-5">
    <div class="row">
    <!-- Rooms -->
        <div class="col-lg-3 col-md-6 mb-4 px-4 ">
            <div class="bg-white1 rounded shadow p-4 border-top border-4 text-center box ">
                <img src="images/about/hotel.svg" width="70px" >
                <h4 class="mt-4">100+ Rooms </h4>
            </div>
        </div>
    <!-- Customers -->
        <div class="col-lg-3 col-md-6 mb-4 px-4 ">
            <div class="bg-white1 rounded shadow p-4 border-top border-4 text-center box ">
                <img src="images/about/customers.svg" width="70px" >
                <h4 class="mt-4" style="font-size: 22px;">200+ Customers</h4>
            </div>
        </div>
    <!-- Reviews     -->
        <div class="col-lg-3 col-md-6 mb-4 px-4 ">
            <div class="bg-white1 rounded shadow p-4 border-top border-4 text-center box ">
                <img src="images/about/rating.svg" width="70px" >
                <h4 class="mt-4">150+ Reviews </h4>
            </div>
        </div>

    <!-- staff -->
        <div class="col-lg-3 col-md-6 mb-4 px-4 ">
            <div class="bg-white1 rounded shadow p-4 border-top border-4 text-center box ">
                <img src="images/about/staff.svg" width="70px" >
                <h4 class="mt-4">200+ Staffs </h4>
            </div>
        </div>


    </div>
</div>  

<!-- MANAGMENT team -->
<h3 class="my-3 fw-bold h-font text-center">MANAGMENT</h3>
    <div class="container px-4">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper mb-5 ">

            <?php 
                $about_r = selectAll('team_details');

                while($row = mysqli_fetch_assoc($about_r) )
                {
                    echo<<<data
                    <div class="swiper-slide bg-white1 text-center overflow-hidden rounded ">
                        <img src="images/about/$row[picture]" class="w-100">
                        <h5 class="mt-2">$row[name]</h5>
                    </div>
                    data;
                }
            ?>
            </div>
            <div class="swiper-pagination"></div>
          </div>
    </div>

<!-- footer -->
<?php require('include/footer.php'); ?>

  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

  <!-- Initialize Swiper -->
  <script>
    var swiper = new Swiper(".mySwiper", {
        slidesPerView : 3,
        spaceBetween : 40,
        pagination: {
        el: ".swiper-pagination",
        dynamicBullets: true,
      },
      breakpoint:{
        320:{
            slidesPerView : 1 ,
        },
        640:{
            slidesPerView : 1 ,
        },
        768:{
            slidesPerView : 3 ,
        },
        1024:{
            slidesPerView : 3,
        },
    }
    });
  </script>


</body>
</html>