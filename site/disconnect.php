<?php
    //remove PHPSESSID from browser
    if ( isset( $_COOKIE[session_name()] ) )
    setcookie( session_name(), “”, time()-3600, “/” );
    //clear session from globals
    $_SESSION = array();
    session_unset();
    //clear session from disk
    session_destroy();
    echo "test";
    echo $_SESSION["pseudo_user"];
    echo "fin";
?>
