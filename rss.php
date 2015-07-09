<?php

require "vendor/autoload.php";

use Silex\Application;
use Silex\Provider\TwigServiceProvider;

date_default_timezone_set("Europe/Berlin");

$app = new Silex\Application();
$app->register(new Silex\Provider\SessionServiceProvider());

$app->register(new TwigServiceProvider(), [
    'twig.path' => __DIR__ . '/views' // path to Twig templates.
]);


$app->get("/", function() use ($app){

    return $app['twig']->render('select.twig');
});

$app->get("/feed", function() use ($app){
    $rss_url = $_GET['url'];
    $xml = simplexml_load_file($rss_url);
    $dropdown = $_GET['feed'];

    if ($dropdown == "1") {

        $feed = $xml->channel->item;
    } else if ($dropdown == "2") {

        $feed = $xml->entry;
    } 

    return $app['twig']->render('main.twig', ['feed' => $feed]);
});



$app->run();




