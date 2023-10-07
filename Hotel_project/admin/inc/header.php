<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<link href="https://fonts.googleapis.com/css2?family=Merienda:wght@400;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- bootstrap icons  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> 
    
    <!-- Swiper js CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>

    <!-- Adding our common css file  -->
    <link rel="stylesheet" href="css/common.css">

<div class="container-fluid bg-dark text-light p-3 d-flex align-items-center justify-content-between sticky-top">   
    <h3 class="mb-0 h-font">Hotel Hub</h3>
    <a class="btn btn-light btn-sm" href="logout.php">LOG OUT</a>
</div>

<!-- Slider-bar-->
<div class="col-lg-2 bg-dark border-top border-3 border-secondary" id="dashboard-menu">
    <nav class="navbar navbar-expand-lg navbar-dark ">
        <div class="container-fluid flex-lg-column align-items-stretch">
            <h4 class="mt-2 text-light ">Admin panel </h4>
            <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#adminDropDown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse flex-column mt-3 align-items-stretch " id="adminDropDown">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="dashboard.php">Dashboard </a>
                    </li>
                    <li class="nav-item">
                    <button class="btn text-white px-3 w-100 shadow-none text-start d-flex align-items-center justify-content-between" type="button" data-bs-toggle="collapse" data-bs-target="#bookinglinks">
                        <span> Bookings </span>
                        <span><i class="bi bi-caret-down-fill"></i></span>
                    </button>
                    <div class="collapse show px-3 small mb-1" id="bookinglinks">
                        <ul class="nav nav-pills flex-column rounded border border-secondary ">
                            <li class="nav-item">
                              <a class="nav-link text-white" href="newbookings.php">New Bookings </a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link text-white" href="refund_bookings.php">Refund Bookings</a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link text-white" href="booking_record.php">Booking Records</a>
                            </li>
                          </ul> 
                      </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="users.php">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="user_queries.php">User Queries</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="rate_review.php">Ratings & Reviews </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="rooms.php">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="feauters_facilities.php">Feauters & Facilities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="carousel.php">Carousel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="settings.php">Settings</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>