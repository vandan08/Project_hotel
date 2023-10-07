<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    

    
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <?php require('include/links.php'); ?>
    <title><?php echo $settings_r['site_title'] ?> - Home </title>

    <!-- Adding css -->
    <style>
        .availibility-form{
            margin-top: -50px;
            z-index: 2;
            position: relative;
        }
        @media screen and (max-width: 575px) {
                .availibility-form{
                margin-top: 0px;
                padding: 0 35px;
                
            }
        }
    </style>
</head>
<body>
    <?php require('include/header.php'); ?>
    

<!-- carousel Design -->
    <div class="container-fluid px-lg-4 mt-4">
        <div class="swiper swiper-container">
            <div class="swiper-wrapper">
                <?php 
                    $res = selectAll('carousel');
                    while($row = mysqli_fetch_assoc($res)){
                        $path = CAROUSEL_IMG_PATH;
            
                        echo <<<data
                        <div class="swiper-slide">
                            <img src="$path$row[image]" class="w-100 d-block" />
                        </div>
                        data;
                    }
                ?>  
            </div>
        </div>
    </div>

<!-- Check availibility Form  -->
    <div class="container availibility-form">
        <div class="row">
            <div class="cl-lg-12 bg-white shadow p-4 rounded ">
                <h5 class="mb-4 ">Check Booking  Availibility </h5>
                <form action="rooms.php">
                    <div class="row align-items-end">
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-weight: 500;" >Check-in</label>
                            <input type="date" class="form-control" name="checkin" required>
                        </div>
                        <div class="col-lg-3 mb-3">
                            <label class="form-label" style="font-weight: 500;" >Check-Out</label>
                            <input type="date" class="form-control" name="checkout" required>
                        </div>
                        <div class="col-lg-3 mb-3 ">
                            <label class="form-label" style="font-weight: 500;" >Adult</label>
                            <select class="form-select " name="adult" >
                                <?php 
                                $guests_q = mysqli_query($con,"SELECT MAX(adult) AS `max_adult`,MAX(children) AS `max_children` 
                                FROM `rooms` WHERE `status`='1' AND `removed`='0'");
                                $guests_res = mysqli_fetch_assoc($guests_q);

                                for ($i=1; $i<=$guests_res['max_adult']; $i++) { 
                                    echo<<<op
                                        <option value="$i">$i</option>

                                    op;
                                }

                                ?>
                            </select>
                        </div>
                        <div class="col-lg-2 mb-3">
                            <label class="form-label" style="font-weight: 500;" >Children</label>
                            <select class="form-select " name="children">
                                <?php 
                                    for ($i=1; $i<=$guests_res['max_children']; $i++) { 
                                        echo<<<op
                                            <option value="$i">$i</option>

                                        op;
                                    }
                                ?>
                            </select>
                        </div>
                        <input type="hidden" name="check_availinility">
                        <div class="col-lg-1 mb-lg-3 mt-2">
                            <button type="submit" class="btn text-white shadow-none custom-bg"> Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<!-- Rooms Cards  -->
   <h2 class="mt-5 pt-5 mb-4 text-center fw-bold h-font">OUR ROOMS </h2>
    <div class="container">
        <div class="row">
            <?php 
            $room_res = select("SELECT * FROM `rooms` WHERE `status`=? AND `removed`=?  ORDER BY `id` DESC  LIMIT 3  ",[1,0],'ii');

            while($room_data = mysqli_fetch_assoc($room_res)){
                //get Features of room 
                $fea_q = mysqli_query($con,"SELECT f.name FROM `features` f 
                    INNER JOIN `room_features` rfea ON f.id = rfea.features_id 
                    WHERE rfea.room_id = '$room_data[id]'");

                $features_data = '';
                while($fea_row = mysqli_fetch_assoc($fea_q)){
                    $features_data.="<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                                        $fea_row[name]
                                    </span>";
                }   
                //get Facilities of room 

                $fac_q = mysqli_query($con,"SELECT f.name FROM `facilities` f 
                INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id 
                WHERE rfac.room_id='$room_data[id]'");

                $facilities_data = '';
                while($fac_row = mysqli_fetch_assoc($fac_q)){
                    $facilities_data.="<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                                        $fac_row[name]
                                    </span>";
                }   

                //get Thumbnail of Room
                $room_thumg = ROOMS_IMG_PATH."thumbnail.jpg";
                $thumb_q = mysqli_query($con,"SELECT * FROM `room_image` 
                            WHERE `room_id`='$room_data[id]' 
                            AND `thumb`='1' ");

                if((mysqli_num_rows($thumb_q)>0)){
                    $thumb_res =mysqli_fetch_assoc($thumb_q);
                    $room_thumb = ROOMS_IMG_PATH.$thumb_res['image'];

                }

                //to check the shutdown mode is turned on or not 
                $book_btn = "";
                if (!$settings_r['shutdown']) {
                    /*Here we are checking that user is loged in or not if user is not logged in 
                    it will throw an alert bar which shows that user need to login if he wants to book room */
                    $login = 0;
                    if(isset($_SESSION['login']) && $_SESSION['login']==true) {
                        $login = 1;
                    }
                    $book_btn = "<button onclick='checkLoginToBook($login,$room_data[id])'  class='btn btn-sm text-white custom-bg shadow-none'>Book Now </button>";
                }

                $rating_q = "SELECT AVG(rating) AS `avg_rating` FROM `rating_review` WHERE `room_id`='$room_data[id]' ORDER BY `sr_no` DESC LIMIT 20 "; 


                // $rating_res = select($rating_q,[$room_data['id']],'i');

                $ratting_res = mysqli_query($con,$rating_q);

                $rating_data = "";

                $rating_fetch = mysqli_fetch_assoc($ratting_res);

                if ($rating_fetch['avg_rating']!=NULL) {
                    $rating_data ="<div class='rating mb-4'>
                        <h6 class='mb-1'>Rating </h6>
                        <span class='badge rounded-pill bg-light '>";

                        for ($i=0; $i < $rating_fetch['avg_rating']; $i++) { 
                            $rating_data .= "<i class='bi bi-star-fill text-warning'></i> ";
                        }

                        $rating_data .= "</span></h6>
                        </div>";
                }   

                //print room card 
                echo<<<abc
                    <div class="col-lg-4 col-md-6 my-3">
                    <div class="card border-0 shadow" style="max-width: 350px; margin: auto;">
                        <img src="$room_thumb" class="card-img-top" >
                        <div class="card-body">
                            <h5>$room_data[name]</h5>
                            <h6 class="mb-4 ">₹$room_data[price] per nigth </h6>

                            <!-- Feauters -->
                            <div class="feauters mb-4 ">
                                <h6 class="mb-1">Feauters</h6>
                                $features_data
                            </div>

                            <!-- Facilities -->
                            <div class="Facilities mb-4 ">
                                <h6 class="mb-1">Facilities</h6>
                                $facilities_data
                            </div>

                            <!-- Guests -->
                            <div class="guest  mb-4 ">
                                <h6 class="mb-1">Guests</h6>
                                <span class="badge rounded-pill bg-light text-dark text-wrap ">
                                    $room_data[adult] Adults
                                </span> 
                                <span class="badge rounded-pill bg-light text-dark text-wrap ">
                                    $room_data[children] Children
                                </span> 
                            </div>
                            
                            <!-- Rating -->
                            $rating_data
                            <!-- Bokk now Button -->
                            <div class="d-flex justify-content-evenly mb-2 ">
                                $book_btn
                                <a href="room_details.php?id=$room_data[id]" class="btn btn-outline-dark shadow-none">More Details </a>

                            </div>
                        </div>
                    </div>
                </div>
                abc;

            }
        ?>

            <div class="col-lg-12 text-center mt-5 ">
                <a href="rooms.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">More Rooms<i class="bi bi-cart fs-5"></i></a>
            </div>
        </div>
    </div>

<!-- FACILITIES -->
    <h2 class="mt-5 pt-5 mb-4 text-center fw-bold h-font">OUR FACILITIES </h2>
    <div class="container">
        <div class="row justify-content-evenly px-lg-0 px-md-0 px-5">
            <?php 
            $res = mysqli_query($con,'SELECT * FROM `facilities` ORDER BY `id` DESC LIMIT 5 ');
            $path = FEATURES_IMG_PATH;

            while($row = mysqli_fetch_assoc($res)){
                echo<<<data

                <!-- WIFI -->
                <div class="col-lg-2 col-md-2 text-center bg-white rounded shadow py-4 my-3">
                    <img src="$path$row[icon]" width="80px" >
                    <h5 class="mt-3">
                        $row[name]
                    </h5>
                </div>
                data;
            }
        ?>
            
    <!-- More facilities buttoon -->
            <div class="col-12 text-center mt-5">
                <a href="facilities.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">MORE FACILITIES>>></a>
            </div>
        
        </div>
    </div>

<!-- Reviews -->
    <h2 class="mt-5 pt-5 mb-4 mt-5 text-center fw-bold h-font">TESTIMONIALS</h2>
    <div class="container mt-5">
        <div class="swiper swiper-testimonial">
            <div class="swiper-wrapper mb-5 ">

            
    <!-- user-1 -->
              <div class="swiper-slide bg-white1 p-4 mb-5">
                <div class="proofile d-flex align-items-center mb-3">
                    <img src="images/salman.jpg" width="40pxx">
                    <h6 class="m-0 ms-2">Salman Khan </h6>
                </div>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                 Sapiente autem dolorum rem, quod culpa explicabo et !</p>
                 <div class="rating">
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i> 
                 </div>
              </div>
    <!-- user-2 -->
              <div class="swiper-slide bg-white1 p-4 mb-5" >
                <div class="proofile d-flex align-items-center mb-3">
                    <img src="images/salman.jpg" width="40pxx">
                    <h6 class="m-0 ms-2">Salman Khan </h6>
                </div>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                 Sapiente autem dolorum rem, quod culpa explicabo et !</p>
                 <div class="rating">
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i> 
                 </div>
              </div>
    <!-- user-3 -->
              <div class="swiper-slide bg-white1 p-4 mb-5 ">
                <div class="proofile d-flex align-items-center mb-3">
                    <img src="images/salman.jpg" width="40pxx">
                    <h6 class="m-0 ms-2">Salman Khan </h6>
                </div>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                 Sapiente autem dolorum rem, quod culpa explicabo et !</p>
                 <div class="rating">
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i> 
                 </div>
              </div>
    <!-- user-4 -->
              <div class="swiper-slide bg-white1 p-4 mb-5">
                <div class="proofile d-flex align-items-center mb-3">
                    <img src="images/salman.jpg" width="40pxx">
                    <h6 class="m-0 ms-2">Salman Khan </h6>
                </div>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.
                 Sapiente autem dolorum rem, quod culpa explicabo et !</p>
                 <div class="rating">
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i>
                    <i class="bi bi-star-fill text-warning"></i> 
                 </div>
              </div>

            </div>
            <div class="swiper-pagination mt-5"></div>
          </div>
          <div class="col-12 text-center mt-5">
            <a href="about.php" class="btn btn-sm btn-outline-dark rounded-0 fw-bold shadow-none">KNOW MORE>>></a>
        </div>
    </div>

<!-- Reach us  -->

    <h2 class="mt-5 pt-5 mb-4 mt-5 text-center fw-bold h-font">REACH US </h2>
    <div class="container">
        <div class="row">
    <!-- Goggle Map  -->
            <div class="col-lg-8 col-md-8 p-4 mb-lg-0 mb-3 bg-white1 rounded ">
                <iframe height="380px " class="w-100 rounded" src="<?php echo $contact_r['iframe']?>"    loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
    <!-- CALL US -->
            <div class="col-lg-4 col-md-4 ">
                <div class="bg-white1  p-4 rounded mb-4 ">
                    <h5>CALL US </h5>
                    <a href="tel: +<?php echo $contact_r['pn1']?>" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i> +<?php echo $contact_r['pn1']?>
                    </a>
                    <br>
                    <?php 
                    if($contact_r['pn2']!=''){
                        echo<<<data
                            <a href="tel: +$contact_r[pn2]" class="d-inline-block mb-2 text-decoration-none text-dark">
                                <i class="bi bi-telephone-fill"></i> +$contact_r[pn2]
                            </a>
                        data;
                    }
                    ?>
                </div>
    <!-- FOLLOW  US -->
                <div class="bg-white1  p-4 rounded mb-4 ">
                    <h5>FOLLOW  US </h5>
                    <?php 
                    if($contact_r['tw']!=''){
                        echo<<<data
                        <a href="$contact_r[tw]" class="d-inline-block mb-3 text-decoration-none">
                            <span class="bagde bg-light text-dark fs-6 p-2 bg-white rounded  ">
                                <i class="bi bi-twitter me-1"></i> TWITTER 
                            </span>
                        </a>
                        data;
                    }
                    ?>
                    
                    <br>
                    <a href="<?php echo $contact_r['fb']?>" class="d-inline-block mb-3 text-decoration-none  bg-white rounded">
                        <span class="bagde bg-light text-dark fs-6 p-2 ">
                            <i class="bi bi-facebook me-1"></i> FACEBOOK 
                        </span>
                    </a>
                    <br>
                    <a href="<?php echo $contact_r['insta']?>" class="d-inline-block mb-3 text-decoration-none  bg-white rounded">
                        <span class="bagde bg-light text-dark fs-6 p-2 ">
                            <i class="bi bi-instagram me-1"></i> INSTAGRAM
                        </span>
                    </a>
                    <br>
                </div>
            </div>
        </div>
    </div>

     Recovery password Modal
    <div class="modal fade" id="recoverymodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="recovery-form" >
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center ">
                            <i class="bi bi-shield-lock fs-3 me-2 "></i>Set Up New Password
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <label class="form-label">New Password</label>
                            <input type="password" name="pass" required class="form-control">
                        </div>
                        <div class="mb-2 text-end">
                            <button type="button" class="btn shadow-none p-0"  data-bs-dismiss="modal"> Cancel </button>
                            <button type="submit" name="submit" class="btn btn btn-dark shadow-sm me-2">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> 




    <?php require('include/footer.php'); ?>

    
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
  <script>

    // carosuel swiper
    var swiper = new Swiper(".swiper-container", {
      spaceBetween: 30, 
      effect: "fade", //effect = fade 
      loop: true, //turned on loop 
      autoplay:{
        delay:3500, //delaying every photos by 3.5 seconds 
        disableOnInteraction: false,    //turned off disable on interaction it means we can change photos with ou mouse movment 
      }
    });

    //testimonial-swiper 
    var swiper = new Swiper(".swiper-testimonial", {
      effect: "coverflow", 
      grabCursor: true, //When we hover over the block cursor turn to grab_cursor 
      centeredSlides: true, 
      slidesPerView: "auto",
      slidesPerView: "3",  // we can see 3 slides at a time 
    //   loop : true,
      coverflowEffect: {
        rotate: 50,
        stretch: 0,
        depth: 100,
        modifier: 1,
        slideShadows: false, 
      },
      pagination: {
        el: ".swiper-pagination",
      },    
      breakpoint:{
        320:{
            slidesPerView : 1 ,
        },
        640:{
            slidesPerView : 1 ,
        },
        768:{
            slidesPerView : 2 ,
        },
        1024:{
            slidesPerView : 3,
        },
      }
    });

    let recovery_form = document.getElementById('recovery-form');
    recovery_form.addEventListener('submit',function(e){
        e.preventDefault();

        let data = new FormData();

        // data.append('email',recovery_form.elements['email'].value);
        // data.append('email',recovery_form.elements['email'].value);
        // // data.append('token',recovery_form.elements['token'].value);
        data.append('pass',recovery_form.elements['pass'].value);
        data.append('recovery_pass','');

        var myModal = document.getElementById('recoverymodal');
        var modal = bootstrap.Modal.getInstance(myModal) // Returns a Bootstrap modal instance
        modal.hide();

        let xhr = new XMLHttpRequest();
            xhr.open("POST","ajax/login_register.php",true);

            xhr.onload = function () {
                if (this.responseText=='failed') {
                    alert('error','Password Reset Failed');
                } else {
                    alert('success','Password Reset Succesfully');
                    recovery_form.reset();
                }

            } 
            xhr.send(data);
    })
  


  </script>



</body>
</html>