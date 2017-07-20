<?php

namespace Lanizz\Laravel;

/**
 * Created by PhpStorm.
 * User: Jinming
 * Date: 2017/7/19
 * Time: 15:30
 */
use Illuminate\Support\ServiceProvider;

class AliSmsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        define('ENABLE_HTTP_PROXY', FALSE);
        define('HTTP_PROXY_IP', '127.0.0.1');
        define('HTTP_PROXY_PORT', '8888');
    }

    public function register()
    {
        $this->app->singleton('alisms', function ($app) {
            $sms = new AliSms();
            $sms->setEndPoint();
            $sms->setKey($app->config->get('alisms.key'));
            $sms->setSecret($app->config->get('alisms.secret'));
            $sms->setRegion($app->config->get('alisms.region'));
            $sms->setSign($app->config->get('alisms.sign'));
            $sms->init();
            return $sms;
        });
    }

}