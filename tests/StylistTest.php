<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Stylist.php";
    require_once "src/Client.php";
    $server = 'mysql:host=localhost:8889;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    class StylistTest extends PHPUnit_Framework_TestCase{
        protected function tearDown(){
            Stylist::deleteAll();
            Client::deleteAll();
        }
        function test_getName(){
            $name = "Kyle";
            $test_stylist = new Stylist($name);
            $result = $test_stylist->getName();
            $this->assertEquals($name, $result);
        }
        function testSetName() {
            $name = "Kyle";
            $test_stylist = new Stylist($name);
            $test_stylist->setName("Home chores");
            $result = $test_stylist->getName();
            $this->assertEquals("Home chores", $result);
        }
        function test_getId(){
            $name = "Kyle";
            $id = 1;
            $test_stylist = new Stylist($name, $id);
            $result = $test_stylist->getId();
            $this->assertEquals($id, $result);
        }
        function test_save(){
            $name = "Work Stuff";
            $id = 1;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();
            $result = Stylist::getAll();
            $this->assertEquals($test_stylist, $result[0]);
        }
        function test_getAll(){
            $name = "Work Stuff";
            $name2 = "Home Stuff";
            $id = 1;
            $id2 = 2;
            $test_stylist = new Stylist($name, $id);
            $test_stylist2 = new Stylist($name2, $id2);
            $test_stylist->save();
            $test_stylist2->save();
            $result = Stylist::getAll();
            $this->assertEquals([$test_stylist, $test_stylist2], $result);
        }
        function test_deleteAll(){
            $name = "Work Stuff";
            $name2 = "Home Stuff";
            $id = 1;
            $id2 = 2;
            $test_stylist = new Stylist($name, $id);
            $test_stylist2 = new SSylist($name2, $id2);
            $test_stylist->save();
            $test_stylist2->save();
            Stylist::deleteAll();
            $result = Stylist::getAll();
            $this->assertEquals([], $result);
        }
        function test_find() {
            $name = "Wash the dog";
            $name2 = "Home Stuff";
            $id = 1;
            $id2 = 2;
            $test_stylist = new Stylist($name, $id);
            $test_stylist2 = new Stylist($name2, $id2);
            $test_stylist->save();
            $test_stylist2->save();
            $result = Stylist::find($test_stylist->getId());
            $this->assertEquals($test_stylist, $result);
        }
        function testUpdate(){
            $description = "Wash the dog";
            $id = 1;
            $test_task = new Client($description, $id);
            $test_task->save();
            $new_description = "Clean the dog";
            $test_task->update($new_description);
            $this->assertEquals($new_description, $test_task->getDescription());
        }
        function testDeletestylist(){
            $name = "Work stuff";
            $id = 1;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();
            $name2 = "Home stuff";
            $id2 = 2;
            $test_stylist2 = new Stylist($name2, $id2);
            $test_stylist2->save();
            $test_stylist->delete();
            $this->assertEquals([$test_stylist2], Stylist::getAll());
        }
        function testAddTask(){
            $name = "Work Stuff";
            $id = 1;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();
            $description = "File Reports";
            $id2 = 2;
            $test_task = new Client($description, $id2);
            $test_task->save();
            $test_stylist->addTask($test_task);
            $this->assertEquals($test_stylist->getTasks(), [$test_task]);
        }
        function testGetTasks(){
            $name = "Home Stuff";
            $id = 1;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();
            $description = "wash the dog";
            $id2= 2;
            $test_task = new Client($name, $id2);
            $test_task->save();
            $description2 = "Take out the trash";
            $id3 = 3;
            $test_task2 = new Client($name2, $id3);
            $test_task2->save();
            $test_stylist->addTask($test_task);
            $test_stylist->addTask($test_task2);
            $this->assertEquals($test_stylist->getTasks(), [$test_task, $test_task2]);
        }
    }
?>