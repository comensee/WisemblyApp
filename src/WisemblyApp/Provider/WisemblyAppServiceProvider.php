<?php

namespace WisemblyApp\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

use WisemblyApp\Utils\Url;

class WisemblyAppServiceProvider implements ServiceProviderInterface
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }
    public function register(Application $app)
    {
        $app['app_auth_token'] = $app->protect(function ($config) use ($app) {
            $url = new Url("http://votrequestion.com/api/3/authentication/get-token");
            $datas = array("app_id" => $config['app_id'], "hash"=>sha1($config['app_id'].$config['app_secret']));
            $response = $url->post($datas);
            $response = json_decode($response);
            $app['session']->set('wis_auth_token', $response->success->data->token);
        });
        $app['app_auth_token']($this->config);

        $app['wisemblyapp'] = array("config"=>$this->config);
    }

    public function boot(Application $app)
    {
    }
} 
