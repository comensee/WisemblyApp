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
        })->bind("security_login");

        /**
         * security
         *
         * GET /logout
         * User account
         */
        $controllers->get('/logout', function () use ($app) {
            $app['session']->get('wis_auth_token')->set(null);
            return $app->redirect($app['url_generator']->generate('security'));
        })->bind("security_logout");
        return $controllers;
    }
}
