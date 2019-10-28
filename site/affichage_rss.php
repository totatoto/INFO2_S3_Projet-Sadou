<?php
	
require 'DB.inc.php';

$db = DB->getInstance();

echo $db->getRSSItem("https://www.ncsc.gov.uk/api/1/services/v1/all-rss-feed.xml");

?>
