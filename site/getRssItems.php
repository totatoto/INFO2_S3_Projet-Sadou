<?php
    require ("DB.inc.php");

    $db = DB::getInstance();
    if ($db == null)
        echo "Impossible de se connecter &agrave; la base de donn&eacute;es !";
    else
    {
        echo json_encode($db->getRSSItems(json_decode(substr($_GET["link"],1,strlen($_GET["link"])-2))));
    }
?>
