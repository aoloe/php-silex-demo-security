<?php

use \Symfony\Component\HttpFoundation\Request;

error_reporting(E_ALL);
ini_set('display_errors', 1);

define('APP_BASEDIR', dirname(__DIR__));

include_once(APP_BASEDIR.'/vendor/autoload.php');

$app = new Aoloe\Demo\Application();

$app->get('/login', function(Request $request) use ($app) {
    return $app['twig']->render('login.twig', array(
        'error' => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
})->bind('login');

$app->get('/', function(Request $request) use ($app) {
    if ($app['security.authorization_checker']->isGranted('ROLE_USER')) {
        return $app['twig']->render('index.twig', []);
    } else {
        return $app->redirect('login');
    }
})->bind('root');

$app->run();
