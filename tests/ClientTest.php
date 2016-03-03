<?php 
	

	/**
	* @backupGlobals disabled
	* @backupStaticAttributes disabled
	*/

	require_once "src/Client.php";

	$server = 'mysql:host=localhost;dbname=hair_salon_test';
	$username = 'root';
	$password = 'root';
	$DB = new PDO($server, $username, $password);

	class ClientTest extends PHPUnit_Framework_TestCase {
		function test_save() {
			//Arrange
			$name = "Abby";
			$phone = "253-921-5534";
			$test_client = new Client($name, $phone);

			//Act
			$test_client->save();

			//Assert
			$result = Client::getAll();
			$this->asserEquals($test_client, $result[0]);
		}
	}
?>