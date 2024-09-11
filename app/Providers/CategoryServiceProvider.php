<?php

namespace Modules\Category\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class CategoryServiceProvider extends ServiceProvider
{
    //=======================================================================
    protected string $moduleName        = 'Category';
    protected string $moduleNameLower   = 'category';
    //=======================================================================
    public function boot(): void{
        $this->registerCommands();
        $this->registerCommandSchedules();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        // $this->loadMigrationsFrom(module_path($this->moduleName, 'database/migrations'));
        $this->loadMigrationsFrom(dirname(__DIR__) .'/../database/migrations');
        //=======================================================================
        /*
            here we will handle 3 steps
            1- publish config file with module name
            2- publish module public folder to main project public/vendor/categry folder
            3- enable module  
        */
        $this->copyModuleConfigToMainProject('category');
        $this->copyModulePublicToMainProject();
        $this->enableModule();
        $this->ensureModuleStructureExists();
        //=======================================================================
    }
    //=======================================================================
    public function register(): void{
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }
    //=======================================================================
    protected function registerCommands(): void{
        // $this->commands([]);
    }
    //=======================================================================
    protected function registerCommandSchedules(): void{
        // $this->app->booted(function () {
        //     $schedule = $this->app->make(Schedule::class);
        //     $schedule->command('inspire')->hourly();
        // });
    }
    //=======================================================================
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
    // protected function registerConfig(): void{
    //     $this->publishes([module_path($this->moduleName, 'config/config.php') => config_path($this->moduleNameLower.'.php')], 'config');
    //     $this->mergeConfigFrom(module_path($this->moduleName, 'config/config.php'), $this->moduleNameLower);
    // }
    //=======================================================================
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
    public function registerViews(): void{
        $viewPath = resource_path('views/modules/'.$this->moduleNameLower);
        // $sourcePath = module_path($this->moduleName, 'resources/views');
        $sourcePath = dirname(__DIR__) .'/../resources/views';

        $this->publishes([$sourcePath => $viewPath], ['views', $this->moduleNameLower.'-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);

        $componentNamespace = str_replace('/', '\\', config('modules.namespace').'\\'.$this->moduleName.'\\'.ltrim(config('modules.paths.generator.component-class.path'), config('modules.paths.app_folder', '')));
        Blade::componentNamespace($componentNamespace, $this->moduleNameLower);
    }
    //=======================================================================
    public function provides(): array{
        return [];
    }
    //=======================================================================
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
    public function copyModuleConfigToMainProject($newConfigFileName){
        // Path to the module's config file
        $moduleConfigPath = dirname(__DIR__)  . '/../config/config.php';

        // Destination path in the main project's config directory
        $destinationPath = config_path("{$newConfigFileName}.php");
        if (!file_exists($destinationPath)) {
            touch($destinationPath);
        }
        // Check if the module's config file exists
        if (File::exists($moduleConfigPath)) {
            // Copy the config file to the main project's config directory
            if (!file_exists($destinationPath)) {
                File::copy($moduleConfigPath, $destinationPath);
            }
            //echo "Config file copied successfully to config directory.";
        }
        //echo "Module config file not found.";
    }
    //=======================================================================
    protected function copyModulePublicToMainProject(): void{
        //echo'inside copyModulePublicToMainProject fun';

        #check if Modules/Category folder not found will create it
        $modulePath = public_path('vendor/category');
        if (!is_dir($modulePath)){
            mkdir($modulePath, 0755, true);
            //echo'create folder ('.$modulePath.')';
        }
        // Copy necessary files from the package to the Modules/Category directory
        #will copy from all folder in Category folder  and put it in Modules/Category
        $sourceDir = dirname(__DIR__)  . '/../public';
        //echo'sourceDir is ('.$sourceDir.')';

        $this->recursiveCopy($sourceDir, $modulePath);
        //echo'after copy public';
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
                    if (!file_exists($dst . '/' . $file)) {
                        copy($src . '/' . $file,$dst . '/' . $file);
                    }
                }
            }
        }
        closedir($dir);
    }
    //=======================================================================
    protected function enableModule(): void{
        //echo'inside enableModule fun';
        $modulesStatuses = base_path('modules_statuses.json');
        if (!file_exists($modulesStatuses)) {
            file_put_contents($modulesStatuses, json_encode([$this->moduleName => true]));
        } else {
            $statuses = json_decode(file_get_contents($modulesStatuses), true);
            $statuses[$this->moduleName] = true;
            file_put_contents($modulesStatuses, json_encode($statuses));
        }
        //echo 'done';
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
}
