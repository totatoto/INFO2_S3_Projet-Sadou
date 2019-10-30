<?php
	require ("DB.inc.php");
	include "fctAux.inc.php";
	include('../lib/full/qrlib.php');

	enTete();
	contenu();
	pied();


	function contenu()
	{
		$db = DB::getInstance();
		if ($db == null)
			echo "Impossible de se connecter &agrave; la base de donn&eacute;es !";
		else
		{
			echo "<h1>Items RSS de la dernière semaine</h1>\n";

    		// outputs image directly into browser, as PNG stream
    		QRcode::png('PHP QR Code :)');

			try {
				echo "<table>\n<tr>\n";
				echo "<th>id</th>\n";
				echo "<th>title</th>\n";
				echo "<th>link</th>\n";
				echo "<th>pub_date</th>\n";
				echo "<th>importance</th>\n";
				echo "</tr>\n";
				foreach ($db->getRSSItem("http://feeds.feedburner.com/phoenixjp/") as $item)
				{
					echo "<tr>\n";
					echo "<td>".$item->getId()."</td>\n";
					echo "<td>".$item->getTitle()."</td>\n";
					echo "<td>".$item->getLink()."</td>\n";
					echo "<td>".$item->getPubDate()."</td>\n";
					echo "<td>".$item->getImportance()."</td>\n";
					echo "</tr>\n";
				}
				echo "</table>";
			} //fin try
			catch (Exception $e) {
				  echo $e->getMessage();
			}
			$db->close();
		}
	}
?>
