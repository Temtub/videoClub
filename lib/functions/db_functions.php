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
function login_check($inputUser, $inputKey) {
    global $db;
    $userInfo=[];

    
    try{
        //Prepared statement to select a user
        $login_sql=$db->prepare("SELECT id, username, password, rol FROM usuarios WHERE username = ?;");
        
        //Bind the param for the sql 
        $login_sql->bindParam(1, $inputUser);
        
        //Execute the query
        $login_sql->execute();
        
        //Extract the data from the select
        $selectData = $login_sql->fetch();
     
        if(password_verify(password_hash($inputKey, PASSWORD_DEFAULT), $selectData[3] ) ){
            //Push the id
            array_push($userInfo, $selectData[0]);
            
            //Push the username
            array_push($userInfo, $selectData[1]);
            
            //Push the pass
            array_push($userInfo, $selectData[2]);
            
            //Push the rol
            array_push($userInfo, $selectData[3]);
        } 
        else {
            $userInfo= "error en selecData";
        }
    } catch (Exception $e) {
        echo "Error en la consulta a la base de datos: " . $e->getMessage();
        $userInfo= "error catch";
    }
    
    return $userInfo;
} 


