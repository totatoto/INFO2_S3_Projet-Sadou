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
				if (isset($_GET['oldUsername']) && (isset($_GET['newUsername']) || isset($_GET['newPassword']) || isset($_GET['newStatus'])))
				{
					if ( ($db->getAccount($_GET['oldUsername']) == null) ||
								//(isset($_GET['newUsername']) && ($db->getAccount($_GET['newUsername']) != null)) ||
								(isset($_GET['newStatus']) && $_GET['newStatus'] != "ADMIN" && $_GET['newStatus'] != "USER")
						)
					{
							echo "invalide Parametre";
					}
					else
					{
						if (isset($_GET['newPassword']))
						{
							$salt = generateSalt();
							$db->updateAccount($_GET['oldUsername'],$_GET['newUsername'],myHash($_GET['newPassword'],$salt),$salt,$_GET['newStatus']);
						}
						else
							$db->updateAccount($_GET['oldUsername'],$_GET['newUsername'],null,null,$_GET['newStatus']);
						echo "done";
					}
				}
				else if (isset($_GET['username']) && (isset($_GET['newPassword'])))
				{
					if ($db->getAccount($_GET['username']) == null)
					{
							echo "username not valide";
					}
					else
					{
						$salt = generateSalt();
						$db->updateAccountPassword($_GET['username'],myHash($_GET['newPassword'],$salt),$salt);
						echo "done";
					}
				}
				else if (isset($_GET['deleteUsername']))
				{
					if (($db->getAccount($_GET['deleteUsername']) != null))
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
					if (($db->getAccount($_GET['insertUsername']) != null) || ($_GET['insertStatus'] != "ADMIN" && $_GET['insertStatus'] != "USER") )
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
