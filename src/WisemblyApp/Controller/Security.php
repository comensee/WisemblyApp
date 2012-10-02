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
        $controllers = new ControllerCollection(new Route());

        /**
         * account
         *
         * GET /account
         * User account
         */
        $controllers->get('/', function () use ($app) {
            return $app['twig']->render('Account/home.html.twig');
        })
        ->bind('account')
        ->value('security', array('ROLE_MEMBER'));

        return $controllers;
    }
}
