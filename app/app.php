<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Client.php";
    require_once __DIR__."/../src/Stylist.php";

    $app = new Silex\Application();
    $server = 'mysql:host=localhost:8889;dbname=hair_salon';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
     'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    $app->get("/stylists", function() use ($app) {
        return $app['twig']->render('stylists.html.twig', array('stylists' => Stylist::getAll()));
    });

    $app->post("/stylist", function() use ($app){
        $new_stylist = new Stylist($_POST['name']);
        $new_stylist->save();
        return $app['twig']->render('categories.html.twig', array('stylists' => Stylist::getAll()));
    });

    $app->get("/stylists/{id}", function($id) use ($app){
        $stylist = Stylists::find($id);
        return $app['twig']->render("stylist.html.twig", array('found_stylist' => $stylist, 'client' => $stylist->getClient(), 'stylists' => Stylist::getAll()));
    });

    $app->post("/stylists/{id}", function($id) use ($app){
        $stylist = Stylist::find($id);
        $new_client = new Client($_POST['name']);
        $new_client = new Client($_POST['phone']);
        $new_task->save();
        foreach ($_POST['stylist_id'] as $style_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO stylists_clients (stylist_id, client_id) VALUES({$style_id}, {$new_client->getId()});");
        }
        return $app['twig']->render("stylist.html.twig", array('found_stylist' => $stylist, 'clients' => $stylist->getClients(), 'stylists' => Stylist::getAll()));
    });

    $app->post('/delete_stylists', function() use ($app){
        Stylist::deleteAll();
        return $app['twig']->render('stylists.html.twig', array('stylists' => Stylist::getAll()));
    });

    $app->post("/delete_stylist_tasks/{id}", function($id) use ($app){
        $stylist = Stylist::find($id);
        $stylist->deleteStylistTasks();
        return $app['twig']->render("stylist.html.twig", array('found_stylist' => $stylist, 'tasks' => $stylist->getClients(), 'stylists' => Stylist::getAll()));
    });

    return $app;
?>