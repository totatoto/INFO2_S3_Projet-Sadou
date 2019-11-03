<?php
    require ("DB.inc.php");

    $db = DB::getInstance();
    if ($db == null)
        echo "Impossible de se connecter &agrave; la base de donn&eacute;es !";
    else
    {
        echo json_encode(substr ($_GET["link"],10));//"{link="++", items=" + $db->getRSSItem($_GET["link"]) + "}");
    }
?>
