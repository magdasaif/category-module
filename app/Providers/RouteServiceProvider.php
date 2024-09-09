<?php

namespace Modules\Category\Providers;

use Illuminate\Support\Facades\Route;
use Modules\Category\Models\Category;
use Modules\Category\Exceptions\ProjectModelNotFoundException;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     */
    public function boot(): void
    {
        parent::boot();
        //===============================================================================
        Route::bind('category', function ($slug) {
            // return Category::where('slug', $slug)->firstOrFail();
            $model= Category::where('slug', $slug)->first();
            if (!$model) {
                throw new ProjectModelNotFoundException('category');
            }
            return $model;
        });
        //===============================================================================
    }

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')->group(module_path('Category', '/routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes(): void
    {
        Route::middleware('api')->prefix('api')->name('api.')->group(module_path('Category', '/routes/api.php'));
    }
}
