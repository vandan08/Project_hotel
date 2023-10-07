<?php 

    require('../admin/inc/essentials.php');
    require('../admin/inc/db_config.php');

    $mail ="";
    if (isset($_POST['submit'])) {
        $mail = $_POST['email']; 
    }



    if(isset($_POST['recovery_pass'])){
    
        $data = filteration($_POST);

    $enc_pass = password_hash($data['pass'],PASSWORD_BCRYPT);

    $query = "UPDATE `user_cred` SET `password`=? WHERE `email`=? ";

    $values = [$enc_pass,$mail];

    if (update($query,$values,'ss')) {
        echo 1;
    } else {
        echo $mail;
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