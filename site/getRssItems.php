<?php
    require ("DB.inc.php");

    $db = DB::getInstance();
    if ($db == null)
        echo "Impossible de se connecter &agrave; la base de donn&eacute;es !";
    else
    {
        echo substr($_GET["link"],1,size($_GET["link"])-1);//json_encode($db->getRSSItems());
    }
?>
