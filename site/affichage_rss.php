<?php
	include "fctAux.inc.php";

	enTete("affichage flux rss","Style.css",["rss_update.js","JS.js"],"images/vignette.png");
	//contenu(getLinksOfFluxRss());
	contenu($_GET['numPage']);//array('https://www.datasecuritybreach.fr/feed/' => ['chiffrement','Android'],'https://www.silicon.fr/feed' => ['android','Logiciels','Big Data'], 'https://www.cert.ssi.gouv.fr/feed/' => null,'https://www.ncsc.gov.uk/api/1/services/v1/all-rss-feed.xml' => null));
	pied();


	function contenu($numPage)
	{
		$db = DB::getInstance();
		if ($db == null)
			echo "Impossible de se connecter &agrave; la base de donn&eacute;es !";
		else
		{
			if (!isset($numPage))
			{
				echo "moi";
				//contenu404();
			}
			else if (!existAffichageRssPage($numPage))
			{
				echo "test";
				//affichageRssPageNotFound($numPage);
			}
			else
			{
				$linksCategs = array();
				$tabLinkCateg = $db->getlinksCategsOfPage($numPage);
				foreach ($tabLinkCateg as $linkCateg)
				{
					if (!array_key_exists($linkCateg->getLinkFluxRss(),$linksCategs))
						$linksCategs[$linkCateg->getLinkFluxRss()] = [];
					$linksCategs[$linkCateg->getLinkFluxRss()][] = $linkCateg->getNameCategory();
				}
				
				print_r($linksCategs);
				//echo '<div class="slideshow-container" linksCategs='."'".json_encode($linksCategs)."'".' id="conteneurItem">';
				//echo '</div>';
			}
    		
			//echo "<h1>Items RSS de la dernière semaine</h1>\n";
			//try {
			//	echo '<table link="https://www.ncsc.gov.uk/api/1/services/v1/all-rss-feed.xml" id="tableItem"></table>';
			//} //fin try
			//catch (Exception $e) {
			//	  echo $e->getMessage();
			//}
			$db->close();
		}
	}
?>
