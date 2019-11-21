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
			echo '<input type="text" name="pubKey" value="';
			
			$config = array(
				"digest_alg" => "sha512",
				"private_key_bits" => 4096,
				"private_key_type" => OPENSSL_KEYTYPE_RSA,
			);
			$keypair = openssl_pkey_new($config);
			
			// get private key
			openssl_pkey_export($res, $privKey);
			
			// get public key
			$pubKey = openssl_pkey_get_details($res);
			$pubKey = $pubKey["key"];
			
			$_SESSION['pubKey'] = $pubKey;
			$_SESSION['privKey'] = $privKey;
			
			echo $pubKey;
			
			echo '" />';
		echo '</form>';
	}


?>