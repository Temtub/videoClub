
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
    
    $user = $_SESSION['user'];
    if ($user->getRol() !== 1) {
        header("Location: ../../index.php?redirected=true");
    }
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
            
            <?php
            //Navbar of hte page
            include '../../lib/controllers/includes/header.php'; 

            if(isset($_GET['redir']) ){
                echo '<div class="message message-error"><p class="message__text">Rellena todos los datos.</p></div>';
            }
            if(isset($_GET['corr']) ){
                echo '<div class="message message-correct"><p class="message__text">Modificado correctamente.</p></div>';

            }
            if(isset($_GET['err']) ){
                echo '<div class="message message-error"><p class="message__text">Ha ocurrido un error con la modificación.</p></div>';
            }
            ?>

            <h1>Bienvenido <?= $user->getUsername()?></h1>
            
            <form class="form d-flex flex-column align-items-center w-25 m-auto mt-5" action="../../lib/controllers/adminController/updateMovie.php" method="POST">
            <h2 class="form__subtitle">ACTUALIZAR PELÍCULA</h2>
            
            <div class="d-flex flex-column form__inputs">  
                <input class="form__input" type="text" name="titulo" value="<?php if(isset($_GET['titulo'])){echo $_GET['titulo'];}?>">
                <label class="form__label">TITULO</label>
            </div>

            <div class="d-flex flex-column form__inputs">  
                <input class="form__input" type="text" name="genero" value="<?php if(isset($_GET['genero'])){echo $_GET['genero'];}?>">
                <label class="form__label">GENERO</label>
            </div>

            <div class="d-flex flex-column form__inputs">  
                <input class="form__input" type="text" name="pais" value="<?php if(isset($_GET['pais'])){echo $_GET['pais'];}?>">
                <label class="form__label">PAIS</label>
            </div>

            <?php
                $anyoInt = 0;
                
                if (isset($_GET['anyo']) && is_numeric($_GET['anyo'])) {
                    $anyoInt = (int)$_GET['anyo'];
                }
            ?>

            <div class="d-flex flex-column form__inputs">  
                <input class="form__input" type="number" name="anyo" value="<?php echo is_numeric($anyoInt) ? $anyoInt : ''; ?>">
                <label class="form__label">AÑO</label>
            </div>

            <div class="d-flex flex-column form__inputs">  
                <input class="form__input" type="text" name="cartel" value="<?php if(isset($_GET['cartel'])){echo $_GET['cartel'];}?>">
                <label class="form__label">CARTEL</label>
            </div>

            <input type="hidden" name="id" value="<?php if(isset($_GET['id'])){echo $_GET['id'];}?>">

            <input class="form__submit" type="submit" name="submit" value="Modificar">
        </form>

        
        </div>
        
        
            
    </body>
</html>

