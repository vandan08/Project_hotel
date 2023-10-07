<?php 

    require('../inc/essentials.php');
    require('../inc/db_config.php');
    admin_login();

//Here we are merging Two tables with their data like both of the tables have the same Booking_id and we are selecting that data from tables which have booking status = "Booked" and Arrival = 0
    if (isset($_POST['get_bookings'])) {
        $frm_data = filteration($_POST);

        //this variable is use to show the limit of the recods per page this
        $limit = 5;
        $page = $frm_data['page'];
        $start = ($page-1) * $limit; //page 1 = (1-1)*10 : 0-10 /// page 2 = (2-1)*10 : 10-20......

        //(bo.arrival = 1 OR bo.arrival = 0)
        //(bo.refund=1 OR bo.refund=0)

       $query = "SELECT bo.*,bd.* FROM `booking_order` bo
            INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
            WHERE (( bo.booking_status = 'booked' AND (bo.arrival = 1 OR bo.arrival = 0) ) 
            OR (bo.booking_status='cancelled' AND (bo.refund=1 OR bo.refund=0) )
            OR (bo.booking_status='pending')) 
            AND (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?)
            ORDER BY bo.booking_id DESC";

       $res = select($query,
       ["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%"],'sss');


       $limit_query = $query." LIMIT $start,$limit";
       
       $limit_res = select($limit_query,
       ["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%"],'sss');



       $i=$start+1;
       $table_data = "";
    
       $total_rows = mysqli_num_rows($res);
        if ($total_rows==0) {
            $output = json_encode(['table_data'=>"<b>No Data Found!</b>","pagination"=>'']);
            echo $output;
            exit;
        }

       while ($data=mysqli_fetch_assoc($limit_res)) {
        
        $date = date("d-m-Y",strtotime($data['datentime']));
        $checkin = date("d-m-Y",strtotime($data['check_in']));
        $checkout = date("d-m-Y",strtotime($data['check_out']));

        if ($data['booking_status']=='booked') {
            $status_bg = 'bg-success';
        } else if ($data['booking_status']=='cancelled') {
            $status_bg = 'bg-danger';
        } else  {
            $status_bg = 'bg-warning text-dark';
        } 



        $table_data .="
            <tr>
                <td>$i</td>
                <td>
                    <span class='badge bg-primary'>
                        Order ID: $data[order_id]
                    </span>
                    <br>
                    <b>Name:</b> $data[user_name]
                    <br>
                    <b>Phone No:</b> $data[phonenum]
                </td>
                <td>
                    <b>Room:</b> $data[room_name]
                    <br>
                    <b>Price:</b>₹$data[price]
                </td>
                <td>
                    <b>Remaining Payment:</b> ₹$data[price]
                    <br>
                    <b>Date:</b> $date
                </td>
                <td>
                    <span class='badge $status_bg'>$data[booking_status]</span>
                </td>
                <td>
                <button type='button' onclick='' class='btn mt-2 btn-outline-dark btn-sm fw-bold shadow-none' >
                    <i class='bi bi-filetype-pdf'></i>
                </button>
                </td>
            </tr>
        ";

        $i++;
       }

       $pagination = "";

       if ($total_rows>$limit) {
        $total_pages = ceil($total_rows/$limit);

        if ($page!=1) {
            $pagination .="
        <li class='page-item'><button onclick='change_page(1)' class='page-link shadow-none'>First</button>
        </li>";
        }

        $disabled = ($page==1) ? "disabled" : "";
        $prev= $page-1;
        $pagination .="
        <li class='page-item $disabled'><button onclick='change_page($prev)' class='page-link shadow-none'>Prev</button>
        </li>";


        
        $disabled = ($page==$total_pages) ? "disabled" : "";
        $next= $page+1;
        $pagination .="
        <li class='page-item $disabled'><button onclick='change_page($next)' class='page-link shadow-none'>Next</button>
        </li>";

       


        if ($page!=$total_pages) {
            $pagination .="
        <li class='page-item'><button onclick='change_page($total_pages)' class='page-link shadow-none'>Last</button>
        </li>";
        }
       }

       $output = json_encode(['table_data'=>$table_data,"pagination"=>$pagination]);

       echo $output;

    }


    if (isset($_POST['assign_room'])) {
        $frm_data = filteration($_POST);

        $query = "UPDATE `booking_order` bo INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id SET bo.arrival = ?,bd.room_no = ? WHERE bo.booking_id = ?";
        
        $values = [1,$frm_data['room_no'],$frm_data['booking_id']];
        $res = update($query,$values,'isi');

        echo ($res==2) ? 1 : 0;



    }

    if (isset($_POST['cancel_booking'])) 
    {
        $frm_data = filteration($_POST);
        
        $query = "UPDATE `booking_order` SET `booking_status`=?, `refund`=? WHERE `booking_id`=?";
        $values = ['cancelled',0,$frm_data['booking_id']];

        $res = update($query,$values,'sii');

        echo $res;

    }

?>