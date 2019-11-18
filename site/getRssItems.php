<?php
    require ("DB.inc.php");

    $db = DB::getInstance();
    if ($db == null)
        echo "Impossible de se connecter &agrave; la base de donn&eacute;es !";
    else
    {
		if (isset($_GET["link"]))
			echo json_encode($db->getRSSItem($_GET["link"]));
		else
			echo json_encode($db->getRSSItems(explode(",",$_GET["links"])));
    }
?>
