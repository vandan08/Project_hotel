<?php 
                $review_q = "SELECT rr.*,uc.name AS uname, r.name AS rname FROM `rating_review` rr 
                    INNER JOIN `user_cred` uc ON rr.user_id = uc.id
                    INNER JOIN `rooms` r ON rr.room_id = r.id
                    ORDER BY  `sr_no` DESC LIMIT 8";

                $review_res = mysqli_query($con,$review_q);
                $img_path = USERS_IMG_PATH;

                if (mysqli_num_rows($review_res)==0) {
                    echo 'No Reviews Yet';
                } else {
                    while($row = mysqli_fetch_assoc($review_res)){
                    
                        $stars = "<i class='bi bi-star-fill text-warning'></i> ";
                        for ($i=1; $i<$row['rating'] ; $i+1) { 
                            $stars .="<i class='bi bi-star-fill text-warning'></i>";
                        }
                        echo<<<review
                        <div class="swiper-slide bg-white1 p-4 mb-5">
                            <div class="proofile d-flex align-items-center mb-3">
                                <img src="images/salman.jpg" width="40pxx">
                                <h6 class="m-0 ms-2">$row[uname]</h6>
                            </div>
                            <p>$row[review]</p>
                            <div class="rating">
                                $stars
                            </div>
                        </div>

                        review;
                    }
                }

            ?>