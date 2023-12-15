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
        <h1>Bienvenido usuario</h1>

        <form action="../../lib/functions/mail.php" method="POST">
            <?php
            $fillInputs=false;
            
            //Check variables
            if(isset($_GET['err']) ){
                
                $fillInputs = true;
                
                if(isset($_GET['em']) ){
                    $email = filter_input(INPUT_GET, 'em', FILTER_SANITIZE_EMAIL);
                }
                if(isset($_GET['as']) ){
                    $asunto = filter_input(INPUT_GET, "as", FILTER_SANITIZE_STRING);
                }
                if(isset($_GET['cu']) ){
                    $cuerpo = filter_input(INPUT_GET, "cu", FILTER_SANITIZE_STRING);
                }
            }
            ?>
            <label>Correo</label>
            <input type="text" value="<?php if($fillInputs){echo $email;}?>" name="email">
            
            <label>Asunto</label>
            <input type="text" value="<?php if($fillInputs){echo $asunto;}?>" name="asunto">
            
            <label>Cuerpo</label>
            <textarea id="id" name="cuerpo" rows="5" cols="10"><?php if($fillInputs){echo $cuerpo;}?></textarea>
            
            <input type="submit" name="name">
            
            
        </form>
    </body>
</html>


