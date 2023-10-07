    let carousel_s_form = document.getElementById('carousel_s_form');
    let carousel_picture_inp = document.getElementById('carousel_picture_inp');

    
    carousel_s_form.addEventListener('submit',function(e){
        e.preventDefault();  
        add_image();
    })


    function add_image(){
        // FormData is an Interface of js in which we can send the images / files or any type of data threw Ajax 


        let data = new FormData();  // here we created a data object variable of FormData interface 
        data.append('picture',carousel_picture_inp.files[0]);      //we are inserting data in to the format of "key" => "value" Format 'files[0]' means that how many files we select it will only consider the very first file as a input 
        data.append('add_image','');

        let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/carousel_crud.php",true);
        

        xhr.onload = function () {
        
            var myModal = document.getElementById('carousel-s')
            var modal = bootstrap.Modal.getInstance(myModal) // Returns a Bootstrap modal instance
            modal.hide();

           if (this.responseText == 'inv_img' ) {
            alert('error',"Only Jpg and Png images are Allowed ");
           }
           else if (this.responseText == 'inv_size'){
            alert('error',"Image size should be less than 2 MB ");
           }
           else if (this.responseText == 'upd_failed'){
            alert('error',"Image Can't Upload ! Server Down !  ");
           } else {
            alert('success',"New Image Added");
            carousel_picture_inp.value='';
            get_carousel();
           }
        }

        xhr.send(data);
    }

    function get_carousel() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/carousel_crud.php",true);
    xhr.setRequestHeader('Content-type' , 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('carousel-data').innerHTML = this.responseText;
    }
    xhr.send('get_carousel');
}

    function rem_image(val){
        let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/carousel_crud.php",true);
        xhr.setRequestHeader('Content-type' , 'application/x-www-form-urlencoded');

        xhr.onload = function () {
           if(this.responseText==1){
                alert('success',"Image Removed ! ");
                get_carousel();
           }
           else {
                alert('error',"server Down !");
           }
        }

        xhr.send('rem_image='+val);
    }



    window.onload = function(){
       get_carousel();
    }

