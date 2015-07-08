<?php

require "vendor/autoload.php";

use Silex\Application;
use Silex\Provider\TwigServiceProvider;

$app = new Silex\Application();
$app->register(new Silex\Provider\SessionServiceProvider());

$app->register(new TwigServiceProvider(), [
    'twig.path' => __DIR__ . '/views' // path to Twig templates.
]);


$app->get("/", function() use ($app){
    $rss_url ='http://feeds.feedburner.com/EatingwellBlogs-AllBlogPosts?format=xml';

    $xml = simplexml_load_file($rss_url);
    $feed = $xml->channel->item;
    $desc = strip_tags($feed->description, '<a></a>');

    return $app['twig']->render('main.twig', array ('feed' => $feed, 'desc' => $desc));
});


$app->run();




