<?php 
    require('inc/essentials.php');
    require('inc/db_config.php');

    session_start();
    if((isset($_SESSION['adminLogin']) && $_SESSION['adminLogin']==true)){
        /*so here we have same if condition like in admin_login but here the difference is that
         if we have login in to it then we can not go back to login page and 
         if we not able to login then we cannot go to dashboard page */
        redirect('dashboard.php');
    }
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Panel </title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <link href="https://fonts.googleapis.com/css2?family=Merienda:wght@400;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
        
        <!-- bootstrap icons  -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> 
        
        <!-- Swiper js CDN -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
    
        <!-- Adding our common css file  -->
        <link rel="stylesheet" href="css/common.css">
    
        

    <?php require('inc/links.php'); ?>


    <style>
        div.login-form{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            width: 400px;

        }
    </style>



</head>
<body class="bg-light ">
    <div class="login-form text-center rounded bg-white shadow overflow-hidden">
        <form method="post" >
            <h4 class="bg-dark text-white py-3">Admin Login Panel </h4>
            <div class="p-4 ">
                <div class="mb-3">
                    <input type="text" name="admin_name" class="form-control shadow-none text-center" placeholder="Admin name" required>
                </div>
                <div class="mb-4">
                    <input type="password" name="admin_pass" class="form-control shadow-none text-center " placeholder="Password" required>
                </div>
                <button type="submit" name="login" class="btn text-white custom-bg shadow-none">LOGIN</button>
            </div>
        </form>
    </div>
        
<?php 

//when we click login button this if condition will start running 
    if(isset($_POST['login'])){
        //its start filtering data from fields by "filteration" function 
        $frm_data = filteration($_POST);

        //by query variable we are storing our values to database 
        $query = "SELECT * FROM `admin_cred` WHERE `admin_name`=? AND `admin_pass` =? ";

        // values variable will seperate values from input fields which are stored in an array formation 
        $values = [$frm_data['admin_name'],$frm_data['admin_pass']];
        // $datatypes = "ss"; - optional to do this we can do that directly also 


        /* res varible is used to perform query by passing its 
        query,variable , datatype parameters with 'select' function */
       $res = select($query,$values,"ss"); 
       if ($res->num_rows==1) {
        $row = mysqli_fetch_assoc($res);
        $_SESSION['adminLogin'] = true;
        $_SESSION['adminId'] = $row['sr_no'];
        redirect('dashboard.php');

       } else {
            alert('error','Login failed - Invalid Credentials ! ');
       }

        

    }
  
?>


    <?php require('inc/scripts.php'); ?>
</body>
</html>