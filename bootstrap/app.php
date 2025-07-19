<?php

use Illuminate\View\Factory;
use Illuminate\View\FileViewFinder;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Events\Dispatcher;

require_once __DIR__.'/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->register(Illuminate\Events\EventServiceProvider::class);

$app->withEloquent();
$app->withFacades();

class_alias(Illuminate\Support\Facades\Hash::class, 'Hash');
$app->register(Illuminate\Hashing\HashServiceProvider::class);



/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

// Singleton 'view'
$app->register(Illuminate\View\ViewServiceProvider::class);

$app->register(Illuminate\Filesystem\FilesystemServiceProvider::class);
$app->configure('filesystems');

/*$app->singleton('view', function () use ($app) {
    $filesystem = new Filesystem;

    // 1. Resolver de motores
    $resolver = new EngineResolver;

    // 2. Compilador Blade
    $bladeCompiler = new BladeCompiler($filesystem, storage_path('views'));

    $resolver->register('blade', function () use ($bladeCompiler) {
        return new CompilerEngine($bladeCompiler);
    });

    // 3. Finder para las vistas
    $finder = new FileViewFinder($filesystem, [resource_path('views')]);

    // 4. Dispatcher de eventos
    $dispatcher = new Dispatcher($app);

    // 5. Fábrica de vistas
    $factory = new Factory($resolver, $finder, $dispatcher);

    return $factory;
});*/

if (!function_exists('resource_path')) {
    function resource_path($path = '')
    {
        return app()->basePath('resources') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}


$app->singleton('view', function ($app) {
    $resolver = new EngineResolver();

    $bladeCompiler = new BladeCompiler(
        $app['files'],
        storage_path('framework/views')
    );

    $resolver->register('blade', function () use ($bladeCompiler) {
        return new CompilerEngine($bladeCompiler);
    });

    $finder = new FileViewFinder(
        $app['files'],
        [resource_path('views')]
    );

    $factory = new Factory($resolver, $finder, $app['events']);
    return $factory;
});



if (!function_exists('view')) {
    function view($view, $data = [], $mergeData = []) {
        return app('view')->make($view, $data, $mergeData)->render();
    }
}
if (!function_exists('session')) {
    function session($key = null)
    {
        return app('session')->get($key);
    }
}


/*if (!function_exists('session')) {
    function session($key = null, $default = null) {
        if (is_null($key)) {
            return app('session');
        }
        return app('session')->get($key, $default);
    }
}*/

/*
|--------------------------------------------------------------------------
| Register Config Files
|--------------------------------------------------------------------------
|
| Now we will register the "app" configuration file. If the file exists in
| your configuration directory it will be loaded; otherwise, we'll load
| the default version. You may register other files below as needed.
|
*/

$app->configure('app');

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

 $app->middleware([
     //App\Http\Middleware\ExampleMiddleware::class,
     Illuminate\Session\Middleware\StartSession::class,
     App\Http\Middleware\StartPhpSession::class,     
     //Laravel\Cookie\Middleware\AddQueuedCookiesToResponse::class,
 ]);

 $app->routeMiddleware([
     'auth' => App\Http\Middleware\Authenticate::class,
     'session.auth' => App\Http\Middleware\SessionAuth::class,
     'admin' => App\Http\Middleware\AdminUser::class,
 ]);



/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

 $app->register(App\Providers\AppServiceProvider::class);
 $app->register(App\Providers\AuthServiceProvider::class);
 $app->register(App\Providers\EventServiceProvider::class);

 $app->register(Illuminate\Auth\AuthServiceProvider::class);

 $app->register(Illuminate\Session\SessionServiceProvider::class);
$app->configure('session');
//class_alias(Illuminate\Support\Facades\Session::class, 'Session');

 //$app->configure('session');
 //$app->register(Illuminate\Session\SessionServiceProvider::class);
 //class_alias(Illuminate\Support\Facades\Session::class, 'Session');
 //$app->register(Laravel\Cookie\CookieServiceProvider::class);

 //class_alias(Illuminate\Support\Facades\Cookie::class, 'Cookie');

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__.'/../routes/web.php';
});

$app->configure('auth');


return $app;
