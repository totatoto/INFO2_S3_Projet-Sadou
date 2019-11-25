<?php
	require("../fctAux.inc.php");

	contenu();


	function contenu()
	{
		$db = DB::getInstance();
		if ($db == null)
			echo "Impossible de se connecter &agrave; la base de donn&eacute;es !";
		else
		{
    		if (isConnected(true))
			{
				if (isset($_GET['oldUsername']) && isset($_GET['newUsername']))
				{
					if (($db->getAccount($_GET['newUsername']) !== null) || ($db->getAccount($_GET['oldUsername']) === null))
					{
							echo "new username or old username not valide";
					}
					else
					{
						$db->updateAccount($_GET['oldUsername'],$_GET['newUsername']);
						echo "done";
					}
				}
				else if (isset($_GET['deleteUsername']))
				{
					if (($db->getAccount($_GET['deleteUsername']) !== null))
					{
						$db->deleteAccount($_GET['deleteUsername']);
						echo "done";
					}
					else
					{
						echo "username to delete not valide";
					}
				}
				else if (isset($_GET['insertUsername']) && isset($_GET['insertPassword']) && isset($_GET['insertStatus']))
				{
					if (($db->getTheFluxRss($_GET['insertUsername']) !== null) || ($_GET['insertStatus'] != "ADMIN" && $_GET['insertStatus'] != "USER") )
					{
						echo "account to insert not valide";
					}
					else
					{
						$salt = generateSalt();
						$db->insertAccount($_GET['insertUsername'], myHash($_GET['insertPassword'],$salt), $_GET['insertStatus'], $salt);
						echo "done";
					}
				}
				else
				{
					echo "no parametre";
				}
			}
			else {
				echo "not connected !";
			}
		}
	}


?>
