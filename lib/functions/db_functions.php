<?php

/*************************** FUNCTIONS CONNECTION DB ******************************/

$db = null;

/**
 * Create the connection to the database
 * 
 * @global PDO $db Connection to the database
 */
function db_connect() {
    
    global $db;
    
    $conn_string = "mysql:dbname=videoclubonline;host=127.0.0.1";
    $user_db = "root";
    $key = "";

    try {
        $db = new PDO($conn_string, $user_db, $key);

    } catch (Exception $e) {
        echo "Error en la conexión con la base de datos" . $e->getMessage();
    }
}

/**
 * Close the connection to the database
 * 
 * @global PDO $db Connection to the data base
 */
function db_disconnect() {
    global $db;
    $db = null;
}

/************************************************ CHECK IN DB ****************************/
/**
 * Get user data from the database based on the provided username
 *
 * @param string $username The username to retrieve data for
 * @return array|false An array containing user data if the user is found, false otherwise
 */
function getUserData($username) {
    global $db;

    try {
        $login_sql = $db->prepare("SELECT id, username, password, rol FROM usuarios WHERE username = ?");
        $login_sql->bindParam(1, $username);
        $login_sql->execute();

        return $login_sql->fetch();
    } catch (Exception $e) {
        
        handleException($e);
        return false;
    }
}

/**
 * Function to select all the movies from the BD
 * @global PDO $db <p>BD of the program</p>
 * @return bool <p>List of the movies of the bd when on true or false on error</p>
 */
function getMoviesList(){
    global $db;
    
    try {
        //Prepare the statement to select all the movies from the BD
        $sqlMoviesList = $db->prepare("SELECT id, titulo, genero, pais, anyo, cartel FROM `peliculas`");
        //execute the selection
        $sqlMoviesList->execute();   
        
    } catch (Exception $ex) {
        echo 'Error en consulta select pelúclas'.$ex->getMessage();
        $sqlMoviesList = false;
    }
    
    return $sqlMoviesList;
}
 

/**
 * Search the actors that works on a specific movie
 * @global PDO $db <p>The BD of the program </p>
 * @param Pelicula $movie <p>Object type Pelicula that will search his actors</p>
 * @return bool <p>returns a list of the actors that work in a movie on true or flase on error 
 */
function getActorsFromMovie($movie){
    
    global $db;
    
    try {
        //Prepare the statement to select all the movies
        $sqlMoviesList = $db->prepare("SELECT actores.id, nombre, apellidos, fotografia FROM `actores` JOIN actuan ON actores.id = actuan.idActor JOIN peliculas ON actuan.idPelicula = peliculas.id WHERE peliculas.id = ?");
        
        //Save the id of the movie
        $idMovie = $movie->getId();
        
        //Bind the param id of the movie we want to search actors of
        $sqlMoviesList ->bindParam(1, $idMovie);
        $sqlMoviesList->execute();
        
    } catch (Exception $ex) {
        echo 'Error en consulta select pelúclas'.$ex->getMessage();
        $sqlMoviesList = false;
    }
    
    return $sqlMoviesList;  
}

/*******************DELETE FUNCTIONS***************************/

function deleteMovie($movieId){
    
    //Open the connection
    global $db;
    db_connect();

    //Prepare the statement for deleting
    $deleteMovie= $db->prepare("DELETE FROM peliculas WHERE id =?");
    
    $deleteMovie->bindParam(1, $movieId );
    
    //If the delete goes well it returns you with vraible correct
    if($deleteMovie->execute() ){
        //header('Location: ../../../pages/adminPages/adminIndex.php?del');
    }
    else{
        //header('Location: ../../../pages/adminPages/adminIndex.php?err');
    }
}

function deleteActuan($movieId){
    
    //Open the connection
    global $db;
    db_connect();

    //Prepare the statement for deleting
    $deleteMovie= $db->prepare("DELETE actuan FROM actuan WHERE actuan.idPelicula =?");
    
    $deleteMovie->bindParam(1, $movieId );
    
    //If the delete goes well it returns you with vraible correct
    if($deleteMovie->execute() ){
        //header('Location: ../../../pages/adminPages/adminIndex.php?del');
    }
    else{
        //header('Location: ../../../pages/adminPages/adminIndex.php?err');
    }
}

function deleteActores($movieId){
    
    //Open the connection
    global $db;
    db_connect();

    //Prepare the statement for deleting
    $deleteMovie= $db->prepare("DELETE actores FROM actores JOIN actuan ON actores.id = actuan.idActor WHERE actuan.idPelicula =?");
    
    $deleteMovie->bindParam(1, $movieId );
    
    //If the delete goes well it returns you with vraible correct
    if($deleteMovie->execute() ){
        //header('Location: ../../../pages/adminPages/adminIndex.php?del');
    }
    else{
        //header('Location: ../../../pages/adminPages/adminIndex.php?err');
    }
}
/*******************END DELETE FUNCTIONS***************************/




/******************CREATE FUNCTIONS**************************/

function createMovie($titulo, $genero, $pais, $anyo, $cartel) {
    // Open the connection
    global $db;
    db_connect();

    // Statements to create the movie in the database
    $createMovieStatement = $db->prepare("INSERT INTO `peliculas` (`titulo`, `genero`, `pais`, `anyo`, `cartel`) VALUES (?, ?, ?, ?, ?)");

    // Trim values
    $titulo = trim($titulo);
    $genero = trim($genero);
    $pais = trim($pais);
    $anyo = trim($anyo);
    $cartel = trim($cartel);

    // Bind parameters
    $createMovieStatement->bindParam(1, $titulo);
    $createMovieStatement->bindParam(2, $genero);
    $createMovieStatement->bindParam(3, $pais);
    $createMovieStatement->bindParam(4, $anyo);
    $createMovieStatement->bindParam(5, $cartel);

    // Execute the statement
    if ($createMovieStatement->execute()) {
        // Redirect on success
        header('Location: ../../../pages/adminPages/createMoviePage.php?corr');
        exit();
    } else {
        // Redirect on failure
        header('Location: ../../../pages/adminPages/createMoviePage.php?err');
        exit();
    }
}

/******************END CREATE FUNCTIONS**************************/





/******************UPDATE FUNCTIONS**************************/

function updateMovie($id, $titulo, $genero, $pais, $anyo, $cartel){
    // Open the connection
    global $db;
    db_connect();

    // Statements to create the movie in the database
    $updateMovieStatement = $db->prepare("UPDATE `peliculas` SET `titulo` = ?, `genero` = ?, `pais` = ?, `anyo` = ?, `cartel` = ? WHERE `peliculas`.`id` = ?");

    // Trim values
    $id = trim($id);
    $titulo = trim($titulo);
    $genero = trim($genero);
    $pais = trim($pais);
    $anyo = trim($anyo);
    $cartel = trim($cartel);

    // Bind parameters
    $updateMovieStatement->bindParam(1, $titulo);
    $updateMovieStatement->bindParam(2, $genero);
    $updateMovieStatement->bindParam(3, $pais);
    $updateMovieStatement->bindParam(4, $anyo);
    $updateMovieStatement->bindParam(5, $cartel);
    $updateMovieStatement->bindParam(6, $id);
    
    // Execute the statement
    if ($updateMovieStatement->execute()) {
        // Redirect on success
        header('Location: ../../../pages/adminPages/updateMoviePage.php?corr');
        exit();
    } else {
        // Redirect on failure
        header('Location: ../../../pages/adminPages/updateMoviePage.php?err');
        exit();
    }
}
/******************END UPDATE FUNCTIONS**************************/




/**************NECESSARY FUNCTIONS **********************/

/**
 * Handle exceptions related to database queries
 *
 * @param Exception $exception The exception object
 */
function handleException($exception) {
    echo "Error en la consulta a la base de datos: " . $exception->getMessage();
}

/**
 * Perform login check for the username and password
 *
 * @param string $inputUser The input username
 * @param string $inputKey The input password
 * @return array|bool An array containing user information if login is successful, or false
 */
function login_check($inputUser, $inputKey) {
    $userInfo = [];
    
    //Info of the data
    $userData = getUserData($inputUser);

    if (!$userData) {
        return false;
    }

    //Verify the password
    if (verifyUserPassword($inputKey, $userData['password']) ){//Correct save the user info in the array userinfo
        
        $userInfo = array(
            'id' => $userData['id'],
            'username' => $userData['username'],
            'rol' => $userData['rol']
        );
    } 
    else {
        return false;
    }

    return $userInfo;
}


/**
 * Verify the user password against the hashed one
 *
 * @param string $inputPassword The input password
 * @param string $hashedPassword The hashed password stored in the database
 * @return bool True if the password is valid, else returns false 
 */
function verifyUserPassword($inputPassword, $hashedPassword) {
    return password_verify($inputPassword, $hashedPassword);
}





