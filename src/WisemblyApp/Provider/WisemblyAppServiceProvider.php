<?php

namespace WisemblyApp\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;


class WisemblyAppServiceProvider implements ServiceProviderInterface
{
    protected $config;

    public function __construct($config)
    {
        $thisd->config = $config;
    }
    public function register(Application $app)
    {
        $app['wis_auth_token'] = $app->protect(function ($name) use ($app) {
            $default = $app['hello.default_name'] ? $app['hello.default_name'] : '';
            $name = $name ?: $default;

            return 'Hello '.$app->escape($name);
        });
    }

    public function boot(Application $app)
    {
    }
} 
