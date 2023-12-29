<?php
    
    require $_SERVER['DOCUMENT_ROOT'] . '\videoclub\lib\functions\session_functions.php';
    require $_SERVER['DOCUMENT_ROOT'] . '\videoclub\lib\functions\db_functions.php';
    require $_SERVER['DOCUMENT_ROOT'] . '\videoclub\lib\functions\user_functions.php';
    
    require $_SERVER['DOCUMENT_ROOT'] . '\videoclub\lib\model\Usuario.php';
    require $_SERVER['DOCUMENT_ROOT'] . '\videoclub\lib\model\Pelicula.php';
    require $_SERVER['DOCUMENT_ROOT'] . '\videoclub\lib\model\Actor.php';
    
    
    //Check if the user has registered
    session_start();
    if(!isset($_SESSION["user"])){
        header("Location: ../../index.php?redirected=true");
    }
    
//If want to activate the inactivity close session, uncomment this
//    if (isset($_SESSION["last_activity"])){
//        check_inactivity($_SESSION["last_activity"]);
//    }
    
    $user = $_SESSION['user'];
    
    
    if(!isset($_GET['id']) || empty($_GET['id']) ){
        header('Location: ../../../pages/adminPages/adminIndex.php?error');
    }
    
    $movieGet = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

    deleteActuan($movieGet);
    deleteMovie($movieGet);
    
    
    header('Location: ../../../pages/adminPages/adminIndex.php?deleted');
    

    
    
    
    

