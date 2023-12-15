<!DOCTYPE html>
<?php
    
    require $_SERVER['DOCUMENT_ROOT'] . '\videoClubRodrigo\lib\functions\session_functions.php';
    require $_SERVER['DOCUMENT_ROOT'] . '\videoClubRodrigo\lib\model\Usuario.php';
    require $_SERVER['DOCUMENT_ROOT'] . '\videoClubRodrigo\lib\functions\db_functions.php';
    
    session_start();
    if(!isset($_SESSION["user"])){
        header("Location: ../../index.php?redirected=true");
    }
    
    //If want to activate the inactivity close session, uncomment this
//    if (isset($_SESSION["last_activity"])){
//        check_inactivity($_SESSION["last_activity"]);
//    }
    
    $user = $_SESSION['user'];
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Video club</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
    
    <body>
        
        <a href="../clientPages/sendEmailUser.php">Enviar email</a>
        
    </body>
</html>
