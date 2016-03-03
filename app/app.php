<?php 
	require_once __DIR__."/../vendor/autoload.php";
	require_once __DIR__."/../src/Client.php";

	$app = new Silex\Application();

	$server = 'mysql:host=localhost;dbname=hair_salon';
	$username = 'root';
	$password = 'root';
	$DB = new PDO($server, $username, $password);

	$app->register(new Silex\Provider\TwigServiceProvider(), array( 
		'twig.path' => __DIR__.'/../views'
	));

	$app->get("/", function() use ($app) {
		return $app['twig']->render('clients.html.twig', array('clients' => Client::getAll()));
	});

	$app->post("/clients", function() use ($app) {
		$client = new Client($_POST['name', 'phone']);
		$client->save();
		return $app['twig']->render('create_client.html.twig', array('newclient'));
	});

	$app->post("/delete_clients", function() use ($app) {
		Task::deleteAll();
		return $app['twig']->render('delete_tasks.html.twig');
	});

	return $app;
?>
