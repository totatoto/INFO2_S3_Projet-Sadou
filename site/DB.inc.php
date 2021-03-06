<?php

require 'rssItem.inc.php';
require 'account.inc.php';
require 'fluxRss.inc.php';
require 'category.inc.php';
require 'pageLinksCategs.inc.php';

class DB {
      private static $instance = null; //m�morisation de l'instance de DB pour appliquer le pattern Singleton
      private $connect=null; //connexion PDO � la base

      /************************************************************************/
      //	Constructeur gerant  la connexion � la base via PDO
      //	NB : il est non utilisable a l'exterieur de la classe DB
      /************************************************************************/
      private function __construct() {
      	      // Connexion � la base de donn�es
	      $connStr = 'pgsql:host=127.0.0.1 port=5432 dbname=info2_s3_projet_sadou';
	      try {
		  // Connexion � la base
	      	  $this->connect = new PDO($connStr, 'pi', 'Martin123');
		  // Configuration facultative de la connexion
		  $this->connect->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
		  $this->connect->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
	      }
	      catch (PDOException $e) {
          try
          {
            $connStr = 'pgsql:host=5.50.179.242 port=5432 dbname=info2_s3_projet_sadou';
    		  // Connexion � la base
    	      	  $this->connect = new PDO($connStr, 'pi', 'Martin123');
      		  // Configuration facultative de la connexion
      		  $this->connect->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
      		  $this->connect->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
          }
          catch (PDOException $e) {
            //echo "probleme de connexion :".$e->getMessage();
            return null;
          }
	      }
      }

      /************************************************************************/
      //	Methode permettant d'obtenir un objet instance de DB
      //	NB : cet objet est unique pour l'ex�cution d'un m�me script PHP
      //	NB2: c'est une methode de classe.
      /************************************************************************/
      public static function getInstance() {
		 if (is_null(self::$instance)) {
 	     	try {
		      self::$instance = new DB();
			}
			catch (PDOException $e) {
				//echo $e;
			}
        } //fin IF
 	    $obj = self::$instance;

	    if (($obj->connect) == null) {
	       self::$instance=null;
	    }
	    return self::$instance;
      } //fin getInstance

      /************************************************************************/
      //	Methode permettant de fermer la connexion a la base de donn�es
      /************************************************************************/
      public function close() {
      	     $this->connect = null;
      }

      /************************************************************************/
      //	Methode uniquement utilisable dans les m�thodes de la class DB
      //	permettant d'ex�cuter n'importe quelle requ�te SQL
      //	et renvoyant en r�sultat les tuples renvoy�s par la requ�te
      //	sous forme d'un tableau d'objets
      //	param1 : texte de la requ�te � ex�cuter (�ventuellement param�tr�e)
      //	param2 : tableau des valeurs permettant d'instancier les param�tres de la requ�te
      //	NB : si la requ�te n'est pas param�tr�e alors ce param�tre doit valoir null.
      //	param3 : nom de la classe devant �tre utilis�e pour cr�er les objets qui vont
      //	repr�senter les diff�rents tuples.
      //	NB : cette classe doit avoir des attributs qui portent le m�me nom que les attributs
      //	de la requ�te ex�cut�e.
      //	ATTENTION : il doit y avoir autant de ? dans le texte de la requ�te
      //	que d'�l�ments dans le tableau pass� en second param�tre.
      //	NB : si la requ�te ne renvoie aucun tuple alors la fonction renvoie un tableau vide
      /************************************************************************/
      private function execQuery($requete,$tparam,$nomClasse) {
      	     //on pr�pare la requ�te
	     $stmt = $this->connect->prepare($requete);
	     //on indique que l'on va r�cup�re les tuples sous forme d'objets instance de Client
	     $stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $nomClasse);
	     //on ex�cute la requ�te
	     if ($tparam != null) {
	     	$stmt->execute($tparam);
	     }
	     else {
	     	$stmt->execute();
	     }
	     //r�cup�ration du r�sultat de la requ�te sous forme d'un tableau d'objets
	     $tab = array();
	     $tuple = $stmt->fetch(); //on r�cup�re le premier tuple sous forme d'objet
	     if ($tuple) {
	     	//au moins un tuple a �t� renvoy�
     	      	 while ($tuple != false) {
		       $tab[]=$tuple; //on ajoute l'objet en fin de tableau
      	    	       $tuple = $stmt->fetch(); //on r�cup�re un tuple sous la forme
						//d'un objet instance de la classe $nomClasse
    		 } //fin du while
             }
	     return $tab;
      }

       /************************************************************************/
      //	Methode utilisable uniquement dans les m�thodes de la classe DB
      //	permettant d'ex�cuter n'importe quel ordre SQL (update, delete ou insert)
      //	autre qu'une requ�te.
      //	R�sultat : nombre de tuples affect�s par l'ex�cution de l'ordre SQL
      //	param1 : texte de l'ordre SQL � ex�cuter (�ventuellement param�tr�)
      //	param2 : tableau des valeurs permettant d'instancier les param�tres de l'ordre SQL
      //	ATTENTION : il doit y avoir autant de ? dans le texte de la requ�te
      //	que d'�l�ments dans le tableau pass� en second param�tre.
      /************************************************************************/
      private function execMaj($ordreSQL,$tparam) {
      	     $stmt = $this->connect->prepare($ordreSQL);
	     $res = $stmt->execute($tparam); //execution de l'ordre SQL
	     return $stmt->rowCount();
      }

      /*************************************************************************
       * Fonctions qui peuvent �tre utilis�es dans les scripts PHP - 50 items au max - voir si on r�cup�re par lien ou si on mix les flux etc
       *************************************************************************/

      public function getRSSItems($linksCategs) { /*links = tableau contenant des liens pour avoir plusieurs sources*/
			/*for ($i=0 ; $i < sizeof($links) ; $i++)
			{
				$links[$i] = pg_escape_string($links[$i]);
			}*/

			$value = "";

			$requete =   'SELECT A.id,A.title,A.link,A.pub_date,A.description,A.category,A.importance
						  FROM RSS_ITEM_WITH_CATEG AS A
						  JOIN ITEM_OF_FLUX_RSS AS B
						  ON A.id = B.id_rss_item
						  WHERE ';

			foreach ($linksCategs as $link => $categs)
			{
				$requete .= "( B.link_flux_rss = '".pg_escape_string($link)."'";

				if ($categs != null && sizeof($categs) != 0)
				{
					$requete .= " AND ARRAY[";

					if (is_array($categs))
					{
						foreach ($categs as $categ)
						{
							$requete .= "getCategory('".pg_escape_string($categ)."'),";
						}
						$requete = substr($requete,0,-1);
					}
					else
						$requete .= "'".pg_escape_string($categs)."'";

					$requete .= "]::varchar[] && ARRAY(SELECT getAllCategories(A.id))";
				}

				$requete .= ") OR";
			}

			$requete = substr($requete,0,-3);

			$requete .=  ' AND A.pub_date >= (SELECT CURRENT_DATE - 7)
						  ORDER BY A.importance DESC, A.pub_date DESC
						  LIMIT 50';

          return $this->execQuery($requete,null,'RSSItem');
      }

      public function getAccount($username) {
			$username = pg_escape_string($username);

  		$requete = 'SELECT A.id, A.username, A.password, A.status, A.salt
  					FROM account AS A
  					WHERE A.username = '."'".$username."'";

  		return $this->execQuery($requete,null,'Account');
	  }

	public function getFluxRss() {
		$requete = 'SELECT A.link, A.id_last_rss
				    FROM FLUX_RSS AS A';

		return $this->execQuery($requete,null,'FluxRss');
	}

    public function getTheFluxRss($link) {
		$link = pg_escape_string($link);

		$requete = 'SELECT A.link, A.id_last_rss
				    FROM FLUX_RSS AS A
                    WHERE A.link = '."'".$link."'";

		return $this->execQuery($requete,null,'FluxRss');
	}


    public function updateFluxRss($oldLink,$newLink) {
		    $oldLink = pg_escape_string($oldLink);
		    $newLink = pg_escape_string($newLink);

        $requete = 'update FLUX_RSS set link = ? where link = ?';
        $tparam = array($newLink,$oldLink);
        return $this->execMaj($requete,$tparam);
    }

    public function deleteFluxRss($link) {
		    $link = pg_escape_string($link);

         $requete = 'delete from FLUX_RSS where link = ?';
         $tparam = array($link);
         return $this->execMaj($requete,$tparam);
     }

     public function insertFluxRss($link) {
 		      $link = pg_escape_string($link);

          $requete = 'insert into FLUX_RSS(link) values(?)';
          $tparam = array($link);
          return $this->execMaj($requete,$tparam);
     }


     public function updateAccount($oldUsername,$newUsername,$newPassword,$newSalt,$newStatus) {
		 $nb = 0;
		if (myIsset($oldUsername))
			$oldUsername = pg_escape_string($oldUsername);
		if (myIsset($newUsername))
		{
			$newUsername = pg_escape_string($newUsername);
			$nb++;
		}
		if (myIsset($newPassword))
		{
			$newPassword = pg_escape_string($newPassword);
			$nb += 2;
		}
		if (myIsset($newStatus))
		{
			$newStatus = pg_escape_string($newStatus);
			$nb++;
		}

		 if ($nb == 1)
		 {
			 $requete = 'update ACCOUNT set '.substr((myIsset($newUsername) ? 'username,' : '').(myIsset($newPassword) ? 'password,salt,' : '').(myIsset($newStatus) ? 'status,' : ''),0,-1).' = '.
         substr((myIsset($newUsername) ? '?,' : '').(myIsset($newPassword) ? '?,?,' : '').(myIsset($newStatus) ? '?,' : ''),0,-1).
         ' where username = ?';
		 }
		 else
		 {
			 $requete = 'update ACCOUNT set ('.substr((myIsset($newUsername) ? 'username,' : '').(myIsset($newPassword) ? 'password,salt,' : '').(myIsset($newStatus) ? 'status,' : ''),0,-1).') = ('.
         substr((myIsset($newUsername) ? '?,' : '').(myIsset($newPassword) ? '?,?,' : '').(myIsset($newStatus) ? '?,' : ''),0,-1).
         ') where username = ?';
		 }


         $tparam = array();
		 if (myIsset($newUsername))
			array_push($tparam,$newUsername);
		 if (myIsset($newPassword))
		 {
			array_push($tparam,$newPassword);
			array_push($tparam,$newSalt);
		 }
		 if (myIsset($newStatus))
			array_push($tparam,$newStatus);

		  array_push($tparam,$oldUsername);

		  return $this->execMaj($requete,$tparam);
     }

     public function insertAccount($username, $password, $status, $salt) {
 		      $username = pg_escape_string($username);
		      $password = pg_escape_string($password);
		      $status = pg_escape_string($status);

          $requete = 'insert into Account(username, password, status,salt) values(?,?,?,?)';
          $tparam = array($username, $password, $status, $salt);
          return $this->execMaj($requete,$tparam);
     }

     public function deleteAccount($username) {
 		    $username = pg_escape_string($username);

          $requete = 'delete from ACCOUNT where username = ?';
          $tparam = array($username);
          return $this->execMaj($requete,$tparam);
      }

    public function getRawLinksCategsOfPage($numPage) {
        $numPage = pg_escape_string($numPage);

        $requete = 'SELECT A.id, A.numPage, A.link_flux_rss, A.name_category
                    FROM PAGE_LINKS_CATEGS AS A
                    WHERE A.numPage = '.$numPage;

        return $this->execQuery($requete,null,'PageLinksCategs');
    }

    public function getRawPageLinksCategs() {

		$requete = 'SELECT A.id, A.numpage, A.link_flux_rss, A.name_category
				    FROM PAGE_LINKS_CATEGS AS A';

		return $this->execQuery($requete,null,'PageLinksCategs');
	}

    public function getAllCategoriesOfFluxRss($link) {
        $link = pg_escape_string($link);

		$requete = 'SELECT distinct getAllCategoriesOfFluxRss('."'".$link."'".') as name';

		return $this->execQuery($requete,null,'Category');
	}



      // public function getClients() {
      //           $requete = 'select * from pac_client';
      //     return $this->execQuery($requete,null,'Client');
      // }

      // public function getProduits() {
      //           $requete = 'select * from pac_produit';
      //     return $this->execQuery($requete,null,'Produit');
      // }

      // public function getAchats() {
      //           $requete = 'select * from pac_achat';
      //     return $this->execQuery($requete,null,'Achat');
      // }

      // public function getClientsAdr($adr) {
      //            $requete = 'select * from pac_client where adr = ?';
      //      return $this->execQuery($requete,array($adr),'Client');
      // }

      // public function getClient($idcli) {
      //            $requete = 'select * from pac_client where ncli = ?';
      //      return $this->execQuery($requete,array($idcli),'Client');
      // }

      // public function insertClient($idcli,$nom,$adr) {
      //            $requete = 'insert into pac_client values(?,?,?)';
      //      $tparam = array($idcli,$nom,$adr);
      //      return $this->execMaj($requete,$tparam);
      // }

      // public function updateAdrClient($idcli,$adr) {
      //            $requete = 'update pac_client set adr = ? where ncli = ?';
      //      $tparam = array($adr,$idcli);
      //      return $this->execMaj($requete,$tparam);
      // }

      // public function deleteClient($idcli) {
      //            $requete = 'delete from pac_client where ncli = ?';
      //      $tparam = array($idcli);
      //      return $this->execMaj($requete,$tparam);

} //fin classe DB

?>
