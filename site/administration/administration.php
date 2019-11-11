<?php
require("../DB.inc.php");
require("../fctAux.inc.php");

if (isPseudoOK($_POST['pseudo_user']) && isAccountOk($_POST['pseudo_user'],$_POST['password_user']))
{
	session_start();

	$_SESSION['pseudo_user'] = $_POST['pseudo_user'];
	$_SESSION['password_user'] = $_POST['password_user'];
	$_SESSION['admin'] = true;
	echo "test";
}
else
{
	echo "test2";
}
?>
<h1>test10</h1>
<?php
	echo "test3";
?>
