<?php

/**
 * Checks if the user is an admin or a normal user
 * 
 * @param Integer $rol <p>the rol to check</p>
 * @return bool <p> if the rol is 1 returns true elses return false</p>
 */
function check_rolAdmin($rol){
    if($rol===1){
        return true;
    }
    else{
        return false;
    }
}

/**
 * Function to check if the user and the password are filled
 * 
 * @param type $userCheck
 * @param type $passCheck
 * @return bool
 */
function checkUserAndPasFilled($userCheck, $passCheck){
    if($userCheck || $passCheck){
        return true;
    }
    else{
        return false;
    }
}

/**********************************GENERATE THE CARDS*************************/

/**
 * Function to show in cards the movies of the array 
 * @param Array $arrayMovies <p>Array of the movies tou want to show</p>
 * @param Integer $admin <p>Integer to show or not the buttons of the admin</p>
 */
function showMovies($arrayMovies, $admin=0) {
    foreach ($arrayMovies as $movie) {
        echo '<div class="card" style="width: 18rem;">';
        echo generateCardHeader($movie);
        echo generateCardBody($movie, $admin);
        echo generateCardFooter($movie);
        echo '</div>';
    }
}

/**
 * Generate the header of the card
 * @param Class Pelicula $movie <p>An object of class Pelicula</p>
 * @return String <p>A string of an HTML card</p>
 */
function generateCardHeader($movie) {
    
    $movieSrc = '../../lib/assets/images/carteleras/noImage.jpg';
    
    if($movie->getCartel() !== NULL || !empty($movie->getCartel() )){
        
        $movieSrc = '../../lib/assets/images/carteleras/'.$movie->getCartel();
    }
    $header = '<img src="'.$movieSrc.'" class="card-img-top" alt="...">';
    return '<div class="card-header">' . $header . '</div>';
}

/**
 * Generate the body of the card 
 * @param Class Pelicula $movie <p>MOvie that we will create the body of</p>
 * @param Integer $admin <p>Integer that will show the buttons of the admin on Integer 1 or on empty it will show nothing</p>
 * @return String <p>Body of the card</p>
 */
function generateCardBody($movie, $admin=0) {
    $body = '<h5 class="card-title card__title">'.$movie->getTitulo().'</h5>';
    $body .= '<p class="card-text">'.$movie->getGenero().'</p>';
    $body .= generateActorSelect($movie->getReparto());
    if($admin === 1){
        $body .= generateCardButtons($movie);
    }
    
    return '<div class="card-body d-flex flex-column justify-content-between">' . $body . '</div>';
}

/**
 * Generate the select of actors
 * @param Array $actors <p>Array of actors of the movie</p>
 * @return String <p>A select of actors that belong to the movie</p>
 */
function generateActorSelect($actors) {
    $options = '';
    foreach ($actors as $actor) {
        $options .= '<option>'.$actor->getNombre().'</option>';
    }
    return '<select>' . $options . '</select>';
}

/**
 * Generate the buttons of the admin
 * @return String <p>Buttons of the card</p>
 */
function generateCardButtons($movie) {
    $serializedPelicula = serialize($movie);

    $buttons = '<div class="d-flex flex-row justify-content-between">';
    
    // Delete Button with Confirmation Modal Trigger
    $buttons .= '<button type="button" class="modifyButton" data-bs-toggle="modal" data-bs-target="#deleteConfirmation' . $movie->getId() . '"><i class="fa-solid fa-trash"></i> Eliminar</button>';
    
    // Edit Button
    $buttons .= '<a class="modifyButton modifyButton--edit" href="../../pages/adminPages/updateMoviePage.php?id='.$movie->getId().'&titulo='.$movie->getTitulo().'&genero='.$movie->getGenero().'&pais='.$movie->getPais().'&anyo='.$movie->getAnyo().'&cartel='.$movie->getCartel().'"><i class="fa-solid fa-pencil"></i>Editar</a>';
    
    // Delete Confirmation Modal
    $buttons .= 
         '<div class="modal fade" id="deleteConfirmation' . $movie->getId() . '" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">¿Seguro que quieres eliminar el hilo?</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Vas a eliminar el hilo con título "' . $movie->getTitulo() . '".</p>
                        <p>¿Seguro?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <a href="../../lib/controllers/adminController/deleteMovie.php?id=' . $movie->getId() . '" class="btn btn-danger">Eliminar</a>
                    </div>
                </div>
            </div>
        </div>';
    
    $buttons .= '</div>';
    return $buttons;
}





/**
 * Generate the footer of the card
 * @param Class Pelicula $movie <p>MOvie that we will create the body of</p>
 * @return String <p>Footer of the card</p>
 */
function generateCardFooter($movie) {
    $footer = '<p>'.$movie->getPais().'</p>';
    $footer .= '<p>'.$movie->getAnyo().'</p>';
    return '<div class="card-footer d-flex flex-row justify-content-between">' . $footer . '</div>';
}

/**********************************END GENERATE THE CARDS*************************/


