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

