function get_bookings(search='',page=1){
    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/booking_record.php",true);
    xhr.setRequestHeader('Content-type' , 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        let data = JSON.parse(this.responseText);
        document.getElementById('table-data').innerHTML=data.table_data;
        document.getElementById('table-pagination').innerHTML=data.pagination;
    }

    xhr.send('get_bookings&search='+search+'&page='+page);
}

function change_page(page){
    get_bookings(document.getElementById('search_input').value,page);
    
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
