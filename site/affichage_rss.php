<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Notre site web</title>
    </head>
    <body>
        <div>
			<?php
	
			include 'DB.inc.php';

			$db = DB->getInstance();

			$db->getRSSItem("https://www.ncsc.gov.uk/api/1/services/v1/all-rss-feed.xml");

			?>
            <!-- Insert name or a logo -->
            <h1>CYBERNEWS</h1>
        </div>
        <div>
            Des informations ici
        </div>
        <div>
            Des informations ici
        </div>
        <div>
            Des informations ici
        </div>
        <div>
            Des informations ici
        </div>
        <div>
            Des informations ici
        </div>
    </body>
</html>