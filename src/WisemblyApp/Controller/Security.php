<?php

namespace WisemblyApp\Controller;

use Silex\ControllerProviderInterface,
    Silex\ControllerCollection,
    Silex\Route,
    Silex\Application;
use Symfony\Component\Form\FormError;

/**
 * Security controller
 */
class Security implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        /**
         * security
         *
         * GET /security
         * User account
         */
        $controllers->get('/login', function () use ($app) {
            return $app['twig']->render('Security/login.html.twig');
        })->bind("security");

        return $controllers;
    }
}
