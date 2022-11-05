<?php

use App\Modules\FrontEnd\Middleware\CartHasItemMiddleware;

Route::group(
    [
        'module' => 'FrontEnd',
        'namespace'=>'App\Modules\FrontEnd\Controllers',
        'middleware' => ['web','XSS']
    ],
    function(){
        Route::get('/clear-cache', function() {
            $exitCode = \Illuminate\Support\Facades\Artisan::call('cache:clear');
            // return what you want
            echo $exitCode;
            echo 'Clear Done!';
        });

        Route::get('/view-clear', function() {
            $exitCode = \Illuminate\Support\Facades\Artisan::call('view:clear');
            // return what you want
            echo $exitCode;
            echo 'Clear Done!';
        });

        //Clear Config cache:
        Route::get('/config-cache', function() {
            $exitCode = \Illuminate\Support\Facades\Artisan::call('config:cache');
            return '<h1>Clear Config cleared</h1>';
        });



        //home
        Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
        Route::get('/thank-you', ['as' => 'success', 'uses' => 'HomeController@success']);
        Route::post('/contact', ['as' => 'contact.post', 'uses' => 'HomeController@sendcontact']);

        //error
        Route::get('404', [ 'as' => 'public.404', 'uses' => 'ErrorController@page404']);
        Route::get('500', [ 'as' => 'public.500', 'uses' => 'ErrorController@page500']);
    }
);

