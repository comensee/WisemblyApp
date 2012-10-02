<?php

namespace WisemblyApp\Composer;

use Composer\Script\Event;

class ScriptHandler
{
    public static function updateBootstrap(Event $event)
    {
        $composer = $event->getComposer();
        // do stuff

        $css_directory = __DIR__.'/../../../vendor/twitter/bootstrap/docs/assets/css';
        $js_directory = __DIR__.'/../../../vendor/twitter/bootstrap/js';
        $bootstrap_directory = __DIR__.'/../../../web/vendor/twitter/bootstrap';


        if(!is_dir($bootstrap_directory)):
            exec("mkdir -p $bootstrap_directory");
        endif;

        exec('cp -r '.$css_directory.' '.$bootstrap_directory);
        exec('cp -r '.$js_directory.' '.$bootstrap_directory);
    }

}
