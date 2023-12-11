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

