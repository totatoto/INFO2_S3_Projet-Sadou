<?php
	require("../fctAux.inc.php");

	enTete("page administration des flux","styles/style_admin.css","administration.js","styles/icon.bmp");
	contenu();
	pied();


	function contenu()
	{
		$db = DB::getInstance();
		if ($db == null)
			echo "Impossible de se connecter &agrave; la base de donn&eacute;es !";
		else
		{
    		if (isConnected(false))
			{

					echo '<header id="bandesup">';
						echo '<div>';
							echo '<span style="float: right; text-align: right;">';
							echo '<input class="favorite styledwhite" type="button" value="Log Out" onclick="logOut()">';
								echo "&nbsp;&nbsp;" . "User :" . "&nbsp" . test_input($_SESSION['pseudo_user']) . "&nbsp;&nbsp;";
							echo '</span>';
							echo "&nbsp;&nbsp;" . date("d/m/Y");
						echo '</div>';
					echo '</header>';

						echo '<p class="titre"> '.(isConnected(true) ? "Administration" : "Visualisation").'</p>';

						// echo '<p>'."Flux RSS integres".'</p>'
						//
						echo '<button class="bouton_retour" onclick=redirect('."'".'administration.php'."'".')>';
				            echo 'Retour';
				        echo '</button>';

						echo '<div id="divCurrentLinks">';
						foreach($db->getFluxRss() as $fluxRss)
						{
							$link = test_input($fluxRss->getLink());
							echo '<div id="'.$link.'" class="divLinks">';
								if (isConnected(true))
								{
									echo '<span style="float: right; text-align: right;">';
									echo '<input class="favorite styledgreen" type="button" value="Modify" onclick="modifyLink('."'".$link."'".')">';
									echo '&nbsp;&nbsp;&nbsp;';
									echo '<input class="favorite styledred" type="button" value="Delete" onclick="deleteLink('."'".$link."'".')">';
									echo '&nbsp;&nbsp;&nbsp;';
									echo '</span>';
									echo '<input type="text" class="inputRSS" value="'.$link.'"/>';
								}
								else
								{
									echo '<p>'.$link.'</p>';
								}
							echo '</div>';
						}
						echo '</div>';

						// echo '<p>'."Ajouter un flux RSS".'</p>'

						if (isConnected(true))
						{
							echo '<div id="insertLink">';
							echo '<span style="float: right; text-align: right;">';
							echo '<input class="favorite styledgreen" type="button" value="Insert" onclick="insertLink()">';
							echo '</span>';
							echo '<input type="text" class="inputRSS" value="" hint="insert the Link to add here"/>';
							echo '</div>';
						}

			}
			else
			{
				echo '<script>document.location.href = "administration_login.php";</script>';
			}
		}
	}


?>
