


function get_bookings(search=''){
    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/new_bookings.php",true);
    xhr.setRequestHeader('Content-type' , 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('table-data').innerHTML=this.responseText;
    }

    xhr.send('get_bookings&search='+search);
}

let assign_room_form = document.getElementById('assign_room_form');

function assign_room(id){
    assign_room_form.elements['booking_id'].value = id;
}

assign_room_form.addEventListener('submit',function(e){
    e.preventDefault();
    
    let data = new FormData();  // here we created a data object variable of FormData interface 
    data.append('room_no',assign_room_form.elements['room_no'].value);
    data.append('booking_id',assign_room_form.elements['booking_id'].value);
    data.append('assign_room','');

    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/new_bookings.php",true);
    

    xhr.onload = function () {
    
        var myModal = document.getElementById('assign-room');
        var modal = bootstrap.Modal.getInstance(myModal);    // Returns a Bootstrap modal instance
        modal.hide();

        if(this.responseText==1){
            alert('success','Room Number Alloted Booking Finalized');
            assign_room_form.reset();
            get_bookings();
        } else {
            alert('error','Server Down!');
        }
    }

    xhr.send(data);
});

function cancel_booking(id){
    if(confirm("Are you Sure You Want to Cancel This Booking !?")){
        let data = new FormData();  // here we created a data object variable of FormData interface 
        data.append('booking_id',id);      //we are inserting data in to the format of "key" => "value" Format 'files[0]' means that how many files we select it will only consider the very first file as a input 
        data.append('cancel_booking','');

            let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/new_bookings.php",true);
        

        xhr.onload = function () {
        
            if (this.responseText == 1 ) {
                alert('success'," Booking Canceled");
                get_bookings();
            }
            else {
                alert('error',"Server Down ");
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
    get_bookings();
}
