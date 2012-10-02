<?php

// Debug mode
$app['debug'] = true;

$app['root_dir'] = __DIR__.'/../';
$config = array();

/**
 * Wisembly Connection
 */
$config['wisemblyapp'] = array(
                            'app_id'        =>  'alainbangoula',
                            'app_secret'    =>  'wisembly'
);

/**
 * Session
 *
 * Warning: it use the version 2.1 of Symfony Session Component
 * @see
 */
$config['session'] = array(
    'session.storage.options' => array('auto_start' => true)
);

/**
 * Twig Service configuration
 * @see
 */
$config['twig'] = array(
    'twig.path' => array(
        __DIR__.'/../../src/WisemblyApp/Resources/views',
        __DIR__.'/../../vendor/symfony/twig-bridge/Symfony/Bridge/Twig/Resources/views/Form'),
);

/**
 * Monolog
 */
$config['monolog'] = array(
    'monolog.logfile'       => __DIR__ . '/../logs/main.log',
    'monolog.name'          => 'main',
    'monolog.level'         => 100 
);
