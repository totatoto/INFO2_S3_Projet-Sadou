<?php
    require ("DB.inc.php");

    $db = DB::getInstance();
    if ($db == null)
        echo "Impossible de se connecter &agrave; la base de donn&eacute;es !";
    else
    {
		if (isset($_GET["linksCategs"]))
			echo json_encode($db->getRSSItems(json_decode($_GET["linksCategs"])));
    }
?>
