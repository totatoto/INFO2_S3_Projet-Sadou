<?php 
	require ("DB.inc.php");

	$db = DB::getInstance();

	foreach ($db->getRSSItem("https://www.ncsc.gov.uk/api/1/services/v1/all-rss-feed.xml") as $item)
				{
					echo "<tr>\n";
					echo "<td>".$item->getId()."</td>\n";
					echo "<td>".$item->getTitle()."</td>\n";
					echo "<td>".$item->getLink()."</td>\n";
					echo "</tr>\n";
				}
?>