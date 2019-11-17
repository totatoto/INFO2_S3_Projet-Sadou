<?php

require 'rssItem.inc.php';
require 'account.inc.php';
require 'fluxRss.inc.php';

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
      	      	    echo "probleme de connexion :".$e->getMessage();
		    return null;
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
				echo $e;
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
      public function getRSSItem($link) {
      	    $requete =   'SELECT A.id,A.title,A.link,A.pub_date,A.importance,A.description
                              FROM RSS_ITEM AS A
                              JOIN ITEM_OF_FLUX_RSS AS B
                              ON A.id = B.id_rss_item
                              WHERE B.link_flux_rss = '."'".$link."'".'
                              AND A.pub_date >= (SELECT CURRENT_DATE - 7)
                              ORDER BY A.importance DESC, A.pub_date DESC
                              LIMIT 50';
	    return $this->execQuery($requete,null,'RSSItem');
      }

      public function getRSSItems($links) { /*links = tableau contenant des liens pour avoir plusieurs sources*/
                $requete =   'SELECT A.id,A.title,A.link,A.pub_date,A.importance,A.description
                              FROM RSS_ITEM AS A
                              JOIN ITEM_OF_FLUX_RSS AS B
                              ON A.id = B.id_rss_item
                              WHERE B.link_flux_rss in '.$links.'
                              AND A.pub_date >= (SELECT CURRENT_DATE - 7)
                              ORDER BY A.importance DESC, A.pub_date DESC
                              LIMIT 50';
          return $this->execQuery($requete,null,'RSSItem');
      }

      public function getAccount($username) {
  		$requete = 'SELECT A.id, A.username, A.password, A.status
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
		$requete = 'SELECT A.link, A.id_last_rss
				    FROM FLUX_RSS AS A
                    WHERE A.link = '."'".$link."'";

		return $this->execQuery($requete,null,'FluxRss');
	}


    public function updateFluxRss($oldLink,$newLink) {
        $requete = 'update FLUX_RSS set link = ? where link = ?';
        $tparam = array($newLink,$oldLink);
        return $this->execMaj($requete,$tparam);
    }

    public function deleteFluxRss($link) {
         $requete = 'delete from FLUX_RSS where link = ?';
         $tparam = array($link);
         return $this->execMaj($requete,$tparam);
     }

     public function insertFluxRss($link) {
          $requete = 'insert into FLUX_RSS(link) values(?)';
          $tparam = array($link);
          return $this->execMaj($requete,$tparam);
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
