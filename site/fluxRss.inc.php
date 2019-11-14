<?php

/*classe permettant de representer les tuples de la table RSS_ITEM */
class FluxRss {
      /*avec PDO, il faut que les noms attributs soient les mêmes que ceux de la table*/
      public $link;
      public $id_last_rss;

      /* Les méthodes qui commencent par __ sont des methodes magiques */
      /* Elles sont appelées automatiquement par php suite à certains événements. */
      /* Ici c'est l'appel à new sur la classe qui déclenche l'exécution de la méthode */
      /* des valeurs par défaut doivent être spécifiées pour les paramètres du constructeur sinon
      	 il y aura une erreur lorsqu'il sera appelé automatiquement par PDO
       */

      public function __construct($i=-1,$t="") {
            $this->link = $i;
            $this->id_last_rss = $t;
      }

      public function getLink() { return $this->link; }
      public function getIdLastRss() { return $this->id_last_rss; }


      public function __toString() {
            $res = "link:".$this->link."\n";
            $res = $res ."id last rss:".$this->id_last_rss."\n";
            $res = $res ."<br/>";
            return $res;
      }
}

?>
