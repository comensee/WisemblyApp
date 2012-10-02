<?php

namespace WisemblyApp\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;


class WisemblyAppServiceProvider implements ServiceProviderInterface
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }
    public function register(Application $app)
    {
        $app['wis_auth_token'] = function ($app) {
            return false;
        };
    }

    public function boot(Application $app)
    {
    }
} 
