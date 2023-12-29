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

    
    $titleCheck = false;
    $generoCheck = false;
    $paisCheck = false;
    $anyocheck = false;
    $cartelCheck = false;
    
    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        if(!isset($_POST['titulo']) || empty($_POST['titulo']) ){
            $titleCheck = true;
        }
        
        if(!isset($_POST['genero']) || empty($_POST['genero']) ){
            $generoCheck = true;
        }
        
        if(!isset($_POST['pais']) || empty($_POST['pais']) ){
            $paisCheck = true;
        }
        
        if(!isset($_POST['anyo']) || empty($_POST['anyo']) ){
            $anyocheck = true;
        }
        
        if(!isset($_POST['cartel']) ){
            $cartelCheck = true;
        }
        
        //If any error ocurred then redirects
        if($titleCheck==true || $generoCheck==true || $paisCheck==true || $anyocheck==true || $cartelCheck==true){
            header('Location: ../../../pages/adminPages/createMoviePage.php?titulo='. trim($_POST['titulo']).'&genero='.$_POST['genero'].'&pais='.$_POST['pais'].'&anyo='.$_POST['anyo'].'&cartel='.$_POST['cartel']);
        }
        
        $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
        $genero = filter_input(INPUT_POST, 'genero', FILTER_SANITIZE_SPECIAL_CHARS);
        $pais = filter_input(INPUT_POST, 'pais', FILTER_SANITIZE_SPECIAL_CHARS);
        $anyo = filter_input(INPUT_POST, 'anyo', FILTER_SANITIZE_SPECIAL_CHARS);
        $cartel = filter_input(INPUT_POST, 'cartel', FILTER_SANITIZE_SPECIAL_CHARS);
        
        if(empty(trim($_POST['cartel'])) ){
            $cartel = 'noImage.jpg';
        }
        
        createMovie($titulo, $genero, $pais, $anyo, $cartel);
        
    }
