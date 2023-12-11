<?php

require $_SERVER['DOCUMENT_ROOT'] . '\videoClubRodrigo\lib\functions\db_functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '\videoClubRodrigo\lib\functions\user_functions.php';

//Connect to the db
db_connect();

$user = $_POST['user'];
$pass = $_POST['pass'];

//Check the login
$loginCheck = login_check($user, $pass);


echo $data;

//Check if the data that came from the function is a null
if($data===null ){
    echo 'null aqui';
//    header("Location: ../../index.php?error=true");
}

if(count($data>3) ){
    
    //Check if is admin
    if(check_rolAdmin((int)$data[3]) ){
        echo 'admin';
    //    header("Location: ../../pages/adminPage.php");
    }
    else{
        echo 'user';
    //    header("Location: ../../pages/userPage.php");
    }
}

