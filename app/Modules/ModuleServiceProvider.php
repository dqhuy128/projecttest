<?php

namespace App\Modules;

use App\Libs\Lib;
use App\Modules\BackEnd\Providers\BackendServiceProvider;
use App\Modules\Core\Providers\CoreServiceProvider;
use App\Modules\FrontEnd\Providers\FrontendServiceProvider;
use App\Modules\Mobile\Providers\MobileServiceProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;

class ModuleServiceProvider extends ServiceProvider
{

    protected $folder;

    public function boot()
    {

        //process https on product
        if (env('APP_HTTPS')) {
            \URL::forceScheme('https');
        }

        $this->folder = Lib::module_config('folder_name');
        $this->bootProviders();
        $this->switchProvider($this->folder);

        //Load file routes.php tuong ung cua tung module
        $webRoutesPath = __DIR__ . '/' . $this->folder;
        if (file_exists($webRoutesPath . '/routes.php')) {
            include $webRoutesPath . '/routes.php';

            if ($this->folder == 'Api') {
                // build the container web routes path
                $webRoutesPath = $webRoutesPath . '/Routes';

                $this->loadApiRoutes($webRoutesPath);
            }
        }

        //Load file template share ung voi tung module
        if (file_exists(__DIR__ . '/' . $this->folder . '/tplShare.php')) {
            include __DIR__ . '/' . $this->folder . '/tplShare.php';
        }

        //Load cac file template tuong ung trong tung module
        if (is_dir(__DIR__ . '/Core/Views')) {
            $this->loadViewsFrom(__DIR__ . '/Core/Views', 'Core');
        }

        //Load cac file template tuong ung trong tung module
        if (is_dir(__DIR__ . '/' . $this->folder . '/Views')) {
            $this->loadViewsFrom(__DIR__ . '/' . $this->folder . '/Views', $this->folder);
        }
    }

    private function loadApiRoutes($webRoutesPath)
    {
        if (File::isDirectory($webRoutesPath)) {
            $files = File::allFiles($webRoutesPath);
            $files = Arr::sort($files, function ($file) {
                return $file->getFilename();
            });
            foreach ($files as $file) {
                $this->loadWebRoute($file, $this->folder, 'api', 'api', 'App\Modules\Api\Controllers');
            }
        }
    }

    private function loadWebRoute($file, $folder, $prefix, $middleware, $controllerNamespace)
    {
        Route::group([
            'prefix'     => $prefix,
            'module'     => $folder,
            'namespace'  => $controllerNamespace,
            'middleware' => [$middleware]
        ], function ($router) use ($file) {
            require $file->getPathname();
        });
    }

    public function register()
    {
    }

    public function bootProviders()
    {
        $this->app->register(CoreServiceProvider::class);
    }

    protected function switchProvider($path = '')
    {
        switch ($path) {
            case 'BackEnd':
                $this->app->register(BackendServiceProvider::class);
                break;
            case 'FrontEnd':
                $this->app->register(FrontendServiceProvider::class);
                break;
            case 'Mobile':
                $this->app->register(MobileServiceProvider::class);
                break;
        }
    }
}
