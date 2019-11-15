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
			echo "test";
			echo $_SESSION['pseudo_user'];
			echo $_SESSION['password_user'];
			echo $_SESSION['admin'];
			echo "aaa";
			echo isConnected(true);
			echo "b";
			echo isConnected(false);
			echo "c";
    		if (isConnected(true))
			{
				echo "d";
			}
    		if (isConnected(false))
			{
				echo "e";
			}

    		if (isConnected(true))
			{
				//if ($_POST['oldLink'] != $_POST['newLink'])
				echo "MMM";
				echo getTheFluxRss($_GET['newLink']);
				echo "LOL".getTheFluxRss($_GET['newLink']);
				//updateFluxRss($_POST['oldLink'],$_POST['newLink']);
			}
		}
	}


?>
