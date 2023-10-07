<?php 

    require('admin/inc/db_config.php');
    require('admin/inc/essentials.php');
    require('admin/inc/scripts.php');

    date_default_timezone_set("Asia/Kolkata");

    session_start();

    if(!(isset($_SESSION['login']) && $_SESSION['login']==true)) {
        redirect('home.php');
    }

    if (isset($_POST['pay_now'])){
        $frm_data = filteration($_POST);

        $query1 = "INSERT INTO `booking_order`(`user_id`, `room_id`, `check_in`, `check_out`,`order_id`) 
        VALUES (?,?,?,?,?)";

        insert($query1,[$_SESSION['uId'],$_SESSION['room']['id'],$frm_data['checkin'],$frm_data['checkout'],random_int(100,1000)],'issss');

       $booking_id = mysqli_insert_id($con);

       $query2 = "INSERT INTO `booking_details`(`booking_id`, `room_name`, `price`, `total`, `user_name`, `phonenum`) VALUES (?,?,?,?,?,?)";

       insert($query2,[$booking_id,$_SESSION['room']['name'],$_SESSION['room']['price'],$_SESSION['room']['payment'],$frm_data['name'],$frm_data['phonenum']],'isssss');
    }

?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<!-- This script got from frontendfreecode.com -->

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


<link href="https://fonts.googleapis.com/css2?family=Merienda:wght@400;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- bootstrap icons  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> 
    
    <!-- Swiper js CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>

    <!-- Adding our common css file  -->
    <link rel="stylesheet" href="css/common.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>


<style>
body {
    background: #f5f5f5;
    margin: 20px;
}
.rounded {
    border-radius: 1rem;
}
.nav-pills .nav-link {
    color: #555;
}
.nav-pills .nav-link.active {
    color: white;
}
input[type="radio"] {
    margin-right: 5px;
}
.bold {
    font-weight: bold;
}
.bg-not{
    background-color: rgba(255, 4, 0, 0.477);
}
</style>

</head>
<body>
<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2">
                    <!-- Credit card form tabs -->
                    <ul role="tablist" class="nav bg-light nav-pills rounded nav-fill mb-3">
                        <li class="nav-item m-2 shadow-sm rounded ">
                            <a data-toggle="pill" href="#credit-card" class="nav-link active"> <i class="fas fa-credit-card mr-2"></i> Credit Card </a>
                        </li>
                        <li class="nav-item m-2 shadow-sm rounded  ">
                            <a data-toggle="pill" href="#cod" class="nav-link"> <i class="bi bi-cash-stack m-2  "></i>COD</a>
                        </li>
                        <li class="nav-item m-2 shadow-sm rounded ">
                            <a data-toggle="pill" href="#net-banking" class="nav-link"> <i class="fas fa-mobile-alt mr-2"></i> Net Banking </a>
                        </li>
                    </ul>
                </div>
                <!-- End -->
                <!-- Credit card form content -->
                <div class="tab-content">
                    <!-- credit card info-->
                    <div id="credit-card" class="tab-pane fade show active pt-3">
                        <form role="form">
                            <div class="form-group">
                                <p class="m-2 text-dark bg-not font-weight-bold" > <i class="m-2 bi-exclamation-triangle"></i>Currently This service is Not Available you can try other methods Also </p>
                                <label for="username">
                                    <h6>Card Owner</h6>
                                </label>
                                <input type="text" name="username" placeholder="Card Owner Name" required class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="cardNumber">
                                    <h6>Card number</h6>
                                </label>
                                <div class="input-group">
                                    <input type="text" name="cardNumber" placeholder="Ex : 1234 5678 1123" class="form-control" required />
                                    <div class="input-group-append">
                                        <span class="input-group-text text-muted"> <i class="fab fa-cc-visa mx-1"></i> <i class="fab fa-cc-mastercard mx-1"></i> <i class="fab fa-cc-amex mx-1"></i> </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label>
                                            <span class="hidden-xs">
                                                <h6>Expiration Date</h6>
                                            </span>
                                        </label>
                                        <div class="input-group"><input type="number" placeholder="08" name="" class="form-control" required /> <input type="number" placeholder="2024" name="" class="form-control" required /></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group mb-4">
                                        <label data-toggle="tooltip" title="Three digit CV code on the back of your card">
                                            <h6>CVV <i class="fa fa-question-circle d-inline"></i></h6>
                                        </label>
                                        <input type="text" placeholder="***" required class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="subscribe btn btn-primary btn-block shadow-sm" disabled>Confirm Payment</button></div>
                        </form>
                    </div>
                    <!-- End -->
                    <!-- Cod info -->
                    <div id="cod" class="tab-pane fade pt-3">
                        <h6 class="pb-2">CASH ON DESK </h6>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <input class="form-control" type="text" placeholder="Name"> </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="input-group"> <input class="form-control" type="number" placeholder="Mobile"> </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="input-group"> <input class="form-control" type="email" placeholder="Email ID"> </div>
                                    <p class="fw-bold" style="font-size: 12px;">Note:Booking Invoice Will send to Your E-mail </p>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="subscribe btn btn-primary btn-block rounded-1 shadow-sm" id="confirm_pay" name="confirm_book">
                            Confirm Booking 
                        </button>
                        <p class="text-muted m-2">
                            Note: After clicking on this Book button , Our Managment team will reach out you soon. By proceeding this method You have to pay Amount of Booking + GST * as per Our plicy . 
                        </p>
                    </form>
                    </div>
                
                    <!-- End -->
                    <!-- bank transfer info -->
                    <div id="net-banking" class="tab-pane fade pt-3">
                        <p class="m-2 text-dark bg-not font-weight-bold" > <i class="m-2 bi-exclamation-triangle"></i>Currently This service is Not Available you can try other methods Also </p>
                        <div class="form-group">
                            <label for="Select Your Bank">
                                <h6>Select your Bank</h6>
                            </label>
                            <select class="form-control" id="ccmonth">
                                <option value="" selected disabled>--Please select your Bank--</option>
                                <option>SBI</option>
                                <option>IDBI</option>
                                <option>AXIS</option>
                                <option>CBI</option>
                                <option>BOB</option>
                                <option>HDFC</option>
                                <option>KOTAK</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <p>
                            <!-- <?php 
                            $room_res = select("SELECT * FROM `rooms` WHERE `id`=? AND `status`=? AND `removed`=?",[$data['id'],1,0],'iii');
                            $room_data = mysqli_fetch_assoc($room_res);

                                echo<<<data
                                <button type='button' name='payment' class='btn btn-primary'><i class='fas fa-mobile-alt mr-2'></i> $room_data[price] Proceed Payment</button>

                                data;
                            
                            ?> -->
                            
                                <button type="button" name="payment" class="btn btn-primary"><i class="fas fa-mobile-alt mr-2"></i>  Proceed Payment</button>
                            </p>
                        </div>
                        <p class="text-muted">
                            Note: After clicking on the button, you will be directed to a secure gateway for payment. After completing the payment process, you will be redirected back to the website to view details of your order.
                        </p>
                    </div>
                    <!-- End -->
                    <!-- End -->
                </div>
            </div>
        </div>
    </div>
</div>
<?php 

if (isset($_POST['confirm_book'])) {
    alert('success','Confirmed Booking');
    redirect('home.php');
}
?>

<script>
$(function () {
    $('[data-toggle="tooltip"]').tooltip();
});

let confirm_pay = document.getElementById('confirm_pay');




</script>

</body>
</html>



