<?php

/*classe permettant de representer les tuples de la table RSS_ITEM */
class PageLinksCategs {
      /*avec PDO, il faut que les noms attributs soient les mêmes que ceux de la table*/
      public $id;
      public $numPage;
      public $link_flux_rss;
      public $name_category;

      /* Les méthodes qui commencent par __ sont des methodes magiques */
      /* Elles sont appelées automatiquement par php suite à certains événements. */
      /* Ici c'est l'appel à new sur la classe qui déclenche l'exécution de la méthode */
      /* des valeurs par défaut doivent être spécifiées pour les paramètres du constructeur sinon
      	 il y aura une erreur lorsqu'il sera appelé automatiquement par PDO
       */

      public function __construct($d=-1,$i=0,$t="",$n="") {
			$this->id = $d;
            $this->numPage = $i;
            $this->link_flux_rss = $t;
            $this->name_category = $n;
      }

      public function getId() { return $this->id; }
      public function getNumPage() { return $this->numPage; }
      public function getLinkFluxRss() { return $this->link_flux_rss; }
      public function getNameCategory() { return $this->name_category; }


      public function __toString() {
            $res = "id:".$this->id."\n";
            $res = $res ."numPage:".$this->numPage."\n";
            $res = $res ."link flux rss:".$this->link_flux_rss."\n";
            $res = $res ."name category:".$this->name_category."\n";
            $res = $res ."<br/>";
            return $res;
      }
}

?>
