<?php
    require ("DB.inc.php");

    $db = DB::getInstance();
    if ($db == null)
        echo "Impossible de se connecter &agrave; la base de donn&eacute;es !";
    else
    {
<<<<<<< HEAD
        echo json_encode($db->getRSSItems($_GET["link"]));
=======
        echo json_encode($db->getRSSItems($_GET["links"]));
>>>>>>> 7da42cf740d58bb5ead0636c8013ffb798b3af4c
    }
?>
