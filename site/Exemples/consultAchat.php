<?php
	require ("DB.inc.php");
	include "fctAux.inc.php";

	enTete();
	contenu();

	pied();
  
  
	function contenu()
	{
		$db = DB::getInstance();
		if ($db == null)
			echo "Impossible de se connecter &agrave; la base de donn&eacute;es !";
		else
		{

			echo "<h1>Consultation de la table Achat</h1>\n";
			try {
				echo "<table>\n<tr>\n";
				echo "<th>ncli</th>\n";
				echo "<th>np</th>\n";
				echo "<th>qa</th>\n";
				echo "</tr>\n";
				foreach ($db->getAchats() as $achat)
				{
					echo "<tr>\n";
					echo "<td>".$achat->getIdcli()."</td>\n";
					echo "<td>".$achat->getIdprod()."</td>\n";
					echo "<td>".$achat->getQa()."</td>\n";
					echo "</tr>\n";
				}
				echo "</table>";
			} //fin try
			catch (Exception $e) {
				  echo $e->getMessage();
			}  
			$db->close();
		}
	}
?>
