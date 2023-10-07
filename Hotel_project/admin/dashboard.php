<?php 
    require('inc/essentials.php');
    require('inc/db_config.php');

    admin_login();
   

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel-Dashboard</title>

    
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


<link href="https://fonts.googleapis.com/css2?family=Merienda:wght@400;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- bootstrap icons  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> 
    
    <!-- Swiper js CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>

    <!-- Adding our common css file  -->
    <link rel="stylesheet" href="css/common.css">

    
<?php require('inc/links.php'); ?>
</head>
<body class="bg-light">

    <?php 
    
        require('inc/header.php'); 
    
        $is_shutdown = mysqli_fetch_assoc(mysqli_query($con,"SELECT `shutdown` FROM `settings`"));

        $current_bookings = mysqli_fetch_assoc(mysqli_query($con,"SELECT 
        COUNT(CASE WHEN booking_status='booked' AND arrival=0 THEN 1 END)AS `new_bookings`,
        COUNT(CASE WHEN booking_status='cancelled' AND refund=0 THEN 1 END)AS `refund_booking` 
        FROM `booking_order`"));

        $unread_queries = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(sr_no) AS `count` 
        FROM `user_quries` WHERE `seen`=0"));

        $unread_reviews = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(sr_no) AS `count` 
        FROM `rating_review` WHERE `seen`=0"));

        $current_users = mysqli_fetch_assoc(mysqli_query($con,"SELECT 
                COUNT(id) AS `total`,
                COUNT(CASE WHEN `status`=1 THEN 1 END) AS `active`,
                COUNT(CASE WHEN `status`=0 THEN 1 END) AS `inactive`,
                COUNT(CASE WHEN `is_verified`=0  THEN 1 END) AS `unverified`
                FROM `user_cred`"));


    ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h3>Dashboard</h3>
                    <?php 
                        if ($is_shutdown['shutdown']) {
                            echo<<<data
                                <h6 class="badge bg-danger py-2 px-3 rounded ">Shutdown Mode is Activate !</h6>

                            data;
                        }
                    ?>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3 mb-4">
                        <a href="newbookings.php" class="text-decoration-none ">
                            <div class="card text-center text-success  p-3">
                                <h6>New Bookings</h6>
                                <h1 class="mt-2 mb-0"><?php echo $current_bookings['new_bookings'] ?></h1>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3 mb-4">
                        <a href="refund_bookings.php" class="text-decoration-none ">
                            <div class="card text-center text-warning  p-3">
                                <h6>Refund Bookings</h6>
                                <h1 class="mt-2 mb-0"><?php echo $current_bookings['refund_booking'] ?></h1>
                            </div>
                        </a>
                    </div>
                    
                    <div class="col-md-3 mb-4">
                        <a href="user_queries.php" class="text-decoration-none ">
                            <div class="card text-center text-info  p-3">
                                <h6>User Queries </h6>
                                <h1 class="mt-2 mb-0"><?php echo $unread_queries['count'] ?></h1>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-3 mb-4">
                        <a href="rate_review.php" class="text-decoration-none ">
                            <div class="card text-center text-info  p-3">
                                <h6>Rating & Reviews</h6>
                                <h1 class="mt-2 mb-0"><?php echo $unread_reviews['count'] ?></h1>
                            </div>
                        </a>
                    </div>
                    
                    
                </div>
<!-- 
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5>Booking Analytics</h5>
                    <select class="form-select shadow-none bg-light w-auto " >
                        <option value="1">Past 30</option>
                        <option value="2">Past 90</option>
                        <option value="3">Past 1 Year</option>
                        <option value="4">All Time </option>
                    </select>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-primary  p-3">
                            <h6>Total Bookings</h6>
                            <h1 class="mt-2 mb-0">5</h1>
                            <h4 class="mt-2 mb-0">₹0</h4>
                        </div>
                    </div>        
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-success  p-3">
                            <h6>Active Bookings</h6>
                            <h1 class="mt-2 mb-0">5</h1>
                            <h4 class="mt-2 mb-0">₹0</h4>
                        </div>
                    </div>        
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-success  p-3">
                            <h6>Cancelled Bookings</h6>
                            <h1 class="mt-2 mb-0">5</h1>
                            <h4 class="mt-2 mb-0">₹0</h4>
                        </div>
                    </div>        
                </div> -->

                <!-- <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5>User , Queries , Reviews Analytics</h5>
                    <select class="form-select shadow-none bg-light w-auto " >
                        <option value="1">Past 30</option>
                        <option value="2">Past 90</option>
                        <option value="3">Past 1 Year</option>
                        <option value="4">All Time </option>
                    </select>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-success  p-3">
                            <h6>New Registeration</h6>
                            <h1 class="mt-2 mb-0">5</h1>
                            
                        </div>
                    </div>        
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-primary  p-3">
                            <h6>Queries</h6>
                            <h1 class="mt-2 mb-0">5</h1>
                            
                        </div>
                    </div>        
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-primary  p-3">
                            <h6>Reviews</h6>
                            <h1 class="mt-2 mb-0">5</h1>
                            
                        </div>
                    </div>        
                </div> -->

                <h5>Users</h5>
                <div class="row mb-3">
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-info  p-3">
                            <h6>Total Users</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['total'] ?></h1>
                            
                        </div>
                    </div>        
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-success  p-3">
                            <h6>Active Users</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['active'] ?></h1>
                            
                        </div>
                    </div>        
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-warning  p-3">
                            <h6>InActive User</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['inactive'] ?></h1>
                            
                        </div>
                    </div>        
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-danger  p-3">
                            <h6>Unverified User</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['unverified'] ?></h1>
                        </div>
                    </div>        
                </div>

            </div>
        </div>
    </div>
    

    <?php require('inc/scripts.php'); ?>
</body>
</html>