<?php

    class Stylist {

        private $name;
        private $id;

        function __construct($name, $id = null) {
            $this->name = $name;
            $this->id = $id;
        }
        function getName() {
            return $this->name;
        }
        function setName($new_name){
          $this->name = $new_name;
        }
        function getId() {
            return $this->id;
        }
        function save() {
            $GLOBALS['DB']->exec("INSERT INTO stylists (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }
        function update($new_name){
            $GLOBALS['DB']->exec("UPDATE stylists SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }
        function addClient($client){
            $GLOBALS['DB']->exec("INSERT INTO stylists_clients(stylist_id, client_id) VALUES ({$this->getId()}, {$client->getId()});");
        }
        static function getAll() {
            $returned_stylist = $GLOBALS['DB']->query("SELECT * FROM stylists;");
            $stylists = array();
            foreach($returned_stylist as $stylist) {
                $name = $stlyist['name'];
                $id = $stylist['id'];
                $new_stylist = new Stylist($name, $id);
                array_push($stylists, $new_stylist);
        }
                return $stylists;
        }

        static function deleteAll() {
            $GLOBALS['DB']->exec("DELETE FROM stylists;");
        }
        static function find($search_id) {
            $found_stylist = null;
            $stylist = Stylist::getAll();
            foreach($stylists as $stylist) {
                $stylist_id = $stylist->getId();
                if ($stylist_id == $search_id) {
                  $found_stylist = $stylist;
            }
        }
                return $found_stylist;
        }
        function getClients()
        {
            $returned_clients = $GLOBALS['DB']->query("SELECT clients.* FROM stylists JOIN stylists_clients ON (stylists_clients.stylist_id = stylists.id) JOIN clients ON (clients.id = stylists_clients.client_id) WHERE stylists.id = {$this->getId()};");
            $clients = array();
            foreach($returned_clients as $client) {
                $name = $client['name'];
                $id = $client['id'];
                $new_client = new Client($name, $id);
                array_push($clients, $new_client);
            }
                return $clients;
        }
        function deleteStylistClient(){
            $GLOBALS['DB']->exec("DELETE FROM stylists_clients WHERE stylist_id = {$this->getId()};");
        }
    }
?>