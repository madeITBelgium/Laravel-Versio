<?php

namespace MadeITBelgium\Versio;

use Illuminate\Support\ServiceProvider;

/**
 * Versio API.
 *
 * @version    0.0.1
 *
 * @copyright  Copyright (c) 2018 Made I.T. (http://www.madeit.be)
 * @author     Made I.T. <info@madeit.be>
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-3.txt    LGPL
 */
class VersioServiceProvider extends ServiceProvider
{
    protected $defer = false;

    protected $rules = [
        'domainvailable',
    ];

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/versio.php' => config_path('versio.php'),
        ]);

        $this->loadTranslationsFrom(__DIR__.'/lang', 'versio');
        $this->addNewRules();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('versio', function ($app) {
            $config = $app->make('config')->get('versio');

            return new VestaCP($config['email'], $config['password'], null, $config['test']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['versio'];
    }

    protected function addNewRules()
    {
        foreach ($this->rules as $rule) {
            $this->extendValidator($rule);
        }
    }

    protected function extendValidator($rule)
    {
        $method = 'validate'.studly_case($rule);
        $translation = $this->app['translator']->get('versio::validation');
        $this->app['validator']->extend($rule, 'MadeITBelgium\Versio\Validation\ValidatorExtensions@'.$method, $translation[$rule]);
    }
}
