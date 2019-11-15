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
				if (isset($_GET['oldLink'] && $_GET['newLink'] ))
				{
					if (sizeof($db->getTheFluxRss($_GET['newLink'])) == 0)
					{
						echo "erreur";
					}
					else
					{
						updateFluxRss($_GET['oldLink'],$_GET['newLink']);
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
