<?php

/*classe permettant de representer les tuples de la table RSS_ITEM */
class RSSItem {
      /*avec PDO, il faut que les noms attributs soient les mêmes que ceux de la table*/
      public $id;
      public $title;
      public $link;
      public $pub_date;
      public $description;
      public $importance;

      /* Les méthodes qui commencent par __ sont des methodes magiques */
      /* Elles sont appelées automatiquement par php suite à certains événements. */
      /* Ici c'est l'appel à new sur la classe qui déclenche l'exécution de la méthode */
      /* des valeurs par défaut doivent être spécifiées pour les paramètres du constructeur sinon
      	 il y aura une erreur lorsqu'il sera appelé automatiquement par PDO
       */

      public function __construct($i=-1,$t="",$l="",$p="",$m="",$k=0) {
            $this->id = $i;
            $this->title = $t;
            $this->link = $l;
            $this->pub_date = $p;
			$this->description = $m;
            $this->importance = $k;
      }

      public function getId() { return $this->id; }
      public function getTitle() { return $this->title; }
      public function getLink() { return $this->link; }
      public function getPubDate() { return $this->pub_date; }
      public function getDescription() { return $this->description; }
      public function getImportance() { return $this->importance; }


      public function __toString() {
            $res = "id:".$this->id."\n";
            $res = $res ."titre:".$this->title."\n";
            $res = $res ."lien de l'article:".$this->link."\n";
            $res = $res ."date de publication:".$this->pub_date."\n";
            $res = $res ."description:".$this->description."\n";
            $res = $res ."importance:".$this->importance."\n";
            $res = $res ."<br/>";
            return $res;
      }
}

?>
