<!DOCTYPE html>
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
?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Video club</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <link rel="stylesheet" href="../../css/styles.css">
    </head>
    
    <body>
        
        <div class="container-fluid">
        
        <?php include '../../lib/controllers/includes/headerUser.php'; ?>
        
        <h1>Bienvenido <?= $user->getUsername()?></h1>

        <?php

            if(isset($_GET['redir']) ){
                echo '<div class="message message-error"><p class="message__text">Rellene todos los datos.</p></div>';
            }
            if(isset($_GET['corr']) ){
                echo '<div class="message message-correct"><p class="message__text">Enviado con éxito.</p></div>';
            }
            
            if(isset($_GET['err']) ){
                echo '<div class="message message-error"><p class="message__text">Ha ocurrido un error.</p></div>';
            }
        ?>
        <form action="../../lib/functions/mail.php" method="POST" class="form d-flex flex-column align-items-center w-25 m-auto mt-5">
            <?php
            $fillInputs = false;

            // Check variables
            if (isset($_GET['err'])) {
                $fillInputs = true;

                $email = (isset($_GET['em'])) ? filter_input(INPUT_GET, 'em', FILTER_SANITIZE_EMAIL) : '';
                $asunto = (isset($_GET['as'])) ? filter_input(INPUT_GET, "as", FILTER_SANITIZE_STRING) : '';
                $cuerpo = (isset($_GET['cu'])) ? filter_input(INPUT_GET, "cu", FILTER_SANITIZE_STRING) : '';
            }
            ?>
            <h2 class="form__subtitle">Enviar Correo</h2>

            <div class="d-flex flex-column form__inputs">
                <input class="form__input" type="text" id="email" value="<?= ($fillInputs) ? $email : '' ?>" name="email">
                <label class="form__label">Correo</label>
            </div>

            <div class="d-flex flex-column form__inputs">
                <input class="form__input" type="text" id="asunto" value="<?= ($fillInputs) ? $asunto : '' ?>" name="asunto">
                <label class="form__label">Asunto</label>
            </div>

            <div class="d-flex flex-column form__inputs">
                <textarea id="cuerpo" name="cuerpo" rows="5" cols="10"><?= ($fillInputs) ? $cuerpo : '' ?></textarea>
                <label class="form__label">Cuerpo</label>
            </div>

            <input type="submit" name="submit" class="form__submit" value="Enviar">
        </form>

        </div>
    </body>
</html>


