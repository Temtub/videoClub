<?php

require $_SERVER['DOCUMENT_ROOT'] . '\videoClubRodrigo\lib\functions\db_functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '\videoClubRodrigo\lib\functions\user_functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '\videoClubRodrigo\lib\model\Usuario.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    $userCheck = false;
    $passCheck = false;
    
    //Connect to the db
    db_connect();

    if(isset($_POST['user']) ){
        
        $userPost = filter_input(INPUT_POST, 'user');
    }
    else{
       $userCheck = true; 
    }
    if(isset($_POST['pass']) ){
        
        $passPost = filter_input(INPUT_POST, 'pass');
    }
    else{
       $passCheck = true; 
    }

    //Check if the variables has been setted
    if(checkUserAndPasFilled($userCheck, $passCheck) ){
        header('Location: ../../index.php?errorLog=true');
    }
    
    //Check the login is correct
    if(!login_check($userPost, $passPost) ){
        echo 'mal';
        header('Location: ../../index.php?wrong=true'); 
    }
    else{
        echo 'bien';
        $userFinished = login_check($userPost, $passPost);
    }
    
    //Guardamos el objeto de usuario
    $user = new Usuario($userFinished['id'], $userFinished['username'], $userFinished['rol']);
    
    // Almacenar el objeto en la sesión
    session_start();
    $_SESSION['user'] = $user;
    
    if($user->getRol() === 1){
        header('Location: ../../pages/adminPage.php');
    }
    else{
        header('Location: ../../pages/userPage.php');
    }

    
    
}
else{
    header('Location: ../../index.php?errorLog=true');
}

