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
				if (isset($db->getTheFluxRss($_GET['newLink'])))
				{
					echo "erreur";
				}
				else
				{
					updateFluxRss($_POST['oldLink'],$_POST['newLink']);
					echo "done";
				}
			}
		}
	}


?>
