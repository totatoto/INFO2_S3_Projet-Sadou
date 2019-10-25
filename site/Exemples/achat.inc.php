<?php

/*classe permettant de representer les tuples de la table client */
class Achat {
      /*avec PDO, il faut que les noms attributs soient les mêmes que ceux de la table*/
      private $ncli;
      private $np;
      private $qa;

      /* Les méthodes qui commencent par __ sont des methodes magiques */
      /* Elles sont appelées automatiquement par php suite à certains événements. */
      /* Ici c'est l'appel à new sur la classe qui déclenche l'exécution de la méthode */
      /* des valeurs par défaut doivent être spécifiées pour les paramètres du constructeur sinon
      	 il y aura une erreur lorsqu'il sera appelé automatiquement par PDO 
       */    
      
      public function __construct($i=-1,$p="",$q="") {
      	     $this->ncli = $i;
	     $this->np = $p;
	     $this->qa = $q;
      }

      public function getIdcli() { return $this->ncli; }
      public function getIdprod() { return $this->np; }
      public function getQa() { return $this->qa; }

      public function __toString() {
      	     $res = "idcli:".$this->ncli."\n";
	     $res = $res ."idprod:".$this->np."\n";
	     $res = $res ."quantite achete:".$this->qa."\n";
	     $res = $res ."<br/>";
	     return $res;
	     
      }
}

?>
