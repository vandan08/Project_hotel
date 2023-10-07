<!-- NAVBAR --> 
<nav id="nav-bar" class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand me-5 fw-bold fs-3 h-font " href="home.php"><?php echo $settings_r['site_title'] ?></a>
        <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item me-2">
                    <a class="nav-link me-2"  href="home.php">Home</a>
                </li>
                <li class="nav-item me-2">
                    <a class="nav-link" href="rooms.php">Rooms</a>
                </li>

                <li class="nav-item me-2">
                    <a class="nav-link" href="facilities.php">Facilities</a>
                </li>

                <li class="nav-item me-2">
                    <a class="nav-link" href="contact.php">Contact us </a>
                </li>

                <li class="nav-item me-2">
                    <a class="nav-link" href="about.php">About </a>
                </li>
            </ul>
            <div class="d-flex">
                <?php 
                  if(isset($_SESSION['login']) && $_SESSION['login']==true) {
                    $path = USERS_IMG_PATH;
                    echo<<<nav
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-dark shadow-none dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                            <img src="$path$_SESSION[uPic]" style ="width: 25px; heigth: 25px;" class="me-1 rounded-circle">
                            $_SESSION[uName]
                        </button>
                        <ul class="dropdown-menu dropdown-menu-lg-end">
                            <li><a class="dropdown-item" href="profile.php" >Profile</a></li>
                            <li><a class="dropdown-item" href="bookings.php" >Bookings</a></li>
                            <li><a class="dropdown-item" href="logout.php" >Logout</a></li>
                            </ul>
                    </div>
                    nav;
                  }  
                  else {
                    echo<<<nav
                    <button type="button" class="btn btn-outline-dark shadow-none me-lg-2 me-2" data-bs-toggle="modal"
                        data-bs-target="#loginmodal">
                        LOGIN
                    </button>
                    <!-- Register Button  -->
                    <button type="button" class="btn btn-outline-dark shadow-none " data-bs-toggle="modal"
                        data-bs-target="#registermodal">
                        Register
                    </button>
                    nav;
                  }
                ?>
                
            </div>
        </div>
    </div>
</nav>

<!-- Login modal -->
<div class="modal fade" id="loginmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="login_form">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center ">
                        <i class="bi bi-person-circle fs-3 me-2 "></i>User Login
                    </h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Email / Mobile </label>
                        <input type="text" name="email_mob" required class="form-control">
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input type="password" name="pass" class="form-control" required>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-2 ">
                        <button type="submit" class="btn btn btn-dark shadow-sm ">Login</button>
                        <button type="button" class="btn text-secondary text-decoration-none shadow-none p-0" data-bs-toggle="modal"
                        data-bs-target="#forgotmodal" data-bs-dismiss="modal">
                            Forgot password?
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Register modal -->
<div class="modal fade" id="registermodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="register-form">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center ">
                        <i class="bi bi-person-add fs-3 me-2 "></i>User Registration
                    </h5>
                    <button type="reset" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span class="badge bg-light text-dark mb-3 text-wrap lh-base">
                        Note: Your Details must match with you ID (Adhar card, passport , Driving liecense , etc.. )
                        That will be required during check in..
                    </span>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6  mb-3">
                                <label class="form-label">Full Name </label>
                                <input  name="name" type="text" class="form-control" required>
                            </div>
                            <div class="col-md-6  mb-3">
                                <label class="form-label">Email Address </label>
                                <input name="email" type="email" class="form-control" required>
                            </div>
                            <div class="col-md-6  mb-3">
                                <label class="form-label">Phone Number </label>
                                <input name="phonenum" type="number"  class="form-control" required>
                            </div>
                            <div class="col-md-6  mb-3">
                                <label class="form-label">Passport size Photo</label>
                                <input name="profile" type="file" accept=".jpg,.jpeg,.png,.webp"  class="form-control" required >
                            </div>
                            <div class="col-md-12  mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control shadow-sm "  rows="1" required></textarea>
                            </div>
                            <div class="col-md-6  mb-3">
                                <label class="form-label">Pin code </label>
                                <input name="pincode" type="number" class="form-control" required>
                            </div>
                            <div class="col-md-6  mb-3">
                                <label class="form-label">Date Of Birth </label>
                                <input name="dob" type="date" class="form-control" required>
                            </div>
                            <div class="col-md-6  mb-3">
                                <label class="form-label">Password</label>
                                <input name="pass" type="password" class="form-control" required>
                            </div>
                            <div class="col-md-6  mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input name="cpass" type="password" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="text-center my-1">
                        <button type="submit" class="btn fs-5 mt-4 btn btn-dark shadow-sm "
                            type="submit">Register</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Forgot modal -->
<div class="modal fade" id="forgotmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="forgot-form" action="../ajax/forgot_pass.php" method="post">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center ">
                        <i class="bi bi-person-circle fs-3 me-2 "></i>Forgot Password
                    </h5>
                </div>
                <div class="modal-body">
                    <span class="badge bg-light text-dark mb-3 text-wrap lh-base">
                            Note: A Link Will be sent to your E-mail to reset your password
                    </span>
                    <div class="mb-4">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" required class="form-control">
                    </div>
                    <div class="mb-2 text-end">
                        <button type="submit" name="submit" class="btn btn btn-dark shadow-sm me-2" id="recover_pass"  data-bs-toggle="modal"
                          
                        >Send Link</button>
                        <button type="button" class="btn shadow-none p-0" data-bs-toggle="modal"
                        data-bs-target="#loginmodal" data-bs-dismiss="modal">
                            Cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Recovery password Modal
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
    </div> -->

