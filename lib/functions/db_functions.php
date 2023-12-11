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
 * Handle exceptions related to database queries
 *
 * @param Exception $exception The exception object
 */
function handleException($exception) {
    echo "Error en la consulta a la base de datos: " . $exception->getMessage();
}

/**
 * Perform login check for the provided username and password
 *
 * @param string $inputUser The input username
 * @param string $inputKey The input password
 * @return array|string An array containing user information if login is successful, or an error message otherwise
 */
function login_check($inputUser, $inputKey) {
    $userInfo = [];
    
    //Info of the data
    $userData = getUserData($inputUser);

    if (!$userData) {
        return "User not found";
    }

    if (verifyUserPassword($inputKey, $userData['password'])) {
        array_push($userInfo, $userData['id'], $userData['username'], $userData['rol']);
    } else {
        return "Invalid password";
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





