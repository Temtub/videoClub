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
    
    if($user->getRol() !== 1){
        header("Location: ../../index.php?redirected=true");
    }
    
    updateLastLoginTime();
    
    
    
    
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
        
        if(isset($_GET['err']) ){
            echo '<div class="message message-error"><p class="message__text">Ha habido un error con la eliminación.</p></div>';
        }
        if(isset($_GET['deleted']) ){
            echo '<div class="message message-correct"><p class="message__text">Se ha eliminado la película correctamente.</p></div>';
        }


        
        if(isset($_COOKIE['last_login_time'])) {
            // Obtener y mostrar el valor de la cookie
            $last_login_time = $_COOKIE['last_login_time'];
            echo '<div class="message message--big message-informative"><p class="message__text">Última hora de inicio de sesión fue el: <span class="message__hora">' . date("d", $last_login_time) . '</span> del <span class="message__hora">' . date("m", $last_login_time) . '</span> a las <span class="message__hora">' . date("H:i", $last_login_time).'</span></p></div>';
            
        } else {
            echo '<div class="message message--big message-informative"><p class="message__text">Hola '.$user->getUsername().' es tu primera conexión desde hace una semana.</p></div>';

        }
        ?>
        
        <!-- Code for geting the movies -->
        <?php 
        
        //Inicialize the variables
        $arrayMovies =[];//array to save all the movies
        $errorBd=false;
        
        
        //Check if theres any error in the procces of getting the movies
        if(isset($_GET['errorList']) ){
            echo 'Error en listado';
            $errorBd=true;
        }
        if(isset($_GET['errorListA']) ){
            echo 'Error en listado';
            $errorBd=true;
        }
        
        
        //Conect to the db
        global $db;
        db_connect();
        
        //Check if there have been any error
        if(isset($errorBd) && $errorBd===false){//if theres havent been any error select the movies
            
            try {
                //Bring all the movies from the BD
                $sqlMovieLists = getMoviesList();
            } catch (Exception $ex) {
                header('Location: '.$_SERVER['PHP_SERVER'].'?errorList=true');
            }

            try {
                //For each movie from the sql statement of the movies we create an object Pelicula
                foreach ($sqlMovieLists as $movie){
                    
                    //Create a Pelicula object and save it in the variable $movieObj
                    $movieObj = new Pelicula($movie['id'], $movie['titulo'], $movie['genero'], $movie['pais'], $movie['anyo'], $movie['cartel']);
                    
                    //Save the variable in the array of movies
                    array_push($arrayMovies, $movieObj);
                    
                    //Now search the actors from the specified movie 
                    $actorsFromMovie = getActorsFromMovie($movieObj);
                    
                    //For each actor that we brought
                    foreach ($actorsFromMovie as $actor){
                        
                        //Create an Actor object 
                        $actorObj = new Actor($actor['id'], $actor['nombre'], $actor['apellidos'], $actor['fotografia']);
                        
                        //Save the object in the array of the movie
                        $movieObj->addActorReparto($actorObj);
                    }
                    
                }
            } catch (Exception $ex) {
                header('Location: '.$_SERVER['PHP_SERVER'].'?errorListA=true');
            }
            
            //Create the section where the movies will display a list of movies
            echo '<section class="allCards d-flex flex-row flex-wrap justify-content-around">';
            
        ?>
        
        <a class="card cardPlus d-flex justify-content-center align-items-center" href="../adminPages/createMoviePage.php">
            
            <div class="d-flex justify-content-center align-items-center">
                <p class="card__plus">+</p>
            </div>
        </a>
        <?php
            showMovies($arrayMovies, 1);
            
            echo '</section>';
        }//end if 

        ?>  
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        </div>
    </body>
</html>
