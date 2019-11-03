<?php
    require ("DB.inc.php");

    $db = DB::getInstance();
    if ($db == null)
        echo "Impossible de se connecter &agrave; la base de donn&eacute;es !";
    else
    {
        foreach ($db->getRSSItem($_GET["link"]) as $item)
        {
        	echo "<tr>\n";
        	echo "<td>".$item->getTitle()."</td>\n";
        	echo "<td>".$item->getLink()."</td>\n";
        	echo "<td>".$item->getPubDate()."</td>\n";
        	echo "</tr>\n";
        }
        //echo json_encode($db->getRSSItem($_GET["link"]));
    }
?>
