    <?php 

    // phpinfo();





    // ajax/login_register.php   line no . 72  'login'  
    // if ($u_fetch['is_verified']==0) {
    //     echo 'not_verified'; 
    // }

    $to      = 'vandansheth8@gmail.com';
    $subject = 'the subject';
    $message = 'hello';
    $headers = 'From: vandanbsheth9@gmail.com';

    if (mail($to,$subject,$message,$headers)) {
        echo "mail Sent"; 
    } else {
        echo "not sent";
    }




    ?>