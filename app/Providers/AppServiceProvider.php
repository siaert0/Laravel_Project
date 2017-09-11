<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        view()->composer('*',function ($view){
            $allTags = \Cache::rememberForever('tags.list', function (){
                return \App\Tag::all();
            });
            $view->with('currentUser',auth()->user());
            $view->with(compact('allTags'));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
