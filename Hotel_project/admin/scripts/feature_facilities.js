let feature_s_form = document.getElementById('feature_s_form');
let facility_s_form = document.getElementById('facility_s_form');

feature_s_form.addEventListener('submit',function(e){
    e.preventDefault();  
    add_feature();
})

function add_feature(){
    // FormData is an Interface of js in which we can send the images / files or any type of data threw Ajax 


    let data = new FormData();  // here we created a data object variable of FormData interface 
    data.append('name',feature_s_form.elements['feature_name'].value);
    data.append('add_feature','');

    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/feature_facilities.php",true);
    

    xhr.onload = function () {
    
        var myModal = document.getElementById('feature-s')
        var modal = bootstrap.Modal.getInstance(myModal) // Returns a Bootstrap modal instance
        modal.hide();

        if (this.responseText == 1 ) {
        alert('success',"New Feature Added");
        feature_s_form.elements['feature_name'].value='';
        get_features();
        }
        else {
        alert('error','Server Down '); 
        }
    }

    xhr.send(data);
}

function get_features() {
let xhr = new XMLHttpRequest();
xhr.open("POST","ajax/feature_facilities.php",true);
xhr.setRequestHeader('Content-type' , 'application/x-www-form-urlencoded');

xhr.onload = function () {
    document.getElementById('features-data').innerHTML = this.responseText;
}
xhr.send('get_features');
}

function rem_feature(val){
    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/feature_facilities.php",true);
    xhr.setRequestHeader('Content-type' , 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if(this.responseText==1){
            alert('success',"Feature Removed ! ");
            get_features();
        } else if (this.responseText=='room_added'){
            alert('error','Feature is added in Room');
        }
        else {
            alert('error',"server Down !");
        }
    }

    xhr.send('rem_feature='+val);
}


facility_s_form.addEventListener('submit',function(e){
    e.preventDefault();  
    add_facility();
})

function add_facility(){
    // FormData is an Interface of js in which we can send the images / files or any type of data threw Ajax 

    let data = new FormData();  // here we created a data object variable of FormData interface 
    data.append('name',facility_s_form.elements['facility_name'].value);
    data.append('icon',facility_s_form.elements['facility_icon'].files[0]);
    data.append('desc',facility_s_form.elements['facility_desc'].value);
    data.append('add_facility','');

    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/feature_facilities.php",true);
    

    xhr.onload = function () {
    
        var myModal = document.getElementById('facility-s');
        var modal = bootstrap.Modal.getInstance(myModal);    // Returns a Bootstrap modal instance
        modal.hide();

        if (this.responseText == 'inv_img' ) {
            alert('error',"Only Svg images are Allowed ");
        }
        else if (this.responseText == 'inv_size'){
            alert('error',"Image size should be less than 1 MB ");
        }
        else if (this.responseText == 'upd_failed'){
            alert('error',"Image Can't Upload ! Server Down !  ");
        } else {
            alert('success',"New Facility Added");
            facility_s_form.reset();

            get_facilities();
        }
    }

    xhr.send(data);
}


function get_facilities() {
let xhr = new XMLHttpRequest();
xhr.open("POST","ajax/feature_facilities.php",true);
xhr.setRequestHeader('Content-type' , 'application/x-www-form-urlencoded');

xhr.onload = function () {
    document.getElementById('facilities-data').innerHTML = this.responseText;
}
xhr.send('get_facilities');
}


function rem_facility(val){
    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/feature_facilities.php",true);
    xhr.setRequestHeader('Content-type' , 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if(this.responseText==1){
            alert('success',"Feature Removed ! ");
            get_facilities();
        } else if (this.responseText=='room_added'){
            alert('error','Facilities is added in Room');
        }
        else {
            alert('error',"server Down !");
        }
    }

    xhr.send('rem_facility='+val);
}


window.onload = function(){
get_features();
get_facilities();
}




