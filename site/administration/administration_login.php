<?php
	require("../fctAux.inc.php");

	enTete("page login","styles/style_admin.css",NULL,"styles/icon.bmp");
	contenu();
	pied();


	function contenu()
	{
		echo '<header>';
			echo '<ul class = "bandesup">';
				echo "&nbsp;&nbsp;" . date("d/m/Y");
			echo '</ul>';
		echo '</header>';
		
		echo '</br>';
		
		echo '<p class="titre"><strong>Page Administration</strong></p>';
		
		echo '<form method="post" action="administration.php">';
			echo '<h1 id="connexion">CONNEXION</h1>';
			echo '</br>';
				echo '<p>';
					echo '<span>PSEUDO</span>';
					echo '<input type="text" name="pseudo_user"  />';
				echo '</p>';
				echo '</br>';
				echo '<p>';
					echo '<span>PASSWORD</span>';
					echo '<input type="password" name="password_user"  />';
				echo '</p>';
			echo '</br>';
			echo '<input id="send_button" type="submit" value="Send" />';
		echo '</form>';
	}


?>