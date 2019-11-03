<?php
	require ("DB.inc.php");
	include "fctAux.inc.php";

	enTete("affichage flux rss","rss.css","rss_update.js");
	echo "<div>";
		contenu("https://www.ncsc.gov.uk/api/1/services/v1/all-rss-feed.xml");
	echo "</div>";
	pied();


	function contenu($link)
	{
		$db = DB::getInstance();
		if ($db == null)
			echo "Impossible de se connecter &agrave; la base de donn&eacute;es !";
		else
		{
			echo "<h1>Items RSS de la dernière semaine</h1>\n";
			try {
				echo '<table  id="tableItem"></table>';

				// \n<tr>\n";
				// echo "<th>title</th>\n";
				// echo "<th>link</th>\n";
				// echo "<th>pub_date</th>\n";
				// echo "</tr>\n";
				//
				// foreach ($db->getRSSItem($link) as $item)
				// {
				// 	echo "<tr>\n";
				// 	echo "<td>".$item->getTitle()."</td>\n";
				// 	echo "<td>".$item->getLink()."</td>\n";
				// 	echo "<td>".$item->getPubDate()."</td>\n";
				// 	echo "</tr>\n";
				// }

				echo json_encode($db->getRSSItem($link));
			} //fin try
			catch (Exception $e) {
				  echo $e->getMessage();
			}
			$db->close();
		}
	}
?>
