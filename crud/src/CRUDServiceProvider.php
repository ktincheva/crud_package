<?php

namespace KTSoftware\CRUD;

use Illuminate\Support\ServiceProvider;

class CRUDServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        //
        
        $this->publishes([__DIR__.'/config/crud.php' => config_path('crud.php')]);
       
        $this->loadViewsFrom(realpath(__DIR__ . '/resources/views/crud'), 'crud');
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router) {
        $router->group(['namespace' => 'App\Http\Controllers'], function($router) {
            require __DIR__ . '/Http/routes.php';
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        //
        $this->registeCRUD();
    }

    private function registeCRUD() {
        //$this->app->make('KTSoftware\CRUD\CRUDController');
        $this->app->bind('CRUD', function($app) {
            $this->app->bind('CRUD', function($app) {
                return new CRUD($app);
            });
        });
    }

    public static function resource($name, $controller, array $options = []) {
        // CRUD routes
        Route::get($name . '/{sortby}/{order}', $controller . '@index');
        Route::get($name . '/orderby{lang}', $controller . '@index');
        Route::get($name . '/{id}/details', $controller . '@showDetailsRow');
        Route::get($name . '/{id}/translate/{lang}', $controller . '@translateItem');
       // Route::delete($name, $controller . '@destroy');
       
        Route::resource($name, $controller, $options);
    }

}
