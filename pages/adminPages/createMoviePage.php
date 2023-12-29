
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
<html>
    <head>
        <meta charset="UTF-8">
        <title>Video club</title>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="../../css/styles.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    </head>
    
    <body>
        
        <?php
        
        if(isset($_GET['redir']) ){
            echo 'Rellena todos los datos';
        }
        if(isset($_GET['corr']) ){
            echo 'creado correctamente';
        }
        if(isset($_GET['err']) ){
            echo 'ha habido un error en la creacion';
        }
        
        ?>
        <h1>Bienvenido <?= $user->getUsername()?></h1>
        
        <form action="../../lib/controllers/adminController/createMovie.php" method="POST">
            
            <label>Titulo</label>
            <input type="text" name="titulo" value=" <?php if(isset($_GET['titulo']) ){echo $_GET['titulo'];}?>">
            
            <label>Genero</label>
            <input type="text" name="genero" value=" <?php if(isset($_GET['genero']) ){echo $_GET['genero'];}?>">
            
            <label>Pais</label>
            <input type="text" name="pais" value=" <?php if(isset($_GET['pais']) ){echo $_GET['pais'];}?>">
            
            <?php
            $anyoInt = 0;
            
            if (isset($_GET['anyo']) && is_numeric($_GET['anyo'])) {
                $anyoInt = (int)$_GET['anyo'];
            }
            ?>

            <label>Año</label>
            <input type="number" name="anyo" value="<?php echo is_numeric($anyoInt) ? $anyoInt : ''; ?>">
            
            <label>Cartel</label>
            <input type="text" name="cartel" value=" <?php if(isset($_GET['cartel']) ){echo $_GET['cartel'];}?>">
            
            <input type="submit" name="submit">
        </form>
        
        
        
        
            
    </body>
</html>