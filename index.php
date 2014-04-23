<?php 

require 'vendor/autoload.php';
require 'Presskit/Autoloader.php';

\Presskit\Autoloader::register();
$presskit = new \Presskit\Load();

$app = new \Slim\Slim(array(
    'view' => new \Slim\Mustache\Mustache()
));

$req = $app->request;
$view = $app->view();

$view->parserOptions = array(
    'helpers' => array(
        'baseUrl' => $req->getUrl(),
    ),
);

$app->get('/', function () use ($app, $presskit) {
    try {
        $data = $presskit->load('company');
        $app->render('company', $data);
    } catch (Exception $e) {
        $app->render('500');
    }
})->name('home');

$app->get('/credits/', function() use ($app) {
    $app->render('credits');
})->name('credits');

$app->run();
