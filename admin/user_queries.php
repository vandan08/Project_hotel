<?php 
    require('inc/essentials.php');
    require('inc/db_config.php');
    admin_login();


    if (isset($_GET['seen'])) {
        $frm_data = filteration($_GET);

        if ($frm_data['seen']=='all') {
            $q ="UPDATE `user_quries` SET `seen`=?";
            $values = [1];
            if (update($q,$values,'i')) {
                alert('success','Marked All As Read');
            } else {
                alert('error','Operation Failed');
            }
        }
        else {
            $q ="UPDATE `user_quries` SET `seen`=? WHERE `sr_no`=?";
            $values = [1,$frm_data['seen']];
            if (update($q,$values,'ii')) {
                alert('success','Marked As Read');
            } else {
                alert('error','Operation Failed');
            }
        }
    }

    if (isset($_GET['del'])) {
        $frm_data = filteration($_GET);

        if ($frm_data['del']=='all') {
            $q ="DELETE FROM `user_quries`";
            if (mysqli_query($con,$q)) {
                alert('success','All Data Deleted');
            } else {
                alert('error','Operation Failed');
            }
        }
        else {
            $q ="DELETE FROM `user_quries` WHERE `sr_no`=?";
            $values = [$frm_data['del']];
            if (delete($q,$values,'i')) {
                alert('success','Data Deleted');
            } else {
                alert('error','Operation Failed');
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel-User Queries</title>

    
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


<link href="https://fonts.googleapis.com/css2?family=Merienda:wght@400;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- bootstrap icons  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"> 
    
    <!-- Swiper js CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>

    <!-- Adding our common css file  -->
    <link rel="stylesheet" href="css/common.css">

    
<?php require('inc/links.php'); ?>
</head>
<body class="bg-light">

    <?php require('inc/header.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">User Queries </h3> 
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">

                    <div class="text-end mb-4 ">
                        <a href="?seen=all" class="btn btn-dark rounded-pill shadow-none btn-sm">
                            <i class="bi bi-check-all"></i> Mark All Read
                        </a>
                        <a href="?del=all" class="btn btn-danger rounded-pill shadow-none btn-sm">
                            <i class="bi bi-trash"></i> Delete All
                        </a>
                    </div>

                        <div class="table-responsive-md" style="height: 450px; overflow-y: scroll;">
                            <table class="table table-hover border " >
                                <thead class="sticky-top"> 
                                  <tr class="bg-dark text-light">
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col" width = "20%">Subject</th>
                                    <th scope="col" width = "30%">Message</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action </th>
                                  </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $q = "SELECT * FROM `user_quries` ORDER BY  `sr_no` DESC";
                                        $data = mysqli_query($con,$q);
                                        $i =1;
                                        while($row = mysqli_fetch_assoc($data)){
                                        $seen = '';
                                        if ($row['seen']!=1) {
                                            $seen = "<a href='?seen=$row[sr_no]' class='btn btn-sm rounded-pill btn-primary'>Mark As Read</a><br>";
                                        }
                                        $seen.="<a href='?del=$row[sr_no]' class='btn btn-sm rounded-pill btn-danger mt-2'>Delete</a>";
                                            echo<<<data
                                                <tr>
                                                    <td>$i</td>
                                                    <td>$row[name]</td>
                                                    <td>$row[email]</td>
                                                    <td>$row[subject]</td>
                                                    <td>$row[message]</td>
                                                    <td>$row[date]</td>
                                                    <td>$seen</td>
                                                </tr>
                                                data;
                                                $i++;
                                        }
                                    
                                    ?>
                                </tbody>
                              </table>
                        </div>

                        <div class="row" id="carousel-data">

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <?php require('inc/scripts.php'); ?>


</body>
</html>