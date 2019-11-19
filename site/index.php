<?php
require ("DB.inc.php");
require ("fctAux.inc.php");

echo '<html>';
    echo '<head>';
        echo '<meta charset="utf-8" />';
        echo '<title>Notre site web</title>';
    echo '</head>';
    echo '<body>';
        echo '<div>';
           echo '<h1>CYBERNEWS</h1>';
       echo '</div>';
       echo '<div>';
            echo 'Des informations ici';
			echo pg_escape_string(test_input($_GET['test']));
        echo '</div>';
    echo '</body>';
echo '</html>';
?>