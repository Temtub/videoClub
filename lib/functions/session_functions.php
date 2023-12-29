<?php

define("EXTENDED", 3600);
define("SHORT", 300);
   
/**
 * Set the cookie of the session duration
 * 
 * @param integer $duration The session duration in seconds
 */
function set_session_option($duration = SHORT){

    setcookie("session_option", $duration , time()+604800 ,"/"); 
}


/**
 * Function to check if the user has been inactive for more than 5 minutes or 1 hour
 * 
 * @param integer $last_activity Last time of activity user  
 *
 */
function updateLastLoginTime() {
    // Obtener la hora actual
    $current_time = time();
    
    $cookieName = "last_login_time";//The cookie name

    $cookieExpirationTime = $current_time + (7 * 24 * 60 * 60); // 1 week

    //Set the cookie with the values
    setcookie($cookieName, $current_time, $cookieExpirationTime, "/");
}




/**
 * Function to check if an string is empty
 * 
 * @param String $data //
 * @return bool //If is empty returns true if not returns false
 */
function isEmpty($data){
    trim($data);
    
    if($data === ""){
        return true;
    }
    else{
        return false;
    }
}

/**
 * Function to check if the select havent been changed
 * 
 * @param type $checkData
 * @return bool //If the check is escoger returns true elses return false
 */
function check_select($checkData){
    if($checkData=="escoger"){
        return true;
    }
    else{
        return false;
    }
}