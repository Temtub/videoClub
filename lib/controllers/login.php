<?php

require $_SERVER['DOCUMENT_ROOT'] . '\videoclub\lib\functions\db_functions.php';
require $_SERVER['DOCUMENT_ROOT'] . '\videoclub\lib\functions\user_functions.php';

require $_SERVER['DOCUMENT_ROOT'] . '\videoclub\lib\model\Usuario.php';
require $_SERVER['DOCUMENT_ROOT'] . '\videoclub\lib\model\Pelicula.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    $userCheck = false;
    $passCheck = false;
    
    //Connect to the db
    db_connect();

    //Check if variables are sended
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

    if( empty($_POST['pass']) || empty($_POST['user']) || $_POST['pass'] == ' ' || $_POST['user'] == ' '){
        $passCheck=true;
        $userCheck=true;
    }
    
    //Check if the variables has been setted
    if(checkUserAndPasFilled($userCheck, $passCheck) ){
        header('Location: ../../index.php?errorLog=true');
        exit();
    }
    
     // Check if the login is correct
    if (!login_check($userPost, $passPost)) {
        header('Location: ../../index.php?wrong=true');
        exit();
    }

    // Successful login
    $userFinished = login_check($userPost, $passPost);
    
    //Guardamos el objeto de usuario
    $user = new Usuario($userFinished['id'], $userFinished['username'], $userFinished['rol']);
    
    // Almacenar el objeto en la sesión
    session_start();
    $_SESSION['user'] = $user;
    
    if($user->getRol() === 1){
        header('Location: ../../pages/adminPages/adminIndex.php');
    }
    else{
        header('Location: ../../pages/clientPages/userIndex.php');
    }

    
    
}
else{
    header('Location: ../../index.php?errorLog=true');
}

