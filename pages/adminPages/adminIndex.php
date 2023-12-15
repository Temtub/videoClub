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
        
        <h1>Bienvenido <?= $user->getUsername()?></h1>
        
        <?php 
        $arrayMovies =[];
        
        $errorBd=false;
        
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
        
        if(isset($errorBd) && $errorBd===false){
            
            try {
                //Bring all the movies
                $sqlMovieLists = getMoviesList();

            } catch (Exception $ex) {
                header('Location: '.$_SERVER['PHP_SERVER'].'?errorList=true');
            }

            try {
                //For each movie from the sql statement that we made before
                foreach ($sqlMovieLists as $movie){
                    
                    //Create a Pelicula object and save it in the variable $movieObj
                    $movieObj = new Pelicula($movie['id'], $movie['titulo'], $movie['genero'], $movie['pais'], $movie['anyo'], $movie['cartel']);
                    
                    //Save the variable in the array of movies
                    array_push($arrayMovies, $movieObj);
                    
                    //Search the actors from the specified movie movie
                    $actorsFromMovie = getActorsFromMovie($movieObj);
                    
                    //For each actor that we brought
                    foreach ($actorsFromMovie as $actor){
                        
                        //Create an Actor object 
                        $actorObj = new Actor($actor['id'], $actor['nombres'], $actor['apellidos'], $actor['fotografia']);
                        
                        //Save the object in the array
                        $movie->addActorReparto($actorObj);
                    }
                    
                }
            } catch (Exception $ex) {
                header('Location: '.$_SERVER['PHP_SERVER'].'?errorListA=true');
            }
        }//end if 
        ?>
        
    </body>
</html>
