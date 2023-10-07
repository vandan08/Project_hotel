<?php 

    require('../admin/inc/essentials.php');
    require('../admin/inc/db_config.php');
    date_default_timezone_set("Asia/Kolkata");

    if (isset($_POST['check_availibility'])) {
        $frm_data = filteration($_POST);
        $status = "";
        $result = "";

        //check in and check out validation

        /* Here we have used DateTime interface to establish Date and many more DateTime Interface's Functions and keywords  */
        
        $today_date = new DateTime(date("Y-m-d"));
        $checkin_date = new DateTime($frm_data['check_in']);
        $checkout_date = new DateTime($frm_data['check_out']);

        if ($checkin_date == $checkout_date) {
            $status = 'check_in_out_equal';
            $result = json_encode(['status'=>$status]);
        } else if($checkout_date < $checkin_date){
            $status = 'check_out_earlier';
            $result = json_encode(['status'=>$status]);
        } else if($checkin_date < $today_date){
            $status = 'check_in_earlier';
            $result = json_encode(['status'=>$status]);
        } 


        //check booking availibility if status id blank else return the error 

        if ($status!='') {
            echo $result;
        } else {
            session_start();

            //run query to check room is available or not 
            $tb_query="SELECT COUNT(*) AS `total_bookings` FROM `booking_order`
             WHERE booking_status=? AND room_id =? 
            AND check_out > ? AND check_in < ?";

            $values = ['booked',$_SESSION['room']['id'],$frm_data['check_in'],$frm_data['check_out']];

            $tb_fetch=mysqli_fetch_assoc(select($tb_query,$values,'siss'));

            $rq_result = select("SELECT `quantity` FROM `rooms` WHERE `id`=?",[$_SESSION['room']['id']],'i');
            $rq_fetch = mysqli_fetch_assoc($rq_result);

            if (($rq_fetch['quantity']-$tb_fetch['total_bookings'])<=0) {
                $status = 'unavailabe';
                $result = json_encode(['status'=>$status]);
                exit;
            }
            

            $count_days = date_diff($checkin_date,$checkout_date)->days;

           $payment = $_SESSION['room']['price'] * $count_days;

           $_SESSION['room']['payment']= $payment;
           $_SESSION['room']['availabe']= true;

           $result = json_encode(["status"=>'availabe','days'=>$count_days,'payment'=>$payment]);
           echo $result;
        }



    }

    if(isset($_POST['pay_now'])){
        $frm_data = filteration($_POST);

        $query1 = "INSERT INTO `booking_order`(`user_id`, `room_id`, `check_in`, `check_out`,`order_id`) 
        VALUES (?,?,?,?,?)";

        insert($query1,[$_SESSION['uId'],$_SESSION['room']['id'],$frm_data['checkin'],$frm_data['checkout'],random_int(100,1000)],'issss');

       $booking_id = mysqli_insert_id($con);

       $query2 = "INSERT INTO `booking_details`(`booking_id`, `room_name`, `price`, `total`, `user_name`, `phonenum`, `email`) VALUES (?,?,?,?,?,?,?)";

       insert($query2,[$booking_id,$_SESSION['room']['name'],$_SESSION['room']['price'],$_SESSION['room']['payment'],$frm_data['name'],$frm_data['phonenum'],$frm_data['email']],'issssss');

    }
    ?>
