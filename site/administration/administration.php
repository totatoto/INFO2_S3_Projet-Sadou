<?php
require("../DB.inc.php");
require("../fctAux.inc.php");

if (isPseudoOK($_POST['pseudo_user']) && isAccountOk($_POST['pseudo_user'],$_POST['password_user']))
{
	session_start();

	$_SESSION['pseudo_user'] = $_POST['pseudo_user'];
	$_SESSION['password_user'] = $_POST['password_user'];
	$_SESSION['admin'] = true;



		include("../site_victor/head.php");
		echo '<body>';
			echo '<header>';
				echo '<div>';
					echo '<span style="float: right; text-align: right;">';
					echo '<input class="favorite styledwhite" type="button" value="Log Out">';
						echo "&nbsp;&nbsp;" . "User :" . "&nbsp" . $_SESSION['pseudo_user'] . "&nbsp;&nbsp;";
					echo '</span>';
					echo "&nbsp;&nbsp;" . date("d/m/Y - h:i:s");
				echo '</div>';
			echo '</header>';



			echo '</br></br></br>';
			echo '<h1>&nbsp; Administration</h1>';
			echo '</br></br></br>';



			echo '<div>';
				echo '<span style="float: right; text-align: right;">';
				echo '<input class="favorite styledgreen" type="button" value="Modify">';
				echo '&nbsp;&nbsp;&nbsp;';
				echo '<input class="favorite styledred" type="button" value="Delete">';
				echo '&nbsp;&nbsp;&nbsp;';
				echo '</span>';
				echo '<p>&nbsp; Ceci est un Flux RSS 1</p>';
			echo '</div>';
			echo '</br></br>';
			echo '<div>';
				echo '<span style="float: right; text-align: right;">';
				echo '<input class="favorite styledgreen" type="button" value="Modify">';
				echo '&nbsp;&nbsp;&nbsp;';
				echo '<input class="favorite styledred" type="button" value="Delete">';
				echo '&nbsp;&nbsp;&nbsp;';
				echo '</span>';
				echo '<p>&nbsp; Ceci est un Flux RSS 2</p>';
			echo '</div>';




			include("../site_victor/footer.php");
		echo '</body>';

}
else
{
	echo "test";
	echo isPseudoOK($_POST['pseudo_user']);
	echo isAccountOk($_POST['pseudo_user'],$_POST['password_user']);
}
?>
