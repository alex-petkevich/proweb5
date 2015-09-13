<?php

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class BlogifyServiceProvider extends ServiceProvider
{

    /**
     * @var array
     */
    protected $providers = [
        'Illuminate\Html\HtmlServiceProvider',
        'Intervention\Image\ImageServiceProvider',
    ];

    /**
     * @var array
     */
    protected $aliases = [
        'Form'      => 'Illuminate\Html\FormFacade',
        'HTML'      => 'Illuminate\Html\HtmlFacade',
        'Image'     => 'Intervention\Image\Facades\Image',
    ];

    /**
     * Register the service provider
     */
    public function register()
    {
        $this->app->bind('blogify', function()
        {
            $db = $this->app['db'];
            $config = $this->app['config'];
            return new Blogify($db, $config);
        });

        $this->registerMiddleware();
        $this->registerServiceProviders();
        $this->registerAliases();
    }

    /**
     * Load the resources
     *
     */
    public function boot()
    {
        // Load the routes for the package
        include __DIR__.'/routes.php';

        $this->publish();

        $this->loadViewsFrom(__DIR__.'/../views', 'blogify');
        $this->loadViewsFrom(__DIR__.'/../Example/Views', 'blogifyPublic');

        // Make the config file accessible even when the files are not published
        $this->mergeConfigFrom(__DIR__.'/../config/blogify.php', 'blogify');

        $this->loadTranslationsFrom(__DIR__.'/../lang/', 'blogify');

        $this->registerCommands();

        // Register the class that serves extra validation rules
        $this->app['validator']->resolver(
            function(
                $translator,
                $data,
                $rules,
                $messages = array(),
                $customAttributes = array()
            ) {
            return new Validation($translator, $data, $rules, $messages, $customAttributes);
        });
    }

    ///////////////////////////////////////////////////////////////////////////
    // Helper methods
    ///////////////////////////////////////////////////////////////////////////

    /**
     * @return void
     */
    private function registerMiddleware()
    {
        $this->app['router']->middleware('BlogifyAdminAuthenticate', 'BlogifyAdminAuthenticate');
        $this->app['router']->middleware('BlogifyVerifyCsrfToken', 'BlogifyVerifyCsrfToken');
        $this->app['router']->middleware('CanEditPost', 'CanEditPost');
        $this->app['router']->middleware('DenyIfBeingEdited', 'DenyIfBeingEdited');
        $this->app['router']->middleware('BlogifyGuest', 'Guest');
        $this->app['router']->middleware('HasAdminOrAuthorRole', 'HasAdminOrAuthorRole');
        $this->app['router']->middleware('HasAdminRole', 'HasAdminRole');
        $this->app['router']->middleware('RedirectIfAuthenticated', 'RedirectIfAuthenticated');
        $this->app['router']->middleware('IsOwner', 'IsOwner');
        $this->app['router']->middleware('CanViewPost', 'CanViewPost');
        $this->app['router']->middleware('ProtectedPost', 'ProtectedPost');
        $this->app['router']->middleware('ConfirmPasswordChange', 'ConfirmPasswordChange');
    }

    /**
     * @return void
     */
    private function registerServiceProviders()
    {
        foreach ($this->providers as $provider)
        {
            $this->app->register($provider);
        }
    }

    /**
     * @return void
     */
    private function registerAliases()
    {
        $loader = AliasLoader::getInstance();

        foreach ($this->aliases as $key => $alias)
        {
            $loader->alias($key, $alias);
        }
    }

    /**
     * @return void
     */
    private function publish()
    {
        // Publish the config files for the package
        $this->publishes([
            __DIR__.'/../config' => config_path('blogify/'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../public/assets' => base_path('/public/assets/blogify/'),
            __DIR__.'/../public/ckeditor' => base_path('public/ckeditor/'),
            __DIR__.'/../public/datetimepicker' => base_path('public/datetimepicker/')
        ], 'assets');

        $this->publishes([
            __DIR__.'/../views/admin/auth/passwordreset/' => base_path('/resources/views/auth/'),
            __DIR__.'/../views/mails/resetpassword.blade.php' => base_path('/resources/views/emails/password.blade.php')
        ], 'pass-reset');
    }

    private function registerCommands()
    {
        $this->commands([
            'Commands\BlogifyMigrateCommand',
            'Commands\BlogifySeedCommand',
            'Commands\BlogifyGeneratePublicPartCommand',
            'Commands\BlogifyCreateRequiredDirectories',
        ]);
    }

}