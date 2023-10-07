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
    <title><?php echo $settings_r['site_title'] ?> - PROFILE </title>
   

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

    $u_exist = select("SELECT * FROM `user_cred` WHERE `id`=? LIMIT 1",[$_SESSION['uId']],'s');

    if (mysqli_num_rows($u_exist)==0) {
        redirect('home.php');
    }

    $u_fetch = mysqli_fetch_assoc($u_exist);


?>

<div class="container">
    <div class="row">
        <!-- heading of Rooms -->
        <div class="col-12 my-5 px-4">
            <h2 class="fw-bold">PROFILE</h2>
            <div class="" style="font-size: 14px;">
                <a href="home.php" class="text-secondary text-decoration-none ">Home</a>
                <span class="text-secondary "> > </span>
                <a href="#" class="text-secondary text-decoration-none ">PROFILE</a>
            </div>
        </div>

        <div class="col-12 mb-5 px-4">
            <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                <form id="info-form" >
                    <h5 class="mb-3 fw-bold ">Basic Information</h5>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Name</label>
                            <input  name="name" value="<?php echo $u_fetch['name']; ?>" type="text" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Phone No:</label>
                            <input  name="phonenum" value="<?php echo $u_fetch['phonenum']; ?>" type="number" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Date Of Birth </label>
                            <input name="dob" type="date" value="<?php echo $u_fetch['dob']; ?>" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Pin code </label>
                            <input name="pincode" type="number" value="<?php echo $u_fetch['pincode']; ?>" class="form-control" required>
                        </div>
                        <div class="col-md-8 mb-4">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control shadow-sm " rows="1" required><?php echo $u_fetch['address']; ?></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn fs-5 mt-4 btn custom-bg text-white shadow-sm " type="submit">Save Changes</button>
                </form>
            </div>    
        </div>

        <div class="col-md-4 mb-5 px-4">
            <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                <form id="profile-form">
                    <h5 class="mb-3 fw-bold ">Picture</h5>
                    <img src="<?php echo USERS_IMG_PATH.$u_fetch['profile'] ?>" class="rounded-circle img-fluid mb-3">
                   
                    <label class="form-label">New Photo</label>
                    <input name="profile" type="file" accept=".jpg,.jpeg,.png,.webp"  class="form-control mb-3" required >           
                   
                   
                    <button type="submit" class="btn fs-5 mt-4 btn custom-bg text-white shadow-sm " >Save Changes</button>
                </form>
            </div>    
        </div>

        <div class="col-md-8 mb-5 px-4">
            <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                <form id="pass-form">
                    <div class="row">
                        <h5 class="mb-3 fw-bold ">Change Password</h5>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">New Password</label>
                            <input  name="new_pass"  type="password" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input name="confirm_pass"  type="password" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" class="btn fs-5 mt-4 btn custom-bg text-white shadow-sm " >Save Changes</button>

                    
                    </form>
            </div>    
        </div>

    </div>
</div>


<?php 

?>

<!-- footer -->
<?php require('include/footer.php'); ?>

<script>



let info_form = document.getElementById('info-form');

info_form.addEventListener('submit',function(e){
    e.preventDefault();

    let data = new FormData(); 
    data.append('info_form','');
    data.append('name',info_form.elements['name'].value);
    data.append('phonenum',info_form.elements['phonenum'].value);
    data.append('address',info_form.elements['address'].value);
    data.append('pincode',info_form.elements['pincode'].value);
    data.append('dob',info_form.elements['dob'].value);

    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/profile.php",true);
    

    xhr.onload = function () {
            if (this.responseText=='phone_already') {
                alert('error','Phone is Already Registered');
            } else if (this.responseText==0){
                alert('error','No Changes Made');
            } else {
                alert('success','Changes Saved');

            }
        }
    xhr.send(data);
})
    
let profile_form = document.getElementById('profile-form');

profile_form.addEventListener('submit',function(e){
    e.preventDefault();

    let data = new FormData(); 
    data.append('profile_form','');
    data.append('profile',profile_form.elements['profile'].files[0]);
    
    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/profile.php",true);
    

    xhr.onload = function () {
            if (this.responseText=='inv_img') {
                alert('error','Only JPG , WEBP & PNG Images are Allowed');
            } else if (this.responseText=='upd_failed') {
                alert('error','Image Upload Failed');
            } else if (this.responseText==0){
                alert('error','Updation Failed');
            } else {
                window.location.href=window.location.pathname;
            }
        }
    xhr.send(data);
})
    
let pass_form = document.getElementById('pass-form');


pass_form.addEventListener('submit',function(e){
    e.preventDefault();

    let new_pass = pass_form.elements['new_pass'].value;
    let confirm_pass = pass_form.elements['confirm_pass'].value;

    if (new_pass != confirm_pass) {
        alert('error','Password Do not Match');
        return false;
    }


    let data = new FormData(); 
    data.append('pass_form','');
    data.append('new_pass',new_pass);
    data.append('confirm_pass',confirm_pass );
    
    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/profile.php",true);
    

    xhr.onload = function () {
            if (this.responseText=='mismatch') {
                alert('error','Password Do not match');
            } else if (this.responseText==0){
                alert('error','Updation Failed');
            } else {
                alert('success','Changes Saved');
                pass_form.reset(); 
            }
        }
    xhr.send(data);
})


</script>
</body>
</html>

