<?php
echo $_SESSION["pseudo_user"];
    //clear session from globals
    $_SESSION = array();
    session_unset();
    //clear session from disk
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');
    session_regenerate_id(true);
    echo "test";
    echo $_SESSION["pseudo_user"];
    echo "fin";
?>
