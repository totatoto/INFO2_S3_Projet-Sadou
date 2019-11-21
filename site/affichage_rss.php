<?php
	include "fctAux.inc.php";

	enTete("affichage flux rss","Style.css",["rss_update.js","JS.js"],"images/vignette.png");
	//contenu(getLinksOfFluxRss());
	contenu( array('https://www.datasecuritybreach.fr/feed/' => ['chiffrement','Android'],'https://www.silicon.fr/feed' => ['android','Logiciels','Big Data']));
	pied();


	function contenu($linksCategs)
	{
		$db = DB::getInstance();
		if ($db == null)
			echo "Impossible de se connecter &agrave; la base de donn&eacute;es !";
		else
		{
    		echo '<div class="slideshow-container" linksCategs='."'".json_encode($linksCategs)."'".' id="conteneurItem">';
			//echo "<h1>Items RSS de la dernière semaine</h1>\n";
			//try {
			//	echo '<table link="https://www.ncsc.gov.uk/api/1/services/v1/all-rss-feed.xml" id="tableItem"></table>';
			//} //fin try
			//catch (Exception $e) {
			//	  echo $e->getMessage();
			//}
			$db->close();
    		echo '</div>';
		}
	}
?>
