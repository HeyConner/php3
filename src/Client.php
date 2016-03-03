<?php 
	class Client {
		private $name;
		private $phone;

		function __construct($name, $phone) {
			$this->name = $name;
			$this->phone = $phone;
		}
		function setName($new_name) {
			$this->name = (string) $new_name;
		}
		function getName() {
			return $this->name;
		}
		function setPhone($new_phone) {
			$this->phone = $new_phone;
		}
		function getPhone() {
			return $this->phone;
		}
		static function getAll() {
			return $_SESSION['list_of_clients'];
		}
		static function deleteAll() {
			$_SESSION['list_of_clients'] = array();
		}
		function save() {
      $GLOBALS['DB']->exec("INSERT INTO clients (name) VALUES ('{$this->getName()}');");
		}

	}
?>