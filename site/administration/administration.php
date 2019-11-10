<?php
require("../DB.inc.php");
include("../fctAux.inc.php");

if (isPseudoOK($_POST['pseudo_user']) && isAccountOk($_POST['pseudo_user'],$_POST['password_user']))
{
	session_start();

	$_SESSION['pseudo_user'] = $_POST['pseudo_user'];
	$_SESSION['password_user'] = $_POST['password_user'];
	$_SESSION['admin'] = true;
}
?>

	<!DOCTYPE html>
	<html>
		<body>
			<header>
				<div>
					<span style="float: right; text-align: right;">
					<input class="favorite styledwhite" type="button" value="Log Out">
					</span>
				</div>
			</header>



			</br></br></br>
			<h1>&nbsp; Administration</h1>
			</br></br></br>



			<div>
				<span style="float: right; text-align: right;">
				<input class="favorite styledgreen" type="button" value="Modify">
				&nbsp;&nbsp;&nbsp;
				<input class="favorite styledred" type="button" value="Delete">
				&nbsp;&nbsp;&nbsp;
				</span>
				<p>&nbsp; Ceci est un Flux RSS 1</p>
			</div>
			</br></br>
			<div>
				<span style="float: right; text-align: right;">
				<input class="favorite styledgreen" type="button" value="Modify">
				&nbsp;&nbsp;&nbsp;
				<input class="favorite styledred" type="button" value="Delete">
				&nbsp;&nbsp;&nbsp;
				</span>
				<p>&nbsp; Ceci est un Flux RSS 2</p>
			</div>




		</body>
	</html>

<?php
else
{
	echo "test";
	echo isPseudoOK($_POST['pseudo_user']));
	echo isAccountOk($_POST['pseudo_user'],$_POST['password_user']);
}
?>
