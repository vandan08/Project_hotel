<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Adding links -->
    <?php require('include/links.php'); ?>
    <title><?php echo $settings_r['site_title'] ?> - Facilities  </title>
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


<!-- FACILITIES -->
<div class="container">
    <div class="row">
        <?php 
            $res = selectAll('facilities');
            $path = FEATURES_IMG_PATH;

            while($row = mysqli_fetch_assoc($res)){
                echo<<<data
                <div class="col-lg-4 col-md-6 mb-5 px-4 ">
                    <div class="bg-white1 rounded shadow p-4 border-top border-4 border-dark pop ">
                        <div class="d-flex align-items-center mb-2 ">
                            <img src="$path$row[icon]" width="40px" >
                            <h5 class="m-0 ms-3 ">$row[name]</h5>
                        </div>
                        <p>$row[description]</p>
                    </div>
                </div>      
                
                
                data;
            }
        ?>
    </div>
</div>

<!-- footer -->
<?php require('include/footer.php'); ?>

</body>
</html>