<?php 
    require('inc/essentials.php');
    require('inc/db_config.php');
    admin_login();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Rooms</title>

    
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
                <h3 class="mb-4">Rooms</h3> 
                <!--Content Table -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <!-- Heading -->
                        <div class="text-end mb-3">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-dark shadow-none btn-sm " data-bs-toggle="modal" data-bs-target="#add-room">
                                    <i class="bi bi-plus-circle"></i>   Add
                                </button>
                        </div>
                        <!-- Table of Data  -->
                        <div class="table-responsive-lg" style="height: 450px; overflow-y: scroll;">
                            <table class="table table-hover border text-center " >
                                <thead > 
                                    <tr class="bg-dark text-light">
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Area </th>
                                    <th scope="col">Guests </th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="room-data">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Add Room Modal -->
    <div class="modal fade mb-4" id="add-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="add_room_form" autocomplete="off">
                <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Room</h5>
                        </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- name -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <!-- area -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Area</label>
                                <input type="number" min="1" name="area" class="form-control" required>
                            </div>
                            <!-- price -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Price</label>
                                <input type="number" min="1" name="price" class="form-control" required>
                            </div>
                            <!-- quantity -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Quantity</label>
                                <input type="number" min="1" name="quantity" class="form-control" required>
                            </div>
                            <!-- adult -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Adult(max.)</label>
                                <input type="number" min="1" name="adult" class="form-control" required>
                            </div>
                            <!-- Childres -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Children(max.)</label>
                                <input type="number" min="1" name="children" class="form-control" required>
                            </div>
                            <!-- Features -->
                            <div class="mb-3 col-12">
                                <label class="form-label fw-bold">Features</label>    
                                <div class="row">
                                    <?php 
                                        $res = selectAll('features');

                                        while($opt = mysqli_fetch_assoc($res)){
                                            echo " 
                                                <div class = 'col-md-3 mb-1'>
                                                    <label>
                                                        <input type = 'checkbox' name='features' value ='$opt[id]' class='form-check-input shadown-none' >
                                                        $opt[name]
                                                    </label>
                                                </div>
                                            
                                            ";
                                        }
                                    
                                    ?>
                                </div>
                            </div>
                            <!-- Facilities -->
                            <div class="mb-3 col-12">
                                <label class="form-label fw-bold">Facilities</label>    
                                <div class="row">
                                    <?php 
                                        $res = selectAll('facilities');

                                        while($opt = mysqli_fetch_assoc($res)){
                                            echo " 
                                                <div class = 'col-md-3 mb-1'>
                                                    <label>
                                                        <input type = 'checkbox' name='facilities' value ='$opt[id]' class='form-check-input shadown-none' >
                                                        $opt[name]
                                                    </label>
                                                </div>
                                            
                                            ";
                                        }
                                    ?>
                                </div>
                            </div>
                            
                            <div class="col-12 mb-3 ">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="desc" rows="4" class="form-control shadow-none" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary " data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <!-- Add Room Modal -->
    <div class="modal fade mb-4" id="edit-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="edit_room_form" autocomplete="off">
                <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Room</h5>
                        </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- name -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <!-- area -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Area</label>
                                <input type="number" min="1" name="area" class="form-control" required>
                            </div>
                            <!-- price -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Price</label>
                                <input type="number" min="1" name="price" class="form-control" required>
                            </div>
                            <!-- quantity -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Quantity</label>
                                <input type="number" min="1" name="quantity" class="form-control" required>
                            </div>
                            <!-- adult -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Adult(max.)</label>
                                <input type="number" min="1" name="adult" class="form-control" required>
                            </div>
                            <!-- Childres -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Children(max.)</label>
                                <input type="number" min="1" name="children" class="form-control" required>
                            </div>
                            <!-- Features -->
                            <div class="mb-3 col-12">
                                <label class="form-label fw-bold">Features</label>    
                                <div class="row">
                                    <?php 
                                        $res = selectAll('features');

                                        while($opt = mysqli_fetch_assoc($res)){
                                            echo " 
                                                <div class = 'col-md-3 mb-1'>
                                                    <label>
                                                        <input type = 'checkbox' name='features' value ='$opt[id]' class='form-check-input shadown-none' >
                                                        $opt[name]
                                                    </label>
                                                </div>
                                            
                                            ";
                                        }
                                    
                                    ?>
                                </div>
                            </div>
                            <!-- Facilities -->
                            <div class="mb-3 col-12">
                                <label class="form-label fw-bold">Facilities</label>    
                                <div class="row">
                                    <?php 
                                        $res = selectAll('facilities');

                                        while($opt = mysqli_fetch_assoc($res)){
                                            echo " 
                                                <div class = 'col-md-3 mb-1'>
                                                    <label>
                                                        <input type = 'checkbox' name='facilities' value ='$opt[id]' class='form-check-input shadown-none' >
                                                        $opt[name]
                                                    </label>
                                                </div>
                                            
                                            ";
                                        }
                                    ?>
                                </div>
                            </div>
                            <!-- Description -->
                            <div class="col-12 mb-3 ">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="desc" rows="4" class="form-control shadow-none" required></textarea>
                            </div>
                            <input type="hidden" name="room_id">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary " data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Manage Room images Modal -->
    <div class="modal fade" id="room-images" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Room Name </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="image-alert"></div>
                <div class="border-bottom border-3 pb-3 mb-3">
                    <form id="add_image_form">
                        <label class="form-label fw-bold">Add Image</label>
                        <input type="file" name="image" accept=".jpg,.png,.webp,.jpeg" class="form-control mb-3" required>
                        <button class="btn custom-bg text-white shadow-none">Add</button>
                        <input type="hidden" name="room_id">
                    </form>
                </div>
                 <!-- Table of Data  -->
                 <div class="table-responsive-lg" style="height: 350px; overflow-y: scroll;">
                    <table class="table table-hover border text-center " >
                        <thead > 
                            <tr class="bg-dark text-light sticky-top">
                            <th scope="col" width ="60%">Image</th>
                            <th scope="col">Thumb</th>
                            <th scope="col">Delete </th>
                            </tr>
                        </thead>
                        <tbody id="room-image-data">
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div>
    </div>


    <?php require('inc/scripts.php'); ?>
    <script src="scripts/rooms.js"></script>
</body>
</html>