<?php

/*classe permettant de representer les user de la table user_table */
class Account {
      public $id;
      public $username;
      public $password;
      public $status;
      public $salt;

      public function __construct($id=-1, $username="", $password="", $status="user", $salt="") {
            $this->id = $id;
            $this->username = $username;
            $this->password = $password;
            $this->status = $status;
			$this->salt = $salt;
      }

      public function getId() { return $this->id; }
      public function getPseudo() { return $this->username; }
      public function getPassword() { return $this->password; }
      public function getStatus() { return $this->status; }
      public function getSalt() { return $this->salt; }
}

?>
