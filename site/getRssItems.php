<?php
    require ("DB.inc.php");

    $db = DB::getInstance();
    if ($db == null)
        echo "Impossible de se connecter &agrave; la base de donn&eacute;es !";
    else
    {
        echo json_encode($_GET["link"]);//"{link="++", items=" + $db->getRSSItem($_GET["link"]) + "}");
    }
?>
