<?php
	
require 'DB.inv.php';

$db = DB->getInstance();

$db->getRSSItem("https://www.ncsc.gov.uk/api/1/services/v1/all-rss-feed.xml");

?>