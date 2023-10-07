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
    <title><?php echo $settings_r['site_title'] ?> - Contact   </title>
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

<!-- heading of facilities -->
<div class="my-5 px-4">
    <h2 class="fw-bold h-font text-center">OUR FACILITIES </h2>
    <div class="h-line bg-dark"></div>
    <p class="text-center mt-3">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sit vel 
        animi aspernatur similique, <br>recusandae consectetur adipisci 
        omnis labore odit numquam.</p>
</div>

<!-- Contact -->
<div class="container">
    <div class="row">
    <!-- Map & contact -->
        <div class="col-lg-6 col-md-6 mb-5 px-4 ">
            <div class="bg-white1 rounded shadow p-4  ">
                <!-- Map & Address -->
                <iframe class="w-100 rounded mb-4" height="320px" src="<?php echo $contact_r['iframe']?>" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                <h5>Address </h5>
                <a href="<?php echo $contact_r['gmap']?>" target="_blank" class="d-inline-block text-decoration-none text-dark  mb-2">
                    <i class="bi bi-geo-alt-fill"></i><?php echo $contact_r['address']?>
                </a>
                <!-- Call US -->
                <h5 class="mt-4">CALL US </h5>
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
                    <h5 class="mt-4"> Email</h5>
                    <a href="mailto: <?php echo $contact_r['email']?>" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-envelope-at-fill"></i> <?php echo $contact_r['email']?> 
                    </a>

                    <!-- FOLLOW US -->
                    <h5 class="mt-4">FOLLOW  US </h5>
                    <?php 
                    if($contact_r['tw']!=''){
                        echo<<<data
                        <a href="$contact_r[tw]" class="d-inline-block text-decoration-none text-dark fs-5 me-2">
                            <i class="bi bi-twitter me-1"></i> 
                        </a>
                        data;
                    }
                    ?>
                    <a href="<?php echo $contact_r['fb']?>" class="d-inline-block text-decoration-none text-dark fs-5 me-2">
                        <i class="bi bi-facebook me-1"></i> 
                    </a>
                    <a href="<?php echo $contact_r['insta']?>" class="d-inline-block  text-decoration-none text-dark fs-5 ">
                            <i class="bi bi-instagram me-1"></i> 
                    </a>
                    
            </div>
        </div>

<!-- Message Form -->
        <div class="col-lg-6 col-md-6 px-4 ">
            <div class="bg-white1 rounded shadow p-4">
                <form action="" method="post" >
                    <h5>Send Us A Message </h5>
                    <div class="mt-3">
                        <label class="form-label" style="font-weight: 500;" >Name</label>
                        <input name="name" type="text " class="form-control" required>
                    </div>    
                    <div class="mt-3">
                      <label class="form-label" style="font-weight: 500;" >Email</label>
                      <input name="email" type="email " class="form-control" required>
                    </div>   
                    <div class="mt-3">
                      <label class="form-label" style="font-weight: 500;" >Subject</label>
                      <input name="subject" required type="text " class="form-control">
                    </div>   
                    <div class="mt-3">
                      <label class="form-label" style="font-weight: 500;" >Message </label>
                      <textarea name="message" required class="form-control shadow-sm " rows="5" style="resize: none;" ></textarea>
                    </div>   
                    <button type="submit" name="send" class="btn text-white custom-bg mt-3" >Send</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php 
    if (isset($_POST['send'])) {
        $frm_data = filteration($_POST);
        $q = "INSERT INTO `user_quries`(`name`, `email`, `subject`, `message`) VALUES (?,?,?,?)";
        $values = [$frm_data['name'],$frm_data['email'],$frm_data['subject'],$frm_data['message']];
        $res = insert($q,$values,'ssss');
        if($res==1){
            alert('success','Message Sent');
        }
        else{
            alert('error','Server Down , Try again Letter');
        }
    }


?>


<!-- footer -->
<?php require('include/footer.php'); ?>


<script>
setTimeout(function(){
    document.getElementById('aap').className = 'waa';
}, 5000);
</script>
</body>
</html>