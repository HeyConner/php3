<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Client.php";
    require_once "src/Stylist.php";
    $server = 'mysql:host=localhost;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class ClientTest extends PHPUnit_Framework_TestCase{
        protected function tearDown(){
            Client::deleteAll();
            Stylist::deleteAll();
        }
        function test_save()
        {
            $name = "Conner";
            $id = 1;
            $phone = "2538610983";
            $test_client = new Client($name, $phone, $id);
            $test_client->save();
            $result = Client::getAll();
            $this->assertEquals($test_client, $result[0]);
        }
        function test_getId()
        {
            $name = "Conner";
            $phone = "2538610983";
            $id = 1;
            $test_client = new Client($name, $phone, $id);
            $test_client->save();
            $result = $test_client->getId();
            $this->assertEquals(true, is_numeric($result));
        }
        function test_getAll()
        {
            $name = "Conner";
            $id = 1;
            $phone = "2538610983";
            $test_client= new client($name, $phone, $id);
            $test_client->save();
            $name2 = "Abby";
            $phone2 = "1234567891";
            $id2 = 2;
            $test_client2 = new client($name2, $phone2, $id2);
            $test_client2->save();
            $result = client::getAll();
            $this->assertEquals([$test_client, $test_client2], $result);
        }
        function test_deleteAll()
        {
            $name = "Conner";
            $phone = "2538610983";
            $id = 1;
            $test_client= new client($name, $id);
            $test_client->save();
            $name2 = "Abby";
            $phone2 = "1234567891"
            $id2 = 2;
            $test_client2 = new client($name2, $id);
            $test_client2->save();
            client::deleteAll();
            $result = client::getAll();
            $this->assertEquals([], $result);
        }
        function test_find(){
            $name = "Conner";
            $phone = "2538610983";
            $name2 = "Abby";
            $phone2 = "1234567891";
            $id = 1;
            $id2 = 2;
            $test_client= new client($name, $phone, $id);
            $test_client2 = new client($name2, $phone2, $id);
            $test_client->save();
            $test_client2->save();
            $result = client::find($test_client->getId());
            $this->assertEquals($test_client, $result);
        }
        function testAddStylist(){
            $name = "Conner";
            $phone = "2538610983";
            $id = 1;
            $test_stylist = new stylist($name, $phone, $id);
            $test_stylist->save();
            $name2 = "Abby";
            $phone = "1234567891"
            $id2 = 2;
            $test_client= new client($name2, $phone2, $id2);
            $test_client->save();
            $test_client->addStylist($test_stylist);
            $this->assertEquals($test_client->getStylists(), [$test_stylist]);
        }
        function testGetStylists(){
            $name = "Conner";
            $phone = "2538610983"
            $id = 1;
            $test_stylist = new stylist($name, $phone, $id);
            $test_stylist->save();
            $name2 = "Abby";
            $phone2 = "1234567891"
            $id2= 2;
            $test_stylist2 = new stylist($name2, $phone2, $id2);
            $test_stylist2->save();
            $name3 = "Ben";
            $phone3 = "9876543211"
            $id3 = 3;
            $test_client= new client($name3, $phone3 $id3);
            $test_client->save();
            $test_client->addstylist($test_stylist);
            $test_client->addstylist($test_stylist2);
            $this->assertEquals($test_client->getStylists(), [$test_stylist, $test_stylist2]);
        }
    }
?>