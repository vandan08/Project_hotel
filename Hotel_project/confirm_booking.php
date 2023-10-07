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
    <title><?php echo $settings_r['site_title'] ?> - Confirm Booking </title>
   

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
<?php require('include/header.php'); ?>

<?php 

        /*
            Check room id from url is present or not 
            shutdown mode is active or not 
            user is logged in or not     
        */
        if (!isset($_GET['id']) || $settings_r['shutdown']==true) {
            redirect('rooms.php');
        } 
        else if(!(isset($_SESSION['login']) && $_SESSION['login']==true)) {
            redirect('rooms.php');
        }

        //filter and get uses and room data

        $data = filteration($_GET);
        $room_res = select("SELECT * FROM `rooms` WHERE `id`=? AND `status`=? AND `removed`=?",[$data['id'],1,0],'iii');

        if (mysqli_num_rows($room_res)==0) {
            redirect('rooms.php');
        }
    
        $room_data = mysqli_fetch_assoc($room_res);

        $_SESSION['room'] = [
            "id" => $room_data['id'],
            "name" => $room_data['name'],
            "price" => $room_data['price'],
            "payment" => null,
            "availabe" =>false,
        ];

        $user_res = select('SELECT * FROM `user_cred` WHERE `id`=?  LIMIT 1',[$_SESSION['uId']],'i');
        $user_data = mysqli_fetch_assoc($user_res);

        

        
    ?>



<!-- filters -->
<div class="container">
    <div class="row">

        <!-- heading of Rooms -->
        <div class="col-12 my-5 mb-4 px-4">
            <h2 class="fw-bold">Confirm Booking</h2>
            <div class="" style="font-size: 14px;">
                <a href="home.php" class="text-secondary text-decoration-none ">Home</a>
                <span class="text-secondary "> > </span>
                <a href="rooms.php" class="text-secondary text-decoration-none ">Rooms</a>
                <span class="text-secondary "> > </span>
                <a href="#" class="text-secondary text-decoration-none ">Confirm</a>
            </div>
        </div>

        <div class="col-lg-7 col-md-12 px-4 ">
           <?php 
             $room_thumg = ROOMS_IMG_PATH."thumbnail.jpg";
             $thumb_q = mysqli_query($con,"SELECT * FROM `room_image` 
                         WHERE `room_id`='$room_data[id]' 
                         AND `thumb`='1' ");

             if((mysqli_num_rows($thumb_q)>0)){
                 $thumb_res =mysqli_fetch_assoc($thumb_q);
                 $room_thumb = ROOMS_IMG_PATH.$thumb_res['image'];
             }

             echo<<<data
                <div class="card p-3 shadow-sm rounded ">
                    <img src="$room_thumb" class="img-fluid rounded mb-3" >
                    <h5>$room_data[name]</h5>
                    <h6>₹$room_data[price] per nigth</h6>
                </div>
             data;
           
           ?>
        </div>

        <div class="col-lg-5 col-md-12 px-4 ">
            <div class="card mb-4 border-0 shadow-sm rounded-3 ">
                <div class="card-body">
                    <form action="pay_now.php" method="POST" id="booking_form">
                        <h6>Booking Details</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label ">Name </label>
                                <input  name="name" type="text" value="<?php echo $user_data['name'] ?>" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label ">Phone Number </label>
                                <input  name="phonenum" type="number" value="<?php echo $user_data['phonenum'] ?>" class="form-control" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control shadow-sm "  rows="1" required><?php echo $user_data['address'] ?></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label ">check - in</label>
                                <input  name="checkin" onchange="check_availibility()" type="date" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label ">check - out</label>
                                <input  name="checkout" onchange="check_availibility()" type="date" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <div class="spinner-border text-info mb-3 d-none" id="info_loader" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>

                                <h6 class="mb-3 text-danger"id="pay_info">Provide Check-in & Check-out Date!</h6>
                                <button name="pay_now" class="btn w-100 text-white custom-bg shadow-none mb-1" disabled>Pay Now</button>
                            </div>
                        </div>  
                    </form>
                </div>    
            </div>
        </div>
    </div>
</div>

<!-- footer -->
<?php require('include/footer.php'); ?>
<script>
    let booking_form = document.getElementById('booking_form');
    let info_loader = document.getElementById('info_loader');
    let pay_info = document.getElementById('pay_info');

    function check_availibility(){
        let checkin_val = booking_form.elements['checkin'].value;
        let checkout_val = booking_form.elements['checkout'].value;

        booking_form.elements['pay_now'].setAttribute('disabled',true);

        if (checkin_val!='' && checkout_val!='') {
            pay_info.classList.add('d-none');
            pay_info.classList.replace('text-dark','text-danger');
            info_loader.classList.remove('d-none');


            let data =new FormData();

            data.append('check_availibility','');
            data.append('check_in',checkin_val);
            data.append('check_out',checkout_val);

            let xhr = new XMLHttpRequest();
            xhr.open("POST","ajax/confirm_booking.php",true);

            xhr.onload = function () {
               let data = JSON.parse(this.responseText);
               if (data.status == 'check_in_out_equal' ) {
                    pay_info.innerText = "You cannot check-out on same day";
               } else if (data.status == 'check_out_earlier' ) {
                    pay_info.innerText = "check-out date is earlier than check-in Date! ";
               } else if (data.status == 'check_in_earlier' ) {
                    pay_info.innerText = "check-in date is earlier than Cureent Date! ";
               } else if (data.status == 'unavailabe') {
                    pay_info.innerText = "Room Not Available for this check-in Date!";
               } else {
                    pay_info.innerHTML = "No. Of Days: "+data.days+"<br>Total Amount to Pay: ₹"+data.payment;
                    pay_info.classList.replace('text-danger','text-dark');
                    booking_form.elements['pay_now'].removeAttribute('disabled');

               }
                  
                pay_info.classList.remove('d-none');
                info_loader.classList.add('d-none');

            } 
            xhr.send(data);
        }

    }

</script>

</body>
</html>

