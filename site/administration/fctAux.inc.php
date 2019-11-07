<?php
	
	function enTete($title="Titre",$css=NULL,$js=NULL)
	{
		echo "<!DOCTYPE html>\n";
		echo "<html>\n";
		echo "\t<head>\n";
		echo "\t\t<title>$title</title>\n";
		echo "\t\t<meta charset=\"UTF-8\"/>\n";
		if (!empty($css))
			echo "\t\t".'<link rel="stylesheet" media="all" type="text/css" href="'.$css.'" />';
		if (!empty($js))
			echo "\t\t".'<script type="text/javascript" src="'.$js.'"></script>';
		echo "\t</head>\n";
		echo "\t<body>\n";
	}

	function pied()
	{
		//echo "\n\t\t".'<hr>'."\n\n\t\t".'Merci de votre visite.'."\n";
		echo "\t".'</body>'."\n".'</html>';
	}

	function isPseudoOK($pseudo)
	{
		$db = DB::getInstance();
		if ($db == null)
			echo "Impossible de se connecter &agrave; la base de donn&eacute;es !!";
		else
		{
			$accounts = $db->getAccount($pseudo);
			if (isset($account))
				return true;
			$db->close();
		}
		return false;
	}

	function isAccountOK ($pseudo,$password)
	{
		if (! isPseudoOK)
			return false;
		
		$db = DB::getInstance();
		if ($db == null)
			echo "Impossible de se connecter &agrave; la base de donn&eacute;es !:";
		else
		{
			$accounts = $db->getAccount($pseudo);
			foreach ($accounts as $account) {
				if ($account->getPassword() == $password)
					return true;
			}
			$db->close();
		}
		return false;
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
