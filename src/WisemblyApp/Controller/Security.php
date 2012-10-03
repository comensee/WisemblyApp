<?php

namespace WisemblyApp\Controller;

use Silex\ControllerProviderInterface,
    Silex\ControllerCollection,
    Silex\Route,
    Silex\Application;
use Symfony\Component\Form\FormError;

use WisemblyApp\Utils\Url;
use WisemblyApp\Form\Type\LoginType;

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
         * GET /security/login
         * LogIn User
         */
        $controllers->match('/login', function () use ($app) {
            if($app['session']->get("user_auth_token")):
                $app->redirect($app['url_generator']->generate('events'));
            endif;
            $form = $app['form.factory']->create(new LoginType());
            $request = $app['request'];
        if ('POST' == $request->getMethod()) {
            $form->bind($request);

            if ($form->isValid()) {
                $data = $form->getData();
                $url = new Url("http://votrequestion.com/api/3/authentication/get-token");
                $response = $url->post(array("username"=>$data['username'], 
                                                "secret"=>$data["password"], 
                                                "app_id"=>$app['wisemblyapp']['config']['app_id'],
                                                "hash"=>sha1($data['username'].$app['wisemblyapp']['config']['app_id'].$app['wisemblyapp']['config']['app_secret'])));
                //error_log($response);
                $response = json_decode($response, true);
                //error_log(key($response));
                if(key($response)=="error"):
                    $app['session']->setFlash("error", "utilisateur non reconnu");
                    return $app['twig']->render('Security/login.html.twig', array("form"=>$form->createView()));
                endif;
                $app['session']->setFlash("success", "utilisateur connecté");
                $app['session']->set("user_auth_token", $response['success']['data']['token']);
                return $app->redirect($app['url_generator']->generate("events"));
            
            }
        }

            return $app['twig']->render('Security/login.html.twig', array("form"=>$form->createView()));
        })->bind("security_login")
        ->method('GET|POST');

        /**
         * security
         *
         * GET /security/logout
         * LogOut User
         */
        $controllers->get('/logout', function () use ($app) {
            $app['session']->setFlash("info", "utilisateur déconnecté");
            $app['session']->set('user_auth_token', null);
            return $app->redirect($app['url_generator']->generate('security_login'));
        })->bind("security_logout");
        return $controllers;
    }
}
