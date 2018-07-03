<?php

namespace Cimons\LaraFcm;

use Cimons\LaraFcm\Sender\FCMSender;
use Illuminate\Support\ServiceProvider;
use Cimons\LaraFcm\FCMManager;

class LaraFcmServiceProvider extends ServiceProvider
{

    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/fcm.php' => config_path('fcm.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('fcm.client', function ($app) {
            return (new FCMManager($app))->driver();
        });

        $this->app->bind('fcm.sender', function ($app) {
            $client = $app['fcm.client'];
            $url    = $app['config']->get('fcm.http.server_send_url');

            return new FCMSender($client, $url);
        });
    }

    public function provides()
    {
        return ['fcm.client', 'fcm.sender'];
    }
}
