<?php

require_once __DIR__."/../vendor/autoload.php";


$app = new Silex\Application();

require_once __DIR__."/config/config.php";

/** Silex Extensions */
use Silex\Provider\SymfonyBridgesServiceProvider,
    Silex\Provider\UrlGeneratorServiceProvider,
    Silex\Provider\SessionServiceProvider,
    Silex\Provider\FormServiceProvider,
    Silex\Provider\TranslationServiceProvider,
    Silex\Provider\SwiftmailerServiceProvider,
    Silex\Provider\MonologServiceProvider,
    Silex\Provider\TwigServiceProvider;


use WisemblyApp\Provider\WisemblyAppServiceProvider;


$app->register(new UrlGeneratorServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new SessionServiceProvider(), $config['session']);
$app->register(new MonologServiceProvider(), $config['monolog']);
$app->register(new TwigServiceProvider(), $config['twig']);

/**
 * Wisembly
 */
$app->register(new WisemblyAppServiceProvider($config['wisemblyapp']));

//$app['autoloader']->registerNamespace( 'WisemblyApp', __DIR__.'/../src' );

$app->before(function() use ($app) {
    if($app['request']->getRequestUri()!= $app['url_generator']->generate('security')):
        if(!$app['session']->get('wis_auth_token')):
            return $app->redirect($app['url_generator']->generate('security'));
        endif;
    endif;
});

/**
 * homepage
 *
 * GET /
 */
$app->get('/', function () use ($app) {
    return $app['twig']->render('homepage.html.twig');
})->bind('homepage');

$app->mount("/security", new WisemblyApp\Controller\Security());
$app->mount("/events", new WisemblyApp\Controller\Event());
return $app;
