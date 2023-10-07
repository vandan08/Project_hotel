<?php 

    require('../admin/inc/essentials.php');
    require('../admin/inc/db_config.php');
    date_default_timezone_set("Asia/Kolkata");


    $email_u = " ";

    if(isset($_POST['register'])){
        $data = filteration($_POST);

        //compare the password and confirm password so that we can move forward 
        if ($data['pass'] != $data['cpass']) {  
            echo 'pass_mismatch';
            exit;
        } 

        //check user Exist or not 

        $u_exist = select('SELECT * FROM `user_cred` WHERE `email`=? OR `phonenum`=? LIMIT 1',[$data['email'],$data['phonenum']],'ss');

        if (mysqli_num_rows(($u_exist))!=0) {
            $u_exist_fetch = mysqli_fetch_assoc($u_exist);
            echo ($u_exist_fetch['email']==$data['email'])? 'email_already' : 'phone_already';
            exit;
        }

        //upload User image to server 
        $img = uploadUserImage($_FILES['profile']);
        if($img == 'inv_img'){
            echo 'inv_img';
            exit;
        } else if($img == 'upd_failed') {
            echo 'upd_failed';
            exit;
        } 


        //Send confirmation link to user's Email 

         


        $enc_pass = password_hash($data['pass'],PASSWORD_BCRYPT);  //here we are encypting password with this 'PASSWORD_BCRYPT' algorithm which is inbuilt algorithm 
        $q =  "INSERT INTO `user_cred`( `name`, `email`, `address`, `phonenum`, `pincode`, `dob`, `profile`,
         `password`) VALUES (?,?,?,?,?,?,?,?)";

         $values = [$data['name'],$data['email'],$data['address'],$data['phonenum'],$data['pincode'],$data['dob']
                    ,$img,$enc_pass];

        if(insert($q,$values,'ssssssss')){
            echo 1;
        } else {
            echo 'ins_failed';
        }





    }

    if(isset($_POST['login'])){
        $data = filteration($_POST);

        //check user Exist or not 

        $u_exist = select('SELECT * FROM `user_cred` WHERE `email`=? OR `phonenum`=? LIMIT 1',[$data['email_mob'],$data['email_mob']],'ss');

        if (mysqli_num_rows($u_exist)==0) {
            echo 'inv_email_mob';
            exit;
        } else {
            $u_fetch = mysqli_fetch_assoc($u_exist);
            if ($u_fetch['status']==0) {
                    echo 'inactive'; 
           } else {
            if (!password_verify($data['pass'],$u_fetch['password'])) {
                echo 'invalid_pass';
            } else {
                session_start();
                $_SESSION['login']=true;
                $_SESSION['uId'] = $u_fetch['id'];
                $_SESSION['uName'] = $u_fetch['name'];
                $_SESSION['uPic'] = $u_fetch['profile'];
                $_SESSION['uPhone'] = $u_fetch['phonenum'];
                echo 1;

            }
        }
    }
    }

    if(isset($_POST['forgot_pass'])){
        $data = filteration($_POST);
        $email_u = $data['email'];

        //check user Exist or not 

        $u_exist = select('SELECT * FROM `user_cred` WHERE `email`=?  LIMIT 1',[$data['email']],'s');

        if (mysqli_num_rows($u_exist)==0) {
            echo 'inv_email';
        } else {
            $u_fetch = mysqli_fetch_assoc($u_exist);
            if ($u_fetch['status']==0) {
                    echo 'inactive'; 
           } else {
            $token =bin2hex(random_bytes(16));
            $date = date("Y-m-d");

            $query = mysqli_query($con,"UPDATE `user_cred` SET `token`='$token',`t_expire`='$date' 
            WHERE `id`=$u_fetch[id]");

            if ($query) {
                echo 1;
            } else {
                echo 'upd_failed';
            }

            }
        }
    }


 if(isset($_POST['recovery_pass'])){

    $email_u = 'vandansheth8@gmail.com';

        $data = filteration($_POST);

    $enc_pass = password_hash($data['pass'],PASSWORD_BCRYPT);

    $query = "UPDATE `user_cred` SET `password`=? WHERE `email`=? ";

    $values = [$enc_pass,$email_u];

    if (update($query,$values,'ss')) {
        echo 1;
    } else {
        echo 'failed';
    }

        // //check user Exist or not 
        // $u_exist = select('SELECT * FROM `user_cred` WHERE `email`=?  LIMIT 1', [$email_u],'s');
        // $u_fetch = mysqli_fetch_assoc($u_exist);
        // $query = mysqli_query($con,"UPDATE `user_cred` SET `password`='$new_pass[pass]' WHERE `id`= $u_fetch[id]");

        // if ($query) {
        //     echo 1;
        // } else {
        //     echo 'upd_failed';
        // }

       
    }
    
    ?>