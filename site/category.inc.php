<?php

/*classe permettant de representer les tuples de la table RSS_ITEM */
class Category {
      /*avec PDO, il faut que les noms attributs soient les mêmes que ceux de la table*/
      public $name;

      /* Les méthodes qui commencent par __ sont des methodes magiques */
      /* Elles sont appelées automatiquement par php suite à certains événements. */
      /* Ici c'est l'appel à new sur la classe qui déclenche l'exécution de la méthode */
      /* des valeurs par défaut doivent être spécifiées pour les paramètres du constructeur sinon
      	 il y aura une erreur lorsqu'il sera appelé automatiquement par PDO
       */

      public function __construct($n="") {
            $this->name = $n;
      }

      public function getName() { return $this->name; }


      public function __toString() {
            $res = "name:".$this->name."\n";
            $res = $res ."<br/>";
            return $res;
      }
}

?>
