<?php 

$h_name='localhost';
$u_name = "root";
$pass = "";
$db = "hotel";

//create a variable to connect with database 
$con=mysqli_connect($h_name,$u_name,$pass,$db);

//to check whether we are able to connect with our databse 
if(!$con){
    die("Cannot Connect to DataBase ".mysqli_connect_errno());
}

//filter the data !! 
function filteration($data){
    foreach ($data as $key => $value) {
        $value = trim($value);    // trim function will remove extra spaces from input 
        $value = stripcslashes($value);   //stripslashes removes backward slash "/" from input 
        $value = htmlspecialchars($value);  // this function will remove all special characters from input 
        $value = strip_tags($value);  //it will stop all html tags from running behind it 

        $data[$key] = $value;
    }
    return $data; 
}

function selectAll($table){
    $con = $GLOBALS['con'];
    $res = mysqli_query($con,"SELECT * FROM $table");
    return $res;
}

function select($sql,$values,$datatypes){
    //as we cannot use a global variable in a function we have to use it by 'GLOBALS' variable 
    $con = $GLOBALS['con'];

    // we called here prepare statement by passing $con , $sql as a parameter and store in a 'statment' variable 
    if ($statment = mysqli_prepare($con,$sql)) {

        // we bind our values with below function 
        mysqli_stmt_bind_param($statment,$datatypes,...$values);

        // after binding our values we have to execute it as well 
        if(mysqli_stmt_execute($statment)){
            // we store our values into a $res variable and close the connection after it and return res varible 
           $res = mysqli_stmt_get_result($statment);
           mysqli_stmt_close($statment);
           return $res;
        }
        else{ // if we are unable to execute query we just call die function and close the connection 
            mysqli_stmt_close($statment);
            die("Query cannot be executed - Select ");    
        }
        
    } else { // if we cannot prepare our query we'll display this 
        die("Query cannot be prepared - Select  ");
        
    }

}

function update($sql,$values,$datatypes){
    //as we cannot use a global variable in a function we have to use it by 'GLOBALS' variable 
    $con = $GLOBALS['con'];

    // we called here prepare statement by passing $con , $sql as a parameter and store in a 'statment' variable 
    if ($statment = mysqli_prepare($con,$sql)) {

        // we bind our values with below function 
        mysqli_stmt_bind_param($statment,$datatypes,...$values);

        // after binding our values we have to execute it as well 
        if(mysqli_stmt_execute($statment)){
            // we store our values into a $res variable and close the connection after it and return res varible 
           $res = mysqli_stmt_affected_rows($statment);
           mysqli_stmt_close($statment);
           return $res;
        }
        else{ // if we are unable to execute query we just call die function and close the connection 
            mysqli_stmt_close($statment);
            die("Query cannot be executed - update ");    
        }
        
    } else { // if we cannot prepare our query we'll display this 
        die("Query cannot be prepared - update  ");
        
    }

}

function insert($sql,$values,$datatypes){
    //as we cannot use a global variable in a function we have to use it by 'GLOBALS' variable 
    $con = $GLOBALS['con'];

    // we called here prepare statement by passing $con , $sql as a parameter and store in a 'statment' variable 
    if ($statment = mysqli_prepare($con,$sql)) {

        // we bind our values with below function 
        mysqli_stmt_bind_param($statment,$datatypes,...$values);

        // after binding our values we have to execute it as well 
        if(mysqli_stmt_execute($statment)){
            // we store our values into a $res variable and close the connection after it and return res varible 
           $res = mysqli_stmt_affected_rows($statment);
           mysqli_stmt_close($statment);
           return $res;
        }
        else{ // if we are unable to execute query we just call die function and close the connection 
            mysqli_stmt_close($statment);
            die("Query cannot be executed - Insert ");    
        }
        
    } else { // if we cannot prepare our query we'll display this 
        die("Query cannot be prepared - Insert  ");
        
    }

}

function delete($sql,$values,$datatypes){
    //as we cannot use a global variable in a function we have to use it by 'GLOBALS' variable 
    $con = $GLOBALS['con'];

    // we called here prepare statement by passing $con , $sql as a parameter and store in a 'statment' variable 
    if ($statment = mysqli_prepare($con,$sql)) {

        // we bind our values with below function 
        mysqli_stmt_bind_param($statment,$datatypes,...$values);

        // after binding our values we have to execute it as well 
        if(mysqli_stmt_execute($statment)){
            // we store our values into a $res variable and close the connection after it and return res varible 
           $res = mysqli_stmt_affected_rows($statment);
           mysqli_stmt_close($statment);
           return $res;
        }
        else{ // if we are unable to execute query we just call die function and close the connection 
            mysqli_stmt_close($statment);
            die("Query cannot be executed - Delete ");    
        }
        
    } else { // if we cannot prepare our query we'll display this 
        die("Query cannot be prepared - Delete  ");
        
    }

}



?>