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
			session_start();
			if (!isConnected(true))
				if(isPseudoOK($_POST['pseudo_user']) && isAccountOk($_POST['pseudo_user'],$_POST['password_user']))
				{

					$_SESSION['pseudo_user'] = $_POST['pseudo_user'];
					$_SESSION['password_user'] = $_POST['password_user'];
					$_SESSION['admin'] = true;
				}
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
				//if ($_POST['oldLink'] != $_POST['newLink'])
				echo "LOL".getTheFluxRss($_GET['newLink']);
				//updateFluxRss($_POST['oldLink'],$_POST['newLink']);
			}
		}
	}


?>
