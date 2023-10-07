


function get_users(){
    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/users.php",true);
    xhr.setRequestHeader('Content-type' , 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('users-data').innerHTML=this.responseText;
    }

    xhr.send('get_users');
}


function toggle_status(id,val){
    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/users.php",true);
    xhr.setRequestHeader('Content-type' , 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if(this.responseText==1)
        {
            alert('success','Status Toggled');
            get_users();
        } else {
            alert('error','Server Down');
        }
    }

    xhr.send('toggle_status='+id+'&value='+val);
}

function remove_user(user_id){
    
    if(confirm("Are you Sure You Want to Delete This User !?")){
        let data = new FormData();  // here we created a data object variable of FormData interface 
        data.append('user_id',user_id);      //we are inserting data in to the format of "key" => "value" Format 'files[0]' means that how many files we select it will only consider the very first file as a input 
        data.append('remove_user','');

            let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/users.php",true);
        

        xhr.onload = function () {
        
            if (this.responseText == 1 ) {
                alert('success'," User Removed");
                get_users();
            }
            else {
                alert('error',"User Removal Failed ");
            }
        }

                xhr.send(data);
    }

    

    
}

function search_user(username){
    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/users.php",true);
    xhr.setRequestHeader('Content-type' , 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('users-data').innerHTML=this.responseText;
    }

    xhr.send('search_user&name='+username);
}

window.onload=function(){
    get_users();
}
