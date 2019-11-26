<?php
	require("DB.inc.php");

	function enTete($title="Titre",$css=NULL,$js=NULL,$icon)
	{
		echo "<!DOCTYPE html>\n";
		echo "<html>\n";
		echo "\t<head>\n";
		echo "\t\t<title>$title</title>\n";
		echo "\t\t<meta charset=\"UTF-8\"/>\n";
		echo '<meta name="viewport" content="width=device-width, initial-scale=1">';
		if (!empty($css))
			if (!is_array($css))
				echo "\t\t".'<link rel="stylesheet" media="all" type="text/css" href="'.$css.'" />';
			else
				foreach ($css as $itemcss)
					echo "\t\t".'<script type="text/javascript" src="'.$itemcss.'"></script>';

		if (!empty($js))
			if (!is_array($js))
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
		echo '<footer>';
            echo '<p class = "copyright"> © 2019 &nbsp;&nbsp; Adam BERNOUY - Benjamin LE CUNFF - Victor POITOU - Martin THOMINIAUX </p>';
        echo '</footer>';
		echo "\t".'</body>'."\n".'</html>';
	}

	function getLinksOfFluxRss()
	{
		$db = DB::getInstance();
		if ($db == null)
			echo "Impossible de se connecter &agrave; la base de donn&eacute;es !!";
		else
		{
			return array_map(function($fluxRss) {return $fluxRss->getLink();},$db->getFluxRss());
		}
		return null;
	}

	function isPseudoOK($pseudo)
	{
		$db = DB::getInstance();
		if ($db == null)
			echo "Impossible de se connecter &agrave; la base de donn&eacute;es !!";
		else
		{
			$accounts = $db->getAccount($pseudo);
			if (isset($accounts))
				return true;
		}
		return false;
	}

	function isAccountOK ($pseudo,$password)
	{
		if (! isPseudoOK($pseudo))
			return false;

		$db = DB::getInstance();
		if ($db == null)
			echo "Impossible de se connecter &agrave; la base de donn&eacute;es !:";
		else
		{
			$accounts = $db->getAccount($pseudo);
			foreach ($accounts as $account) {
				if ($account->getPassword() == myHash($password,$account->getSalt()))
					return true;
			}
		}
		return false;
	}

	function isConnected($admin)
	{
		if ($admin == true)
			return isset($_SESSION['admin']) && ($_SESSION['admin'] == true);

		return isset($_SESSION['admin']);
	}

	function generateSalt()
	{
		return bin2hex(random_bytes('32'));
	}

	function myHash($text,$salt)
	{
		return hash_hmac("sha512",$text,$salt);
	}

	function myUncrypt($text,$key)
	{
		return $text;
		/*openssl_private_decrypt($text,$ret,$key);
		return $ret;*/
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

	session_start();
	if (!isConnected(false))
		if(isset($_POST['pseudo_user']) && isset($_POST['password_user']))// && isset($_POST['pubKey']) && isset($_SESSION['pubKey']) && $_POST['pubKey'] == $_SESSION['pubKey'])
		{
			$password_user = myUncrypt($_POST['password_user'],$_SESSION['privKey']);

			if (isPseudoOK($_POST['pseudo_user']) && isAccountOk($_POST['pseudo_user'],$password_user))
			{
				$_SESSION['pseudo_user'] = $_POST['pseudo_user'];
				$_SESSION['password_user'] = $password_user;
				foreach (DB::getInstance()->getAccount($_SESSION['pseudo_user']) as $account)
					if ($account->getPassword() == myHash($_SESSION['password_user'],$account->getSalt()))
						$_SESSION['admin'] = $account->getStatus()=="ADMIN";
			}
		}
?>
