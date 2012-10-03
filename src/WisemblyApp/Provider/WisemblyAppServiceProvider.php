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
        $app['wis_auth_token'] = $app->protect(function ($config) use ($app) {
            $url = new Url("http://votrequestion.com/api/3/authentication/get-token");
            $datas = array( "username"=>$config['username'], 
                            "secret"=>$config['secret'],
                            "app_id" => $config['app_id'], 
                            "hash"=>sha1($config['username'].$config['app_id'].$config['app_secret']));
            error_log(json_encode($datas));
            $response = $url->post($datas);
            error_log($response);
            $response = json_decode($response);
            $app['session']->set('wis_auth_token', $response->success->data->token);
        });
        $app['wis_auth_token']($this->config);
    }

    public function boot(Application $app)
    {
    }
} 
