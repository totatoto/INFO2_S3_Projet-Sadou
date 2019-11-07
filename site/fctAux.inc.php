<?php
	function enTete($title="Titre",$css=NULL,$js=NULL,$icon)
	{
		echo "<!DOCTYPE html>\n";
		echo "<html>\n";
		echo "\t<head>\n";
		echo "\t\t<title>$title</title>\n";
		echo "\t\t<meta charset=\"UTF-8\"/>\n"; 
		echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
		if (!empty($css))
			if (!gettype($css) == "array")
				echo "\t\t".'<link rel="stylesheet" media="all" type="text/css" href="'.$css.'" />';
			else
				foreach ($css as $itemcss)
					echo "\t\t".'<script type="text/javascript" src="'.$itemcss.'"></script>';
				
		if (!empty($js))
			if (!gettype($js) == "array")
				echo "\t\t".'<script type="text/javascript" src="'.$js.'"></script>';
			else
				foreach ($js as $itemjs)
					echo "\t\t".'<script type="text/javascript" src="'.$itemjs.'"></script>';
					
		if (!empty($icon))
			echo "\t\t".'<link rel = "icon" href =  "'.$icon.'" type = "image/x-icon"/>';
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

	function parse($data)
	{
		$parser=xml_parser_create();

		xml_parse($parser,$data) or
		die (sprintf("XML Error: %s at line %d",
		xml_error_string(xml_get_error_code($parser)),
		xml_get_current_line_number($parser)));
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
