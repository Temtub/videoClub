<?php

    session_start();
    
    // Destroy the session
    $_SESSION = array();
    session_destroy();
    
    // Delete the cookies
    setcookie(session_name(),"", time()-1000,"/");
    header("Location: ../../public_html/index.php");