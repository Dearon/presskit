<?php 

require 'vendor/autoload.php';
require 'Presskit/Autoloader.php';

session_cache_limiter(false);
session_start();

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

$app->post('/mail/', function() use ($app, $presskit) {
    $data = $presskit->load('company');
    $email = new \Presskit\Email();

    try {
        $success = $email->email($data['press-contact'], $_POST['from'], $_POST['outlet'], $_POST['gametitle']);

        if ($success) {
            $app->flash('success', 'Thanks for the request. We\'ll be in touch as soon as possible. In the meanwhile, feel free to <a href="#contact">follow up with any questions or requests you might have!');
        } else {
            $app->flash('error', 'We failed to send the email. Please try contacting us using <a href="#contact">one of the options listed here</a>.');
        }
    } catch (Exception $e) {
        if ($e->getMessage() == 'The to email address needs to be a valid email address') {
            $app->flash('error', 'We failed to send the email. Please try contacting us using <a href="#contact">one of the options listed here</a>.');
        } else if ($e->getMessage() == 'The from email address needs to be a valid email address') {
            $app->flash('error', 'We could not validate your email address. Please try contacting us using <a href="#contact">one of the options listed here</a>.');
        } else if ($e->getMessage() == 'The outlet field can not be empty') {
            $app->flash('error', 'Please fill the company name field in or try contacting us using <a href="#contact">one of the options listed here</a>.');
        } else if ($e->getMessage() == 'The gametitle field can not be empty') {
            $app->flash('error', 'We failed to send the email. Please try contacting us using <a href="#contact">one of the options listed here</a>.');
        }
    } finally {
        $app->redirect('/' . urlencode($_POST['game']) . '#preview');
    }
})->name('mail');

$app->get('/:project', function($project) use ($app, $presskit) {
    try {
        $data = $presskit->load($project);

        if (isset($_SESSION['slim.flash']['error'])) {
            $data['email-result']['error'] = $_SESSION['slim.flash']['error'];
        }

        $app->render('project', $data);
    } catch (Exception $e) {
        if ($e->getMessage() == 'The XML argument has to be a file') {
            $app->render('404');
        } else {
            $app->render('500');
        }
    }
})->name('project');

$app->run();
