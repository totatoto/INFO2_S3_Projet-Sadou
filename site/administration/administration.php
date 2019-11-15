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
    		if (isConnected(true))
			{

					include("../site_victor/head.php");
					echo '<header>';
						echo '<div>';
							echo '<span style="float: right; text-align: right;">';
							echo '<input class="favorite styledwhite" type="button" value="Log Out" onclick="logOut()">';
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
								echo '<input class="favorite styledgreen" type="button" value="Modify" onclick="modifyLink('."'".$link."'".')">';
								echo '&nbsp;&nbsp;&nbsp;';
								echo '<input class="favorite styledred" type="button" value="Delete" onclick="deleteLink('."'".$link."'".')">';
								echo '&nbsp;&nbsp;&nbsp;';
								echo '</span>';
								echo '<input type="text" value="'.$link.'"/>';
							echo '</div>';
							echo '</br></br>';
						}

			}
			else
			{
				echo '<script>document.location.href = "administration_login.php";</script>';
			}
		}
	}


?>
