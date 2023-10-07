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
    <title><?php echo $settings_r['site_title'] ?> - BOOKINGS </title>
   

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
    if(!(isset($_SESSION['login']) && $_SESSION['login']==true)) {
        redirect('home.php');
    }
?>

<!-- filters -->
<div class="container">
    <div class="row">
        <!-- heading of Rooms -->
        <div class="col-12 my-5 px-4">
            <h2 class="fw-bold">Booking</h2>
            <div class="" style="font-size: 14px;">
                <a href="home.php" class="text-secondary text-decoration-none ">Home</a>
                <span class="text-secondary "> > </span>
                <a href="#" class="text-secondary text-decoration-none ">BOOKINGS</a>
            </div>
        </div>

        <?php 

            $query = "SELECT bo.*,bd.* FROM `booking_order` bo
            INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
            WHERE (( bo.booking_status = 'booked' ) 
            OR (bo.booking_status='cancelled' )
            OR (bo.booking_status='pending')) 
            AND (bo.user_id=?)
            ORDER BY bo.booking_id DESC";

            $result = select($query,[$_SESSION['uId']],'i');

            while($data = mysqli_fetch_assoc($result)){
                $date = date("d-m-Y",strtotime($data['datentime']));
                $checkin = date("d-m-Y",strtotime($data['check_in']));
                $checkout = date("d-m-Y",strtotime($data['check_out']));

                $status_bg = "";

                $btn ="";

                if ($data['booking_status']=='booked') {
                    $status_bg = 'bg-success';

                    if($data['arrival']==1){
                        $btn = "<a href='generate.php' class='btn mt-2 btn-dark btn-sm shadow-none' >Download Pdf </a>";
                        if ($data['rate_review']==0) {
                            $btn .= "
                            <button type='button' onclick='review_room($data[booking_id],$data[room_id])' class='btn btn-dark btn-sm ms-2 mt-2 shadow-none' data-bs-toggle='modal'
                            data-bs-target='#reviewmodal' >
                                Rate & Review
                            </button>";
                        }
                    } else {
                        $btn = "
                        <button type='button' onclick='cancel_booking($data[booking_id])' class='btn btn-danger btn-sm shadow-none' >
                            Cancel
                        </button>";
                    }
                }
                else if($data['booking_status']=='cancelled'){
                    $status_bg = 'bg-danger';
                    if ($data['refund']==0) {
                        $btn="
                        <span class='badge bg-primary'>
                            Refund in Process 
                        </span>";
                    } else {
                        $btn = "<a href='generate.php' class='btn mt-2 btn-dark btn-sm  shadow-none' >Download Pdf </a>";
                    }
                } 
                else {
                    $status_bg = 'bg-warning';
                    $btn = "<a href='generate.php' class='btn mt-2 btn-dark btn-sm  shadow-none' >Download Pdf </a>";

                }

                echo<<<book
                    <div class = "col-md-4 px-4 mb-4">
                        <div class= " bg-white p-3 rounded shadow-sm">
                            <h5 class="fw-bold"> $data[room_name]</h5>
                            <p>₹$data[price] </p>
                            <p>
                                <b>Check in : $checkin</b> <br>
                                <b>Check out : $checkout</b>
                            </p>
                            <p>
                                <b>Amount : </b> ₹$data[price] <br>
                                <b>Order Id : </b>$data[order_id] <br>
                                <b>Date : </b> $date 
                            </p>
                            <p> 
                                <span class = 'badge $status_bg'>
                                    $data[booking_status]
                                </span>
                            </p>
                            $btn
                        </div>
                    </div>
                book;
            }
        ?>

    </div>
</div>

<!-- Login modal -->
<div class="modal fade" id="reviewmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="review_form">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center ">
                        <i class="bi bi-chat-square-heart-fill fs-3 me-2 "></i>Rate & Review
                    </h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <select class="form-select shadow-none" name="rating" >
                            <option value="5">Excellent</option>
                            <option value="4">Good</option>
                            <option value="3">OK</option>
                            <option value="2">Poor</option>
                            <option value="1">Bad</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Review</label>
                        <textarea rows="3" name="review" class="form-control shadow-none" required></textarea>
                    </div>

                    <input type="hidden" name="booking_id">
                    <input type="hidden" name="room_id">
                    
                    <div class="text-end">
                        <button type="submit" class="btn btn btn-dark shadow-sm ">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<?php 
    if (isset($_GET['cancel_status'])) {
        alert('success','Booking Cancelled');
    } else  if (isset($_GET['review_status'])) {
        alert('success','Thank You For Rating & Review');
    }

?>

<!-- footer -->
<?php require('include/footer.php'); ?>

<script>

    function cancel_booking(id){
        if (confirm('Are you Sure to Cancel Booking ?')) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST","ajax/cancel_booking.php",true);
            xhr.setRequestHeader('Content-type' , 'application/x-www-form-urlencoded');

            xhr.onload = function () {
                    if (this.responseText==1) {
                        window.location.href="bookings.php?cancel_status=true";

                    } else {
                        alert('error','canacellation Failed');
                    }
                }

            xhr.send('cancel_booking&id='+id);
        }
    }

    let review_form = document.getElementById('review_form');



    function review_room(bid,rid){
        review_form.elements['booking_id'].value = bid;
        review_form.elements['room_id'].value = rid;


    }

    review_form.addEventListener('submit',function(e){
        e.preventDefault(); //This Function Stops the page from executing
        
    let data = new FormData(); 
    data.append('review_form','');
    data.append('rating',review_form.elements['rating'].value);
    data.append('review',review_form.elements['review'].value);
    data.append('booking_id',review_form.elements['booking_id'].value);
    data.append('room_id',review_form.elements['room_id'].value);
   

    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/review_room.php",true);
    

    xhr.onload = function () {


            if (this.responseText==1){
                window.location.href='bookings.php?review_status=true'
            } else {
                var myModal = document.getElementById('reviewmodal')
                var modal = bootstrap.Modal.getInstance(myModal) // Returns a Bootstrap modal instance
                modal.hide();
                
                alert('error','Rate & Review Failed');
            }
        }
    xhr.send(data);


    })


</script>
</body>
</html>

