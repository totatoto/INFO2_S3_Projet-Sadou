<?php
	require ("DB.inc.php");
	include "fctAux.inc.php";

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
			echo 'SELECT * 
                              FROM RSS_ITEM AS A 
                              JOIN ITEM_OF_FLUX_RSS AS B 
                              ON A.id = B.id_rss_item  
                              WHERE B.link_flux_rss = \''.$link.'\' 
                              AND A.pub_date >= (SELECT CURRENT_DATE - 7) 
                              ORDER BY A.importance DESC, A.pub_date DESC
                              LIMIT 50';
							  
			echo 'SELECT * 
                              FROM RSS_ITEM AS A 
                              JOIN ITEM_OF_FLUX_RSS AS B 
                              ON A.id = B.id_rss_item  
                              WHERE B.link_flux_rss = '."'".$link."'".' 
                              AND A.pub_date >= (SELECT CURRENT_DATE - 7) 
                              ORDER BY A.importance DESC, A.pub_date DESC
                              LIMIT 50';
			echo "<h1>Consultation de la table Achat</h1>\n";
			echo $db->getRSSItem("https://www.ncsc.gov.uk/api/1/services/v1/all-rss-feed.xml"
			try {
				echo "<table>\n<tr>\n";
				echo "<th>ncli</th>\n";
				echo "<th>np</th>\n";
				echo "<th>qa</th>\n";
				echo "</tr>\n";
				foreach ($db->getRSSItem("https://www.ncsc.gov.uk/api/1/services/v1/all-rss-feed.xml") as $item)
				{
					echo "<tr>\n";
					echo "<td>".$item->getId()."</td>\n";
					echo "<td>".$item->getTitle()."</td>\n";
					echo "<td>".$item->getLink()."</td>\n";
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
