<?php
	function enTete($title="Titre",$css=NULL)
	{
		echo "<!DOCTYPE html>\n";
		echo "<html>\n";
		echo "\t<head>\n";
		echo "\t\t<title>$title</title>\n";
		echo "\t\t<meta charset=\"UTF-8\"/>\n";
		if (!empty($css))
			echo "\t\t".'<link rel="stylesheet" media="all" type="text/css" href="$css" />';
		echo "\t</head>\n";
		echo "\t<body>\n";
	}
	
	function pied()
	{
		//echo "\n\t\t".'<hr>'."\n\n\t\t".'Merci de votre visite.'."\n";
		echo "\t".'</body>'."\n".'</html>';
	}
	
	function isLoginOK($login)
	{
		return $login == "user" || $login == "admin";
	}
	
	function isMotDePasseOK ($login,$mdp)
	{
		return ( $login == "user" && $mdp == "userpwd" ) || ( $login == "admin" && $mdp == "adminpwd" );
	}
	
	function test_input($data)
	{
	   //on supprime les espaces, les sauts de ligne etc.
	   $data = trim($data);
	   //on supprime les antislashs
	   $data = stripslashes($data);
	   //on utilise les codes HTML pour les caractéres spéciaux
	   $data = htmlentities($data);
	   return $data;
	}
?>
