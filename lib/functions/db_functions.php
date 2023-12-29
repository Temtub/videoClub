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

/**
 * Function to delete all the actors from a movie</p>
 * @global PDO $db <p>The BD of the program</p>
 * @param Integer $movieId <p>The id of the movie to delete the actors</p>
 */
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

/**
 * Creates a new movie entry in the database with the given details
 * @global PDO $db
 * @param string $titulo <p>The title of the movie.</p>
 * @param string $genero <p>The genre of the movie.</p>
 * @param string $pais <p>The country of origin of the movie.</p>
 * @param int $anyo <p>The release year of the movie.</p>
 * @param string $cartel <p>The URL or path to the movie poster image.</p>
 */
function createMovie($titulo, $genero, $pais, $anyo, $cartel) {
    // Open the database connection
    global $db;
    db_connect();

    // Prepare SQL statement to create the movie in the database
    $createMovieStatement = $db->prepare("INSERT INTO `peliculas` (`titulo`, `genero`, `pais`, `anyo`, `cartel`) VALUES (?, ?, ?, ?, ?)");

    // Trim input values
    $titulo = trim($titulo);
    $genero = trim($genero);
    $pais = trim($pais);
    $anyo = trim($anyo);
    $cartel = trim($cartel);

    // Bind parameters to the prepared statement
    $createMovieStatement->bindParam(1, $titulo);
    $createMovieStatement->bindParam(2, $genero);
    $createMovieStatement->bindParam(3, $pais);
    $createMovieStatement->bindParam(4, $anyo);
    $createMovieStatement->bindParam(5, $cartel);

    // Execute the prepared statement
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

/**
 * Updates an existing movie entry in the database with the given details.
 *
 * This function modifies the information of an existing movie in the 'peliculas' table of the database,
 * including its title, genre, country of origin, release year, and the URL or path to the movie poster image.
 *
 * @global PDO $db <p>The global PDO database connection object.</p>
 * @param int $id <p>The unique identifier of the movie to be updated.</p>
 * @param string $titulo <p>The updated title of the movie.</p>
 * @param string $genero <p>The updated genre of the movie.</p>
 * @param string $pais <p>The updated country of origin of the movie.</p>
 * @param int $anyo <p>The updated release year of the movie.</p>
 * @param string $cartel <p>The updated URL or path to the movie poster image.</p>
 *
 * @return void <p>This function redirects to the updateMoviePage.php page with a success or error message.</p>
 */
function updateMovie($id, $titulo, $genero, $pais, $anyo, $cartel) {
    // Open the database connection
    global $db;
    db_connect();

    // Prepare SQL statement to update the movie in the database
    $updateMovieStatement = $db->prepare("UPDATE `peliculas` SET `titulo` = ?, `genero` = ?, `pais` = ?, `anyo` = ?, `cartel` = ? WHERE `peliculas`.`id` = ?");

    // Trim input values
    $id = trim($id);
    $titulo = trim($titulo);
    $genero = trim($genero);
    $pais = trim($pais);
    $anyo = trim($anyo);
    $cartel = trim($cartel);

    // Bind parameters to the prepared statement
    $updateMovieStatement->bindParam(1, $titulo);
    $updateMovieStatement->bindParam(2, $genero);
    $updateMovieStatement->bindParam(3, $pais);
    $updateMovieStatement->bindParam(4, $anyo);
    $updateMovieStatement->bindParam(5, $cartel);
    $updateMovieStatement->bindParam(6, $id);
    
    // Execute the prepared statement
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





