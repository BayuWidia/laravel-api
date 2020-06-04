<?php

namespace App\Repositories\User\ServiceProvider;

use Illuminate\Support\ServiceProvider;

class UserRepoServiceProvider extends ServiceProvider{
    
    public function boot(){

    }

    public function register(){
        $this->app->bind('App\Repositories\User\Interfaces\UserInterface','App\Repositories\User\UserRepository');
    }
    
}
