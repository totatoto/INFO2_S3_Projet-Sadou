<?php
	require("../DB.inc.php");
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
				if (isset($_GET['oldLink']) && isset($_GET['newLink']))
				{
					if (sizeof($db->getTheFluxRss($_GET['newLink'])) != 0 || sizeof($db->getTheFluxRss($_GET['oldLink'])) == 0)
					{
						echo "newLink or oldLink not valide";
					}
					else
					{
						$db->updateFluxRss($_GET['oldLink'],$_GET['newLink']);
						echo "done";
					}
				}
				else if (isset($_GET['deleteLink']))
				{
					if (sizeof($db->getTheFluxRss($_GET['deleteLink'])) != 0)
					{
						$db->deleteFluxRss($_GET['deleteLink']);
						echo "done";
					}
					else
					{
						echo "link to delete not valide";
					}
				}
				else if (isset($_GET['insertLink']))
				{
					if (sizeof($db->getTheFluxRss($_GET['insertLink'])) != 0)
					{
						echo "link to insert not valide";
					}
					else
					{
						$db->insertFluxRss($_GET['insertLink']);
						echo "done";
					}
				}
				else
				{
					echo "not parametre";
				}
			}
		}
	}


?>
