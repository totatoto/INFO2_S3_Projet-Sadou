<?php
	require("../DB.inc.php");
	require("../fctAux.inc.php");

	enTete("page administration","style_admin.css","administration.js","icon.bmp");
	contenu();
	pied();


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

    		if (isConnected(true))
			{

					include("../site_victor/head.php");
					echo '<header>';
						echo '<div>';
							echo '<span style="float: right; text-align: right;">';
							echo '<input class="favorite styledwhite" type="button" value="Log Out" onclick="logOut">';
								echo "&nbsp;&nbsp;" . "User :" . "&nbsp" . $_SESSION['pseudo_user'] . "&nbsp;&nbsp;";
							echo '</span>';
							echo "&nbsp;&nbsp;" . date("d/m/Y - h:i:s");
						echo '</div>';
					echo '</header>';



						echo '</br></br></br>';
						echo '<h1>&nbsp; Administration</h1>';
						echo '</br></br></br>';


						foreach($db->getFluxRss() as $fluxRss)
						{
							$link = $fluxRss->getLink();
							echo '<div id="'.$link.'">';
								echo '<span style="float: right; text-align: right;">';
								echo '<input class="favorite styledgreen" type="button" value="Modify" onclick="modify('."'".$link."'".')">';
								echo '&nbsp;&nbsp;&nbsp;';
								echo '<input class="favorite styledred" type="button" value="Delete" onclick="delete('."'".$link."'".')">';
								echo '&nbsp;&nbsp;&nbsp;';
								echo '</span>';
								echo '<a href="updateFluxRss.php">lien</a>';
								echo '<input type="text" value="'.$link.'"/>';
							echo '</div>';
							echo '</br></br>';
						}

			}
			else
			{
				echo "test";
				echo isPseudoOK($_POST['pseudo_user']);
				echo isAccountOk($_POST['pseudo_user'],$_POST['password_user']);
			}
		}
	}


?>
