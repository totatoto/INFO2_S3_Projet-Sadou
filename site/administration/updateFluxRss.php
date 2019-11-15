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
						echo "erreur";
					}
					else
					{
						$db->updateFluxRss($_GET['oldLink'],$_GET['newLink']);
						echo "done";
					}
				}
				else
				{
					echo "erreur2";
				}
			}
		}
	}


?>
