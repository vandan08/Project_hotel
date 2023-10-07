    let general_data,contacts_data;

    let general_s_form = document.getElementById('general_s_form');
    let site_title_inp = document.getElementById('site_title_inp');
    let site_about_inp = document.getElementById('site_about_inp');

    let contacts_s_form = document.getElementById('contacts_s_form');

    let team_s_form = document.getElementById('team_s_form');
    let member_name_inp = document.getElementById('member_name_inp');
    let member_picture_inp = document.getElementById('member_picture_inp');

    //threw this function we will get data of Title and About us text !
    function get_general(){
        let site_title = document.getElementById('site_title');
        let site_about=document.getElementById('site_about');
        let shutdown_toggle = document.getElementById('shutdown-toggle');
    
        let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/settings_crud.php",true);
        xhr.setRequestHeader('Content-type' , 'application/x-www-form-urlencoded');

        xhr.onload = function () {
            general_data = JSON.parse(this.responseText);
            // console.log(general_data);
            site_title.innerText = general_data.site_title;
            site_about.innerText = general_data.site_about;

            site_title_inp.value = general_data.site_title;
            site_about_inp.value = general_data.site_about;

            if (general_data.shutdown == 0) {
               shutdown_toggle.checked = false;
               shutdown_toggle.value = 0;  
            } else {
               shutdown_toggle.checked = true;
               shutdown_toggle.value = 1;  
            }
        }

        xhr.send('get_general');
    }

    general_s_form.addEventListener('submit',function(e){
        e.preventDefault();
        upd_general(site_title_inp.value,site_about_inp.value)
    })


    //update general function !! 
    function upd_general(site_title_val,site_about_val) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/settings_crud.php",true);
        xhr.setRequestHeader('Content-type' , 'application/x-www-form-urlencoded');

        xhr.onload = function () {
            var myModal = document.getElementById('general-s')
            var modal = bootstrap.Modal.getInstance(myModal) // Returns a Bootstrap modal instance
            modal.hide();

           if (this.responseText == 1 ) {
            alert('success',"Changes Saved!");
            get_general();
           }
           else {
            alert('error',"No Changes Saved!");
           }
        }

        xhr.send('site_title='+site_title_val+'&site_about='+site_about_val+'&upd_general');
    }

    function upd_shutdown(val) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/settings_crud.php",true);
        xhr.setRequestHeader('Content-type' , 'application/x-www-form-urlencoded');

        xhr.onload = function () {
           if (this.responseText == 1 && general_data.shutdown==0 ) {
            alert('success',"Site Has been Shutdown!");
           }
           else {
            alert('success',"Shutdown Mode is Off now!!");
           }
           get_general();
        }

        xhr.send('upd_shutdown='+val);
    }
    
    function get_contacts(){
        //storing data of contacts in array format and accessing it by it's 'p' tags 'id'
        let contacts_p_id = ['address','gmap','pn1','pn2','email','fb','insta','tw'];
        let iframe = document.getElementById('iframe');

        //Ajax code 
        let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/settings_crud.php",true);
        xhr.setRequestHeader('Content-type' , 'application/x-www-form-urlencoded');

        xhr.onload = function () {
            contacts_data = JSON.parse(this.responseText);
            contacts_data = Object.values(contacts_data);

            for(i=0;i<contacts_p_id.length;i++){
                document.getElementById(contacts_p_id[i]).innerText = contacts_data[i+1];
            }
            iframe.src = contacts_data[9];

            contacts_inp(contacts_data);

        }

        xhr.send('get_contacts');
    }

    function contacts_inp(data) {  
        let contacts_inp_id = ['address_inp','gmap_inp','pn1_inp','pn2_inp','email_inp','fb_inp','insta_inp','tw_inp','iframe_inp'];
        for (let i = 0; i < contacts_inp_id.length; i++) {
            document.getElementById(contacts_inp_id[i]).value = data[i+1];
        }

    }

    contacts_s_form.addEventListener('submit',function(e){
        e.preventDefault();
        upd_contacts();
    })

    function upd_contacts(){
        let index = ['address','gmap','pn1','pn2','email','fb','insta','tw','iframe'];
        let contacts_inp_id = ['address_inp','gmap_inp','pn1_inp','pn2_inp','email_inp','fb_inp','insta_inp','tw_inp','iframe_inp']; 

        let data_str = "";

        for (let i = 0; i < index.length; i++) {
            data_str += index[i] + "=" + document.getElementById(contacts_inp_id[i]).value + '&';
        }
        data_str += "upd_contacts";

        //Ajax code 
        let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/settings_crud.php",true);
        xhr.setRequestHeader('Content-type' , 'application/x-www-form-urlencoded');

        xhr.onload = function(){
            var myModal = document.getElementById('contacts-s')
            var modal = bootstrap.Modal.getInstance(myModal) // Returns a Bootstrap modal instance
            modal.hide();

            if (this.responseText == 1) {
            alert('success',"Changes Saved ! ");
            get_contacts();
           }
           else {
            alert('error',"No Changed made!");
           }
           get_general();
        }

        xhr.send(data_str);
    }

    team_s_form.addEventListener('submit',function(e){
        e.preventDefault();  
        add_member();
    })

    function add_member(){
        // FormData is an Interface of js in which we can send the images / files or any type of data threw Ajax 


        let data = new FormData();  // here we created a data object variable of FormData interface 
        data.append('name',member_name_inp.value);      //we are inserting data in to the format of "key" => "value" Format 
        data.append('picture',member_picture_inp.files[0]);      //we are inserting data in to the format of "key" => "value" Format 'files[0]' means that how many files we select it will only consider the very first file as a input 
        data.append('add_member','');

        let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/settings_crud.php",true);
        

        xhr.onload = function () {
        
            var myModal = document.getElementById('team-s')
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
            alert('success',"New Mmeber Added");
            member_name_inp.value='';
            member_picture_inp.value='';
            get_members();
           }
        }

        xhr.send(data);
    }

    function get_members() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/settings_crud.php",true);
    xhr.setRequestHeader('Content-type' , 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('team-data').innerHTML = this.responseText;
    }
    xhr.send('get_members');
    }

    function rem_member(val){
        let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/settings_crud.php",true);
        xhr.setRequestHeader('Content-type' , 'application/x-www-form-urlencoded');

        xhr.onload = function () {
           if(this.responseText==1){
                alert('success',"Member Removed ! ");
                get_members();
           }
           else {
                alert('error',"server Down !");
           }
        }

        xhr.send('rem_member='+val);
    }



    window.onload = function(){
        get_general();
        get_contacts();
        get_members();
    }

