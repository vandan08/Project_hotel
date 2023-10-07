<?php 
    //To upload process we neeed this data in FrontEnd 
    define('SITE_URL','http://127.0.0.1/Hotel_project/'); //After deploying this Website we have to change our value from this : "http://127.0.0.1/Hotel_project/" to "http://web.in"
    define('ABOUT_IMG_PATH',SITE_URL.'images/about/');
    define('CAROUSEL_IMG_PATH',SITE_URL.'images/carousel/');
    define('FEATURES_IMG_PATH',SITE_URL.'images/features/');
    define('ROOMS_IMG_PATH',SITE_URL.'images/rooms/');
    define('USERS_IMG_PATH',SITE_URL.'images/users/');





    //To upload process we neeed this data in backend 
    define('UPLOAD_IMAGE_PATH',$_SERVER['DOCUMENT_ROOT'].'/HOTEL_PROJECT/images/');
    define('ABOUT_FOLDER','about/');
    define('CAROUSEL_FOLDER','carousel/');
    define('FEATURE_FOLDER','features/');
    define('ROOMS_FOLDER','rooms/');
    define('USER_FOLDER','users/');

    function admin_login(){
        session_start();
        if(!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin']==true)){
        echo "
            <script> 
                window.location.href ='admin.php';
            </script>"; 
            exit;
        }
        // session_regenerate_id(true); //this function will generate a new session id always when we reload the page 
    }


    function redirect($url){
        //redirect function is used to redirect us from one page to another by js components ! 
        echo "
        <script> 
            window.location.href ='$url';
        </script>"; 
        exit;
    }
    function alert($type,$msg){
        $bs_class = ($type == "success")? "alert-success" : "alert-danger"; 

        echo <<<ABC
        <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
            <strong class = "me-3">$msg</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ABC ;
    }

    function uploadImage($image,$folder){
        $valid_mime = ['image/jpeg','image/png','image/webp']; //here we create an array of valid image extenstions 
        $img_mime = $image['type'];     

        if(!in_array($img_mime,$valid_mime)){  // function in_array() will search that if we have put rigth image extenstion or not 
            return 'inv_img';   //invalid image format 
        }
        else if(($image['size']/(1024*1024))>2){
            return 'inv_size'; //invalid greater than 2MB 
        }
        else {
            $ext = pathinfo($image['name'],PATHINFO_EXTENSION);
            $rname = 'IMG_'.random_int(11111,99999).".$ext";
            $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
            if(move_uploaded_file($image['tmp_name'],$img_path)){
                return $rname;
            }
            else {
                return 'upd_failed';
            }
        }
    }

    function delete_image($image,$folder){
        if(unlink(UPLOAD_IMAGE_PATH.$folder.$image)) { 
            return true;
        } else {
            return false;
        }
    }

    function uploadSvgImage($image,$folder){
        $valid_mime = ['image/svg+xml']; //here we create an array of valid image extenstions 
        $img_mime = $image['type'];     

        if(!in_array($img_mime,$valid_mime)){  // function in_array() will search that if we have put rigth image extenstion or not 
            return 'inv_img';   //invalid image format 
        }
        else if(($image['size']/(1024*1024))>1){
            return 'inv_size'; //invalid greater than 2MB 
        }
        else {
            $ext = pathinfo($image['name'],PATHINFO_EXTENSION);
            $rname = 'IMG_'.random_int(11111,99999).".$ext";
            $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
            if(move_uploaded_file($image['tmp_name'],$img_path)){
                return $rname;
            }
            else {
                return 'upd_failed';
            }
        }
    }

    function uploadUserImage($image){
        $valid_mime = ['image/jpeg','image/png','image/webp']; //here we create an array of valid image extenstions 
        $img_mime = $image['type'];     

        if(!in_array($img_mime,$valid_mime)){  // function in_array() will search that if we have put rigth image extenstion or not 
            return 'inv_img';   //invalid image format 
        }
        else {
            $ext = pathinfo($image['name'],PATHINFO_EXTENSION);
            $rname = 'IMG_'.random_int(11111,99999).".jpeg";

            $img_path = UPLOAD_IMAGE_PATH.USER_FOLDER.$rname;

            if($ext == 'png' || $ext == 'PNG'){
                $img = imagecreatefrompng($image['tmp_name']);        //This function is a php pre-defined function which creates a image from URL or png image 
            } else if($ext == 'webp' || $ext == 'WEBP'){
                $img = imagecreatefromwebp($image['tmp_name']);       //This function is a php pre-defined function which creates a image from URL or webp image 
            } else {
                $img = imagecreatefromjpeg($image['tmp_name']);       //This function is a php pre-defined function which creates a image from URL or jpeg image 
            }



            if(imagejpeg($img,$img_path,75)){
                return $rname;
            }
            else {
                return 'upd_failed';
            }
        }
    }

?>