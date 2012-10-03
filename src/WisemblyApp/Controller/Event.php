<?php

namespace WisemblyApp\Controller;

use Silex\ControllerProviderInterface,
    Silex\ControllerCollection,
    Silex\Route,
    Silex\Application;
use Symfony\Component\Form\FormError;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException; 

use WisemblyApp\Utils\Url;
use WisemblyApp\Form\Type\QuoteType;
/**
 * Event controller provider
 */
class Event implements ControllerProviderInterface
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
            $events = array();
            $events[] = array("keyword"=> "abangoulaevent", "title"=>"Alain Bangoula Event");
            return $app['twig']->render('Event/list.html.twig', array("events"=>$events));
        })
        ->bind('events');

        $controllers->get('/{keyword}', function ($keyword) use ($app) {
                $event_url = new Url("http://votrequestion.com/api/3/event/".$keyword);
                $event = json_decode($event_url->get(), true);
                if(key($event)=="error"):
                    throw new \Exception($event['error'][0]['message']);
                endif;
                
                $quote_url = new Url("http://votrequestion.com/api/3/event/".$keyword."/quotes");
                $quotes = json_decode($quote_url->get(), true);
                $form = $app['form.factory']->create(new QuoteType());
            return $app['twig']->render('Event/event.html.twig', array(
                                                                        "event"  => $event['success']['data'],
                                                                        "quotes" => $quotes['success']['data'],
                                                                        "form"   => $form->createView()
                                                                    ));
        })
        ->bind('event');

        $controllers->post('/{keyword}/quotes', function ($keyword) use ($app) {
                $question_url = new Url("http://votrequestion.com/api/3/event/".$keyword."/quotes?token=".$app['session']->get('user_auth_token'));
                $datas = $app['request']->request->all();
                error_log(print_r($datas));
                $response = $question_url->post(array("quote"=>$datas['quote']['content']));
                error_log($response);
                return $app->redirect($app['url_generator']->generate('event', array('keyword'=>$keyword)));
        })
        ->bind('post_quote');

        $controllers->get('/{keyword}/quotes/{id}/vote', function ($keyword, $id) use ($app) {
                $vote_url = new Url("http://votrequestion.com/api/3/event/".$keyword."/quotes/".$id."/vote?token=".$app['session']->get('wis_auth_token'));
                $response = $vote_url->post(array());
                error_log($response);
                return $app->redirect($app['url_generator']->generate('event', array('keyword'=>$keyword)));
        })
        ->bind('post_vote');
        return $controllers;
    }
}
