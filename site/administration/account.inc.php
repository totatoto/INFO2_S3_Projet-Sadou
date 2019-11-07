<?php

/*classe permettant de representer les user de la table user_table */
class Account {
      public $id;
      public $username;
      public $password;
      public $status;

      public function __construct($id=-1, $username="", $password="", $status="user") {
            $this->id = $id;
            $this->username = $username;
            $this->password = $password;
            $this->status = $status;
      }

      public function getId() { return $this->id; }
      public function getPseudo() { return $this->username; }
      public function getPassword() { return $this->password; }
      public function getStatus() { return $this->status; }
}

?>
