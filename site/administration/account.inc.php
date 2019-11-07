<?php

/*classe permettant de representer les user de la table user_table */
class Account {
      public $id;
      public $pseudo;
      public $password;
      public $status;

      public function __construct($id=-1, $pseudo="", $password="", $status="user") {
            $this->id = $id;
            $this->pseudo = $pseudo;
            $this->password = $password;
            $this->status = $status;
      }

      public function getId() { return $this->id; }
      public function getPseudo() { return $this->pseudo; }
      public function getPassword() { return $this->password; }
      public function getStatus() { return $this->status; }
}

?>
