<?php
	include "fctAux.inc.php";
	

    $db = DB::getInstance();
    if ($db == null)
        echo "Impossible de se connecter &agrave; la base de donn&eacute;es !";
    else
    {
		if (isset($_GET["linksCategs"]))
			echo json_encode($db->getRSSItems(json_decode($_GET["linksCategs"])));
		else if (isset($_GET["numPage"]))
			echo json_encode(getLinksCategsOfPage($numPage));
    }
?>
