function get_bookings(search=''){
    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/refund_bookings.php",true);
    xhr.setRequestHeader('Content-type' , 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('table-data').innerHTML=this.responseText;
    }

    xhr.send('get_bookings&search='+search);
}

function refund_booking(id){
    if(confirm("Refund Money For This Booking !?")){
        let data = new FormData();  // here we created a data object variable of FormData interface 
        data.append('booking_id',id);      //we are inserting data in to the format of "key" => "value" Format 'files[0]' means that how many files we select it will only consider the very first file as a input 
        data.append('refund_booking','');

            let xhr = new XMLHttpRequest();
        xhr.open("POST","ajax/refund_bookings.php",true);
        

        xhr.onload = function () {
        
            if (this.responseText == 1 ) {
                alert('success'," Money Refunded");
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
