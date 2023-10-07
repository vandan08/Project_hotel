<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


<link href="https://fonts.googleapis.com/css2?family=Merienda:wght@400;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- bootstrap icons  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> 
    
    <!-- Swiper js CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>

    <!-- Adding our common css file  -->
    <link rel="stylesheet" href="css/common.css">

    

    <!-- Adding links -->
    <?php require('include/links.php'); ?>
    <title><?php echo $settings_r['site_title'] ?> - rooms   </title>
   
    <!-- Adding css -->
    <style>
        .pop:hover{
             border-top-color: var(--teal)  !important; /*as we can not overwrite inbuilt functioin of bootstrap so mark as !important so it will execute  */
             transform: scale(1.03); /* it will transfrom the contenet in 1.03 multiplier when we hover it   */
             transition: all 0.3s; /* it will tanslate all the content after 0.3s  */
        }
        
    </style>
</head>
<body>
<!-- header -->
<?php 
    require('include/header.php'); 
    
    $checkin_default = "";
    $checkout_default = "";
    $adult_default = "";
    $children_default = "";

    if (isset($_GET['check_availinility'])) {
        $frm_data = filteration($_GET);
        $checkin_default = $frm_data['checkin'];
        $checkout_default = $frm_data['checkout'];
        $adult_default = $frm_data['adult'];
        $children_default = $frm_data['children'];
    }
?>

<!-- heading of Rooms -->
<div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">OUR ROOMS </h2>
    <div class="h-line bg-dark"></div>
</div>


<!-- Rooms -->
<div class="container-fluid">
    <div class="row">

    <!-- Filters-box-->
        <div class="col-lg-3 col-md-12 mb-4 mb-lg-0 px-0 ps-4">
            <nav class="navbar navbar-expand-lg navbar-light bg-white1 rounded shadow">
                <div class="container-fluid flex-lg-column align-items-stretch">
                  <h4 class="mt-2 ">FILTERS</h4>
                  <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#filterDropDown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse flex-column mt-3 align-items-stretch " id="filterDropDown">
                <!-- check availibility -->
                    <div class="border bg-light p-3 rounded mb-3 ">
                        <h5 class="d-flex align-iteam-center justify-content-between mb-3" style="font-size: 18px;">
                            <span>CHECK AVAILIBILITY</span>
                            <button id="chk_avail_btn" onclick="chk_avail_clear()" class="btn btn-sm text-secondary shadow-none d-none">Reset</button>
                            <span></span>
                        </h5>
                        <label class="form-label">Check-in</label>
                        <input type="date" class="form-control shadow-none mb-3" value="<?php echo $checkin_default ?>" id="checkin" onchange="chk_avail_filter()">
                        <label class="form-label">Check-out</label>
                        <input type="date" class="form-control" value="<?php echo $checkout_default ?>" id="checkout" onchange="chk_avail_filter()">
                    </div>
                <!-- Facilities -->
                    <div class="border bg-light p-3 rounded mb-3 ">
                        <h5 class="d-flex align-iteam-center justify-content-between mb-3" style="font-size: 18px;">
                            <span>Facilities</span>
                            <button id="facilities_btn" onclick="facilities_clear()" class="btn btn-sm text-secondary shadow-none d-none">Reset</button>
                        </h5>
                        <?php

                            $facilities_q = selectAll('facilities');
                            while ($row=mysqli_fetch_assoc($facilities_q)) {
                                echo<<<fac
                                <div class="mb-2">
                                    <input type="checkbox" onclick="fetch_rooms()" id="$row[id]" name="facilities" value="$row[id]" class="form-check-input shadow-none me-1">
                                    <label class="form-label" for="$row[id]">$row[name]</label>    
                                </div>

                                fac;
                            }
                        ?>
                    </div>

                <!-- Guest  -->
                     <div class="border bg-light p-3 rounded mb-3 ">
                        <h5 class="d-flex align-iteam-center justify-content-between mb-3" style="font-size: 18px;">
                            <span>Guests</span>
                            <button id="guests_btn" onclick="guests_clear()" class="btn btn-sm text-secondary shadow-none d-none">Reset</button>
                            <span></span>
                        </h5>
                        <div class="d-flex">
                            <div class="me-3">
                                <label class="form-label">Adults</label>
                                <input type="number" min="1" id="adults" value="<?php echo $adult_default ?>" oninput="guests_filter()" class="form-control shadow-none ">
                            </div>
                            <div class="">
                                <label class="form-label">Children</label>
                                <input type="number" min="1" value="<?php echo $children_default ?>" id="children" oninput="guests_filter()" class="form-control shadow-none ">
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
              </nav>
        </div>

        <div class="col-lg-9 col-md-12 px-4" id="rooms-data">            
        
        </div>
    </div>
</div>

<script>

    let rooms_data = document.getElementById('rooms-data');
    let checkin = document.getElementById('checkin');
    let checkout = document.getElementById('checkout');
    let chk_avail_btn =document.getElementById('chk_avail_btn');

    let adults = document.getElementById('adults');
    let children = document.getElementById('children');
    let guests_btn = document.getElementById('guests_btn');

    let facilities_btn = document.getElementById('facilities_btn');

    

    function fetch_rooms(){

        let chk_avail =JSON.stringify({
            checkin: checkin.value,
            checkout: checkout.value
        })

        let guests =JSON.stringify({
            adults:adults.value,
            children:children.value
        })

        let facility_list = {"facilities":[]};
        let get_facilities =document.querySelectorAll('[name="facilities"]:checked');
        if (get_facilities.length>0) {
            get_facilities.forEach((facility)=>{
            facility_list.facilities.push(facility.value);
        })
        facilities_btn.classList.remove('d-none');
    } else {
        facilities_btn.classList.add('d-none');
    }

    facility_list =JSON.stringify(facility_list);


        let xhr = new XMLHttpRequest();
        xhr.open("GET","ajax/rooms.php?fetch_rooms&chk_avail="+chk_avail+"&guests="+guests+"&facility_list="+facility_list,true);

        xhr.onprogress = function(){
            rooms_data.innerHTML = `<div class="spinner-border text-info mb-3 mx-auto d-block" id="loader" role="status">
            <span class="visually-hidden">Loading...</span>
            </div>`;

        }

        xhr.onload = function(){
            rooms_data.innerHTML = this.responseText;
        }

        xhr.send();
}

function chk_avail_filter(){
    if (checkin.value!='' && checkout.value !='') {
        fetch_rooms();
        chk_avail_btn.classList.remove('d-none');
    }
}


function chk_avail_clear(){
    checkin.value='';
    checkout.value =''
    chk_avail_btn.classList.add('d-none');
    fetch_rooms();
    }

    function guests_filter(){
        if (adults.value>0 || children.value>0) {
            fetch_rooms();
            guests_btn.classList.remove('d-none');
        }
    }

    function guests_clear(){
        adults.value='';
        children.value='';
        guests_btn.classList.add('d-none');
        fetch_rooms();
    }
    
    function facilities_clear(){
        let get_facilities =document.querySelectorAll('[name="facilities"]:checked');
            get_facilities.forEach((facility)=>{
            facility.checked=false; 
        });
            facilities_btn.classList.add('d-none');
            fetch_rooms();
    }


window.onload =function(){
    fetch_rooms();
}

</script>

<!-- footer -->
<?php require('include/footer.php'); ?>

</body>
</html>