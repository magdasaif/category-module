<?php

namespace Modules\Category\Providers;

use Spatie\Html\HtmlServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class CategoryServiceProvider extends ServiceProvider
{
    protected string $moduleName        = 'Category';
    protected string $moduleNameLower   = 'category';
    //=======================================================================
    /**
     * Boot the application events.
     */
    public function boot(): void{
        $this->registerCommands();
        $this->registerCommandSchedules();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        // $this->loadMigrationsFrom(module_path($this->moduleName, 'database/migrations'));
        $this->loadMigrationsFrom(dirname(__DIR__) .'/../database/migrations');
        $this->publishPublic();
        $this->publishConfig();
        $this->ensureModuleIsRegistered();
        $this->ensureModuleStructureExists();
        // $this->call('vendor:publish', ['--tag' => 'category-public']);
    }
    //=======================================================================
    /**
     * Register the service provider.
     */
    public function register(): void{
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        // $this->app->register(HtmlServiceProvider::class);
    }
    //=======================================================================
    /**
     * Register commands in the format of Command::class
     */
    protected function registerCommands(): void{
        $this->commands([
            \Modules\Category\Console\PublishModuleCommand::class,
        ]);
    }
    //=======================================================================
    /**
     * Register command Schedules.
     */
    protected function registerCommandSchedules(): void{
        // $this->app->booted(function () {
        //     $schedule = $this->app->make(Schedule::class);
        //     $schedule->command('inspire')->hourly();
        // });
    }
    //=======================================================================
    /**
     * Register translations.
     */
    public function registerTranslations(): void{
        $langPath = resource_path('lang/modules/'.$this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            //:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            //module default setting
            // $this->loadTranslationsFrom(module_path($this->moduleName, 'lang'), $this->moduleNameLower);
            // $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'lang'));
            //:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            //change in lang path to be affect project
            // $this->loadTranslationsFrom(module_path($this->moduleName, 'resources/lang'), $this->moduleNameLower);
            // $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'resources/lang'));
            //:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
            //use dirname(__DIR__)  instead of module_path
            $this->loadTranslationsFrom(dirname(__DIR__) .'/../resources/lang', $this->moduleNameLower);
            $this->loadJsonTranslationsFrom(dirname(__DIR__) .'/../resources/lang');
            //:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
        }
    }
    //=======================================================================
    /**
     * Register config.
     */
    #to solve ppear another error is  require(/home/murabba/projects/package_development/test-contact-module/config/config.php): Failed to open stream: No such file or directory
    protected function registerConfig(): void{
        #ensure it's looking for the config file in the correct location
        // $sourcePath = __DIR__.'/../config/config.php'; //contain module name
        $sourcePath =dirname(__DIR__) .'/../config/config.php'; //contain module name
        if (file_exists($sourcePath))
        {
            #publish config file in config:folder to be appeared in external project
            $this->publishes([$sourcePath => config_path($this->moduleNameLower.'.php')], 'config');
            #put modulenamelower "contact" file in config folder in external project
            $this->mergeConfigFrom($sourcePath, $this->moduleNameLower);
        } else
        {
            \Illuminate\Support\Facades\Log::warning("Config file not found: {$sourcePath}");
        }
        // $this->publishes([module_path($this->moduleName, 'config/config.php') => config_path($this->moduleNameLower.'.php')], 'config');
        // $this->mergeConfigFrom(module_path($this->moduleName, 'config/config.php'), $this->moduleNameLower);
    }
    //=======================================================================
    /**
     * Register views.
     */
    public function registerViews(): void{
        $viewPath   = resource_path('views/modules/'.$this->moduleNameLower);
        // $sourcePath = module_path($this->moduleName, 'resources/views');
        $sourcePath = dirname(__DIR__) .'/../resources/views';

        $this->publishes([$sourcePath => $viewPath], ['views', $this->moduleNameLower.'-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);

        $componentNamespace = str_replace('/', '\\', config('modules.namespace').'\\'.$this->moduleName.'\\'.ltrim(config('modules.paths.generator.component-class.path'), config('modules.paths.app_folder', '')));
        Blade::componentNamespace($componentNamespace, $this->moduleNameLower);
    }
    //=======================================================================
    /**
     * Get the services provided by the provider.
     *
     * @return array<string>
     */
    public function provides(): array{
        return [];
    }
    //=======================================================================
    /**
     * @return array<string>
     */
    private function getPublishableViewPaths(): array{
        $paths = [];
        foreach (config('view.paths') as $path) {
            if (is_dir($path.'/modules/'.$this->moduleNameLower)) {
                $paths[] = $path.'/modules/'.$this->moduleNameLower;
            }
        }
        return $paths;
    }
    //=======================================================================
    public function publishPublic(){
        // Publish CSS and JS files from the package's public folder
        $this->publishes([
            dirname(__DIR__).'/../public' => public_path('vendor/category'),
        ], 'category-public');
    }
    //=======================================================================
    public function publishConfig(){
        //==============================================================================================
        // publish config
        $this->publishes([
            dirname(__DIR__) .'/../config/config.php' => config_path('category.php'),
        ], 'category-config');
        //==============================================================================================
    }
    //=======================================================================
    protected function ensureModuleIsRegistered(): void{
        $modulesStatuses = base_path('modules_statuses.json');
        if (!file_exists($modulesStatuses)) {
            file_put_contents($modulesStatuses, json_encode([$this->moduleName => true]));
        } else {
            $statuses = json_decode(file_get_contents($modulesStatuses), true);
            $statuses[$this->moduleName] = true;
            file_put_contents($modulesStatuses, json_encode($statuses));
        }
    }
    //=======================================================================
    protected function ensureModuleStructureExists(): void{
        #check if Modules/Category folder not found will create it
        $modulePath = base_path('Modules/Category');
        if (!is_dir($modulePath)){
            mkdir($modulePath, 0755, true);
        }
        // Copy necessary files from the package to the Modules/Category directory
        #will copy from all folder in Category folder  and put it in Modules/Category
        $sourceDir = dirname(__DIR__)  . '/..';
        $this->recursiveCopy($sourceDir, $modulePath);
    }
    //=======================================================================    
    protected function ensureModuleConfigExists(): void{
        #check if Modules/Category folder not found will create it
        $modulePath = config_path('category.php');
        if (!is_dir($modulePath)){
            mkdir($modulePath, 0755, true);//TODO
        }
        // Copy necessary files from the package to the Modules/Category directory
       
        #will copy from config folder and put it in config
        $sourceDir = dirname(__DIR__)  . '/../config/config.php';
        $dir = opendir($sourceDir);
        copy($sourceDir,$modulePath);
        closedir($dir);
    }
    //=======================================================================
    protected function ensureModuleSPublicExists(): void{
        #check if Modules/Category folder not found will create it
        $modulePath = public_path('vendor/category');
        if (!is_dir($modulePath)){
            mkdir($modulePath, 0755, true);
        }
        // Copy necessary files from the package to the Modules/Category directory
        #will copy from all folder in Category folder  and put it in Modules/Category
        $sourceDir = dirname(__DIR__)  . '/../public';
        $this->recursiveCopy($sourceDir, $modulePath);
    }
    //=======================================================================
    #handle copy of content of folders
    private function recursiveCopy($src, $dst){
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->recursiveCopy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }
    //=======================================================================
}
