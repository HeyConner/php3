<?php
    class Client{
        private $name;
        private $phone;
        private $id;
        function __construct($name, $phone, $id = null){
            $this->name = $name;
            $this->phone = $phone;
            $this->id = $id;
        }
        function setname($new_name){
            $this->name = (string) $new_name;
        }
        function getname(){
            return $this->name;
        }
        function setPhone(new_phone){
        	$this->phone;
        }
        function getPhone() {
        	return $this->phone;
        }
        function getId(){
            return $this->id;
        }
        function save(){
            $GLOBALS['DB']->exec("INSERT INTO clients (name) VALUES ('{$this->getname()}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }
        static function getAll(){
            $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients;");
            $clients = array();
            foreach($returned_clients as $client){
                $name = $client['name'];
                $id = $client['id'];
                $new_client = new Client($name, $phone, $id);
                array_push($clients, $new_client);
            }
            return $clients;
        }
        static function find($search_id){
            $found_client = null;
            $clients = Client::getAll();
            foreach($clients as $client){
                $client_id = $client->getId();
                if($client_id == $search_id){
                    $found_client = $client;
                }
            }
            return $found_client;
        }
        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE clients SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }
        function update($new_phone) {
        	$GLOBALS['DB']->exec("UPDATE clients SET phone '{$new_phone}' WHERE id = {$this->getId()};");
        	$this->setPhone($new_phone);
        }
        function delete() {
          $GLOBALS['DB']->exec("DELETE FROM clients WHERE id = {$this->getId()};");
          $GLOBALS['DB']->exec("DELETE FROM stylists_clients WHERE client_id = {$this->getId()};"); 
        }
        static function deleteALL(){
            $GLOBALS['DB']->exec("DELETE FROM clients;");
        }
        function addStylist($stylist){
            $GLOBALS['DB']->exec("INSERT INTO stylists_clients (stylist_id, client_id) VALUES ({$stylist->getId()}, {$this->getId()});");
        }
        function getStylists(){
            $query = $GLOBALS['DB']->query("SELECT stylist_id FROM stylists_clients WHERE client_id = {$this->getId()};");
           
            $stylist_ids = $query->fetchAll(PDO::FETCH_ASSOC);
            $stylists = array();
            foreach($stylist_ids as $id){
                $stylist_id = $id['stylist_id'];
                $result = $GLOBALS['DB']->query("SELECT * FROM stylists WHERE id = {$stylist_id};");
                $returned_stylist = $result->fetchAll(PDO::FETCH_ASSOC);
                $name = $returned_name[0]['name'];
                $id = $returned_stylist[0]['id'];
                $phone = $returned_phone[0]['phone'];
                $new_stylist = new Stylist($name, $phone, $id);
                array_push($stylists, $new_stylist);
            }
            return $stylist;
        }
    }
?>